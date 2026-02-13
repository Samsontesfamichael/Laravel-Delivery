<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeliveryZoneController extends Controller
{
    /**
     * Display a listing of all delivery zones.
     */
    public function index(Request $request)
    {
        $query = DeliveryZone::query();
        
        // Filter by status
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }
        
        // Filter by delivery type
        if ($request->has('delivery_type') && $request->delivery_type) {
            $query->where('delivery_type', $request->delivery_type);
        }
        
        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $zones = $query->orderBy('name')->paginate(20);
        
        return view('admin.delivery-zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new delivery zone.
     */
    public function create()
    {
        return view('admin.delivery-zones.create');
    }

    /**
     * Store a newly created delivery zone.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:delivery_zones',
            'description' => 'nullable|string',
            'delivery_type' => 'required|in:radius,polygon,postal_code',
            'center_latitude' => 'required_if:delivery_type,radius|numeric|between:-90,90',
            'center_longitude' => 'required_if:delivery_type,radius|numeric|between:-180,180',
            'radius_km' => 'required_if:delivery_type,radius|numeric|min:0.1',
            'polygon_coordinates' => 'required_if:delivery_type,polygon|array|min:3',
            'postal_codes' => 'required_if:delivery_type,postal_code|array|min:1',
            'base_delivery_fee' => 'required|numeric|min:0',
            'per_km_fee' => 'nullable|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'free_delivery_threshold' => 'nullable|numeric|min:0',
            'maximum_delivery_distance' => 'nullable|numeric|min:0',
            'estimated_delivery_time' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'extra_charges' => 'nullable|array',
            'extra_charges.*.name' => 'required_with:extra_charges|string|max:255',
            'extra_charges.*.amount' => 'required_with:extra_charges|numeric|min:0',
            'extra_charges.*.type' => 'required_with:extra_charges|in:fixed,percentage',
            'working_hours' => 'nullable|array',
            'working_hours.*.day' => 'required_with:working_hours|integer|between:0,6',
            'working_hours.*.start' => 'required_with:working_hours|date_format:H:i',
            'working_hours.*.end' => 'required_with:working_hours|date_format:H:i',
            'working_hours.*.is_active' => 'required_with:working_hours|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_default'] = $request->has('is_default');
        
        // Handle polygon coordinates
        if ($request->delivery_type === 'polygon' && $request->polygon_coordinates) {
            $data['polygon_coordinates'] = json_encode($request->polygon_coordinates);
        }
        
        // Handle postal codes
        if ($request->delivery_type === 'postal_code' && $request->postal_codes) {
            $data['postal_codes'] = json_encode($request->postal_codes);
        }
        
        // Handle extra charges
        if ($request->extra_charges) {
            $data['extra_charges'] = json_encode($request->extra_charges);
        }
        
        // Handle working hours
        if ($request->working_hours) {
            $data['working_hours'] = json_encode($request->working_hours);
        }
        
        // Generate unique slug
        $data['slug'] = Str::slug($request->name);
        
        // If this is set as default, unset other defaults
        if ($request->is_default) {
            DeliveryZone::where('is_default', true)->update(['is_default' => false]);
        }
        
        DeliveryZone::create($data);

        return redirect()->route('admin.delivery-zones.index')
            ->with('success', 'Delivery zone created successfully.');
    }

    /**
     * Display the specified delivery zone.
     */
    public function show(DeliveryZone $deliveryZone)
    {
        return view('admin.delivery-zones.show', compact('deliveryZone'));
    }

    /**
     * Show the form for editing the specified delivery zone.
     */
    public function edit(DeliveryZone $deliveryZone)
    {
        return view('admin.delivery-zones.edit', compact('deliveryZone'));
    }

    /**
     * Update the specified delivery zone.
     */
    public function update(Request $request, DeliveryZone $deliveryZone)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:delivery_zones,name,' . $deliveryZone->id,
            'description' => 'nullable|string',
            'delivery_type' => 'required|in:radius,polygon,postal_code',
            'center_latitude' => 'required_if:delivery_type,radius|numeric|between:-90,90',
            'center_longitude' => 'required_if:delivery_type,radius|numeric|between:-180,180',
            'radius_km' => 'required_if:delivery_type,radius|numeric|min:0.1',
            'polygon_coordinates' => 'required_if:delivery_type,polygon|array|min:3',
            'postal_codes' => 'required_if:delivery_type,postal_code|array|min:1',
            'base_delivery_fee' => 'required|numeric|min:0',
            'per_km_fee' => 'nullable|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'free_delivery_threshold' => 'nullable|numeric|min:0',
            'maximum_delivery_distance' => 'nullable|numeric|min:0',
            'estimated_delivery_time' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'extra_charges' => 'nullable|array',
            'extra_charges.*.name' => 'required_with:extra_charges|string|max:255',
            'extra_charges.*.amount' => 'required_with:extra_charges|numeric|min:0',
            'extra_charges.*.type' => 'required_with:extra_charges|in:fixed,percentage',
            'working_hours' => 'nullable|array',
            'working_hours.*.day' => 'required_with:working_hours|integer|between:0,6',
            'working_hours.*.start' => 'required_with:working_hours|date_format:H:i',
            'working_hours.*.end' => 'required_with:working_hours|date_format:H:i',
            'working_hours.*.is_active' => 'required_with:working_hours|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_default'] = $request->has('is_default');
        
        // Handle polygon coordinates
        if ($request->delivery_type === 'polygon' && $request->polygon_coordinates) {
            $data['polygon_coordinates'] = json_encode($request->polygon_coordinates);
        }
        
        // Handle postal codes
        if ($request->delivery_type === 'postal_code' && $request->postal_codes) {
            $data['postal_codes'] = json_encode($request->postal_codes);
        }
        
        // Handle extra charges
        if ($request->extra_charges) {
            $data['extra_charges'] = json_encode($request->extra_charges);
        }
        
        // Handle working hours
        if ($request->working_hours) {
            $data['working_hours'] = json_encode($request->working_hours);
        }
        
        // If this is set as default, unset other defaults
        if ($request->is_default && !$deliveryZone->is_default) {
            DeliveryZone::where('is_default', true)->update(['is_default' => false]);
        }
        
        $deliveryZone->update($data);

        return redirect()->route('admin.delivery-zones.index')
            ->with('success', 'Delivery zone updated successfully.');
    }

    /**
     * Toggle the status of the specified delivery zone.
     */
    public function toggleStatus(DeliveryZone $deliveryZone)
    {
        $deliveryZone->update(['is_active' => !$deliveryZone->is_active]);
        
        $status = $deliveryZone->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Delivery zone {$status}.");
    }

    /**
     * Set the specified delivery zone as default.
     */
    public function setDefault(DeliveryZone $deliveryZone)
    {
        // Unset other defaults
        DeliveryZone::where('is_default', true)->update(['is_default' => false]);
        
        // Set this as default
        $deliveryZone->update(['is_default' => true, 'is_active' => true]);
        
        return redirect()->back()->with('success', 'Default delivery zone updated.');
    }

    /**
     * Check if address is within delivery zone (AJAX).
     */
    public function checkDelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coordinates provided.'
            ], 400);
        }

        $zone = DeliveryZone::where('is_active', true)
            ->get()
            ->filter(function ($zone) use ($request) {
                return $zone->containsPoint($request->latitude, $request->longitude);
            })
            ->first();

        if ($zone) {
            $fee = $zone->calculateFee($request->latitude, $request->longitude);
            return response()->json([
                'success' => true,
                'deliverable' => true,
                'zone' => $zone->name,
                'delivery_fee' => $fee,
                'estimated_time' => $zone->estimated_delivery_time,
            ]);
        }

        return response()->json([
            'success' => true,
            'deliverable' => false,
            'message' => 'Location not within any delivery zone.'
        ]);
    }

    /**
     * Clone the specified delivery zone.
     */
    public function clone(DeliveryZone $deliveryZone)
    {
        $clone = $deliveryZone->replicate();
        $clone->name = $deliveryZone->name . ' (Copy)';
        $clone->slug = Str::slug($clone->name);
        $clone->is_default = false;
        $clone->is_active = false;
        $clone->save();

        return redirect()->route('admin.delivery-zones.edit', $clone->id)
            ->with('success', 'Delivery zone cloned. You can now edit it.');
    }

    /**
     * Remove the specified delivery zone.
     */
    public function destroy(DeliveryZone $deliveryZone)
    {
        // Prevent deleting default zone
        if ($deliveryZone->is_default) {
            return redirect()->back()->with('error', 'Cannot delete the default delivery zone.');
        }
        
        $deliveryZone->delete();

        return redirect()->route('admin.delivery-zones.index')
            ->with('success', 'Delivery zone deleted successfully.');
    }

    /**
     * Bulk toggle status for delivery zones.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'zone_ids' => 'required|array',
            'zone_ids.*' => 'exists:delivery_zones,id',
            'status' => 'required|boolean',
        ]);

        DeliveryZone::whereIn('id', $request->zone_ids)->update([
            'is_active' => $request->status
        ]);

        $status = $request->status ? 'enabled' : 'disabled';
        return response()->json([
            'success' => true,
            'message' => "{$request->status} delivery zones {$status}."
        ]);
    }

    /**
     * Get delivery zone statistics.
     */
    public function statistics()
    {
        $stats = [
            'total_zones' => DeliveryZone::count(),
            'active_zones' => DeliveryZone::where('is_active', true)->count(),
            'inactive_zones' => DeliveryZone::where('is_active', false)->count(),
            'radius_zones' => DeliveryZone::where('delivery_type', 'radius')->count(),
            'polygon_zones' => DeliveryZone::where('delivery_type', 'polygon')->count(),
            'postal_code_zones' => DeliveryZone::where('delivery_type', 'postal_code')->count(),
            'default_zone' => DeliveryZone::where('is_default', true)->first(),
            'average_delivery_fee' => DeliveryZone::where('is_active', true)->avg('base_delivery_fee'),
        ];

        return view('admin.delivery-zones.statistics', compact('stats'));
    }
}
