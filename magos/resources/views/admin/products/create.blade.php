<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #3a4c40;
            color: #f0f0f0;
            align-items: center;
            padding: 50px;
        }
        .container {
            background-color: #2c1e14;
            border: 5px;
            border-radius: 20px;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px #000;
        }
        .btn {
            font-size: 16px;
            padding: 10px 25px;
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .btn-primary {
            background-color: #7c4700;
            border: 3px solid #ffd700;
        }
        .btn-primary:hover {
            background-color: #3b2a1c;
            transform: scale(1.05);
        }
        .btn-secondary {
            background-color: #3b2a1c;
            border: 3px solid #7c4700;
        }
        .btn-secondary:hover {
            background-color: #7c4700;
        }
        .alert-danger {
            background-color: #ff4c4c;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Product</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock') }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="text-center mb-4">
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>

        <div class="text-center">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
</body>
</html>
