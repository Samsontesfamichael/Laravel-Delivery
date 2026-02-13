<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AIImageService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.openai.com/v1/images/generations';

    public function __construct()
    {
        $this->apiKey = config('openai.api_key');
    }

    /**
     * Generate food image using DALL-E
     */
    public function generateFoodImage($foodName, $description = '', $style = 'photorealistic')
    {
        if (!$this->apiKey) {
            Log::warning('OpenAI API key not configured');
            return null;
        }

        $prompt = $this->buildImagePrompt($foodName, $description, $style);

        try {
            $response = Http::timeout(60)
                ->withHeaders(array(
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ))
                ->post($this->apiUrl, array(
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => '1024x1024',
                    'response_format' => 'url',
                ));

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['data'][0]['url'];
                
                // Download and save image
                return $this->downloadAndSaveImage($imageUrl, $foodName);
            }

            Log::error('DALL-E API error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('DALL-E API exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate multiple food images
     */
    public function generateMultipleFoodImages($foodItems, $style = 'photorealistic')
    {
        $results = array();
        
        foreach ($foodItems as $item) {
            $imagePath = $this->generateFoodImage(
                $item['name'],
                isset($item['description']) ? $item['description'] : '',
                $style
            );
            
            $results[] = array(
                'name' => $item['name'],
                'image_path' => $imagePath,
            );
            
            // Add delay to avoid rate limiting
            sleep(5);
        }
        
        return $results;
    }

    /**
     * Generate restaurant cover image
     */
    public function generateRestaurantImage($restaurantName, $cuisine, $style = 'professional photography')
    {
        $prompt = "Professional " . $style . " of a " . $cuisine . " restaurant called '" . $restaurantName . "'. 
        Clean, appetizing, modern restaurant interior or exterior shot. 
        High quality, 4k, detailed, professional food photography style.";

        return $this->generateFromPrompt($prompt);
    }

    /**
     * Generate category banner image
     */
    public function generateCategoryBanner($categoryName, $style = 'vibrant food photography')
    {
        $prompt = $style . " banner for " . $categoryName . " food category. 
        Colorful, appetizing display of various " . $categoryName . " dishes. 
        Clean background, professional food photography, 4k quality.";

        return $this->generateFromPrompt($prompt);
    }

    /**
     * Generate promotional banner
     */
    public function generatePromoBanner($promoText, $theme = 'food delivery')
    {
        $prompt = "Professional promotional banner for food delivery service. 
        Text: '" . $promoText . "'. 
        " . $theme . " theme, vibrant colors, appetizing food imagery, 
        modern design, 4k quality, clean composition.";

        return $this->generateFromPrompt($prompt);
    }

    /**
     * Generate variation images for food item
     */
    public function generateVariationImages($baseFoodName, $variations)
    {
        $results = array();
        
        foreach ($variations as $variation) {
            $prompt = "Photorealistic image of " . $variation . " " . $baseFoodName . ". 
            Professional food photography, appetizing, clean presentation, 
            high quality, 4k, studio lighting.";
            
            $imagePath = $this->generateFromPrompt($prompt);
            
            $results[] = array(
                'variation' => $variation,
                'image_path' => $imagePath,
            );
            
            sleep(5);
        }
        
        return $results;
    }

    /**
     * Generate image from custom prompt
     */
    public function generateFromPrompt($prompt)
    {
        if (!$this->apiKey) {
            return null;
        }

        try {
            $response = Http::timeout(60)
                ->withHeaders(array(
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ))
                ->post($this->apiUrl, array(
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => '1024x1024',
                    'response_format' => 'url',
                ));

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['data'][0]['url'];
                
                return $this->downloadAndSaveImage($imageUrl, md5($prompt));
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Image generation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build image prompt
     */
    private function buildImagePrompt($foodName, $description, $style)
    {
        $basePrompt = "Professional " . $style . " of " . $foodName;
        
        if (!empty($description)) {
            $basePrompt .= ". " . $description;
        }
        
        $basePrompt .= ". Clean presentation, appetizing, high quality, 4k, 
        professional food photography, studio lighting, white or neutral background,
        detailed, realistic, food photography masterpiece.";

        return $basePrompt;
    }

    /**
     * Download and save image to storage
     */
    private function downloadAndSaveImage($imageUrl, $filename)
    {
        try {
            $imageContent = file_get_contents($imageUrl);
            
            if ($imageContent === false) {
                return null;
            }
            
            // Sanitize filename
            $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
            $filename = $filename . '_' . time() . '.png';
            
            // Save to public storage
            $path = 'food_images/' . $filename;
            Storage::disk('public')->put($path, $imageContent);
            
            return $path;

        } catch (\Exception $e) {
            Log::error('Image download error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Edit existing image (using DALL-E 2)
     */
    public function editFoodImage($imagePath, $maskPath, $editPrompt)
    {
        // This would require DALL-E 2 for image editing
        // Implementation similar to generation but with image/mask upload
        Log::info('Image editing feature - requires DALL-E 2');
        return null;
    }

    /**
     * Create variations of existing image
     */
    public function createImageVariations($imagePath, $count = 3)
    {
        // This would require DALL-E 2 for image variations
        Log::info('Image variations feature - requires DALL-E 2');
        return null;
    }
}
