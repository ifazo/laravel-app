<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryItems = Review::query();

        if ($request->has('productId')) {
            $queryItems->where('product_id', '=', $request->productId);
        } else {
            return response()->json([
                'error' => 'The productId parameter is required.'
            ], 400);
        }

        $reviews = $queryItems->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found for this product.']);
        }
        return response()->json(
            [
                'message' => 'Reviews of this product found.',
                'data' => ReviewResource::collection($reviews)
            ],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {

        $review = Review::create($request->validated());

        return response()->json(
            [
                'message' => 'Review created successfully.',
                'data' => new ReviewResource($review)
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json(
            [
                'message' => 'Review retrieved successfully.',
                'data' => new ReviewResource($review)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {

        $review->update($request->validated());

        return response()->json(
            [
                'message' => 'Review updated successfully.',
                'data' => new ReviewResource($review)
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.'], 200);
    }
}
