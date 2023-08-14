<?php

namespace App\Http\Resources;

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
//        $imagePath = $this->getFirstMedia('images')[0];
//        $imageParts = explode('localhost', $imagePath);
//        $image = $imageParts[0].'localhost:3000'.$imageParts[1];
        return [
            'id' => $this->id,
            'type' => new ProductTypeResource($this->whenLoaded('type')),
            'name' => $this->name,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'detail' => $this->detail,
            'category' => new ProductCategoryResource($this->whenLoaded('category')),
            'attributes' => ProductAttributeResource::collection($this->whenLoaded('attribute')),
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'stock_quantity' => $this->stock_quantity,
            'total_sale' => $this->total_sale,
            'tags' => ProductTagResource::collection($this->whenLoaded('tag')),
            'images' => $this->getMedia('images'),
        ];
    }
}
