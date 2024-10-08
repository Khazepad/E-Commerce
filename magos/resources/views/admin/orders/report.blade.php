<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-pixelated@1.1.0/dist/bootstrap-pixelated.min.css">
    <title>Sales Report</title>
</head>
<body>
    <div class="container">
        <h1 class="pixelated">Sales Report</h1>

        <table class="table table-bordered pixelated">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completedOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>₾{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <h3 class="pixelated">Total Sales: ₾{{ number_format($completedOrders->sum('total_amount'), 2) }}</h3>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary pixelated me-2">Back to Orders</a>
            <a href="{{ route('admin.orders.report', ['download' => 'pdf']) }}" class="btn btn-primary pixelated">Download PDF</a>
        </div>
    </div>

    <script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
