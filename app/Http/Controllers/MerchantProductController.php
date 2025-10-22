<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MerchantProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0|max:99999999.99',
            'description' => 'nullable|string|max:1000',
            'category'    => 'required|in:Electronic,Food,Fashion,Beauty and Personal Care,Furniture,Pet Products',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $merchant = Auth::guard('merchant')->user();
        if (!$merchant) {
            abort(403, 'Unauthorized action.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
            $mime = mime_content_type($file->getRealPath());

            if (!in_array($mime, $allowedMime)) {
                return back()->withErrors(['image' => 'Invalid or unsafe image type detected.']);
            }

            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('products', $filename, 'public');

            if (str_contains($imagePath, '../') || str_contains($imagePath, '..\\')) {
                Storage::disk('public')->delete($imagePath);
                return back()->withErrors(['image' => 'Invalid file path detected.']);
            }

            if (!Storage::disk('public')->exists($imagePath)) {
                return back()->withErrors(['image' => 'File upload failed.']);
            }
        }

        Product::create([
            'merchant_id' => $merchant->id,
            'name'        => e($validated['name']),
            'price'       => $validated['price'],
            'description' => e($validated['description'] ?? ''),
            'category'    => $validated['category'],
            'stock'       => $validated['stock'],
            'image'       => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Product added!');
    }

    public function destroy($id)
    {
        $merchant = Auth::guard('merchant')->user();

        $product = Product::where('id', $id)
            ->where('merchant_id', $merchant->id)
            ->firstOrFail();

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
