<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PaymentMethodResource::collection(PaymentMethod::all()));
    }

    /**
     * Store a newly created product type in storage.
     */
    public function store(Request $request)
    {
        $newMethod = PaymentMethod::create([
            'name' => $request->name,
            'description' => json_encode($request->payment_description)
        ]);
        return response()->json($newMethod, 204);
    }

    /**
     * Display the specified product type.
     */
    public function show(string $id)
    {
        return response()->json(PaymentMethod::findOrFail($id));
    }

    /**
     * Update the specified product type in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = PaymentMethod::findOrFail($id);
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
        PaymentMethod::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete method type successfully.'
        ], 200);
    }
}
