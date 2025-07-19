@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-box-open me-2"></i>Mes Produits
                        <span class="badge bg-light text-dark ms-2">{{ $products->total() }}</span>
                    </h4>
                    <a href="{{ route('products.create') }}" class="btn btn-light">
                        <i class="fas fa-plus"></i> Ajouter un Produit
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <!-- Vue en grille pour un meilleur affichage -->
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <!-- Image du produit -->
                                        <div class="position-relative">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="card-img-top"
                                                     style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <span class="text-muted">
                                                        <i class="fas fa-image fa-2x"></i><br>
                                                        <small>Pas d'image</small>
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            <!-- Badge catégorie -->
                                            @if($product->category)
                                                <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-2">
                                                    {{ ucfirst($product->category) }}
                                                </span>
                                            @endif
                                            
                                            <!-- Badge prix -->
                                            <span class="position-absolute top-0 end-0 badge bg-success m-2 fs-6">
                                                {{ number_format($product->price, 2) }} €
                                            </span>
                                        </div>
                                        
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            
                                            @if($product->description)
                                                <p class="card-text text-muted small flex-grow-1">
                                                    {{ Str::limit($product->description, 100) }}
                                                </p>
                                            @endif
                                            
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-boxes"></i> {{ $product->quantity }} unité(s)
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> {{ $product->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                                
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('products.show', $product) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i> Voir les détails
                                                    </a>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('products.edit', $product) }}" 
                                                           class="btn btn-outline-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Modifier
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                <i class="fas fa-trash"></i> Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>

                    @else
                        <!-- Message si aucun produit -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-box-open fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Aucun produit trouvé</h5>
                            <p class="text-muted">Commencez par ajouter votre premier produit !</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter un Produit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection