<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id','product_id','quantity','price','subtotal'];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
