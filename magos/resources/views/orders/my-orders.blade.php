<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #d5c5b4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border: 5px solid #7c4700;
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px;
        }
        h1 {
            color: #7c4700;
            text-shadow: 2px 2px #000;
        }
        .order-card {
            background-color: #d2b89b;
            border: 3px solid #7c4700;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #2a4038;
            border-color: #7c4700;
        }
        .btn-primary:hover {
            background-color: #648464;
            border-color: #3b2a1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">My Orders</h1>
        
        @foreach($orders as $order)
            <div class="card order-card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order #{{ $order->id }}</h5>
                    <p class="card-text">Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    <p class="card-text">Total: ₾{{ number_format($order->total_amount, 2) }}</p>
                    <p class="card-text">Status: {{ ucfirst($order->shipping_status) }}</p>
                    <h6>Items:</h6>
                    <ul>
                        @foreach($order->items as $item)
                            <li>{{ $item->product_name }} (x{{ $item->quantity }}) - ₾{{ number_format($item->price * $item->quantity, 2) }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">View Details</a>
                </div>
            </div>
        @endforeach

        @if($orders->isEmpty())
            <p>You haven't placed any orders yet.</p>
        @endif

        <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
