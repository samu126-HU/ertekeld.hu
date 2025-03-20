<?php

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RaterController;
use App\Http\Middleware\IsAdmin;
use App\Models\Raters;
use App\Models\Rating;
use App\Models\Website;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $totalWebsites = (int)Website::count();
    $totalRatings = (int)Rating::count();
    $averageRating = (float)Rating::avg('rating') ?? 0.0;
    $latestReviews = Rating::with(['user:id,name', 'website:id,name,url'])
        ->orderBy('updated_at', 'desc')
        ->latest()
        ->take(15)
        ->get();

    return Inertia::render('Dashboard', [
        'totalWebsites' => $totalWebsites,
        'totalRatings' => $totalRatings,
        'averageRating' => $averageRating,
        'latestReviews' => $latestReviews
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


//Access if logged in
Route::middleware(['auth'])->group(function () {
    //Rating of websites
    Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');
    Route::post('/websites/rate', [WebsiteController::class, 'rate'])->name('websites.rate');

    //Access if logged in & admin
    Route::middleware(IsAdmin::class)->group(function () {

        //Main navigation
        Route::get('management', [PermissionsController::class, 'index'])->name('management');

        //Rate ability management
        Route::get('/management/users', [RaterController::class, 'index'])
            ->name('management.users');
        Route::post('/users/{user}/toggle-rating', [RaterController::class, 'toggleRating'])
            ->name('users.toggle-rating');

        //Admin management
        Route::get('/management/admins', [AdminController::class, 'index'])
            ->name('management.admins');
        Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])
            ->name('users.toggle-admin');

    });

});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
