@extends('layouts.app')
@section('content')
    <div class="row my-3">
        <a type="button" class="btn btn-primary" href="{{ route('products.getCart') }}">
            Shopping card <span class="badge badge-secondary">{{ Session::has('cart') ? Session::get('cart')->totalQuantity : '0' }}</span>
        </a>
    </div>
    @foreach($products as $product)
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ $product->name }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->price }}</h5>
                        <p class="card-text">{{ str_limit($product->description, $limit=100) }}</p>
                        <a href="{{ route('products.addProductToCart', ['id' => $product->id]) }}" class="btn btn-primary">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row text-center">
        {{ $products->links() }}
    </div>
@endsection