@extends('home.layouts.app')

@section('title')
    Famms - Order
@endsection

@section('content')
    <div class="hero_area">

        @include('home.header')

        <div class="container mt-5">

            {{-- @include('message') --}}
            @include('sweetalert::alert')

            <table class="table text-center border table-responsive-md table-striped">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Product Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Image</th>
                        <th>Manage Order</th>
                        {{-- @if($order->delivery_status=='processing')
                            <a href="{{ route('cancel_order', $order->id) }}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Cancel This Order')">Cancel</a>
                        @elseif($order->delivery_status == 'canceled')
                            <th>Delete</th>
                            <a href="{{ route('restore_order', $order->id) }}" class="btn btn-success" onclick="return confirm('Are You Sure You Want To Go Ahead With This Order?')">Restore</a>
                        @else
                            <p></p>
                        @endif --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order as $order)
                    <tr>
                        <td style="" class="align-middle">0000{{ $order->id }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->product_title }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->quantity }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->price }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->created_at->toDayDateTimeString() }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->payment_status }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">{{ $order->delivery_status }}</td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">
                            <img src="{{ asset('product/' . $order->image) }}" alt="" class="img-fluid img">
                        </td>
                        <td style="max-width: 100px; max-height:100px" class="align-middle">

                            {{-- when you are able to solve the  confirmation messages for canceling, deleting and restoring orders, implemet disabled cancel buttons for orders that are already paid for --}}
                            @if($order->payment_status=='cash on delivery' && $order->delivery_status == 'processing')
                                @php
                                    $restored_at = $order->restored_at;
                                    $timestamp = Carbon\Carbon::parse($restored_at)->diffInHours(Carbon\Carbon::now());
                                    // dd($timestamp);
                                @endphp
                                @if ($timestamp !== null && $timestamp < 24)

                                    {{-- <a href="{{ route('cancel_order', $order->id) }}" class="btn btn-danger" onclick="confirmLink(event, 'Are you sure you want to cancel this order?', 'You will not be able to revert this after 24hrs!')" data-product-title="{{ $order->product_title }}">Cancel</a> --}}
                                    <form action="{{ route('cancel_order', $order->id) }}" onsubmit="confirmForm(event, 'Are you sure you want to cancel this order?', 'You will not be able to revert this after 24hrs!')" method="POST">
                                        @csrf
                                        <input type="submit" value="Cancel" class="p-3 btn">
                                    </form>
                                @elseif($timestamp !== null && $timestamp >= 24)
                                    {{-- <a href="{{ route('cancel_order', $order->id) }}" class="btn btn-danger" onclick="confirmLink(event, 'Are you sure you want to cancel this order?', 'You will not be able to revert this after 24hrs!')" data-product-title="{{ $order->product_title }}">Cancel</a> --}}
                                    <form action="{{ route('cancel_order', $order->id) }}" onsubmit="confirmForm(event, 'Are you sure you want to cancel this order?', 'You will not be able to revert this after 24hrs!')" method="POST">
                                        @csrf
                                        <input type="submit" value="Cancel" class="p-3 btn" disabled>
                                    </form>
                                @endif

                                @elseif($order->delivery_status == 'canceled' && $order->payment_status=='cash on delivery')
                                {{-- <a href="{{ route('restore_order', $order->id) }}" class="btn btn-success" onclick="confirmLink(event, 'Are you sure you want to restore this order?', 'This action can not be undone after 24hrs!')" data-product-title="{{ $order->product_title }}">Restore</a> --}}
                                <form action="{{ route('restore_order', $order->id) }}" onsubmit="confirmForm(event, 'Are you sure you want to restore this order?', 'This action can not be undone after 24hrs!')"  method="POST">
                                    @csrf
                                    <input type="submit" value="Restore" class="p-3 btn">
                                </form>

                                @else
                                <p></p>
                            @endif

                            @if($order->delivery_status == 'canceled')
                                <form action="{{ route('delete_order', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mt-3 btn btn-danger" onsubmit="confirmForm(event, 'Are you sure you want to delete this order?', 'This action cannot be undone. You will not be able to restore this order or access this order history!')" data-product-title="{{ $order->product_title }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    {{-- <input type="submit" value="X"  onsubmit="confirmForm(event, 'Are you sure you want to delete this order?', 'This action cannot be undone. You will not be able to restore this order or access this order history!')" data-product-title="{{ $order->product_title }}"> --}}
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
     </div>

        @include('home.footer')

        <div class="cpy_">
         <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            {{-- Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a> --}}

         </p>
      </div>
      <!-- jQery -->
      {{-- <script src="/home/js/jquery-3.4.1.min.js"></script> --}}
      <!-- popper js -->
      {{-- <script src="/home/js/popper.min.js"></script> --}}
      <!-- bootstrap js -->
      {{-- <script src="/home/js/bootstrap.js"></script> --}}
      <!-- custom js -->
      {{-- <script src="/home/js/custom.js"></script> --}}

      {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

      <script>
    //       function confirmAction(ev, title, text, callback) {
    //           ev.preventDefault();

    //           swal({
    //               title: title,
    //               text: text,
    //               icon: "warning",
    //               buttons: true,
    //               dangerMode: true,
    //               confirmButtonText: 'Yes, do it!',
    //           }).then((willConfirm) => {
    //               if (willConfirm) {
    //                   callback();
    //                 }
    //           });
    //       }

    //       function confirmLink(ev, title, text) {
    //           confirmAction(ev, title, text, function() {
    //               window.location.href = ev.currentTarget.href;
    //             });
    //       }

    //       function confirmForm(ev, title, text) {
    //     confirmAction(ev, title, text, function() {
    //         // Prevent default form submission
    //         ev.preventDefault();

    //         // Create a new FormData object from the form
    //         const formData = new FormData(ev.target);

    //         // Ensure the method is POST
    //         const method = ev.target.method.toUpperCase();
    //         if (method !== 'POST') {
    //             throw new Error('Form method must be POST.');
    //         }

    //         // Use fetch to submit the form data
    //         fetch(ev.target.action, {
    //             method: 'POST',
    //             body: formData,
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //             }
    //         })
    //         .then(response => {
    //             if (response.ok) {
    //                 // Reload the page after successful form submission
    //                 // swal("Success", "The action was completed successfully.", "success")
    //                 .then(() => {
    //                     location.reload(true);
    //                 });
    //             } else {
    //                 return response.text().then(text => { throw new Error(text) });
    //             }
    //         })
    //         .catch(error => {
    //             swal("Error", "There was an error processing your request: " + error.message, "error");
    //         });
    //     });
    // }

    // function confirmForm(ev, title, text) {
        //       confirmAction(ev, title, text, function() {
            //           ev.target.submit();
            //           setTimeout(function() {
                //             location.reload(true);
                //         }, 500); // Adjust the delay as needed
                //       });
        //   }
      </script>

@endsection
