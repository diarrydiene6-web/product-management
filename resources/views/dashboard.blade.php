@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tableau de bord</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total des produits</h5>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Valeur totale</h5>
                <h2>{{ number_format($totalValue, 2) }} €</h2>
            </div>
        </div>
    </div>
</div>

@if($recentProducts->count() > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Produits récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Date d'ajout</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price, 2) }} €</td>
                                        <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" 
                                               class="btn btn-sm btn-info">Voir</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.index') }}"
                                             class="btn btn-primary">Voir mes produits </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection