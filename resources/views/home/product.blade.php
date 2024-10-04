      <!-- product section -->
      <section class="product_section layout_padding" id="products">
        <div class="container">
           <div class="heading_container heading_center">
              <h2>
                 Our <span>products</span>
              </h2>
              <div class="my-3">
                {{-- <form action="{{ route('product_search') }}" method="GET">
                    <input type="text" name="search" id="" placeholder="search">
                    <input type="submit" value="Search">
                </form> --}}

                {{-- @include('message') --}}
                @include('sweetalert::alert')

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
                            <form action="{{ route('add_cart',$product->id) }}" class="row mt-2 p-2" method="POST">
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
                        <img src="{{ asset('product/' . $product->image) }}" alt="">
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

        </div>
           <div class="btn-box">
              <a href="{{ route('products') }}">
              View All products
              </a>
           </div>
        </div>
     </section>
     <!-- end product section -->
