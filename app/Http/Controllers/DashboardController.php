<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalProducts = $user->products()->count();
        $totalValue = $user->products()->sum('price');
        $recentProducts = $user->products()->latest()->take(5)->get();
        
        return view('dashboard', compact('totalProducts', 'totalValue', 'recentProducts'));
    }
}