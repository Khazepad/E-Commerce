<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-image: url('/images/pixel15.gif');
            background-size: 100%;
            color: #fff;
            padding: 20px;
        }
        .container {
            background-color: #d2b89b;
            border: 5px solid #7c4700;
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px;
        }
        h1, h2 {
            color: #7c4700;
            text-shadow: 2px 2px #000;
        }
        .order-details, .shipping-details {
            background-color: #e6d2bc;
            border: 3px dashed #7c4700;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .item {
            background-color: #f0e6d8;
            border: 2px solid #7c4700;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .total {
            font-size: 1.2em;
            color: #7c4700;
            text-shadow: 1px 1px #000;
        }
        .btn-primary {
            background-color: #7c4700;
            border-color: #7c4700;
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
        }
        .btn-primary:hover {
            background-color: #3b2a1c;
            border-color: #3b2a1c;
        }
        .order-details p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Order Confirmation</h1>
        
        <div class="order-details">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> {{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Total Amount:</strong> ₾{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Total Items:</strong> {{ $order->items->sum('quantity') }}</p>
            @if($order->applied_discount > 0)
                <p><strong>Discount Applied:</strong> ₾{{ number_format($order->applied_discount, 2) }}</p>
            @endif
            @if($order->cod_fee > 0)
                <p><strong>Cash on Delivery Fee:</strong> ₾{{ number_format($order->cod_fee, 2) }}</p>
            @endif
            @if($order->voucher_code)
                <p><strong>Voucher Applied:</strong> {{ $order->voucher_code }}</p>
            @endif
        </div>

        <div class="shipping-details">
            <h2>Shipping Information</h2>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>City:</strong> {{ $order->city }}</p>
            <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
        </div>

        <h2>Order Items</h2>
        @php
            $totalAmount = 0;
        @endphp
        @foreach($order->items as $item)
            <div class="item">
                <p><strong>{{ $item->product->product_name }}</strong></p>
                <p>Quantity: {{ $item->quantity }}</p>
                <p>Price: ₾{{ number_format($item->price, 2) }}</p>
                <p>Subtotal: ₾{{ number_format($item->price * $item->quantity, 2) }}</p>
            </div>
            @php
                $totalAmount += $item->price * $item->quantity;
            @endphp
        @endforeach

        <div class="total mt-4">
            <p><strong>Subtotal: ₾{{ number_format($totalAmount, 2) }}</strong></p>
            @if($order->applied_discount > 0)
                <p><strong>Discount: -₾{{ number_format($order->applied_discount, 2) }}</strong></p>
            @endif
            @if($order->cod_fee > 0)
                <p><strong>Cash on Delivery Fee: ₾{{ number_format($order->cod_fee, 2) }}</strong></p>
            @endif
            <p><strong>Total: ₾{{ number_format($order->total_amount, 2) }}</strong></p>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const totalElement = document.getElementById('totalAmount');
        const codFeeElement = document.getElementById('codFee');
        let originalTotal = parseFloat(totalElement.innerText.replace('Total: ₾', ''));

        paymentMethodSelect.addEventListener('change', function() {
            let newTotal = originalTotal;
            if (this.value === 'cash_on_delivery') {
                newTotal += 5.00;
                codFeeElement.style.display = 'block';
            } else {
                codFeeElement.style.display = 'none';
            }
            totalElement.innerText = `Total: ₾${newTotal.toFixed(2)}`;
        });
    });
    </script>
</body>
</html>

