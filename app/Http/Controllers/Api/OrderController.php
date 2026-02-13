<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get pending orders for monitoring
     */
    public function pending()
    {
        $orders = DB::table('orders')
            ->whereIn('status', ['pending', 'processing'])
            ->orderBy('created_at', 'asc')
            ->limit(50)
            ->get();
            
        return response()->json([
            'data' => $orders,
            'count' => $orders->count(),
        ]);
    }
    
    /**
     * Get today's orders
     */
    public function today()
    {
        $orders = DB::table('orders')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'data' => $orders,
            'count' => $orders->count(),
        ]);
    }
    
    /**
     * Get order statistics
     */
    public function stats()
    {
        $today = today();
        $startOfWeek = $today->copy()->startOfWeek();
        
        return response()->json([
            'today' => [
                'orders' => DB::table('orders')
                    ->whereDate('created_at', $today)
                    ->count(),
                'revenue' => DB::table('orders')
                    ->whereDate('created_at', $today)
                    ->where('status', 'completed')
                    ->sum('total_amount'),
                'pending' => DB::table('orders')
                    ->whereDate('created_at', $today)
                    ->whereIn('status', ['pending', 'processing'])
                    ->count(),
            ],
            'this_week' => [
                'orders' => DB::table('orders')
                    ->whereBetween('created_at', [$startOfWeek, $today])
                    ->count(),
                'revenue' => DB::table('orders')
                    ->whereBetween('created_at', [$startOfWeek, $today])
                    ->where('status', 'completed')
                    ->sum('total_amount'),
            ],
            'by_status' => DB::table('orders')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get(),
        ]);
    }
}
