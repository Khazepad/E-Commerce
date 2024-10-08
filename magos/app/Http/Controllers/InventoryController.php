<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.inventory.index', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('admin.inventory.index')->with('success', 'Stock updated successfully');
    }

    public function adjustStock(Product $product, $quantity)
    {
        $product->stock += $quantity;
        $product->save();
    }

    public function decreaseStockForOrder(Order $order)
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $this->adjustStock($product, -$item->quantity);
            }
        }
    }

    public function lowStockAlert()
    {
        $lowStockThreshold = 10; // You can adjust this value as needed
        $lowStockProducts = Product::where('stock', '<', $lowStockThreshold)->get();
        return view('admin.inventory.low-stock', compact('lowStockProducts'));
    }

    public function restock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->adjustStock($product, $request->quantity);

        return redirect()->route('admin.inventory.index')->with('success', 'Product restocked successfully');
    }
}
