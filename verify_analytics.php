<?php

use Illuminate\Contracts\Console\Kernel;
use App\Models\LiveStream;
use App\Models\StreamAnalytics;
use App\Models\StreamInteraction;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();


function logOutput($message)
{
    file_put_contents('analytics_result.log', $message . "\n", FILE_APPEND);
}

file_put_contents('analytics_result.log', "--- Verifying Analytics System ---\n");

// 1. Ensure Stream Exists
$stream = LiveStream::first();
if (!$stream) {
    logOutput("Creating test stream...");
    $stream = LiveStream::create([
        'user_id' => 1,
        'title' => 'Test Stream',
        'is_active' => true,
        'product_id' => 1, // Assuming product 1 exists
        'auction_end_time' => now()->addHour()
    ]);
}
logOutput("Using Stream ID: {$stream->id}");

// 2. Simulate Data Insertion
logOutput("Simulating data...");

// Viewers
StreamAnalytics::create(['live_stream_id' => $stream->id, 'viewer_count' => 10]);
StreamAnalytics::create(['live_stream_id' => $stream->id, 'viewer_count' => 15]);
StreamAnalytics::create(['live_stream_id' => $stream->id, 'viewer_count' => 25]);

// Clicks
StreamInteraction::create(['live_stream_id' => $stream->id, 'interaction_type' => 'click', 'user_id' => 1]);
StreamInteraction::create(['live_stream_id' => $stream->id, 'interaction_type' => 'click', 'user_id' => 1]);

logOutput("Data inserted successfully.");

// 3. Test Controller Logic (Get Stats)
logOutput("Testing Data Retrieval...");
$controller = new AnalyticsController();
$response = $controller->getStats($stream->id);
$data = $response->getData(true);

logOutput("\n--- API Response Preview ---");
logOutput("Viewer History Points: " . count($data['viewer_history']));
logOutput("Last Viewer Count: " . end($data['viewer_history'])['count']);
logOutput("Total Clicks: " . $data['conversion']['clicks']);
logOutput("Chat Activity Points: " . count($data['chat_activity']));

if (count($data['viewer_history']) >= 3 && $data['conversion']['clicks'] >= 2) {
    logOutput("\n✅ VERIFICATION SUCCESSFUL: Data is being stored and retrieved correctly.");
} else {
    logOutput("\n❌ VERIFICATION FAILED: Data mismatch.");
}
