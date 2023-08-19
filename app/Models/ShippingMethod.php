<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}