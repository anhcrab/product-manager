<?php

namespace App\Http\Resources;

use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => ProductType::findOrFail($this->type_id)->name,
            'name' => $this->name,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'detail' => $this->detail,
            'category' => ProductCategory::findOrFail($this->category_id)->name,
            'attributes' => ProductAttributeResource::collection(ProductAttribute::where('product_id', $this->id)->get()),
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'stock_quantity' => $this->stock_quantity,
            'total_sale' => $this->total_sale,
            'tags' => ProductTagResource::collection($this->whenLoaded('tag')),
            'images' => $this->getMedia('images')->map(function ($media) {
                $imageParts = explode('localhost', $media->getUrl());
                $image = $imageParts[0].'localhost:3000'.$imageParts[1];
                return $image;
            }),
        ];
    }
}
