<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'merchant_id',
        'total_amount',
        'status',
        'note'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
