<?php

namespace App\Http\Controllers\Api\inventory;

use App\Http\Controllers\Controller;

use App\Models\Inventory\Inventory;

use Illuminate\Http\Request;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Inventory::all(), 200);
        } catch (\Throwable $throwable) {
            return response()->json([
                'msg' => $throwable->getMessage()
            ]);
        }
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $payment = Inventory::create([
                'type' => $request->type,
                'detail' => $request->detail,
            ]);
            return response()->json($payment, 200);
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
            return response()->json(Inventory::findOrFail($id), 200);
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
            $inventory = Inventory::findOrFail($id);
            $inventory->type = $request->type;
            $inventory->detail = $request->detail;
            $inventory->save();
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
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();
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
