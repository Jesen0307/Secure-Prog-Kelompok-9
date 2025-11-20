<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (! $cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        $itemsByMerchant = [];
        $grandTotal = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            if (! $product) {
                return back()->with('error', 'One of the products is no longer available.');
            }
            $merchantId = $product->merchant_id;
            $subtotal = $item->price * $item->quantity;
            $grandTotal += $subtotal;

            $itemsByMerchant[$merchantId][] = [
                'item' => $item,
                'product' => $product,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
            ];
        }


        if (bccomp($user->wallet_balance, $grandTotal, 2) < 0) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        DB::beginTransaction();
        try {
            $user->wallet_balance = bcsub($user->wallet_balance, $grandTotal, 2);
            $user->save();

            foreach ($itemsByMerchant as $merchantId => $items) {
                $total = array_sum(array_column($items, 'subtotal'));

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'merchant_id' => $merchantId,
                    'total_amount' => $total,
                    'status' => 'paid',
                ]);

                foreach ($items as $row) {
                    $prod = $row['product'];
                    $qty = $row['quantity'];
                    $price = $row['price'];
                    $subtotal = $row['subtotal'];

                    if ($prod->stock < $qty) {
                        throw new \Exception("Product {$prod->name} does not have enough stock.");
                    }

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $prod->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ]);

                    $prod->stock = max(0, $prod->stock - $qty);
                    $prod->save();
                }

                $merchant = \App\Models\User::find($merchantId);
                if ($merchant) {
                    $merchant->wallet_balance = bcadd($merchant->wallet_balance, $total, 2);
                    $merchant->save();
                }

            }

            foreach($cart->items as $cartItem){
                $cartItem->delete();
            }

            DB::commit();
            return redirect()->route('dashboard.home')->with('success', 'Checkout successful. Order has been placed.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout failed: '.$e->getMessage());
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
