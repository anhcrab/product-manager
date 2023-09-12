<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return response()->json(ProductCategory::all());
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $newType = ProductCategory::create($request->all());
      $newType->slug = Str::slug($newType->name);
      $newType->save();
      return response()->json($newType, 204);
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage(),
      ]);
    }

  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return response()->json(ProductCategory::findOrFail($id));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $cat = ProductCategory::findOrFail($id);
      $cat->name = $request->name;
      $cat->category_id = $request->category_id;
      $cat->slug = $request->slug;
      $cat->save();
      return response()->json([
        'message' => 'Updated type of products successfully.'
      ], 200);
    } catch (\Throwable $throwable) {
      return response()->json([
        'msg' => $throwable->getMessage()
      ]);
    }

  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    ProductCategory::findOrFail($id)->delete();
    return response()->json([
      'message' => 'Delete products type successfully.'
    ], 200);
  }
}