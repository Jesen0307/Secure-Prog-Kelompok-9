<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'merchant_id',
        'name',
        'price',
        'description',
        'image',
    ];

    // Relationship: a product belongs to a merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
