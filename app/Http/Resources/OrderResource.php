<?php

namespace App\Http\Resources;

use App\Models\Order\Shipping;
use App\Models\Payment\Payment;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'products' => json_decode($this->products),
            'total_price' => $this->total_price,
            'device_id' => $this->device_id,
            'user_id' => $this->user_id,
            'address' => $this->address,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'payment' => Payment::findOrFail($this->payment_method_id)->first(),
            'shipping' => Shipping::findOrFail($this->shipping_method_id)->first(),
            'status' => $this->status,
        ];
    }
}
