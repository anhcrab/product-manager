<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductType;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use PHPUnit\Event\Code\Throwable;

class ProductAttributeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      return response()->json(ProductAttribute::all());
    } catch (\Throwable $throwable) {
      return response()->json([
        'msg' => $throwable->getMessage()
      ]);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $newAttr = ProductAttribute::create($request->all());
      return response()->json($newAttr, 200);
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ], 200);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, string $id)
  {
    try {
      return response()->json(ProductAttribute::findOrFail($id));
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ], 500);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $attr = ProductAttribute::findOrFail($id);
      $attr->type = $request->type;
      $attr->name = $request->input('name');
      $attr->code = $request->code;
      $attr->save();
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
    try {
      ProductAttribute::findOrFail($id)->delete();
      return response()->json([
        'message' => 'Delete products type successfully.'
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}