<?php

use Illuminate\Contracts\Console\Kernel;
use App\Services\AIChatbot;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

function logOutput($message)
{
    file_put_contents('chatbot_result.log', $message . "\n", FILE_APPEND);
}

file_put_contents('chatbot_result.log', "--- Verifying AI Chatbot ---\n");

$bot = new AIChatbot();

// Test Fallback
logOutput("Testing Fallback (Keyword: 'shipping')...");
$response = $bot->ask("Tell me about shipping");
logOutput("Response: " . $response);

if (str_contains($response, "Fallback Mode")) {
    logOutput("✅ Fallback Verified: Response contains 'Fallback Mode'.");
} else {
    logOutput("❌ Fallback Failed: Response does not indicate fallback.");
}

// Test Unknown
logOutput("Testing Unknown Query...");
$response = $bot->ask("What is the meaning of life?");
logOutput("Response: " . $response);
