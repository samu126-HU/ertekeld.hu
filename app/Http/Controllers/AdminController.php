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
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('AdminManagement', [
            'users' => $users,
            'filters' => $request->only(['search'])
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

    public function adminLevels()
    {
        $users = User::with('admin')->paginate(10);

        return Inertia::render('AdminManagement', [
            'users' => $users,
        ]);
    }

    public function updateAdminLevel(Request $request, User $user)
    {
        $validated = $request->validate([
            'level' => 'required|integer|min:0|max:2',
        ]);

        $user->admin()->updateOrCreate(
            ['user_id' => $user->id],
            ['adminLevel' => $validated['level']]
        );

        return back()->with('success', 'Admin level updated successfully.');
    }
}
