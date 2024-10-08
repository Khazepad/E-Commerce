<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Pixel Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-image: url('/images/pixel13.gif');
            background-size: 100%;
            color: #333;
            margin: 0;
            padding: 20px; /* Padding around the body */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        h1 {
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 30px;
            
           
        }
        h5 {
            font-size: 12px;
        }
        
        .message, .error {
            font-weight: bold;
            margin-bottom: 15px; /* Space below the message */
        }

        .error {
            color: red;
        }

        .product-img {
            max-width: 35%;
            height: auto;
            image-rendering: pixelated; /* Pixelate image */
            display: block;
            margin: 0 auto 10px; /* Center the image and add bottom margin */
        }

        .btn-custom, .btn-secondary, .btn-warning, .btn-danger, .btn-success, .btn-primary, .btn-info {
            background-color: #7c4700;
            border: 2px solid #3b2a1c;
            border-radius: 8px;
            color: #f5f5f5;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 12px;
            padding: 5px 16px;
            margin: 5px 0 5px 10px; /* Add left margin for spacing */
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .btn-custom:hover, .btn-secondary:hover, .btn-warning:hover, .btn-danger:hover, .btn-success:hover, .btn-primary:hover, .btn-info:hover {
            background-color: #3b2a1c;
            border-color: #7c4700;
            color: #ffffff;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-custom:active, .btn-secondary:active, .btn-warning:active, .btn-danger:active, .btn-success:active, .btn-primary:active, .btn-info:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Ensuring consistent button size for alignment */
        .btn { 
        min-width: 100px; /* Set a minimum width for alignment */
        }

        .alert-success {
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            background-color: #d4edda; /* Light green background for success */
            border: 1px solid #c3e6cb; /* Green border */
            color: #155724; /* Dark green text color */
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 5 cards per row */
            gap: 15px; /* Space between cards */
            padding: 5px 0; /* Padding to ensure content isn't flush against edges */
        }

        .card {
            border: 5px dotted #333; /* Dotted border style */
            background: #d2b89b; /* Light brown background */
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Ensures content doesn't overflow the card */
            height: 500px; /* Increased height for cards */
            display: flex;
            flex-direction: column; /* Stack content vertically */
            margin: 10px; /* Space around each card */
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0px 9px 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
        }

        .card-body {
            font-family: 'Press Start 2P', cursive;
            padding: 15px; /* Add padding inside the card body */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribute space between content */
            flex-grow: 1; /* Allow the card body to grow */
            overflow: hidden; /* Ensure content fits */
            font-size: 9px; 
        }

       /* Adjusting the button footer for better alignment */
        .card-footer {
            background-color: #f7f7f7; /* Light gray background for footer */
            border-top: 1px solid #ddd;
            padding: 10px;
            text-align: center; /* Center footer content */
            display: flex;
            justify-content: space-between; /* Distribute buttons evenly */
            gap: 10px; /* Space between buttons */
            align-items: center; /* Center items vertically */
        }

        .product-img {
            max-width: 35%; /* Adjusted to ensure the image fits */
            height: auto;
            image-rendering: pixelated; /* Pixelate image */
            margin: 0 auto 10px; /* Center the image and add bottom margin */
        }

        .product-description {
            padding: 15px; /* Add padding around the description */
            font-family: 'Press Start 2P', cursive;
            font-size: 8px; /* Smaller text size */
            background: #f9f9f9; /* Light background for description */
            border-top: 1px solid #ddd; /* Light border at the top */
            margin-top: 10px; /* Space above the description */
            overflow: hidden; /* Ensure text fits within the card */
            text-overflow: ellipsis; /* Add ellipsis if text overflows */
            height: 100px; /* Fixed height for the description area */
        }

        .container {
            padding: 25px;
            color: #ffd700;
            margin-bottom: 30px;
            background-color: rgba(100, 99, 90, 0.8); /* Semi-transparent background */
            border: 3px solid #333;
            border-radius: 20px;
            box-shadow: 10px 10px 0 rgba(0, 0, 0, 0.2);
            
        }

        .form-control {
            font-family: 'Press Start 2P', cursive; 
            font-size: 12px; /* Smaller font size */
            padding: 3px; /* Reduced padding */
            border-width: 2px;
            margin-bottom: 8px; /* Reduced space below the input field */
            max-width: 500px; /* */
        }

        .form-inline .form-control {
            margin-right: 10px; /* Space to the right of input fields */
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .left-buttons .btn,
        .right-buttons .btn {
            margin-right: 15px;
        }

        .right-buttons .btn:last-child {
            margin-right: 0;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        /* Add these new styles */
        .input-group .form-control,
        .input-group .btn {
            border-radius: 4px; /* Reduced border radius */
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

         /* New styles for the bottom-right image */
         .bottom-right-image {
            position: fixed;
            bottom: -29px;
            right: -29px;
            z-index: 1000;
            max-width: 400px; /* Increased from 150px to 300px */
            height: auto;
        }

    
    </style>
</head>
<body>
<img src="/images/pixel3.gif" alt="Bottom Right Image" class="bottom-right-image">
<div class="container">
    <h1>Products List</h1>

    <!-- Updated button container with logout and view cart -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('home') }}" class="btn btn-secondary">Home</a>
            <a href="{{ route('cart.index') }}" class="btn btn-primary">View Cart</a>
            <a href="{{ route('orders.my-orders') }}" class="btn btn-info">My Orders</a>
        </div>
        <div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <!-- Display success message if available -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search products...">
            <form>
                <button type="submit" class="btn btn-primary" style="display: center; margin-left: 50px;">Search</button>
            </form>
        </div>
    </form>

    <!-- List of products -->
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($products as $product)
            <div class="col">
                <div class="card h-100">
                    @if ($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="card-img-top product-img">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">₾{{ number_format($product->price, 2) }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>

                        <!-- Product Description -->
                        <div class="product-description">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="card-footer">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control d-inline-block w-25">
                            <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                alert(response.message);
                // You can update a cart icon or counter here if needed
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
</body>
</html>
