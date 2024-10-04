@extends('home.layouts.app')

@section('meta')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        #card-element{
            height: 50px;
            padding-top: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="hero_area">


        @include('home.header')

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card mt-5">
                        <h3 class="card-header p-3 text-center">Enter Your Card Deteils</h3>
                        <div class="card-body">

                            {{-- @include('message') --}}
                            @include('sweetalert::alert')

                            <form id='checkout-form'  method='post' action="{{ route('stripe_post', $total) }}">
                                @csrf

                                <strong>Name On Card:</strong>
                                <input type="input" class="form-control form-input" name="name" placeholder="Enter Name">

                                <input type='hidden' class="form-input form-control" name='stripeToken' id='stripe-token-id'>
                                <br>
                                <div id="card-element" class="form-control " ></div>
                                <input   id='pay-btn'
                                class="btn w-25 mt-3 d-block text-center"
                                type="submit"
                                style="margin-top: 20px; width: 100%;padding: 7px;"
                                onclick="createToken()"
                                value="PAY ${{ $total }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('home.footer')

    <div class="cpy_">
        <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

        {{-- Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a> --}}

        </p>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">

        var stripe = Stripe('{{ env('STRIPE_KEY') }}')
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        /*------------------------------------------
        --------------------------------------------
        Create Token Code
        --------------------------------------------
        --------------------------------------------*/
        function createToken() {
            document.getElementById("pay-btn").disabled = true;
            stripe.createToken(cardElement).then(function(result) {

                if(typeof result.error != 'undefined') {
                    document.getElementById("pay-btn").disabled = false;
                    alert(result.error.message);
                }

                /* creating token success */
                if(typeof result.token != 'undefined') {
                    document.getElementById("stripe-token-id").value = result.token.id;
                    document.getElementById('checkout-form').submit();
                }
            });
        }
    </script>
@endsection
