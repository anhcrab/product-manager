<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Models\Payment\Store;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Store::all(), 200);
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
            $store = Store::create([
                'name' => $request->name,
                'address' => $request->address,
            ]);
            return response()->json($store, 200);
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
            return response()->json(Store::findOrFail($id), 200);
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
            $store = Store::findOrFail($id);
            $store->name = $request->name;
            $store->address = $request->address;
            $store->save();
            return response()->json($store, 200);
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
            $store = Store::findOrFail($id);
            $store->delete();
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
