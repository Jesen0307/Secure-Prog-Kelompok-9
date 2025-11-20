<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'name',
        'price',
        'description',
        'category',
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'float',
        'merchant_id' => 'integer',
    ];
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function getDescriptionAttribute($value)
    {
        return e($value);
    }
    public function getNameAttribute($value)
    {
        return e($value);
    }


}
