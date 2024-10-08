@extends('layouts.admin')

@section('content')
<style>
    :root {
        --brown-100: #f5e8d3;
        --brown-200: #e6d0b3;
        --brown-300: #d7b894;
        --brown-400: #c8a075;
        --brown-500: #b98855;
        --brown-600: #a97036;
        --brown-700: #8d5d2d;
        --brown-800: #714a24;
        --brown-900: #55371b;
    }
    body {
        background-color: #fff;
        color: var(--brown-900);
        font-family: 'Courier New', monospace;
    }
    .pixelated {
        image-rendering: pixelated;
        border: 2px solid var(--brown-900);
        box-shadow: 4px 4px 0 var(--brown-900);
        background-color: var(--brown-200);
    }
    .pixelated-btn {
        padding: 5px 10px;
        font-family: 'Courier New', monospace;
        text-transform: uppercase;
        font-weight: bold;
        background-color: var(--brown-400);
        border-radius: 5px;
        color: var(--brown-900);
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.1s;
    }
    .pixelated-btn:hover {
        background-color: var(--brown-500);
        border-radius: 5px;
        box-shadow: 2px 2px 0 var(--brown-900);
        transform: translateY(-2px);

    }
    .pixelated-select {
        appearance: none;
        padding: 5px 30px 5px 10px;
        background-color: var(--brown-300);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cpath d='M0 0h8v2H0zM0 3h8v2H0zM0 6h8v2H0z' fill='%23000'/%3E%3C/svg%3E");
        background-position: right 10px center;
        background-repeat: no-repeat;
        background-size: 8px;
    }

    .pixelated-select:hover {
        border-radius: 5px;
        box-shadow: 2px 2px 0 var(--brown-900);
        transform: translateY(-2px);
        background-color: var(--brown-400);

    }

    .pixelated-table {
        border-collapse: separate;
        border-spacing: 2px;
        width: 100%;
    }
    .pixelated-table th, .pixelated-table td {
        border: 2px solid var(--brown-900);
        padding: 8px;
        background-color: var(--brown-200);
    }
    .pixelated-table th {
        background-color: var(--brown-400);
    }
    .pixelated-container {
        max-width: 100%;
        padding: 20px;
    }
    .pixelated-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .pixelated-title {
        color: var(--brown-800);
        text-align: center;
        margin: 0;
    }
    .pixelated-form {
        margin-bottom: 20px;
    }
    .pixelated-actions {
        margin-top: 20px;
    }
    h1 {
        color: var(--brown-800);
        text-align: center;
        margin-bottom: 20px;
    }
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }
    .pagination li {
        margin: 0 5px;
    }
    .pagination a, .pagination span {
        display: inline-block;
        padding: 5px 10px;
        background-color: var(--brown-300);
        color: var(--brown-900);
        text-decoration: none;
    }
    .pagination .active span {
        background-color: var(--brown-500);
    }
    .generate-report-btn {
        background-color: var(--brown-600);
        border: 2px solid var(--brown-900);
        color: var(--brown-100);
        font-size: 12px;
        padding: 10px 20px;
        text-transform: uppercase;
        cursor: pointer;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.1s;
    }
    .generate-report-btn:hover {
        background-color: var(--brown-700);
        transform: translateY(-2px);
    }
</style>

<div class="pixelated-container pixelated">
    <div class="pixelated-header">
        <h1 class="pixelated-title">Order Management</h1>
        <a href="{{ route('admin.dashboard') }}" class="pixelated-btn">Back to Dashboard</a>
    </div>

    <form action="{{ route('admin.orders.index') }}" method="GET" class="pixelated-form">
        <select name="status" onchange="this.form.submit()" class="pixelated-select">
            <option value="">All Orders</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
        </select>
    </form>

    <table class="pixelated-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                <td>₾{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ ucfirst($order->shipping_status) }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="pixelated-btn">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}

    <a href="{{ route('admin.orders.report') }}" class="generate-report-btn pixelated pixelated-btn">Generate Sales Report</a>
</div>
@endsection
