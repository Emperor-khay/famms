<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function category($category_name)
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == '1') {
                Alert::error('Error', 'Unauthorized Access');
                return redirect()->back();
            } else {
                $category = Category::where('category_name', $category_name)->first();
                if (!$category) {
                    Alert::error('Error', 'Category not found');
                    return redirect()->back();
                }
                $products = Product::where('category', $category->category_name)->get();
                $comments = Comment::orderby('id', 'desc')->get();
                $reply = Reply::all();
                // dd($category, $products, $comments, $reply);
                return view('home.all_products', [
                    'products' => $products,
                    'comments' => $comments,
                    'reply' => $reply,
                    'selectedCategory' => $category
                ]);
                // return view('home.all_products', compact('products', 'comments', 'reply', 'category'));
            }
        } else {
            $category = Category::where('category_name', $category_name)->first();
            if (!$category) {
                Alert::error('Error', 'Category not found');
                return redirect()->back();
            }
            $products = Product::where('category', $category->category_name)->get();
            $comments = Comment::orderby('id', 'desc')->get();
            $reply = Reply::all();
            // dd($catego   ry, $products, $comments, $reply);
            return view('home.all_products', [
                'products' => $products,
                'comments' => $comments,
                'reply' => $reply,
                'selectedCategory' => $category
            ]);
            // return view('home.all_products', compact('products', 'comments', 'reply', 'category'));
        }
    }

}

// The problem with this code is that i needed two category variables:
// one containing all the categories in the categories tab and one containing the particular category we will be using to sort our products (hence, the category id or name being passed to betwn blade and controller)
// Using the same name for both variables was causing a mix and thereby causing these variables to return null values at some point
