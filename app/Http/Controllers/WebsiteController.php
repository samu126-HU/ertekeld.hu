<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Rating;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();
        $userRatings = auth()->user()->ratings()
            ->get()
            ->pluck('rating', 'website_id')
            ->toArray();

        $canRate = auth()->user()->rater->canRate;


        return Inertia::render('Rate', [
            'websites' => $websites,
            'userRatings' => $userRatings,
            'canRate'=> $canRate
        ]);
    }

    public function rate(Request $request)
    {
        $validated = $request->validate([
            'website_id' => 'required|exists:websites,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'website_id' => $validated['website_id']
            ],
            ['rating' => $validated['rating']]
        );

        $rating->website->updateAverageRating();

        return back();
    }
}