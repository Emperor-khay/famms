@extends('home.layouts.app')

@section('title')
    Famms - {{ $product->title }}
@endsection

@section('content')
    <div class="hero_area">
        @include('home.header')

        {{-- @include('message') --}}
        @include('sweetalert::alert')


        <div class="p-2 mx-auto col-sm-6 col-md-4 col-lg-4">
            <div class="box">
                <div class="img-box">
                    <img src="/product/{{ $product->image }}" alt="" class="img img-fluid">
                </div>
                <div class="detail-box">
                    <h5 class="mt-2">
                        {{ $product->title }}
                    </h5>
                    &nbsp;
                    @if($product->discount_price!=null)
                    <h6 class="text-primary">
                        Discount Price: <br>
                        ${{ $product->discount_price }}
                    </h6>
                    &nbsp;
                    <h6 style="text-decoration: line-through" class="text-danger">
                        Price: <br>
                        ${{ $product->price }}
                    </h6>

                    @else

                    <h6 class="text-primary">
                        Price: <br>
                        ${{ $product->price }}
                    </h6>
                    @endif

                    <h6>Product Category: {{ $product->category }}</h6>
                    <h6>Product Details: {{ $product->description }}</h6>

                    @if($product->quantity == '0')
                        <h6 class="text-danger">OUT OF STOCK!</h6>
                    @else
                        <h6>Available Quantity: {{ $product->quantity }}</h6>

                        <div>
                            <form action="{{ route('add_cart',$product->id) }}" class="p-2 mt-2 row" method="POST">
                                @csrf
                                <div class="col-md-4">
                                    <input type="number" name="quantity" id="" value="1" min="1">
                                </div>
                                <div class="col-md-4">
                                    <input type="submit" value="Add To Cart" class="option2">
                                    </div>

                            </form>

                            {{-- <a href="" class="btn btn-danger">Add to cart</a> --}}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @include('home.footer')

    <div class="cpy_">
        <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>
@endsection
