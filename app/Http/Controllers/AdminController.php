<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Notifications\EmailNotification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function view_category()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
             } else {
                $data = Category::all();
                if ($data->isEmpty()) {
                    return view('admin.category')->with('message', 'No items available.');
                }
                return view('admin.category', compact('data'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function add_category(Request $request)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $request->validate([
                    'category' => 'required|unique:categories,category_name',
                ], [
                    'category.unique' => 'Category already exists.',
                ]);
                $data=new Category;
                $data->category_name = $request->category;
                $data->save();
                 return redirect()->back()->with('success', 'Category Added Successfully!');
            }
        } else {
            return redirect()->route('login');
        }

    }

    public function delete_category($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $data = Category::find($id);
                if ($data)
                {
                    $data->delete();
                }
                return redirect()->back()->with('success', 'Category has been deleted successfully!');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function edit_category($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $data = Category::find($id);
                return view('admin.editcategory', compact('data'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function update_category(Request $request, $id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $data= Category::find($id);
                $data->category_name = $request->category;
                $data->save();
                return redirect()->route('view_category')->with('success', 'Category Updated Successfully!');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function product_form()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $category = Category::all();
                return view('admin.product', compact('category'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function add_product(Request $request)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $validator = Validator::make($request->all(), [
                    'price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                    'discount_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                 // Check if the category exists
                 $categoryExists = Category::where('category_name', $request->category)->exists();

                 if (!$categoryExists) {
                     return redirect()->back()->with('error', 'Category does not exist.');
                 }
                $product = new Product();
                $product->title = $request->title;
                // $description = Str::limit($request->description, 255);
                // $product->description = $request->description;
                $product->description = Str::limit($request->description, 255);
                $product->price = $request->price;
                $product->discount_price = $request->dis_price;
                $product->quantity = $request->quantity;
                $product->category = $request->category;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imagename = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('product'), $imagename);
                    $product->image = $imagename;
                }
                // $image  = $request->image;
                // $imagename=time().'.'.$image->getClientOriginalExtension();
                // $image->move('product', $imagename);
                // $product->image = $imagename;
                $product->save();

                return redirect()->route('show_product')->with('success', 'Product Added Successfully');
                // return view('admin.product');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function show_product()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $product = Product::all();
                return view('admin.show_product', compact('product'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function edit_product($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $category = Category::all();
                $product = Product::find($id);
                return view('admin.edit_product', compact('product', 'category'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function update_product(Request $request, $id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $product = Product::find($id);
                $product->title = $request->title;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->discount_price = $request->dis_price;
                $product->category = $request->category;
                $product->quantity = $request->quantity;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imagename = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('product'), $imagename);
                    $product->image = $imagename;
                }
                $product->save();
                return redirect()->route('show_product')->with('success', 'Product has been updated Successfully');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function delete_product($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $product = Product::find($id);

                if ($product)
                {
                    $product->delete();
                    // $data->delete();
                }
                return redirect()->back()->with('success', 'Product Deleted Successfully');
                // return redirect()->back()->with('message', 'Category has been deleted successfully!');

            }
        } else {
            return redirect()->route('login');
        }
    }

    public function order()
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $user = Auth::user();
                $order = Order::where('delivery_status', '!=', 'canceled')->get();
                return view('admin.order', compact('order'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function delivered($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                $order->delivery_status = "delivered";
                $order->payment_status = "paid";
                $order->save();
                return redirect()->back();
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function viewPDF($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $data = [
                    'title' => 'Invoice',
                    'date' => Carbon::now()->format('F j, Y, g:i a'), // Current date and time
                    // 'date' => Carbon::now()->format('F j, Y'), // Current date in 'Month Day, Year' format
                ];
                $order = Order::find($id);
                // $product = Product::find($order->product_id);
                $product = Product::where('id', '=', $order->product_id)->first();
                return view('admin.test', compact('data', 'order', 'product'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function send_email($id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                return view('admin.email', compact('order'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function send_user_email(Request $request, $id)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $order = Order::find($id);
                $details = [
                    'greeting' => $request->greeting,
                    'firstline' => $request->firstline,
                    'body' => $request->body,
                    'button' => $request->button,
                    'url' => $request->url,
                    'lastline' => $request->lastline,
                ];

                // Notification::sendNow($order, new EmailNotification($details));
                // Notification::route('mail', $order->email)->notify(new EmailNotification($details));
                $order->notify(new EmailNotification($details));

                return redirect()->back()->with('success', 'Email Notification Sent');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function search_order(Request $request)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $search = $request->search;
                $order = Order::where('name', 'LIKE', "%$search%")->orwhere('phone', 'LIKE', "%$search%")->orwhere('product_title', 'LIKE', "%$search%")->get();
                return view('admin.order', compact('order'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function search_product(Request $request)
    {
        if(Auth::check()) {
            $usertype = Auth::user()->usertype;
            if($usertype == '0') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $search = $request->search;
                $product = Product::where('title', 'LIKE', "%$search%")->orwhere('category', 'LIKE', "%$search%")->get();
                return view('admin.show_product', compact('product'));
            }
        } else {
            return redirect()->route('login');
        }
    }
}

