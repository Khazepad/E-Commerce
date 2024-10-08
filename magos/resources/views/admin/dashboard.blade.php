<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-image: url('/images/pixel11.gif');
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 20px;
            display: flex;
          
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border: 4px solid #000;
            box-shadow: 8px 8px 0 #000;
            border-radius: 10px;
            padding: 20px;
            max-width: 300px;
            text-align: center;
        }
        h2 {
            color: #ffd700;
            text-shadow: 2px 2px #000;
            margin-bottom: 20px;
        }
        .btn {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            margin: 10px 0;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #7c4700;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #3b2a1c;
            color: #ffd700;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #000;
        }
        .btn-danger {
            background-color: #8b0000;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #5c0000;
            color: #ffd700;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #000;
        }
        
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, {{ Auth::guard('admin')->user()->name }}!</p>
    <div class="d-grid gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Manage Products</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Manage Orders</a>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-primary">Manage Inventory</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
</body>
</html>
