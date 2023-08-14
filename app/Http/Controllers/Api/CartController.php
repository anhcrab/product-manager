<?php

namespace App\Http\Controllers\Api;

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
            // TODO: create new cart
        ]);
        return response()->json([
            'Message' => 'A new cart have been created for you!',
            'data' => $cart
        ], 200);
    }


    public function show(Request $request)
    {
        $device = $request->input('device');
        $cart = Cart::where('device', $device);
        return response()->json([
            'cart' => Cart::findOrFail($device),
            'Items in Cart' => new CartItemCollection(),
        ], 200);

    }


    public function destroy(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');

        if ($cart->key == $cartKey) {
            $cart->delete();
            return response()->json(null, 204);
        } else {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }


    public function addProducts(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        if ($cart->key == $cartKey) {
            $Product = Product::findOrFail($productID);

            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
            }

            return response()->json(['message' => 'The Cart was updated with the given product information successfully'], 200);

        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }
}
