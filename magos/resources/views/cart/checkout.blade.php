<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #d5c5b4;
            color: #333;
            padding: 20px;
        }
        .card {
            background-color: #d2b89b;
            border: 5px solid #7c4700;
            margin-bottom: 20px;
        }
        .btn {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
        }
        .btn-primary {
            background-color: #172621;
            border-color: #7c4700;
            margin-top: 13px;
        }
        .btn-primary:hover {
            background-color: #648464;
            border-color: #3b2a1c;
        }
        .form-control {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Checkout</h1>
        
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if(!session()->has('cart') || count(session('cart')) == 0)
            <div class="alert alert-warning">
                Your cart is empty. Please add items before proceeding to checkout.
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Go to Products</a>
        @else
            <!-- Existing checkout form and content -->
            <div class="row">
                <div class="col-md-6">
                    <h2>Order Summary</h2>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        @php
                        $subtotal = 0;
                        @endphp
                        @foreach(session('cart') as $id => $details)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $details['name'] }}</h5>
                                    <p class="card-text">Price: ₾{{ $details['price'] }}</p>
                                    <p class="card-text">Quantity: {{ $details['quantity'] }}</p>
                                    <p class="card-text">Subtotal: ₾{{ $details['price'] * $details['quantity'] }}</p>
                                </div>
                            </div>
                            @php
                            $subtotal += $details['price'] * $details['quantity'];
                            @endphp
                        @endforeach
                        <p id="subtotalAmount">Subtotal: ₾{{ number_format($subtotal, 2) }}</p>
                        <p id="discountAmount" style="display: none;">Discount: -₾<span></span></p>
                        <p id="codFee" style="display: none;">Cash on Delivery Fee: ₾5.00</p>
                        <p id="totalAmount">Total: ₾{{ number_format($subtotal, 2) }}</p>
                        <div class="form-group">
                            <label for="voucher">Voucher Code</label>
                            <input type="text" class="form-control" id="voucher" name="voucher">
                            <button type="button" id="applyVoucher" class="btn btn-secondary mt-2">Apply Voucher</button>
                        </div>
                        <p id="voucherMessage" style="display: none;"></p>
                    @endif
                    
                     
                </div>
                
                <div class="col-md-6">
                    <h2>Shipping Information</h2>
                    <form action="{{ route('place.order') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method:</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Select a payment method</option>
                                <option value="paypal">PayPal</option> 
                                <option value="cash_on_delivery">Cash on Delivery (₾5.00 fee)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                
                    </form>
                    <form>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary mt-3">Back to Cart</a>
                    </form>
                </div>
                
            </div>
            <!-- End of existing checkout form and content -->
        @endif
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const subtotalElement = document.getElementById('subtotalAmount');
        const discountElement = document.getElementById('discountAmount');
        const codFeeElement = document.getElementById('codFee');
        const totalElement = document.getElementById('totalAmount');
        const voucherInput = document.getElementById('voucher');
        const applyVoucherButton = document.getElementById('applyVoucher');
        const voucherMessage = document.getElementById('voucherMessage');
        
        let subtotal = parseFloat(subtotalElement.innerText.replace('Subtotal: ₾', ''));
        let appliedDiscount = 0;
        let codFee = 0;

        function updateTotal() {
            let total = subtotal - appliedDiscount + codFee;
            totalElement.innerText = `Total: ₾${total.toFixed(2)}`;
        }

        paymentMethodSelect.addEventListener('change', function() {
            if (this.value === 'cash_on_delivery') {
                codFee = 5.00;
                codFeeElement.style.display = 'block';
            } else {
                codFee = 0;
                codFeeElement.style.display = 'none';
            }
            updateTotal();
        });

        applyVoucherButton.addEventListener('click', function() {
            const voucherCode = voucherInput.value.trim();
            
            $.ajax({
                url: '{{ route("apply.voucher") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    voucher_code: voucherCode
                },
                success: function(response) {
                    if (response.success) {
                        appliedDiscount = response.orderSummary.discount;
                        voucherMessage.innerText = response.message;
                        voucherMessage.style.color = 'green';
                        discountElement.querySelector('span').innerText = appliedDiscount.toFixed(2);
                        discountElement.style.display = 'block';
                    } else {
                        appliedDiscount = 0;
                        voucherMessage.innerText = response.message;
                        voucherMessage.style.color = 'red';
                        discountElement.style.display = 'none';
                    }
                    voucherMessage.style.display = 'block';
                    updateTotal();
                },
                error: function() {
                    voucherMessage.innerText = 'An error occurred. Please try again.';
                    voucherMessage.style.color = 'red';
                    voucherMessage.style.display = 'block';
                }
            });
        });

        // Initial total update
        updateTotal();
    });
    </script>
</body>
</html>
