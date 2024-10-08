<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
        .btn-secondary {
            background-color: #3b2a1c;
            border-color: #3b2a1c;
            margin-top: 20px;
        }
        .btn-secondary:hover {
            background-color: #7c4700;
            border-color: #7c4700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Details</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Total Amount: ₾{{ number_format($order->total_amount, 2) }}</p>
        <p>Status: {{ ucfirst($order->shipping_status) }}</p>
        <!-- Add more order details as needed -->

        <a href="{{ route('orders.my-orders') }}" class="btn btn-secondary">Back to My Orders</a>
    </div>
</body>
</html>
