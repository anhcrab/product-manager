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
        $name = $request->name;
        $category = ProductCategory::where('name', $request->search_keyword)->get();
        if ($category) {
            return \response()->json($category->product());
        }
        return response()->json([
            'message' => 'No product found'
        ], 404);
    }
}
