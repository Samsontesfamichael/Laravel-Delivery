<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{
    /**
     * Get system status for n8n monitoring
     */
    public function status()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();
            $dbStatus = 'connected';
            
            // Get today's order statistics
            $ordersToday = DB::table('orders')
                ->whereDate('created_at', today())
                ->count();
            
            $revenueToday = DB::table('orders')
                ->whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $pendingDeliveries = DB::table('orders')
                ->whereIn('status', ['pending', 'processing'])
                ->count();
            
            // Get top restaurant
            $topRestaurant = DB::table('restaurants')
                ->join('orders', 'restaurants.id', '=', 'orders.restaurant_id')
                ->whereDate('orders.created_at', today())
                ->groupBy('restaurants.id', 'restaurants.name')
                ->orderByRaw('COUNT(*) DESC')
                ->select('restaurants.name', DB::raw('COUNT(*) as order_count'))
                ->first();
            
            // Determine system status
            $status = 'healthy';
            $errorMessage = null;
            
            if ($pendingDeliveries > 50) {
                $status = 'warning';
            }
            if ($ordersToday > 1000) {
                $status = 'critical';
                $errorMessage = 'High order volume detected';
            }
            
            return response()->json([
                'status' => $status,
                'timestamp' => now()->toIso8601String(),
                'orders_today' => $ordersToday,
                'revenue_today' => $revenueToday ?? 0,
                'pending_deliveries' => $pendingDeliveries,
                'top_restaurant' => $topRestaurant->name ?? 'N/A',
                'database' => $dbStatus,
                'error_message' => $errorMessage,
                'alert_phone' => config('services.whatsapp.alert_phone'),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'critical',
                'timestamp' => now()->toIso8601String(),
                'error_message' => $e->getMessage(),
                'database' => 'disconnected',
            ], 500);
        }
    }
    
    /**
     * Simple health check endpoint
     */
    public function health()
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];
        
        $allHealthy = !in_array(false, array_column($checks, 'status'));
        
        return response()->json([
            'healthy' => $allHealthy,
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ], $allHealthy ? 200 : 503);
    }
    
    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => true, 'message' => 'Connected'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
    private function checkCache()
    {
        try {
            Cache::put('health_check', true, 10);
            return ['status' => Cache::get('health_check'), 'message' => 'Working'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
    private function checkStorage()
    {
        try {
            $path = storage_path('framework/cache');
            return ['status' => is_writable($path), 'message' => 'Writable'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Send Telegram notification
     */
    public function sendTelegram(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'chat_id' => 'nullable|string',
        ]);
        
        $botToken = config('services.telegram.bot_token');
        $chatId = $request->chat_id ?? config('services.telegram.chat_id');
        
        if (!$botToken || !$chatId) {
            return response()->json(['error' => 'Telegram not configured'], 400);
        }
        
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        
        $response = \Http::post($url, [
            'chat_id' => $chatId,
            'text' => $request->message,
            'parse_mode' => 'Markdown',
        ]);
        
        return response()->json($response->json());
    }
    
    /**
     * Send WhatsApp notification
     */
    public function sendWhatsApp(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'phone' => 'required|string',
        ]);
        
        $venomUrl = config('services.whatsapp.api_url');
        
        try {
            $response = \Http::post("{$venomUrl}/send/text", [
                'phone' => $request->phone,
                'message' => $request->message,
            ]);
            
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
