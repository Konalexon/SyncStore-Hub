<?php

namespace App\Services;

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
        $question = strtolower($question);

        foreach ($this->knowledgeBase as $keyword => $answer) {
            if (str_contains($question, $keyword)) {
                return $answer;
            }
        }

        return "I'm not sure about that. Please contact our support team for more details.";
    }
}
