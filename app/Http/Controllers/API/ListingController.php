<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(): JsonResponse{
        $listings = listing::query()->withCount('transactions')->orderBy('transactions_count', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Get All Listings',
            'data' => $listings,
        ]);
    }

    public function show(listing $listing): JsonResponse{
        $listing_detail = $listing::query()->where('slug', $listing->slug)->first();
        return response()->json([
            'success' => true,
            'message' => 'Get Detail Listing',
            'data'=> $listing_detail,
        ]);
    }
}
