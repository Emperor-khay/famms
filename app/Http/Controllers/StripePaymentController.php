<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($total): View
    {
        return view('home.stripe', compact('total'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe_post(Request $request, $total): RedirectResponse
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([

                "amount" => $total * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

        $user = Auth::user();
        $userid = $user->id;
        $cart_data = Cart::where('user_id', '=', $userid)->get();

        // this is because the querry will return more than one result
        foreach($cart_data as $data)
        {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->product_id = $data->product_id;
            $order->image = $data->image;
            $order->payment_status = 'paid';
            $order->delivery_status = 'processing';
            $order->save();

            // Delete from cart after placing order
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

                   // Decrease available quantity by the ordered quantity
            // $product = Product::where('id', '=', $cart_data->product_id)->first();
            // $product->quantity -= $data->quantity;
            $product = Product::find($data->product_id);
            if ($product) {
                $product->quantity -= $data->quantity;
                $product->save();
            }
        }
        Alert::success('Success', 'Payment Successfull!');
        return redirect()->route('show_cart');
    }
}
