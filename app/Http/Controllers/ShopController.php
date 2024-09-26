<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{

    public function catalog() {
        $products = Product::where('quantity', '>', 0)->paginate(15);
        $title = 'Каталог';
        return view('shop.catalog', compact('products', 'title'));
    }

    public function addToCart(Request $request) {
        $data = [
            'product_id' => $request->input('productId'),
            'quantity' => $request->input('quantity'),
        ];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $cart = array_filter($cart, function ($item) use ($data) {
                return $item['product_id'] != $data['product_id'];
            });
            if ($data['quantity'] > 0) {
                $cart[] = $data;
            }

            Session::put('cart', $cart);
        } else {
            Session::push('cart', $data);
        }
        return count(Session::get('cart'));
    }

    public function cart() {
        $cart = Session::get('cart');
        if (is_null($cart)) {
            return redirect(route('shop.catalog'));
        }
        foreach ($cart as &$item) {
            $item['product'] = Product::find($item['product_id'])->toArray();
        }
        return view('shop.cart', compact('cart'));
    }

    public function createOrder() {
        try {
            Order::createOrder();
        } catch (\Exception $exception) {
            return back()->withErrors(['msg' => $exception->getMessage()]);
        }
        return redirect(route('shop.orders'));
    }

    public function orders() {
        $orders = Order::with('products')->get();
        return view('shop.orders', compact('orders'));
    }
}
