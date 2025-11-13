<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class SyncNotificationController extends Controller
{
    public function getLatest()
    {
        $notification = Cache::get('last_sync_notification');
        
        if (!$notification) {
            return response()->json(['notification' => null]);
        }

        return response()->json([
            'notification' => $notification,
            'id' => 'sync-notification-' . str_replace([' ', ':'], '-', $notification['timestamp'] ?? time())
        ]);
    }
}
