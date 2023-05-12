<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class OrderController extends Controller
{
    public function storeOrder()
    {
        $user = auth()->user();
        $cart = $user->cart;
        $cartItems = $user->cart->product;

        $order = new Order;
        $message = new Message(
            body: ["userId" => $user->id, "productId" => $cartItems],
        );

        Kafka::publishOn("checkout")->withMessage($message)->send();

        return "Message sent to kafka";
        $order->user_id = $user->id;
        $order->price = $cartItems->sum('price');
        $order->cart_items = $cartItems;
        $order->save();

        return response([
            'data' => $order,
            'message' => 'Order successful'
        ], 201);
    }
}
