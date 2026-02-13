<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIMenuService
{
    protected $apiKey;
    protected $organization;
    protected $requestTimeout;

    public function __construct()
    {
        $this->apiKey = config('openai.api_key');
        $this->organization = config('openai.organization');
        $this->requestTimeout = config('openai.request_timeout', 30);
    }

    /**
     * Generate AI menu description
     */
    public function generateMenuDescription($foodName, $ingredients = array(), $cuisine = '')
    {
        $prompt = $this->buildMenuDescriptionPrompt($foodName, $ingredients, $cuisine);
        
        return $this->callGPT($prompt);
    }

    /**
     * Generate multiple menu descriptions in bulk
     */
    public function generateBulkMenuDescriptions($menuItems)
    {
        $results = array();
        
        foreach ($menuItems as $item) {
            $description = $this->generateMenuDescription(
                $item['name'],
                isset($item['ingredients']) ? $item['ingredients'] : array(),
                isset($item['cuisine']) ? $item['cuisine'] : ''
            );
            
            $results[] = array(
                'name' => $item['name'],
                'description' => $description,
            );
            
            // Add delay to avoid rate limiting
            sleep(1);
        }
        
        return $results;
    }

    /**
     * Generate SEO-friendly food title
     */
    public function generateSEOTitle($foodName, $restaurantName)
    {
        $prompt = "Generate a catchy, SEO-friendly title for a food item called '" . $foodName . "' from restaurant '" . $restaurantName . "'. Keep it under 60 characters.";
        
        return $this->callGPT($prompt);
    }

    /**
     * Generate restaurant bio
     */
    public function generateRestaurantBio($restaurantName, $cuisine, $specialties = array())
    {
        $prompt = "Write an engaging 2-3 sentence bio for a " . $cuisine . " restaurant called '" . $restaurantName . "'.";
        
        if (!empty($specialties)) {
            $prompt .= " Their specialties include: " . implode(', ', $specialties);
        }
        
        return $this->callGPT($prompt);
    }

    /**
     * Generate AI response for customer support
     */
    public function generateSupportResponse($customerQuery, $context = array())
    {
        $systemPrompt = "You are a helpful customer support agent for a food delivery service. Be polite, concise, and helpful.";
        
        $prompt = "Customer asks: " . $customerQuery;
        
        if (!empty($context)) {
            $prompt .= "\n\nContext: " . json_encode($context);
        }
        
        return $this->callGPT($prompt, $systemPrompt);
    }

    /**
     * Generate daily specials suggestions
     */
    public function suggestDailySpecials($availableIngredients, $cuisine)
    {
        $ingredients = implode(', ', $availableIngredients);
        
        $prompt = "As a " . $cuisine . " chef, suggest 5 creative daily special dishes using these ingredients: " . $ingredients . ". 
        
For each dish, provide:
1. Name
2. Brief description
3. Suggested price
4. Cooking time

Format as JSON array.";

        return $this->callGPT($prompt);
    }

    /**
     * Analyze customer review sentiment
     */
    public function analyzeReviewSentiment($review)
    {
        $prompt = "Analyze this restaurant review and provide:
1. Sentiment (positive/negative/neutral)
2. Key points mentioned
3. Rating suggestion (1-5 stars)

Review: " . $review . "

Format response as JSON with keys: sentiment, key_points, rating_suggestion";

        return $this->callGPT($prompt);
    }

    /**
     * Generate order summary for delivery driver
     */
    public function generateDeliveryInstructions($order, $restaurant, $customer)
    {
        $orderNotes = 'None';
        if (isset($order['notes'])) {
            $orderNotes = $order['notes'];
        }
        
        $prompt = "Generate clear delivery instructions for a driver:

Restaurant: " . $restaurant['name'] . "
Restaurant Address: " . $restaurant['address'] . "
Customer: " . $customer['name'] . "
Customer Address: " . $customer['address'] . "
Order Notes: " . $orderNotes . "

Provide concise, clear instructions in bullet points.";

        return $this->callGPT($prompt);
    }

    /**
     * Build menu description prompt
     */
    private function buildMenuDescriptionPrompt($foodName, $ingredients, $cuisine)
    {
        $ingredientList = !empty($ingredients) ? implode(', ', $ingredients) : 'fresh ingredients';
        
        return "Write a mouthwatering, appetizing description for a " . $cuisine . " dish called '" . $foodName . "'. 
        
Use these ingredients: " . $ingredientList . "

Requirements:
- 1-2 sentences only
- Highlight key flavors and textures
- Make it sound delicious and irresistible
- No special characters or emojis
- Start with an action verb";
    }

    /**
     * Call GPT-4 API
     */
    private function callGPT($userPrompt, $systemPrompt = null)
    {
        if (!$this->apiKey) {
            Log::warning('OpenAI API key not configured');
            return null;
        }

        try {
            $messages = array();
            
            if ($systemPrompt) {
                $messages[] = array(
                    'role' => 'system',
                    'content' => $systemPrompt
                );
            }
            
            $messages[] = array(
                'role' => 'user',
                'content' => $userPrompt
            );

            $response = Http::timeout($this->requestTimeout)
                ->withHeaders(array(
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ))
                ->post('https://api.openai.com/v1/chat/completions', array(
                    'model' => 'gpt-4',
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 500,
                ));

            if ($response->successful()) {
                $data = $response->json();
                return trim($data['choices'][0]['message']['content']);
            }

            Log::error('OpenAI API error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('OpenAI API exception: ' . $e->getMessage());
            return null;
        }
    }
}
