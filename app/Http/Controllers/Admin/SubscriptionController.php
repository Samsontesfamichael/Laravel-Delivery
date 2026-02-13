<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of all subscriptions.
     */
    public function index(Request $request)
    {
        $query = Subscription::with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by plan type
        if ($request->has('plan_type') && $request->plan_type) {
            $query->where('plan_type', $request->plan_type);
        }
        
        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Search by user name or email
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Date range filter
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        
        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new subscription.
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created subscription.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'plan_type' => 'required|in:daily,weekly,monthly,yearly,lifetime',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'features' => 'nullable|array',
            'max_orders' => 'nullable|integer|min:-1',
            'max_products' => 'nullable|integer|min:-1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_trial' => 'boolean',
            'trial_days' => 'nullable|integer|min:0',
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'auto_renew' => 'boolean',
            'send_notification' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = true;
        $data['status'] = 'active';
        $data['payment_status'] = 'completed';
        
        Subscription::create($data);

        // Send notification if requested
        if ($request->send_notification) {
            // Implementation for sending notification
        }

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription created successfully.');
    }

    /**
     * Display the specified subscription.
     */
    public function show(Subscription $subscription)
    {
        $subscription->load('user', 'transactions');
        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified subscription.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified subscription.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'plan_type' => 'required|in:daily,weekly,monthly,yearly,lifetime',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'features' => 'nullable|array',
            'max_orders' => 'nullable|integer|min:-1',
            'max_products' => 'nullable|integer|min:-1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_trial' => 'boolean',
            'trial_days' => 'nullable|integer|min:0',
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'auto_renew' => 'boolean',
            'status' => 'in:active,expired,cancelled,paused',
            'payment_status' => 'in:pending,completed,failed,refunded',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Update status based on dates
        if (now()->gt($subscription->end_date) && $subscription->status === 'active') {
            $data['status'] = 'expired';
            $data['is_active'] = false;
        }
        
        $subscription->update($data);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    }

    /**
     * Cancel the specified subscription.
     */
    public function cancel(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'nullable|string|max:500',
            'immediate' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $subscription->update([
            'status' => 'cancelled',
            'is_active' => false,
            'cancelled_at' => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->back()
            ->with('success', 'Subscription cancelled successfully.');
    }

    /**
     * Pause the specified subscription.
     */
    public function pause(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'paused',
            'is_active' => false,
            'paused_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Subscription paused successfully.');
    }

    /**
     * Resume the specified subscription.
     */
    public function resume(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'active',
            'is_active' => true,
            'resumed_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Subscription resumed successfully.');
    }

    /**
     * Renew the specified subscription.
     */
    public function renew(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Calculate new end date based on plan type
        $currentEnd = $subscription->end_date;
        $newEnd = match($subscription->plan_type) {
            'daily' => $currentEnd->addDay(),
            'weekly' => $currentEnd->addWeek(),
            'monthly' => $currentEnd->addMonth(),
            'yearly' => $currentEnd->addYear(),
            default => $currentEnd,
        };

        $subscription->update([
            'start_date' => now(),
            'end_date' => $newEnd,
            'status' => 'active',
            'is_active' => true,
            'payment_status' => 'completed',
            'last_renewed_at' => now(),
            'renewal_count' => $subscription->renewal_count + 1,
        ]);

        return redirect()->back()
            ->with('success', 'Subscription renewed successfully.');
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription deleted successfully.');
    }

    /**
     * Export subscriptions to CSV.
     */
    public function export(Request $request)
    {
        $query = Subscription::with('user');
        
        // Apply same filters as index
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $subscriptions = $query->get();
        
        $csv = [];
        $csv[] = ['ID', 'User', 'Email', 'Plan', 'Price', 'Status', 'Start Date', 'End Date', 'Created At'];
        
        foreach ($subscriptions as $sub) {
            $csv[] = [
                $sub->id,
                $sub->user->name,
                $sub->user->email,
                $sub->name,
                $sub->price . ' ' . $sub->currency,
                $sub->status,
                $sub->start_date,
                $sub->end_date,
                $sub->created_at,
            ];
        }
        
        $filename = 'subscriptions_' . date('Y-m-d') . '.csv';
        
        return response()->streamDownload(function () use ($csv) {
            $handle = fopen('php://output', 'w');
            foreach ($csv as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Get subscription statistics.
     */
    public function statistics()
    {
        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'expired' => Subscription::where('status', 'expired')->count(),
            'cancelled' => Subscription::where('status', 'cancelled')->count(),
            'paused' => Subscription::where('status', 'paused')->count(),
            'trial' => Subscription::where('is_trial', true)->count(),
            'total_revenue' => Subscription::where('payment_status', 'completed')->sum('price'),
            'monthly_revenue' => Subscription::where('payment_status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('price'),
        ];

        return view('admin.subscriptions.statistics', compact('stats'));
    }
}
