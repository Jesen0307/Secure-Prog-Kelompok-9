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
        $query = $request->input('query');

        if ($query) {
            $products = Product::where('name', 'LIKE', '%' . $query . '%')
                               ->take(6)
                               ->get();
        } else {

            $products = Product::orderBy('created_at', 'desc')->take(6)->get();
        }

        return view('home', compact('products'));
    }
}
