<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - E-Commerce Site</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Retro pixelated font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            color: #333;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:url(https://i.pinimg.com/originals/cb/e1/40/cbe140b6a6cd6958a5457508cc7280e0.gif) no-repeat center center fixed;
            background-size: cover;
            
        }
        .container {
            text-align: center;
            padding: 50px;
            border: 3px solid #333;
            border-radius: 20px;
            background-color: rgba(100, 99, 90, 0.8); /* Semi-transparent background */
            box-shadow: 10px 10px 0 rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 5rem;
            color: #333;
            margin-bottom: 20px;
            text-shadow: 2px 2px #ccc;
        }
        .lead {
            font-size: 1rem;
            color: #ccc;
        }
        .btn-custom {
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            padding: 10px 20px;
            border: 3px solid #4e3a2a;
            background-color: #4e3a2a;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #3b2a1c;
            border-color: #3b2a1c;
            color: #f5f5f5;
            box-shadow: 4px 4px 8px #2c1e14;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">ᘻᗩᘜᓍϚ</h1>
        <p class="lead mb-5">Beware thy seek!</p>
        <a href="{{ route('choice') }}" class="btn btn-custom">eiságo</a>
    </div>

    <!-- Bootstrap JS (optional, if you need Bootstrap's JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>