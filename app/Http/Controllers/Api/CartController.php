<?php

namespace App\Http\Controllers\Api;

use App\Http\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\Count;

class CartController extends Controller
{
    public function addToCart(Request $request, string $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->addToCart($id);
        $request->session()->put('Cart', $newCart);
    }

    public function removeFromCart(Request $request, string $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->removeFromCart($id);
        if (Count($newCart->getProducts()) > 0){
            $request->session()->put('Cart', $newCart);
        } else {
            $request->session()->forget('Cart');
        }
        $request->session()->put('Cart', $newCart);
    }
}
