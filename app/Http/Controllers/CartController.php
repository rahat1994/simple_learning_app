<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiHelpers;
    public function cartList(Request $request)
    {
        // dd($request->user()->id);
        $cartItems = Cart::where('user_id', $request->user()->id)->get();
        // dd($cartItems);
        return $this->onSuccess(
            CartResource::collection($cartItems)
        );
        
    }


    public function addToCart(Request $request)
    {
        
        Cart::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user()->id,
            'quantity' => $request->quantity
        ]);

        return "Added to cart";
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::where('course_id', $request->course_id);

        $cart->quantity = $request->quantity;
        $cart->save();

        return $this->onSuccess(
            [],
            "cart Updated"
        );

    }

    public function removeCart(Request $request)
    {
        $cart = Cart::where([
            ['course_id','=', $request->course_id],
            ['user_id','=', $request->user()->id]
        ])->delete();

        return $this->onSuccess(
            [],
            "Course Removed"
        );
    }

    public function clearAllCart(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return $this->onSuccess(
            [],
            "Cart Cleared"
        );
    }
}
