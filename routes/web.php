<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil (accessible à tous)
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification (login, register, etc.)
Auth::routes();

// Routes protégées (nécessitent d'être connecté)
Route::middleware('auth')->group(function () {
    
    // Page d'accueil après connexion
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Dashboard
    Route::get('/dashboard', function () {
        try {
            $user = auth()->user();
            $totalProducts = $user->products()->count() ?? 0;
            $totalValue = $user->products()->sum('price') ?? 0;
            $recentProducts = $user->products()->latest()->take(5)->get() ?? collect();
        } catch (\Exception $e) {
            // Si la table products n'existe pas encore
            $totalProducts = 0;
            $totalValue = 0;
            $recentProducts = collect(); // Collection vide
        }
        
        return view('dashboard', compact('totalProducts', 'totalValue', 'recentProducts'));
    })->name('dashboard');
    
    // Routes pour les produits
    Route::resource('products', ProductController::class);
    Route::get('/my-products', [ProductController::class, 'index'])->name('my-products');
});