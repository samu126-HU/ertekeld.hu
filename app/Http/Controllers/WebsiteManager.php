<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Website;

class WebsiteManager extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $websites = Website::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('WebsiteManagement', [
            'websites' => $websites,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $website = new Website();
        $website->name = $validatedData['name'];
        $website->url = $validatedData['url'];
        $website->average_rating = 0.00;
        $website->total_ratings = 0;
        $website->save();

        return redirect('/management/websites')->with('successMessage', 'Weboldal sikeresen hozzáadva.');

    }

    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();

        return redirect('/management/websites')->with('successMessage', 'Weboldal sikeresen hozzáadva.');

    }
}
