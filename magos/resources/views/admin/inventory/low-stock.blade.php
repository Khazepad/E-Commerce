@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Low Stock Alert</h1>
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary mb-3">Back to Inventory</a>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Current Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <form action="{{ route('admin.inventory.restock', $product) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" min="1" required>
                        <button type="submit" class="btn btn-primary">Restock</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
