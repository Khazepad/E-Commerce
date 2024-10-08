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
            background-color: #f0f0f0;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #fff; /* Text color */
            margin-bottom: 25px; /* Space below the heading */
            font-size: 36px; /* Adjust the font size as needed */
            text-shadow: 
                -1px -1px 0 #000,  
                1px -1px 0 #000,
                -1px  1px 0 #000,
                1px  1px 0 #000; /* Black text stroke effect */
        }

        .btn {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            border: 2px solid #000;
            box-shadow: 4px 4px 0 #000;
            transition: all 0.1s ease;
        }

        .btn:active {
            box-shadow: 0 0 0 #000;
            transform: translate(4px, 4px);
        }

        .card {
            border: 2px solid #000;
            box-shadow: 4px 4px 0 #000;
            margin-bottom: 20px;
        }

        .card-img-top {
            border-bottom: 2px solid #000;
        }

        .card-body {
            padding: 10px;
        }

        .card-title {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .card-footer {
            border-top: 2px solid #000;
            padding: 10px;
        }

        .alert {
            border: 2px solid #000;
            box-shadow: 4px 4px 0 #000;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Discontinued Products</h1>
            <a href="/admin/products" class="btn btn-secondary">Back to Products</a>
        </div>

	@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
	@endif

        <div class="container">
            <div class="row">
                @forelse ($discontinuedProducts as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="card-img-top product-img">
                            @else
                                <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text"><strong>Price:</strong> ₾{{ number_format($product->price, 2) }}</p>
                                <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="me-2">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this product?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            No discontinued products found.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example of how to show success message
        function showSuccessMessage(message) {
            document.getElementById('success-message').innerText = message;
            document.getElementById('success-alert').style.display = 'block';
        }

        // Example of how to handle no products
        function handleNoProducts() {
            document.getElementById('no-products-alert').style.display = 'block';
        }
    </script>
</body>
</html>
