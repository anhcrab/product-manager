<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemCollection as CartItemCollection;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function store(Request $request)
    {
        $cart = Cart::create([
            'device' => $request->device
        ]);
        return response()->json([
            'Message' => 'A new cart have been created for you!',
            'data' => $cart
        ], 200);
    }


    public function show(Request $request, string $device)
    {
        $cart = Cart::where('device', $device)->first();
        CartItem::where('cart_id', $cart->id)->get()
            ->map(function ($c) {
                return Product::findOrFail($c->product_id);
            });
        return response()->json([
            'cart' => $cart,
            'items' => CartItemResource::collection(CartItem::where('cart_id', $cart->id)->get())
        ], 200);

    }


    public function destroy(Request $request, string $device)
    {
        $cart = Cart::where('device', $request->device);
        $cart->delete();
        return response()->json(null, 204);
    }


    public function addProducts(Request $request)
    {
        $cart = Cart::where('device', $request->device)->first();
        $quantity = $request->quantity;
        $product = Product::findOrFail($request->product_id);
        $cartItem = CartItem::where([
            'cart_id' => $cart->getKey(),
            'product_id' => $request->product_id
        ])->first();
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            CartItem::where([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id
            ])->update(['quantity' => $quantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
        return response()->json([
            'message' => 'The Cart was updated with the given product information successfully'
        ], 200);

    }

    public function removeProducts(Request $request)
    {
        $item = CartItem::where([
            'cart_id' => Cart::where('device', $request->device)->first()->id,
            'product_id' => $request->product_id
        ]);
        $item->delete();
        return response()->json([
            'message' => 'deleted'
        ], 200);
    }
}
