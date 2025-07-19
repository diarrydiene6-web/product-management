@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>{{ $product->name }}
                    </h4>
                    <div>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Image du produit -->
                        <div class="col-md-6">
                            <div class="text-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-fluid rounded shadow"
                                         style="max-height: 400px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="height: 300px;">
                                        <span class="text-muted">
                                            <i class="fas fa-image fa-3x"></i><br>
                                            Aucune image
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Détails du produit -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong><i class="fas fa-tag text-primary"></i> Nom :</strong></td>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-euro-sign text-success"></i> Prix :</strong></td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                {{ number_format($product->price, 2) }} €
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-boxes text-info"></i> Quantité :</strong></td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $product->quantity }} unité(s)
                                            </span>
                                        </td>
                                    </tr>
                                    @if($product->category)
                                    <tr>
                                        <td><strong><i class="fas fa-list text-warning"></i> Catégorie :</strong></td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $product->category }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong><i class="fas fa-calendar text-secondary"></i> Créé le :</strong></td>
                                        <td class="text-muted">
                                            {{ $product->created_at->format('d/m/Y à H:i') }}
                                        </td>
                                    </tr>
                                    @if($product->updated_at != $product->created_at)
                                    <tr>
                                        <td><strong><i class="fas fa-edit text-secondary"></i> Modifié le :</strong></td>
                                        <td class="text-muted">
                                            {{ $product->updated_at->format('d/m/Y à H:i') }}
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Description/Détails -->
                    @if($product->description)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5><i class="fas fa-align-left text-primary"></i> Détails</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Liste des produits
                        </a>
                        <div>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" 
                                  method="POST" 
                                  style="display: inline-block;"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection