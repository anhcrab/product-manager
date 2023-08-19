<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'products',
        'total_price',
        'user_device',
        'user_id',
        'address',
        'full_name',
        'email',
        'phone',
        'payment_method_id',
        'shipping_method_id',
    ];

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class);
    }

    public function shippingMethod()
    {
        return $this->hasOne(ShippingMethod::class);
    }
}
