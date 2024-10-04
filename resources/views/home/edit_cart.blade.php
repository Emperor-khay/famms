@extends('home.layouts.app')

@section('title')
    Famms - Edit Cart
@endsection

@section('content')
    <div class="hero_area">

        @include('home.header')

        {{-- @include('message') --}}
        @include('sweetalert::alert')

        <div class="container mt-4">
            <form action="{{ route('update_cart', $cart->id) }}" method="POST">
            @csrf
                <div class="mb-3">
                    <label for="product_title" class="form-label">Product Title</label>
                    <input type="text" value="{{ $cart->product_title }}" class="form-control" name="product_title" disabled>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" min="1" value="{{ $cart->quantity }}" class="form-control" name="quantity">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price Per Single Quantity ($)</label>
                    <input type="text" value="{{ $product->price }}" class="form-control" disabled name="price">
                </div>
                <div class="mb-3">
                    <label for="dis_price" class="form-label">Discount Price ($)</label>
                    <input type="text" value="{{ $product->discount_price }}" class="form-control" disabled name="dis_price">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Product Image</label><br>
                    <img src="{{ asset('product/' . $cart->image) }}" alt="" class="img-fluid img form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Update Cart" class="btn btn-danger">
                </div>

            </form>
        </div>
    </div>

        @include('home.footer')

    <div class="cpy_">
        <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            {{-- Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a> --}}

        </p>
    </div>
@endsection
