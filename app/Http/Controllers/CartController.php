<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $quantity = 1;

        if($quantity > $product->stock){
            $quantity = $product->stock;
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        if($cartItem)
        {
            $cartItem->quantity = min($cartItem->quantity + $quantity, $product->stock);
            $cartItem->save();
        } 
        else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return view('cart.index', compact('cart'));
    }

    public function update(Request $request, $itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);

        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $quantity = (int)$request->input('quantity', 1);

        if ($quantity < 1) {
            return redirect()->back()->with('error', 'Quantity tidak boleh kurang dari 1.');
        }

        $product = $cartItem->product->fresh();

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', "Stok produk '{$product->name}' tidak mencukupi. Maksimal: {$product->stock}.");
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }


    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        if($cartItem->cart->user_id !== Auth::id()){
            abort(403);
        }

        $cartItem->delete();
        return redirect()->back()->with('success', 'Item removed!');
    }
}
