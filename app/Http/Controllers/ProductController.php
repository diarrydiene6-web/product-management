<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()->products()->paginate(6); // Pagination de 6 par page
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image OBLIGATOIRE
            'price' => 'required|numeric|min:0.01', // Prix positif obligatoire
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string'
        ], [
            'name.required' => 'Le nom du produit est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.min' => 'Le prix doit être positif.',
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPG ou PNG.',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo.'
        ]);

        $data = $request->all();

        // Upload de l'image (obligatoire)
        $imagePath = $request->file('image')->store('products', 'public');
        $data['image'] = $imagePath;

        auth()->user()->products()->create($data);

        return redirect()->route('products.index')
                         ->with('success', 'Produit créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Vérifier que le produit appartient à l'utilisateur connecté
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Vérifier que le produit appartient à l'utilisateur connecté
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Vérifier que le produit appartient à l'utilisateur connecté
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Optionnelle en modification
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string'
        ], [
            'name.required' => 'Le nom du produit est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.min' => 'Le prix doit être positif.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPG ou PNG.',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo.'
        ]);

        $data = $request->all();

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')
                         ->with('success', 'Produit modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Vérifier que le produit appartient à l'utilisateur connecté
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        // Supprimer l'image si elle existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Produit supprimé avec succès !');
}
}