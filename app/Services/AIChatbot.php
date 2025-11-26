<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class AIChatbot
{
    protected $knowledgeBase = [
        'shipping' => 'We offer free shipping on orders over $50. Standard delivery takes 3-5 business days.',
        'return' => 'You can return items within 30 days of purchase. Please keep the original packaging.',
        'payment' => 'We accept Visa, MasterCard, PayPal, and Stripe.',
        'live' => 'Our live auctions happen every Friday at 8 PM EST.',
        'discount' => 'Use code WELCOME10 for 10% off your first order!',
        'hello' => 'Hi there! How can I help you today?',
        'help' => 'I can help with shipping, returns, payments, and live stream info. Just ask!',
    ];

    public function ask($question)
    {
        $apiKey = env('GEMINI_API_KEY');

        // 1. Try Gemini API if key is present
        if ($apiKey) {
            try {
                return $this->callGeminiAPI($question, $apiKey);
            } catch (\Exception $e) {
                Log::error('Gemini API Error: ' . $e->getMessage());
                // Fallback to keyword matching on error
            }
        }

        // 2. Fallback: Keyword Matching
        $question = strtolower($question);
        foreach ($this->knowledgeBase as $keyword => $answer) {
            if (str_contains($question, $keyword)) {
                return $answer . " (Fallback Mode)";
            }
        }

        return "I'm not sure about that. Please contact our support team for more details.";
    }

    protected function callGeminiAPI($question, $apiKey)
    {
        // Fetch Product Context
        $products = Product::all(['name', 'price', 'description'])->take(5); // Limit context size
        $productContext = $products->map(function ($p) {
            return "- {$p->name} (\${$p->price}): {$p->description}";
        })->implode("\n");

        $systemPrompt = "You are a helpful shopping assistant for SyncStore Hub. 
        Here is our current product catalog:\n{$productContext}\n
        Answer the user's question based on this catalog. 
        If they ask for recommendations, suggest products from the list. 
        Keep answers concise (under 50 words).";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nUser: " . $question]
                            ]
                        ]
                    ]
                ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? "I'm having trouble thinking right now.";
        }

        throw new \Exception('API Request Failed: ' . $response->body());
    }
}
