@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Inventory Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        <a href="{{ route('admin.inventory.low-stock') }}" class="btn btn-warning">Low Stock Alert</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Current Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <form action="{{ route('admin.inventory.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="stock" value="{{ $product->stock }}" min="0">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
