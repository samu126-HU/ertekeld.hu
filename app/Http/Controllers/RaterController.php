<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class RaterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('rater')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->toArray();

        return Inertia::render('RateManagement', [
            'users' => $users,
            'filters' => $request->only(['search']),
        ]);
    }

    public function toggleRating(User $user)
    {
        $user->rater()->updateOrCreate(
            ['user_id' => $user->id],
            ['canRate' => !$user->canRate()]
        );

        return back();
    }
}
