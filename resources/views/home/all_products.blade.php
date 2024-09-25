@extends('home.layouts.app')

@section('title')
    Famms - All Products
@endsection

@section('content')
    <div class="hero_area">

            @include('home.header')

            <!-- product section -->
            <section class="product_section layout_padding">
                <div class="container">
                <div class="heading_container heading_center">
                    {{-- @include('message') --}}
                    @include('sweetalert::alert')

                    <div class="mt-3">
                        <h2>Product Categories</h2>
                        {{-- <ul class="nav nav-pills">
                            @foreach ($categories as $category)
                            <li class="m-1 nav-item">
                                <a class="nav-link text-danger @if (request()->segment(2) == $category->category_name) active text-light bg-danger  @endif" aria-current="page" href="{{ route('category', $category->category_name) }}">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                            @endforeach
                        </ul> --}}

                        <ul class="nav nav-tabs">
                            @foreach ($categories as $category)
                                <li class="m-1 nav-item">
                                    <a class="nav-link text-danger  @if (request()->segment(2) == $category->category_name)  active text-light bg-danger  @endif" aria-current="page" href="{{ route('category', $category->category_name) }}">
                                        {{ $category->category_name }}
                                    </a>
                                </li>
                                @endforeach
                                <li class="m-1 nav-item">
                                    <a class="nav-link  @if (Route::is('products')) active text-light bg-danger @endif" aria-current="page" href="{{ route('products') }}">
                                        All
                                    </a>
                                </li>
                        </ul>
                    </div>
                    <hr>

                    <div class="mt-3">
                    <form action="{{ route('product_search') }}" method="GET">
                        @csrf
                            <input type="text" name="search" id="" placeholder="search">
                            <input type="submit" value="Search">
                        </form>
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="box">
                            <div class="option_container">
                                <div class="options">
                                    <a href="{{ route('product_details',$product->id) }}" class="option1">
                                        Product Details
                                    </a>
                                    {{-- <a href="" class="option2">
                                        Add To Cart
                                    </a> --}}
                                    <form action="{{ route('add_cart',$product->id) }}" class="p-2 mt-2 row" method="POST">
                                        @csrf
                                        <div class="col-md-4">
                                            <input type="number" name="quantity" id="" value="1" min="1">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" value="Add To Cart" class="option2">
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="img-box">
                                <img src="product/{{ $product->image }}" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    {{ $product->title }}
                                </h5>
                                &nbsp;
                                @if($product->discount_price!=null)
                                    <h6 class="text-primary">
                                        ${{ $product->discount_price }}
                                    </h6>
                                    &nbsp;
                                    <h6 style="text-decoration: line-through" class="text-danger">
                                        ${{ $product->price }}
                                    </h6>
                                @else

                                <h6 class="text-primary">
                                    ${{ $product->price }}
                                </h6>
                                @endif


                            </div>
                        </div>
                        </div>
                    @endforeach

                    {{-- <span class="pt-4"> --}}
                        {{-- {!! $products->withQueryString()->links('pagination::bootstrap-5') !!} --}}
                        {{-- OR --}}
                        {{-- {{ $products->withQueryString()->links('pagination::bootstrap-5') }} --}}
                        {{-- {{ $products->appends(request()->all())->links() }} --}}
                    {{-- </span> --}}

                </div>
                </div>
            </section>
            <!-- end product section -->

        </div>

        @include('home.comment')

        @include('home.footer')

    <div class="cpy_">
        <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>

    <script>
        function reply(caller) {
            document.getElementById('commentId').value=$(caller).attr('data-Commentid');
            $('#reply').insertAfter($(caller).closest('div'));
            $('#reply').removeClass('d-none');
        }

        function reply_close(caller) {
            $('#reply').addClass('d-none');
        }

        // document.addEventListener("DOMContentLoaded", function(event) {
        //     var scrollpos = localStorage.getItem('scrollpos');
        //     if (scrollpos) window.scrollTo(0, scrollpos);
        // });

        // window.onbeforeunload = function(e) {
        //     localStorage.setItem('scrollpos', window.scrollY);
        // }
    </script>
@endsection
