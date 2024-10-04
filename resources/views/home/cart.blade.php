@extends('home.layouts.app')

@section('title')
    Famms - Cart
@endsection

@section('content')
    <div class="hero_area">
        @include('home.header')

        {{-- @include('message') --}}
        @include('sweetalert::alert')

        <div class="container mt-5 ">
            <table class="table text-center border table-responsive-md table-striped">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Product Quantity</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                {{-- initialize total price in cart --}}
                <?php
                $total = 0
                ?>
                @forelse ($cart as $cart)
                    <tr>
                        <td style="max-height:100px" class="align-middle"><a href="{{ route('product_details', $cart->product_id) }}" class="text-danger">{{ $cart->product_title }}</a></td>
                        <td style="max-height:100px" class="align-middle">{{ $cart->quantity }}</td>
                        <td style="max-height:100px" class="align-middle">${{ $cart->price }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">
                            <img src="{{ asset('product/' . $cart->image) }}" alt="" class="img-fluid">
                        </td>
                        <td class="align-middle" style="max-height:100px">
                            <div class="d-flex justify-content-center">
                                {{-- <a href="{{ route('edit_cart', $cart->id) }}" class="mx-1 btn btn-primary">Change Quantity</a> --}}

                                <form action="{{ route('edit_cart', $cart->id) }}" method="GET">
                                    @csrf
                                    <input type="submit" value="Change Quantity" class="mx-1 btn btn-primary d-none d-lg-block">
                                    <button type="submit" class="mx-1 btn btn-primary d-lg-none">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </form>

                                <form action="{{ route('remove_cart', $cart->id) }}" onsubmit="confirmation(event)" method="POST" data-product-title="{{ $cart->product_title }}">
                                    @csrf
                                    <input type="submit" value="Remove" class="mx-1 btn btn-danger d-none d-lg-block">
                                    <button type="submit" class="mx-1 btn btn-danger d-lg-none">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    {{-- calculate total price in cart --}}
                    <?php
                    $total = $total + $cart->price
                    ?>
                @empty
                    <tr>
                        <td colspan="6">No Items In Cart</td>
                    </tr>
                @endforelse
            </tbody>
            </table>

            <div class="mt-5 text-center">
            @if ($total == 0)
            <h2 class="text-danger">Price In Cart: ${{ $total }}</h2>
            <p>Check out our products. I'm sure you will find something you like</p>
            @else
            <h2 class="text-success">Price In Cart: ${{ $total }}</h2>
            @endif
            </div>
        </div>

        @if ($total >0 )
            <div class="mt-5 text-center">
                <h1>Proceed To Order</h1>
                <a href="{{ route('cash_order') }}" class="btn btn-danger">Cash On Delivery</a>
                {{-- <a href="{{ route('stripe', $total) }}" class="btn btn-danger">Pay Using Card</a> --}}
            </div>
        @endif
    </div>

        @include('home.footer')

    <div class="cpy_">
        <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            {{-- Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a> --}}

        </p>
    </div>
    <script>
        function confirmation(ev) {
            ev.preventDefault(); // Prevent the default form submission

            var form = ev.target; // Get the form element
            var productTitle = form.getAttribute('data-product-title'); // Get the product title from data attribute

            swal({
                title: `Are you sure you want to remove ${productTitle} from cart?`,
                text: "You will not be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willCancel) => {
                if (willCancel) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
@endsection
