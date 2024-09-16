@extends('home.layouts.app')

@section('title')
    Famms - All Products
@endsection

@section('content')
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
        @endforeacah

        <span class="pt-4">
            {{-- {!! $products->withQueryString()->links('pagination::bootstrap-5') !!} --}}
            {{-- OR --}}
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            {{-- {{ $products->appends(request()->all())->links() }} --}}
        </span>

    </div>
 @endsection
