<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Payment::all(), 200);
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
            $payment = Payment::create([
                'type' => $request->type,
                'detail' => json_encode($request->detail),
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
            return response()->json(Payment::findOrFail($id), 200);
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
            $payment = Payment::findOrFail($id);
            $payment->type = $request->type;
            $payment->detail = json_encode($request->detail);
            $payment->save();
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
            $payment = Payment::findOrFail($id);
            $payment->delete();
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
