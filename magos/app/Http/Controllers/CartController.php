<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;


class CartController extends Controller
{
    public function addToCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($product->isInStock()) {
            if ($product->decreaseStock($quantity)) {
                $cart = $request->session()->get('cart', []);
                
                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity'] += $quantity;
                } else {
                    $cart[$product->id] = [
                        'name' => $product->product_name,
                        'price' => $product->price,
                        'quantity' => $quantity
                    ];
                }
                
                $request->session()->put('cart', $cart);

                return response()->json(['message' => 'Product added to cart successfully']);
            } else {
                return response()->json(['message' => 'Not enough stock available'], 400);
            }
        } else {
            return response()->json(['message' => 'Product is out of stock'], 400);
        }
    }

    // this method retreives the cart from the session and displays it
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }
    // kwaon ang session sa cart, ipang kalkyu ang total price
    public function checkout()
    {
        $cart = session('cart');
        
        if (!$cart || empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
        }

        $total = array_sum(array_column($cart, 'price'));

        return view('cart.checkout', compact('cart', 'total'));
    }

    // validate ang data gikan sa form ug ipang save sa database
    public function placeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'payment_method' => 'required|string|in:paypal,credit_card,cash_on_delivery',
        ]);

        $cart = session('cart');
        
        if (!$cart || empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before placing an order.');
        }

        // Calculate the total
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Apply voucher discount if any
        $appliedDiscount = 0;
        if ($request->has('voucher_code')) {
            // Validate and apply voucher
            $voucher = Voucher::where('code', $request->voucher_code)->first();
            if ($voucher && $voucher->is_valid) {
                $appliedDiscount = $total * ($voucher->discount_percentage / 100);
            }
        }

        // Apply COD fee if applicable
        $codFee = 0;
        if ($validatedData['payment_method'] === 'cash_on_delivery') {
            $codFee = 5.00;
        }

        // Calculate shipping fee (you can adjust this logic based on your requirements)
        $shippingFee = 10.00; // Set a default shipping fee

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'postal_code' => $validatedData['postal_code'],
            'shipping_fee' => $shippingFee,
            'total_amount' => $total - $appliedDiscount + $codFee + $shippingFee,
            'payment_method' => $validatedData['payment_method'],
            'payment_status' => 'pending',
            'shipping_status' => 'pending',
            'applied_discount' => $appliedDiscount,
            'cod_fee' => $codFee,
        ]);

        foreach ($cart as $id => $details) {
            $order->items()->create([
                'product_id' => $id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.receipt', ['order' => $order->id]);
    }
// kani kay ang receipt 
    public function showReceipt(Order $order)
    {
        return view('cart.receipt', compact('order'));
    }

    public function remove(Request $request, $productId)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart');
        }

        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function update(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully');
        }

        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function restockProduct(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');
        $product->increaseStock($quantity);

        return redirect()->back()->with('success', 'Product restocked successfully');
    }

    public function checkLowStock()
    {
        $lowStockThreshold = 10; // You can adjust this value as needed
        $lowStockProducts = Product::where('stock', '<', $lowStockThreshold)->get();

        return view('admin.low-stock-products', compact('lowStockProducts'));
    }

    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function processPayment(Request $request)
    {
        switch ($request->payment_method) {
            case 'paypal':
                return $this->processPayPalPayment($request);
            case 'credit_card':
                return $this->processCreditCardPayment($request);
            case 'cash_on_delivery':
                return $this->processCashOnDelivery($request);
            default:
                return redirect()->back()->with('error', 'Invalid payment method');
        }
    }

    private function processPayPalPayment($request)
    {
        // Existing PayPal logic
    }

    private function processCreditCardPayment($request, $amount)
    {
        // This is a placeholder for actual credit card processing logic
        // In a real-world scenario, you would integrate with a payment gateway here
        
        // Simulate a successful payment (80% success rate)
        return (rand(1, 100) <= 80);
    }

    private function processCashOnDelivery($request)
    {
        // Logic for cash on delivery
        // Update order status, etc.
        return redirect()->route('order.complete')->with('success', 'Order placed successfully. Payment due on delivery.');
    }

    public function paymentSuccess(Request $request)
    {
        // Handle successful payment
        // Update order status, clear cart, etc.
        return redirect()->route('order.complete')->with('success', 'Payment successful!');
    }

    public function paymentCancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment cancelled');
    }

    private function createPayment($total, $currency)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($total);
        $amount->setCurrency($currency);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
                     ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return $payment;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $cart = session('cart', []);

        // Check if the cart is empty
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Add items before applying a voucher.'
            ]);
        }

        // Validate the voucher code
        if ($voucherCode === 'SUMMER2023') {
            $subtotal = $this->calculateSubtotal($cart);
            $voucherDiscount = $subtotal * 0.15; // 15% discount

            session(['voucher_discount' => $voucherDiscount]);
            session(['voucher_code' => $voucherCode]);

            $orderSummary = $this->getOrderSummary();

            return response()->json([
                'success' => true,
                'message' => 'Voucher applied successfully!',
                'orderSummary' => $orderSummary,
                'voucherCode' => $voucherCode
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code.'
            ]);
        }
    }

    private function calculateSubtotal($cart)
    {
        return array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    }

    private function getOrderSummary()
    {
        $cart = session('cart', []);
        $subtotal = $this->calculateSubtotal($cart);

        $voucherDiscount = session('voucher_discount', 0);
        $voucherCode = session('voucher_code', null);
        $totalAfterDiscount = max(0, $subtotal - $voucherDiscount);

        return [
            'subtotal' => $subtotal,
            'discount' => $voucherDiscount,
            'total' => $totalAfterDiscount,
            'voucherCode' => $voucherCode
        ];
    }
}
