<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- Custom Pixel Art CSS -->
    <style>
        body {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            background-color: #4b3619; /* Updated background color */
            padding-top: 20px;
        }
        
        .form-control, .btn {
            border-radius: 0; /* Square corners */
            font-size: 14px; /* Pixelated font size */
            box-shadow: none; /* Remove default shadow */
        }
        .btn-primary {
            background-color: #7c4700; /* Updated background color */
            border: 2px solid #7c4700; /* Border color matching the background */
            border-radius: 8px; /* Rounded corners for form group container */
            color: #fff; /* Dark text color for contrast */
        }
        .btn-primary:hover {
            background-color: #3b2a1c; /* Even darker brown for hover effect */
            border-color: #3b2a1c; /* Match the border color to the hover background */
            border-radius: 8px; /* Rounded corners for form group container */
            color: #f5f5f5; /* Slightly lighter text color on hover */
            box-shadow: 4px 4px 8px #2c1e14; /* Darker shadow for a subtle depth effect */
            transform: scale(1.05); /* Optional: Slightly enlarge the button on hover */
        }
        .btn-secondary {
            background-color: #9e9e9e;
            border: 2px solid #9e9e9e; /* Pixel border */
            color: #fff; /* White text color */
            border-radius: 8px; /* Rounded corners for form group container */
        }
        .btn-secondary:hover {
            background-color: #757575; /* Darker color on hover */
            border-color: #757575; /* Match border color on hover */
            transition: background-color 0.3s ease; /* Smooth transition */
            border-radius: 8px; /* Rounded corners for form group container */
        }
        .form-container {
            background-color: #d2b89b;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 9px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .alert {
            border-radius: 0; /* Square corners for alerts */
            border: 2px solid #ff5722; /* Alert border color */
        }
        img.img-thumbnail {
            border: 2px solid #616161; /* Border color for images */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-light">Edit Product</h1>

        <div class="form-container">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="product_name" class="text-light">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="text-light">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price" class="text-light">Price:</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="stock" class="text-light">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                </div>

                <div class="form-group">
                    <label for="image" class="text-light">Image:</label>
                    <input type="file" id="image" name="image" class="form-control">
                    @if ($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-thumbnail" width="150">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>

            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Product List</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
