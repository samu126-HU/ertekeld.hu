<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('admin')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->toArray();

        return Inertia::render('AdminManagement', [
            'users' => $users,
            'filters' => $request->only(['search']),
        ]);
    }

    public function toggleAdmin(User $user)
    {
        $user->admin()->updateOrCreate(
            ['user_id' => $user->id],
            ['isAdmin' => !$user->isAdmin()]
        );

        return back();
    }
}
