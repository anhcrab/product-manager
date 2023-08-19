<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ShippingMethod::all());
    }

    /**
     * Store a newly created product type in storage.
     */
    public function store(Request $request)
    {
        $newMethod = ShippingMethod::create($request->all());
        return response()->json($newMethod, 204);
    }

    /**
     * Display the specified product type.
     */
    public function show(string $id)
    {
        return response()->json(ShippingMethod::findOrFail($id));
    }

    /**
     * Update the specified product type in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = ShippingMethod::findOrFail($id);
        $type->name = $request->input('name');
        $type->save();
        return response()->json([
            'message' => 'Updated method successfully.'
        ], 200);
    }

    /**
     * Remove the specified product type from storage.
     */
    public function destroy(string $id)
    {
        ShippingMethod::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete method type successfully.'
        ], 200);
    }
}
