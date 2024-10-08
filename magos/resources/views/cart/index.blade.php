<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #d5c5b4;
            color: #333;
            padding: 20px;
        }
        .card {
            background-color: #d2b89b;
            border: 5px solid #7c4700;
            margin-bottom: 20px;
        }
        .btn {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
        }
        .btn-primary {
            background-color: #648464;
            border-color: #172621;
        }
        .btn-primary:hover {
            background-color: #2a4038;
            border-color: #3b2a1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Shopping Cart</h1>
        
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $details['name'] }}</h5>
                        <p class="card-text">Price: ₾{{ $details['price'] }}</p>
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control d-inline-block w-25">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div class="text-right">
                <h3>Total: ₾{{ $total }}</h3>
                <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
        @else
            <p>Your cart is empty.</p>
        @endif
        <form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Continue Shopping</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
