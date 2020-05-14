@extends('layouts.app')
@section('content')
    @if (!empty($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
    @if (!empty($products))
        <h1>Your order</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $id => $product)
                <tr>
                    <th scope="row"></th>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td><a href="{{ route('products.deleteFromCart', ['id' => $id]) }}" type="button" class="btn btn-danger">Delete Product</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <h1>Total Price: {{ $totalPrice }}</h1>
    @else
        Cart is empty
    @endif
@endsection