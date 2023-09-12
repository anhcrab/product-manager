<?php

namespace App\Models\transaction;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory;
  protected $fillable = [
    'uuid',
    'order_id',
    'intent',
    'payer_id',
    'name',
    'country_code',
    'email',
    'purchase_units',
    'status',
    'created_at',
    'updated_at'
  ];
  public function order()
  {
    return $this->hasOne(Order::class, 'order_id');
  }
}
