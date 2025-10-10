<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the landing page with products.
     */
    public function index(Request $request)
    {
        // Check if there's a search query
        $query = $request->input('query');

        if ($query) {
            // Search products by name (case-insensitive)
            $products = Product::where('name', 'LIKE', '%' . $query . '%')
                               ->take(6) // limit to 6 products
                               ->get();
        } else {
            // Default: show latest 6 products
            $products = Product::orderBy('created_at', 'desc')->take(6)->get();
        }

        // Pass products to the view
        return view('home', compact('products'));
    }
}
