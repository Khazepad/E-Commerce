<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Make sure to import the Product model

class AdminController extends Controller
{
   
    
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function lowStockProducts()
    {
        // Fetch products with stock below a certain threshold (e.g., 10)
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('admin.products.low-stock-products', ['lowStockProducts' => $lowStockProducts]);
    }

    public function checkLowStock()
    {
        $lowStockThreshold = 10; // You can adjust this value as needed
        $lowStockProducts = Product::where('stock', '<', $lowStockThreshold)->get();

        return view('admin.products.low-stock-products', ['lowStockProducts' => $lowStockProducts]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function restockProduct(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');
        $product->increaseStock($quantity);

        return redirect()->back()->with('success', 'Product restocked successfully');
    }
}
