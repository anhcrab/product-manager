<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order\Order;
use App\Models\Product;
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
      return response()->json(Order::all());
    } catch (Throwable $th) {
      return \response()->json([
        'Order message: ' => $th->getMessage()
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
        'products' => json_encode($request->products),
        'total_price' => $request->total_price,
        'device_id' => $request->device_id,
        'address' => $request->address,
        'fullname' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'shipping_id' => $request->shipping_id,
        'payment_id' => $request->payment_id,
        'status' => $request->status == null ? 'accepted' : $request->status,
      ]);
      if ($request->user_id) {
        $order->user_id = $request->user_id;
        $order->save();
      }
      // Xử lí thay đổi số lượng của kho hàng và tổng bán sau khi thực hiện tạo đơn hàng
      foreach ($request->products as $client_product) {
        $product = Product::findOrFail($client_product['product_id']);
        $product->stock_quantity = $product->stock_quantity - $client_product['quantity'];
        $product->total_sale = $product->total_sale + $client_product['quantity'];
        $product->save();
      }
      return response()->json($order->id, 200);
    } catch (Throwable $err) {
      return response()->json([
        'Order message: ' => $err->getMessage()
      ]);
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

  public function showByUuid(Request $request, string $uuid)
  {
    try {
      return response()->json(Order::where('device_id', $uuid)->get());
    } catch (Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  public function cancelById(Request $request, string $id)
  {
    try {
      $order = Order::findOrFail($id);
      $rawProducts = json_decode($order->products);
      foreach ($rawProducts as $rawProduct) {
        $product = Product::findOrFail($rawProduct->product_id);
        $product->stock_quantity = $product->stock_quantity + $rawProduct->quantity;
        $product->total_sale = $product->total_sale - $rawProduct->quantity;
        $product->save();
      }
      $order->status = 'cancel';
      $order->save();
      return response()->json('Order message: cancel', 200);
    } catch (Throwable $th) {
      return response()->json([
        'Orders message: ' => $th->getMessage()
      ]);
    }

  }

  public function updateStatus(Request $request, string $id)
  {
    try {
      $order = Order::findOrFail($id);
      $order->status = $request->status;
      $order->save();
      return response()->json($order, 200);
    } catch (Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}
