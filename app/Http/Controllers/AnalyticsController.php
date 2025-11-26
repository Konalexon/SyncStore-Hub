<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use App\Models\StreamAnalytics;
use App\Models\StreamInteraction;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function recordViewerCount(Request $request, $streamId)
    {
        $request->validate([
            'count' => 'required|integer|min:0'
        ]);

        StreamAnalytics::create([
            'live_stream_id' => $streamId,
            'viewer_count' => $request->count
        ]);

        return response()->json(['success' => true]);
    }

    public function recordClick(Request $request, $streamId)
    {
        StreamInteraction::create([
            'live_stream_id' => $streamId,
            'interaction_type' => 'click',
            'user_id' => Auth::id()
        ]);

        return response()->json(['success' => true]);
    }

    public function getStats($streamId)
    {
        // 1. Viewer History (Last 30 minutes)
        $viewerHistory = StreamAnalytics::where('live_stream_id', $streamId)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->orderBy('created_at')
            ->get(['created_at', 'viewer_count'])
            ->map(function ($item) {
                return [
                    'time' => $item->created_at->format('H:i:s'),
                    'count' => $item->viewer_count
                ];
            });

        // 2. Conversion Funnel
        $clicks = StreamInteraction::where('live_stream_id', $streamId)
            ->where('interaction_type', 'click')
            ->count();

        // Infer purchases from OrderItems created during the stream
        // This is a simplification; ideally we'd link orders to streams explicitly
        $stream = LiveStream::findOrFail($streamId);
        $purchases = 0;
        if ($stream->is_active) {
            // Logic to count purchases would go here. 
            // For now, we'll simulate it or use interactions if we tracked 'purchase' type
            $purchases = StreamInteraction::where('live_stream_id', $streamId)
                ->where('interaction_type', 'purchase')
                ->count();
        }

        // 3. Chat Heatmap (Messages per minute)
        $chatActivity = ChatMessage::select(
            DB::raw('DATE_FORMAT(created_at, "%H:%i") as minute'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subMinutes(30)) // Filter for this stream ideally
            ->groupBy('minute')
            ->orderBy('minute')
            ->get();

        return response()->json([
            'viewer_history' => $viewerHistory,
            'conversion' => [
                'clicks' => $clicks,
                'purchases' => $purchases
            ],
            'chat_activity' => $chatActivity
        ]);
    }
}
