<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #d5c5b4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border: 5px solid #7c4700;
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px;
        }
        h1 {
            color: #7c4700;
            text-shadow: 2px 2px #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Processing Payment</h1>
        <p class="text-center">Please wait while we process your payment...</p>
        <div class="text-center mt-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        // Simulate payment processing and redirect after a delay
        setTimeout(function() {
            @if($order->payment_method === 'credit_card')
                window.location.href = "{{ route('order.receipt', $order->id) }}";
            @else
                window.location.href = "{{ route('order.receipt', $order->id) }}";
            @endif
        }, 3000); // Redirect after 3 seconds
    </script>
</body>
</html>
