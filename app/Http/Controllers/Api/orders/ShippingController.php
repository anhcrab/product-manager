<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Models\Order\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Shipping::all(), 200);
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
            $shipping = Shipping::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);
            return response()->json($shipping, 200);
        } catch (\Throwable $throwable) {
            return response()->json([
                'msg' => $throwable->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json(Shipping::findOrFail($id), 200);
        } catch (\Throwable $throwable) {
            return response()->json([
                'msg' => $throwable->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $shipping = Shipping::findOrFail($id);
            $shipping->name = $request->name;
            $shipping->price = $request->price;
            $shipping->save();
            return response()->json([
                'msg' => 'success'
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
            $shipping = Shipping::findOrFail($id);
            $shipping->delete();
            return response()->json([
                'msg' => 'success'
            ], 200);
        } catch (\Throwable $throwable) {
            return response()->json([
                'msg' => $throwable->getMessage()
            ]);
        }
    }
}
