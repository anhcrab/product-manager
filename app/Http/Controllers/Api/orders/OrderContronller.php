<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Throwable;

class OrderContronller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return OrderResource::collection(Order::all());
        } catch (Throwable $th) {
            return \response()->json([
                'msg' => $th->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $order = Order::create([
                'uuid' => uuid_create(),
                'products' => json_encode($request->products),
                'total_price' => $request->total_price,
                'user_device' => $request->user_device,
                'address' => $request->address,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'shipping_method_id' => $request->shipping_id,
                'payment_method_id' => $request->payment_id,
                'store' => $request->store
            ]);
            if($request->user_id){
                $order->user_id = $request->user_id;
                $order->save();
            }
            return (new OrderResource($order));
        } catch (Throwable $err){
            return $err->getMessage();
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return new OrderResource(Order::findOrFail($id));
        } catch (Throwable $th) {
            return \response()->json([
                'msg' => $th->getMessage()
            ]);
        }

    }
}
