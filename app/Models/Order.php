<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    use HasFactory;
    public static function createOrder() {
        $cart = session('cart');
        if (empty($cart)) {
            throw new \Exception( 'Корзина пуста');
        }
        $order = new Order();
        $order->save();
        foreach($cart as $item) {
            $order->products()->attach($item['product_id'], ['count' => $item['quantity']]);
            Product::find($item['product_id'])->decrement('quantity', $item['quantity']);
        }
        Session::forget('cart');
        return true;
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('count');
    }

    public function getJoinProductNames(string $join = ', ') {
        return join($join, array_column($this->products->toArray(), 'name'));
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->products as $cartItem) {
            $total += $cartItem->price * $cartItem->getOriginal('pivot_count');
        }
        return $total;
    }
}
