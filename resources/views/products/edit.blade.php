@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modifier le Produit
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nom du produit -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag text-primary"></i> Nom du Produit *
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description/Détails -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left text-info"></i> Détails
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Description détaillée du produit (optionnel)">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Image actuelle -->
                        @if($product->image)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-image text-success"></i> Image actuelle
                            </label>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail"
                                     style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>
                        @endif

                        <!-- Nouvelle image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                <i class="fas fa-camera text-danger"></i> 
                                {{ $product->image ? 'Changer l\'image' : 'Ajouter une image' }}
                            </label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Formats acceptés : JPEG, PNG, JPG. Taille max : 2Mo
                                {{ $product->image ? '(Laisser vide pour garder l\'image actuelle)' : '' }}
                            </div>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-list text-warning"></i> Catégorie
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category">
                                <option value="">-- Sélectionner une catégorie --</option>
                                @foreach(\App\Models\Product::getCategories() as $key => $label)
                                    <option value="{{ $key }}" 
                                            {{ old('category', $product->category) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Prix -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        <i class="fas fa-euro-sign text-success"></i> Prix (€) *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $product->price) }}" 
                                           step="0.01" 
                                           min="0.01" 
                                           required>
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Quantité -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">
                                        <i class="fas fa-boxes text-info"></i> Quantité *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="{{ old('quantity', $product->quantity) }}" 
                                           min="0" 
                                           required>
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour aux détails
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection