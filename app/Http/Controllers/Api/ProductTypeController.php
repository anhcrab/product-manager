<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the product types.
     */
    public function index()
    {
        return response()->json(ProductType::all());
    }

    /**
     * Store a newly created product type in storage.
     */
    public function store(Request $request)
    {
        $newType = ProductType::create($request->all());
        return response()->json($newType, 204);
    }

    /**
     * Display the specified product type.
     */
    public function show(string $id)
    {
        return response()->json(ProductType::findOrFail($id));
    }

    /**
     * Update the specified product type in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = ProductType::findOrFail($id);
        $type->name = $request->input('name');
        $type->save();
        return response()->json([
            'message' => 'Updated type of products successfully.'
        ], 200);
    }

    /**
     * Remove the specified product type from storage.
     */
    public function destroy(string $id)
    {
        ProductType::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete products type successfully.'
        ], 200);
    }
}
