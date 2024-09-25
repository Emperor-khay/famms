<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileInformationControllerProxy;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

// jetstream made
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// our dashboard route
Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard')->middleware('auth', 'verified');
Route::get('/',[HomeController::class,'index'])->name('index')->middleware('guest');
Route::post('/add_cart/{id}',[HomeController::class,'add_cart'])->name('add_cart');
Route::get('/show_cart',[HomeController::class,'show_cart'])->name('show_cart');
Route::post('/remove_cart/{id}',[HomeController::class,'remove_cart'])->name('remove_cart');
Route::get('/edit_cart/{id}',[HomeController::class,'edit_cart'])->name('edit_cart');
Route::post('/update_cart/{id}',[HomeController::class,'update_cart'])->name('update_cart');
Route::get('/cash_order',[HomeController::class,'cash_order'])->name('cash_order');
Route::get('/stripe/{total}',[StripePaymentController::class,'stripe'])->name('stripe');
Route::post('/stripe_post/{total}',[StripePaymentController::class,'stripe_post'])->name('stripe_post');
Route::get('/show_order', [HomeController::class, 'show_order'])->name('show_order');
Route::post('/cancel_order/{id}', [HomeController::class, 'cancel_order'])->name('cancel_order');
Route::post('/restore_order/{id}', [HomeController::class, 'restore_order'])->name('restore_order');
Route::post('/delete_order/{id}', [HomeController::class, 'delete_order'])->name('delete_order');
Route::post('/comment', [HomeController::class, 'comment'])->name('comment');
Route::post('/reply', [HomeController::class, 'reply'])->name('reply');
Route::post('/comment/{id}', [HomeController::class, 'delete_comment'])->name('delete_comment');
Route::post('/reply/{id}', [HomeController::class, 'delete_reply'])->name('delete_reply');
Route::get('/product_details/{id}',[HomeController::class,'product_details'])->name('product_details');
Route::get('/product_search', [HomeController::class, 'product_search'])->name('product_search');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/category/{category_name}', [HomeController::class, 'category'])->name('category');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');

Route::get('/view_category',[AdminController::class,'view_category'])->name('view_category');
Route::post('/add_category',[AdminController::class,'add_category'])->name('add_category');
Route::get('/delete_category/{id}',[AdminController::class,'delete_category'])->name('delete_category');
Route::get('/edit_category/{id}',[AdminController::class,'edit_category'])->name('edit_category');
Route::post('/update_category/{id}',[AdminController::class,'update_category'])->name('update_category');
Route::get('/product_form',[AdminController::class,'product_form'])->name('product_form');
Route::post('/add_product',[AdminController::class,'add_product'])->name('add_product');
Route::get('/show_product',[AdminController::class,'show_product'])->name('show_product');
Route::get('/delete_product/{id}',[AdminController::class,'delete_product'])->name('delete_product');
Route::get('/edit_product/{id}',[AdminController::class,'edit_product'])->name('edit_product');
Route::post('/update_product/{id}',[AdminController::class,'update_product'])->name('update_product');
Route::get('/order',[AdminController::class,'order'])->name('order');
Route::get('/delivered/{id}',[AdminController::class,'delivered'])->name('delivered');
// Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('generate_pdf');
Route::get('/view-pdf/{id}', [AdminController::class, 'viewPDF'])->name('view_pdf');
Route::get('/send_email/{id}', [AdminController::class, 'send_email'])->name('send_email');
Route::post('/send_user_email/{id}', [AdminController::class, 'send_user_email'])->name('send_user_email');
Route::get('/search_order', [AdminController::class, 'search_order'])->name('search_order');
Route::get('/search_product', [AdminController::class, 'search_product'])->name('search_product');


Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth', 'verified');
Route::get('/edit_profile/{id}', [ProfileController::class, 'edit_profile'])->name('edit_profile')->middleware('auth', 'verified');
// Route::post('/update_profile/{id}', [ProfileController::class, 'update_profile'])->name('update_profile')->middleware('auth', 'verified');
Route::post('/update_profile/{id}', [ProfileInformationControllerProxy::class, 'updateProfile'])->name('update_profile')->middleware('auth', 'verified');

// Route::get('/category/{category_name}', [CategoryController::class, 'category'])->name('category');

// Auth::routes([
    //     'verify' => true
// ]);

Route::get('/trigger-500', function () {
    throw new Exception('This is a deliberate exception to trigger a 500 error.');
});

Route::get('send-mail', [EmailController::class, 'sendWelcomeEmail']);

require_once __DIR__ . '/routes.php';
