<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function filter(Request $request)
    {

    }

    public function sort(Request $request)
    {
        $sort = $request->sort;
        switch ($sort){
            case 'price:asc':
                return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
                    if ($p1->price > $p2->price) return 1;
                    if ($p1->price < $p2->price) return -1;
                    return 0;
                });
            case 'price:desc':
                return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
                    if ($p1->price > $p2->price) return -1;
                    if ($p1->price < $p2->price) return 1;
                    return 0;
                });
            case 'name:asc':
                return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
                    if ($p1->name > $p2->name) return 1;
                    if ($p1->name < $p2->name) return -1;
                    return 0;
                });
            case 'name:desc':
                return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
                    if ($p1->name > $p2->name) return -1;
                    if ($p1->name < $p2->name) return 1;
                    return 0;
                });
            default:
                return ProductResource::collection(Product::all());
        }
    }
}
