@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter un Nouveau Produit
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nom du produit -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag text-primary"></i> Nom du Produit *
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Ex: iPhone 15, Nike Air Max..."
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
                                      placeholder="Description détaillée du produit (optionnel)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Image du produit -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                <i class="fas fa-camera text-danger"></i> Image du Produit *
                            </label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   required>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-exclamation-triangle text-warning"></i> 
                                <strong>Obligatoire</strong> - Formats acceptés : JPEG, PNG, JPG. Taille max : 2Mo
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
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
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
                                           value="{{ old('price') }}" 
                                           step="0.01" 
                                           min="0.01" 
                                           placeholder="9.99"
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
                                           value="{{ old('quantity') }}" 
                                           min="0" 
                                           placeholder="10"
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
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour à la Liste
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le Produit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection