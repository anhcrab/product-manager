<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
  public function total(Request $request)
  {
    try {
      $filter = $request->filter;
      $sort = $request->sort;
      //        return $filter;
      return response()->json($this->filter($this->sort($sort), $filter));
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
  public function filter($products, $filters)
  {
    try {
      foreach ($filters as $filter) {
        switch ($filter) {
          case "Dưới 100.000₫":
            $products->filter(function ($value) {
              return $value->regular_price < 100000;
            });
            break;
          case "100.000₫ - 250.000₫":
            $products->filter(function ($value) {
              return $value->regular_price >= 100000 && $value->regular_price <= 250000;
            });
            break;
          case "250.000₫ - 500.000₫":
            $products->filter(function ($value) {
              return $value->regular_price > 250000 && $value->regular_price < 500000;
            });
            break;
          case "500.000₫ - 800.000₫":
            $products->filter(function ($value) {
              return $value->regular_price >= 500000 && $value->regular_price <= 800000;
            });
            break;
          case "Trên 800.000₫":
            $products->filter(function ($value) {
              return $value->regular_price < 800000;
            });
            break;
        }
      }
      return $products;
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  public function sort($sort)
  {
    try {
      switch ($sort) {
        case 'price:asc':
          return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
            if ($p1->price > $p2->price)
              return 1;
            if ($p1->price < $p2->price)
              return -1;
            return 0;
          });
        case 'price:desc':
          return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
            if ($p1->price > $p2->price)
              return -1;
            if ($p1->price < $p2->price)
              return 1;
            return 0;
          });
        case 'name:asc':
          return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
            if ($p1->name > $p2->name)
              return 1;
            if ($p1->name < $p2->name)
              return -1;
            return 0;
          });
        case 'name:desc':
          return ProductResource::collection(Product::all())->collection->sort(function ($p1, $p2) {
            if ($p1->name > $p2->name)
              return -1;
            if ($p1->name < $p2->name)
              return 1;
            return 0;
          });
        default:
          return ProductResource::collection(Product::all());
      }
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}
