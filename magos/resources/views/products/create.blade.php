<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <!-- Bootstrap CSS (updated to 5.3.0) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom pixelated styles */
        body {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            background-color: #4b3619; /* Background color */
            color: #333;
            padding: 50px;
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
        .form-group-container {
            margin-bottom: 30px; /* Space between form groups */
            padding: 5px; /* Padding inside the form group container */
            background-color: #f9f9f9; /* Light background color for each form group container */
            border-radius: 8px; /* Rounded corners for form group container */
            border: 1px solid #ddd; /* Border for the form group container */
            max-width: 600px; /* Set a maximum width for the form group container */
            margin-left: auto; /* Centering using auto margins */
            margin-right: auto; /* Centering using auto margins */
        }
        .pixelated {
            image-rendering: pixelated;
            -ms-interpolation-mode: nearest-neighbor;
            -webkit-optimize-contrast: none;
        }
        .form-control, .btn {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            font-size: 10px;
        }
        .alert {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            font-size: 10px;
        }
        .btn {
            padding: 5px 7.5px;
            border: 2px solid;
            border-radius: 5px; /* Optional: Add rounded corners */
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; /* Transition effects for button */
        }
        .btn-primary {
            background-color: #7c4700; /* Dark brown background color */
            border-color: #7c4700; /* Dark brown border color */
            color: #fff; /* White text color */
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #3b2a1c; /* Even darker brown for hover effect */
            border-color: #3b2a1c; /* Match the border color to the hover background */
            color: #f5f5f5; /* Slightly lighter text color on hover */
            box-shadow: 4px 4px 8px #2c1e14; /* Darker shadow for a subtle depth effect */
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 10px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: #e0e0e0; /* Optional: Change text color on hover */
        }
        textarea.form-control {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            font-size: 12px; /* Adjusted font size for better readability */
        }
        label {
            font-family: 'Press Start 2P', cursive; /* Retro pixelated font */
            font-size: 12px; /* Adjusted font size for better readability */
        }
        /* Custom styles for the file input container */
        .file-input-container {
            margin-top: 20px; /* Adjust the margin as needed */
        }
        /* Custom styles for the file input */
        .file-input {
            font-size: 10px; /* Smaller font size */
            padding: 4px; /* Reduce padding */
            width: auto; /* Set width to auto for better responsiveness */
        }
    </style>
    <!-- Retro pixelated font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Create Product</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group-container">
                        <div class="form-group">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group-container">
                        <div class="form-group">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group-container">
                        <div class="form-group">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group-container">
                        <div class="form-group">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group-container file-input-container">
                        <div class="form-group">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" name="image" id="image" class="form-control file-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <!-- Bootstrap JS (updated to 5.3.0) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
