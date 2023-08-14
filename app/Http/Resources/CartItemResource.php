<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{

    public function toArray(Request $request)
    {
        $product = Product::find($this->product_id);

        return [
            'product_id' => $this->product_id,
            'price' => $product->sale_price ?: $product->regular_price,
            'Name' => $product->Name,
            'quantity' => $this->quantity,
        ];
    }
}
