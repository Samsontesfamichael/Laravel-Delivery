<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AIMenuService;
use App\Services\AIImageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AIController extends Controller
{
    protected $menuService;
    protected $imageService;

    public function __construct(AIMenuService $menuService, AIImageService $imageService)
    {
        $this->menuService = $menuService;
        $this->imageService = $imageService;
    }

    /**
     * Generate menu description
     * POST /api/ai/menu-description
     */
    public function generateMenuDescription(Request $request): JsonResponse
    {
        $request->validate([
            'food_name' => 'required|string',
            'ingredients' => 'nullable|array',
            'cuisine' => 'nullable|string',
        ]);

        $description = $this->menuService->generateMenuDescription(
            $request->food_name,
            $request->ingredients ?? array(),
            $request->cuisine ?? ''
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'food_name' => $request->food_name,
                'description' => $description,
            ),
        ]);
    }

    /**
     * Generate bulk menu descriptions
     * POST /api/ai/bulk-menu-descriptions
     */
    public function generateBulkMenuDescriptions(Request $request): JsonResponse
    {
        $request->validate([
            'menu_items' => 'required|array',
        ]);

        $results = $this->menuService->generateBulkMenuDescriptions(
            $request->menu_items
        );

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    /**
     * Generate SEO title
     * POST /api/ai/seo-title
     */
    public function generateSEOTitle(Request $request): JsonResponse
    {
        $request->validate([
            'food_name' => 'required|string',
            'restaurant_name' => 'required|string',
        ]);

        $title = $this->menuService->generateSEOTitle(
            $request->food_name,
            $request->restaurant_name
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'title' => $title,
            ),
        ]);
    }

    /**
     * Generate restaurant bio
     * POST /api/ai/restaurant-bio
     */
    public function generateRestaurantBio(Request $request): JsonResponse
    {
        $request->validate([
            'restaurant_name' => 'required|string',
            'cuisine' => 'required|string',
            'specialties' => 'nullable|array',
        ]);

        $bio = $this->menuService->generateRestaurantBio(
            $request->restaurant_name,
            $request->cuisine,
            $request->specialties ?? array()
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'bio' => $bio,
            ),
        ]);
    }

    /**
     * Generate customer support response
     * POST /api/ai/support-response
     */
    public function generateSupportResponse(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string',
            'context' => 'nullable|array',
        ]);

        $response = $this->menuService->generateSupportResponse(
            $request->query,
            $request->context ?? array()
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'response' => $response,
            ),
        ]);
    }

    /**
     * Suggest daily specials
     * POST /api/ai/daily-specials
     */
    public function suggestDailySpecials(Request $request): JsonResponse
    {
        $request->validate([
            'ingredients' => 'required|array',
            'cuisine' => 'required|string',
        ]);

        $specials = $this->menuService->suggestDailySpecials(
            $request->ingredients,
            $request->cuisine
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'specials' => $specials,
            ),
        ]);
    }

    /**
     * Analyze review sentiment
     * POST /api/ai/review-sentiment
     */
    public function analyzeReviewSentiment(Request $request): JsonResponse
    {
        $request->validate([
            'review' => 'required|string',
        ]);

        $analysis = $this->menuService->analyzeReviewSentiment($request->review);

        return response()->json([
            'success' => true,
            'data' => array(
                'analysis' => $analysis,
            ),
        ]);
    }

    /**
     * Generate delivery instructions
     * POST /api/ai/delivery-instructions
     */
    public function generateDeliveryInstructions(Request $request): JsonResponse
    {
        $request->validate([
            'order' => 'required|array',
            'restaurant' => 'required|array',
            'customer' => 'required|array',
        ]);

        $instructions = $this->menuService->generateDeliveryInstructions(
            $request->order,
            $request->restaurant,
            $request->customer
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'instructions' => $instructions,
            ),
        ]);
    }

    /**
     * Generate food image
     * POST /api/ai/generate-image
     */
    public function generateFoodImage(Request $request): JsonResponse
    {
        $request->validate([
            'food_name' => 'required|string',
            'description' => 'nullable|string',
            'style' => 'nullable|string|in:photorealistic,artistic,professional,minimalist',
        ]);

        $imagePath = $this->imageService->generateFoodImage(
            $request->food_name,
            $request->description ?? '',
            $request->style ?? 'photorealistic'
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'image_path' => $imagePath,
                'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
            ),
        ]);
    }

    /**
     * Generate restaurant image
     * POST /api/ai/generate-restaurant-image
     */
    public function generateRestaurantImage(Request $request): JsonResponse
    {
        $request->validate([
            'restaurant_name' => 'required|string',
            'cuisine' => 'required|string',
            'style' => 'nullable|string',
        ]);

        $imagePath = $this->imageService->generateRestaurantImage(
            $request->restaurant_name,
            $request->cuisine,
            $request->style ?? 'professional photography'
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'image_path' => $imagePath,
                'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
            ),
        ]);
    }

    /**
     * Generate category banner
     * POST /api/ai/generate-category-banner
     */
    public function generateCategoryBanner(Request $request): JsonResponse
    {
        $request->validate([
            'category_name' => 'required|string',
            'style' => 'nullable|string',
        ]);

        $imagePath = $this->imageService->generateCategoryBanner(
            $request->category_name,
            $request->style ?? 'vibrant food photography'
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'image_path' => $imagePath,
                'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
            ),
        ]);
    }

    /**
     * Custom image generation
     * POST /api/ai/custom-image
     */
    public function customImage(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $imagePath = $this->imageService->generateFromPrompt($request->prompt);

        return response()->json([
            'success' => true,
            'data' => array(
                'image_path' => $imagePath,
                'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
            ),
        ]);
    }
}
