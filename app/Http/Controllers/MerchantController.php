<?php
// app/Http/Controllers/MerchantProductController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;


class MerchantProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'merchant_id' => Auth::guard('merchant')->id(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function index()
    {
        $merchant = Auth::user();
        $products = Product::where('merchant_id', $merchant->id)->get();
        $orders = TransactionItem::whereHas('product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->with(['product', 'transaction.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $orders = $orders->map(function ($item) {
            return (object)[
                'id' => $item->transaction->id,
                'user' => $item->transaction->user,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'total_price' => $item->subtotal,
                'status' => $item->transaction->status,
                'created_at' => $item->created_at,
            ];
        });

        return view('merchant.dashboard', compact('merchant', 'products', 'orders'));
    }



}
