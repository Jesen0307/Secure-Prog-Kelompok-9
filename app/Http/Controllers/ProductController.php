<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2|max:100',
        ]);

        $query = trim($validated['query']);

        $products = Product::where('is_active', true)
            ->where('stock', '>=', 1)
            ->where('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return view('dashboard', compact('products'));
    }

    public function show($id)
    {

        if (!ctype_digit($id) || (int)$id <= 0) {
            abort(400, 'Invalid product ID');
        }

        $product = Product::with('merchant')
            ->where('id', $id)
            ->where('is_active', true)
            ->where('stock', '>=', 1)
            ->first();

        if (!$product) {
            abort(404, 'Product not found or out of stock');
        }

        $products = Product::where('is_active', true)
            ->where('stock', '>=', 1)
            ->where('id', '!=', $id)
            ->limit(10)
            ->get();

        return view('product-detail', compact('product', 'products'));
    }
}
