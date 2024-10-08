<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;






class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update($request->only(['payment_status', 'shipping_status']));
        
        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function adminIndex(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('shipping_status', $request->status);
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateShippingStatus(Request $request, Order $order)
    {
        $request->validate([
            'shipping_status' => 'required|in:pending,shipped,delivered',
        ]);

        $order->update(['shipping_status' => $request->shipping_status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function report(Request $request)
    {
        $completedOrders = Order::where('shipping_status', 'delivered')->get();
        
        if ($request->has('download') && $request->download == 'pdf') {
            $pdf = PDF::loadView('admin.orders.report_pdf', compact('completedOrders'));
            return $pdf->download('sales_report.pdf');
        }
        
        return view('admin.orders.report', compact('completedOrders'));
    }

    public function placeOrder(Request $request)
    {
        // ... existing validation and cart retrieval ...

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_amount = $request->input('final_total');
        $order->applied_discount = $request->input('applied_discount');
        $order->cod_fee_applied = $request->input('cod_fee_applied');
        // ... set other order fields ...
        $order->save();

        // ... create order items ...

        // Adjust inventory
        $inventoryController = new InventoryController();
        $inventoryController->decreaseStockForOrder($order);

        // ... clear cart ...

        return view('cart.receipt', compact('order'));
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->get();
        return view('orders.my-orders', compact('orders'));
    }
    
}
