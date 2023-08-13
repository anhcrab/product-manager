<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ProductTag::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newType = ProductTag::create($request->all());
        return response()->json($newType, 204);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(ProductTag::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = ProductTag::findOrFail($id);
        $type->name = $request->input('name');
        $type->save();
        return response()->json([
            'message' => 'Updated type of products successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductTag::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete products type successfully.'
        ], 200);
    }
}
