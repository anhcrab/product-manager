<?php

namespace App\Http\Resources;

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
            'uuid' => $this->uuid,
            'products' => json_decode($this->products),
            'total_price' => $this->total_price,
            'user_device' => $this->user_device,
            'user_id' => $this->user_id,
            'address' => $this->address,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'payment' => PaymentMethodResource::collection(PaymentMethod::findOrFail($this->payment_method_id)->first()),
            'shipping' => ShippingMethod::findOrFail($this->shipping_method_id)->first()
        ];
    }
}
