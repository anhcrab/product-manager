<?php

namespace App\Http;

use App\Models\Product;

class Cart
{
    private $products = null;
    private $total_price = 0;
    private $total_quantity = 0;

    /**
     * @param null $products
     * @param int $total_price
     * @param int $total_quantity
     */
    public function __construct(Cart $cart)
    {
        $this->products = $cart->products;
        $this->total_price = $cart->total_price;
        $this->total_quantity = $cart->total_quantity;
    }

    /**
     * @return null
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param null $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->total_price = $total_price;
    }

    public function getTotalQuantity(): int
    {
        return $this->total_quantity;
    }

    public function setTotalQuantity(int $total_quantity): void
    {
        $this->total_quantity = $total_quantity;
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->sale_price == null ? $product->regular_price : $product->sale_price;
        $new_products = [
            'quantity' => 0,
            'price' => $price,
            'data' => $product
        ];
        if ($this->products && array_key_exists($id, $this->products)) {
            $new_products = $this->products[$id];
        }
        $new_products['quantity']++;
        $new_products['price'] = $new_products['quantity'] * $price;
        $this->products[$id] = $new_products;
        $this->total_price += $price;
        $this->total_quantity++;
    }

    public function removeFromCart($id)
    {
        $this->total_quantity -= $this->products[$id]['quantity'];
        $this->total_price -= $this->products[$id]['price'];
        unset($this->products[$id]);
    }
}
