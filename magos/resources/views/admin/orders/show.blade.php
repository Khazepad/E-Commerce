<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: #d2b89b;
            border: 5px solid #333;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        h1, h2 {
            color: #fff;
            text-shadow: 
                -1px -1px 0 #000,  
                1px -1px 0 #000,
                -1px  1px 0 #000,
                1px  1px 0 #000;
        }

        .table {
            background-color: #f9f9f9;
            border: 2px solid #333;
        }

        .table th, .table td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 12px;
        }

        .form-control {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 2px solid #333;
        }

        .btn {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            padding: 10px 20px;
            border: 2px solid #3b2a1c;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #7c4700;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #3b2a1c;
            color: #f5f5f5;
            box-shadow: 4px 4px 8px #2c1e14;
            transform: scale(1.05);
        }

        .alert-success {
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            background-color: #d4edda; /* Light green background */
            border: 1px solid #c3e6cb; /* Green border */
            color: #155724; /* Dark green text */
            border-radius: 8px;
            padding: 15px; /* Increased padding for better spacing */
            margin-top: 20px; /* Space above the alert */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            display: flex; /* Allows for flex alignment */
            align-items: center; /* Center content vertically */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
        }

        .alert-success:hover {
            background-color: #c3e6cb; /* Darker background on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-4">Order #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back to Orders</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-3">Order Details</h2>
                <p><strong>Customer:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>City:</strong> {{ $order->city }}</p>
                <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
                <p><strong>Total:</strong> ₾{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                <p><strong>Shipping Status:</strong> {{ $order->shipping_status }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">Order Items</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₾{{ number_format($item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <h2 class="mt-4 mb-3">Update Order Status</h2>
        <form id="updateStatusForm" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="shipping_status" class="form-label">Shipping Status</label>
                <select name="shipping_status" id="shipping_status" class="form-control">
                    <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div id="successMessage" class="alert alert-success mt-3" style="display: none;"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#updateStatusForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#successMessage').text(response.message).show();
                    setTimeout(function() {
                        $('#successMessage').fadeOut();
                    }, 3000);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>
