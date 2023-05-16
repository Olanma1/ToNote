<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class CartsController extends Controller
{
   public function addProductsToCart(Request $request)
   {
        $productId = $request['product_id'];
        $theUserId = auth()->user()->id;

        if(!$productId){
            return response([
                'data' => Cart::where('user_id', $theUserId)->sum('quantity'),
                'message' => 'You have fetched all cart'
            ], 200);
        }

        //Pass to producer

        $message = new Message(
            body: ["userId" => $theUserId, "productId" => $productId],
        );

        Kafka::publishOn("cartItem")->withMessage($message)->send();

        $product = Product::find($productId);

        $productExistsInCart = Cart::where(['id' => $productId, 'user_id' => $theUserId])->first();

        if($productExistsInCart) {
            Cart::where('user_id', $theUserId)
                ->where('product_id', $productId)
                ->increment('quantity');
        }
        else {
            $cart = Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
                'user_id' => $theUserId,
            ]);
        }

        if($cart){

            $userCartProducts = Cart::where(['user_id' => $theUserId, 'id' => $productId])->first();
            return response([
                'data' => $userCartProducts,
                'message' => 'You have added product to cart'
            ], 201);
        }
   }

   public function getUserCartProducts()
   {
        $userCartProducts = Cart::with('product')->where('user_id', auth()->user()->id)->get();

        $totalPriceInCart = 0;
        foreach ($userCartProducts as $cartProduct) {
            $productPrice = $cartProduct->price * $cartProduct->quantity;
            $totalPriceInCart += $productPrice;
        }
        return response([
            'data' => $userCartProducts,
            'totalPrice' => number_format($totalPriceInCart, 2),
            'message' => 'You have fetched all the product in your cart'
        ], 200);
   }

   public function removeProductFromCart($id)
   {
        $theUserId = auth()->user()->id;
        $cartItem  = Cart::where(['user_id' => $theUserId, 'id' => $id])->first();

        if($cartItem == NULL) {
			return response([
				'message' => 'Cart does not exists'
			], 404);
		}
        if($cartItem['quantity'] > 1) {
            $cartItem->decrement('quantity');
        } else {
            // Remove the product from the cart
            $cartItem->delete();
        }

        return response([
            'message' => 'You have successfully removed product from cart'
        ], 200);
   }
}
