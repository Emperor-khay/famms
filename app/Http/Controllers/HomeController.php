<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Reply;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == '1') {
                $total_product = Product::all()->count();
                $total_order = Order::all()->count();
                $total_user = User::where('usertype', '=', '0')->get()->count();
                $order = Order::all();
                $total_revenue = 0;
                foreach($order as $order)
                {
                    $total_revenue=$total_revenue+$order->price;
                }
                $total_delivered = Order::where('delivery_status', '=', 'delivered')->get()->count();
                $total_processing = Order::where('delivery_status', '=', 'processing')->get()->count();
                return view('admin.home', compact('total_product', 'total_order', 'total_user', 'total_revenue', 'total_delivered', 'total_processing'));
            // } elseif ($usertype == null) {
            //     return redirect()->route('login');
            } else {
                // $products = Product::inRandomOrder()->paginate(6);
                $products = Product::inRandomOrder()->take(6)->get();
                $comments = Comment::orderby('id', 'desc')->get();
                $replies = Reply::all();

                foreach($replies as $reply) {
                    if($reply->parent_id) {
                        $parentReply = Reply::find($reply->parent_id);
                        $reply->parent_name = $parentReply ? $parentReply->name : null;
                    }
                }

                // $products = Product::paginate(6);
                return view('home.userpage', compact('products', 'comments', 'replies'));
            }
        } else {
            //   Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login')->banner('You have to login first to use the system!.');
        }
    }

    public function index()
    {
        // $products = Product::paginate(6);
        $products = Product::inRandomOrder()->take(6)->get();
        $comments = Comment::orderby('id', 'desc')->get();
        $replies = Reply::all();

        foreach($replies as $reply) {
            if($reply->parent_id) {
                $parentReply = Reply::find($reply->parent_id);
                $reply->parent_name = $parentReply ? $parentReply->name : null;
            }
        }
        return view('home.userpage', compact('products', 'comments', 'replies'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $user = Auth::user();
                $product = Product::find($id);

                 // Check if the product already exists in the cart
                $existingCart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

                if ($existingCart) {
                        Alert::error('Error', 'Product Already Exists In Cart. You can go to cart details to edit');
                        return redirect()->route('show_cart');
                        // return redirect()->back();
                }else{
                    if ($request->quantity > $product->quantity) {
                        Alert::error('Error', 'The requested quantity exceeds the available stock.');
                        return redirect()->back()
                        // ->withErrors(['quantity' => 'The requested quantity exceeds the available stock.'])
                        ;
                    }else{
                        $cart = new Cart;
                        $cart->name = $user->name;
                        $cart->email = $user->email;
                        $cart->phone = $user->phone;
                        $cart->address = $user->address;
                        $cart->user_id = $user->id;
                        $cart->product_title = $product->title;
                        $cart->quantity = $request->quantity;
                        // to check for discount
                        if($product->discount_price!=null)
                        {
                            $cart->price = $product->discount_price * $request->quantity;
                        }
                        else
                        {
                            $cart->price = $product->price * $request->quantity;
                        }

                        $cart->product_id = $product->id;
                        $cart->image = $product->image;
                        $cart->save();
                        Alert::success('Product Added Successfully', 'We have added product to the cart');
                        return redirect()->back();
                    }
                }
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function show_cart()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $user = Auth::user();
                $cart = Cart::where('user_id', '=', $user->id)->get();
                return view('home.cart', compact('cart'));
            }
        }
        else
        {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $cart = Cart::find($id);
                $cart->delete();
                Alert::success('Product Removed From Cart', 'Product Has Been Successfully Removed From Cart');
                return redirect()->back();
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function edit_cart($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $cart = Cart::find($id);
                $product = Product::where('id', '=', $cart->product_id)->first();
                return view('home.edit_cart', compact('cart', 'product'));
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function update_cart(Request $request, $id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $cart = Cart::find($id);
                $product = Product::where('id', '=', $cart->product_id)->first();
                if ($request->quantity > $product->quantity) {
                    Alert::error('Error', 'The requested quantity exceeds the available stock');
                    return redirect()->back()
                    // ->withErrors(['quantity' => 'The requested quantity exceeds the available stock.'])
                    ;
                }else{
                    $cart->quantity = $request->quantity;

                    if($product->discount_price!=null)
                    {
                        $cart->price = $product->discount_price * $request->quantity;
                    }
                    else
                    {
                        $cart->price = $product->price * $request->quantity;
                    }

                    $cart->save();
                    Alert::success('Cart Updated Successfully', 'The quantity of product in cart has been updated.');
                    return redirect()->route('show_cart');
                }
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function cash_order()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
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
                    $order->payment_status = 'cash on delivery';
                    $order->delivery_status = 'processing';
                    $order->restored_at = now();
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
                Alert::success('Processing Order', 'Your order is on its way! Thank you for shopping with us.');
                return redirect()->back();
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function show_order()
    {
        if (Auth::check()){
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                if (!Session::has('restored_at')) {
                    Session::put('restored_at', now());
                }

                $user = Auth::user();
                $order = Order::where('user_id', '=', $user->id)->orderby('id', 'desc')->get();
                // $order->created_at = $order->created_at->diff
                return view('home.order', compact('order'));
            }
        }
        else
        {
              Alert::error('Error', 'You have to login first to use the system');
              return view('auth.login');
        }
    }

    public function cancel_order($id){
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                if ($order) {
                    $restored_at = $order->restored_at;
                    $timestamp = Carbon::parse($restored_at)->diffInHours(Carbon::now());
                    // dd($timestamp);
                    if ($timestamp !== null && $timestamp < 24)
                    {
                        $order->delivery_status = 'canceled';
                        $order->canceled_at = now();
                        $order->restored_at = null;
                        $order->save();
                        $product = Product::find($order->product_id);
                        if ($product) {
                            $product->quantity += $order->quantity;
                            $product->save();
                        }
                        Alert::success('Order Cancelled', 'Order Has Been Cancelled Successfully');
                        return redirect()->back();
                    } elseif ($timestamp !== null && $timestamp > 24) {
                        // Add an error message
                        Alert::error('Cancellation period expired', 'You cannot cancel this order becauce it has been over 24hrs since this order was placed and it has already been processed and is on its way to your doorstep.');
                    } else {
                        Alert::error('Null Timestamp', '$diffInHours = null.');
                    }
                }
                else {
                    Alert::error('Order not Found', 'Invalid Order id.');
                }
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function restore_order($id){
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                $order->delivery_status = 'processing';
                $order->canceled_at = null;
                $order->restored_at = now();
                $order->save();
                $product = Product::find($order->product_id);
                if ($product) {
                    $product->quantity -= $order->quantity;
                    $product->save();
                }
                Alert::success('Order Restored', 'Order Has Been Restored Successfully');
                return redirect()->back();
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function delete_order($id){
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                $order->delete();
                Alert::success('Order Deleted', 'Order Has Been Deleted Successfully');
                return redirect()->back();
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

    public function comment(Request $request)
    {
        if(Auth::check()){
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $comment = new Comment;
                $comment->name = Auth::user()->name;
                $comment->user_id = Auth::user()->id;
                $comment->comment = $request->comment;
                $comment->save();
                Alert::success('Comment Uploaded', 'We ave uploaded your comment');
                return redirect()->back();
            }
        }
        else
        {
            return redirect('login');
        }
    }

    public function reply(Request $request)
    {
        if(Auth::check())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $reply = new Reply;
                $reply->name=Auth::user()->name;
                $reply->user_id=Auth::user()->id;
                $reply->comment_id=$request->commentId;
                $reply->parent_id = $request->parentId; // This will be null for top-level replies
                $reply->reply=$request->reply;
                $reply->save();
                Alert::success('Reply Uploaded', 'We ave uploaded your reply to this comment');
                return redirect()->back();
            }
        }
        else
        {
              Alert::error('Error', 'You have to login first to use the system');
              return view('auth.login');
        }
    }

    public function delete_comment($id)
    {
        if(Auth::check())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $comment = Comment::findOrFail($id);

                // Check if the authenticated user owns the comment
                if ($comment->user_id == auth()->id()) {
                    $comment->delete();
                    Alert::success('You have deleted this comment', 'Comment deleted successfully');
                    return redirect()->back();
                } else {
                    Alert::success('Unauthorized to delete this comment.', 'You cannot delete a comment you didnt publish');
                    return redirect()->back();
                }
            }
        }
        else
        {
              Alert::error('Error', 'You have to login first to use the system');
              return view('auth.login');
        }
    }

    public function delete_reply($id)
    {
        if(Auth::check())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $reply = Reply::findOrFail($id);

                // Check if the authenticated user owns the reply
                if ($reply->user_id == auth()->id()) {
                    $reply->delete();
                    return redirect()->back();
                } else {
                    return redirect()->back();
                }
            }
        }
        else
        {
            Alert::error('Error', 'You have to login first to use the system');
            return view('auth.login');
        }
    }

    public function product_details($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $product = Product::find($id);
                return view('home.product_details', compact('product'));
            }
        } else {
            $product = Product::find($id);
            return view('home.product_details', compact('product'));
            // return redirect()->route('login');
        }
    }

    public function product_search(Request $request)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $categories = Category::all();
                $search = $request->search;
                $products = Product::where('title', 'LIKE', "%$search%")->orWhere('category', 'LIKE', "%$search%")->paginate(6);
                $comments = Comment::orderby('id', 'desc')->get();
                $replies = Reply::all();

                foreach($replies as $reply) {
                    if($reply->parent_id) {
                        $parentReply = Reply::find($reply->parent_id);
                        $reply->parent_name = $parentReply ? $parentReply->name : null;
                    }
                }

                return view('home.all_products', compact('products', 'comments', 'replies'));
            }
        } else {
            $categories = Category::all();
            $search = $request->search;
            $products = Product::where('title', 'LIKE', "%$search%")->orWhere('category', 'LIKE', "%$search%")->paginate(6);
            $comments = Comment::orderby('id', 'desc')->get();
            $replies = Reply::all();

            foreach($replies as $reply) {
                if($reply->parent_id) {
                    $parentReply = Reply::find($reply->parent_id);
                    $reply->parent_name = $parentReply ? $parentReply->name : null;
                }
            }

            // return view('home.all_products', compact('products', 'comments', 'replies', 'categories'));
            // return redirect()->route('login');
            return view('home.all_products', [
                'products' => $products,
                'comments' => $comments,
                'reply' => $reply,
                'categories' => $categories
            ]);
        }
    }

    public function products()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $categories = Category::all();
                $products = Product::paginate(6);
                $comments = Comment::orderby('id', 'desc')->get();
                $replies = Reply::all();

                foreach($replies as $reply) {
                    if($reply->parent_id) {
                        $parentReply = Reply::find($reply->parent_id);
                        $reply->parent_name = $parentReply ? $parentReply->name : null;
                    }
                }

                return view('home.all_products', compact('products', 'comments', 'replies', 'categories'));
            }
        } else {
            $categories = Category::all();
            $products = Product::paginate(6);
            $comments = Comment::orderby('id', 'desc')->get();
            $replies = Reply::all();

            foreach($replies as $reply) {
                if($reply->parent_id) {
                    $parentReply = Reply::find($reply->parent_id);
                    $reply->parent_name = $parentReply ? $parentReply->name : null;
                }
            }

            return view('home.all_products', compact('products', 'comments', 'replies', 'categories'));
            // return redirect()->route('login');
            // return view('home.all_products', [
            //     'products' => $products,
            //     'comments' => $comments,
            //     'reply' => $reply,
            //     'categories' => $categories
            // ]);
        }
    }
    // public function stripe($total)
    // {
    //     return view('home.stripe', compact('total'));
    // }

    // public function stripe_post(Request $request): RedirectResponse
    // {
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     Charge::create ([
    //             "amount" => 10 * 100,
    //             "currency" => "usd",
    //             "source" => $request->stripeToken,
    //             "description" => "Test payment from itsolutionstuff.com."
    //     ]);

    //     return back()
    //             ->with('success', 'Payment successful!');
    // }

    public function category($category_name)
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $categories = Category::all();
                $category = Category::where('category_name', $category_name)->first();
                            if (!$category) {
                    Alert::error('Error', 'Category not found');
                    return redirect()->back();
                }
                $products = Product::where('category', $category->category_name)->get();
                $comments = Comment::orderby('id', 'desc')->get();
                $replies = Reply::all();

                foreach($replies as $reply) {
                    if($reply->parent_id) {
                        $parentReply = Reply::find($reply->parent_id);
                        $reply->parent_name = $parentReply ? $parentReply->name : null;
                    }
                }

                // dd($category, $products, $comments, $reply);
                // return view('home.all_products', [
                //     'products' => $products,
                //     'comments' => $comments,
                //     'reply' => $reply,
                //     'selectedCategory' => $category,
                //     'categories' => $categories
                // ]);
                return view('home.all_products', compact('products', 'comments', 'replies', 'category', 'categories'));
            }
        } else {
            $categories = Category::all();
            $category = Category::where('category_name', $category_name)->first();
            if (!$category) {
                Alert::error('Error', 'Category not found');
                return redirect()->back();
            }
            $products = Product::where('category', $category->category_name)->get();
            $comments = Comment::orderby('id', 'desc')->get();
            $replies = Reply::all();

            foreach($replies as $reply) {
                if($reply->parent_id) {
                    $parentReply = Reply::find($reply->parent_id);
                    $reply->parent_name = $parentReply ? $parentReply->name : null;
                }
            }

            // dd($catego   ry, $products, $comments, $reply);
            // return view('home.all_products', [
            //     'products' => $products,
            //     'comments' => $comments,
            //     'reply' => $reply,
            //     'selectedCategory' => $category,
            //     'categories' => $categories
            // ]);
                return view('home.all_products', compact('products', 'comments', 'replies', 'category', 'categories'));
        }
    }

    public function blog()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
                } else {
                // $products = Product::inRandomOrder()->paginate(6);
                $comments = Comment::orderby('id', 'desc')->get();
                $replies = Reply::all();

                foreach($replies as $reply) {
                    if($reply->parent_id) {
                        $parentReply = Reply::find($reply->parent_id);
                        $reply->parent_name = $parentReply ? $parentReply->name : null;
                    }
                }

                // $products = Product::paginate(6);
                return view('home.blog', compact( 'comments', 'replies'));
            }
        } else {
              Alert::error('Error', 'You have to login first to use the system');
              return redirect()->route('login');
        }
    }

}

