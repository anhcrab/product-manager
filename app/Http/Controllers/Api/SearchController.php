<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  /**
   * search product by something
   */
  public function something()
  {

  }

  /**
   * search product by related string
   */
  public function searchProductByRelatedString(Request $request)
  {
    try {
      $category = ProductCategory::where('name', 'like', '%' . $request->search_keyword . '%')->get('id');
      $products = Product::with('category')
        ->whereHas(
          'category',
          function ($query) use ($category) {
            $query->whereIn('id', $category);
          }
        )->get();
      return response()->json($products);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}