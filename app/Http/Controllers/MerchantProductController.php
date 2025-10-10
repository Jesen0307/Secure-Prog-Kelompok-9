<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MerchantProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $merchant = Auth::guard('merchant')->user();

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $mime = $file->getMimeType();
            $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mime, $allowedMime)) {
                return back()->withErrors(['image' => 'Invalid image type detected.']);
            }

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $imagePath = $file->storeAs('products', $filename, 'public');
        }
        Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'] ?? '',
            'image'       => $imagePath,
            'merchant_id' => $merchant->id,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}
