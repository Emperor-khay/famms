<!DOCTYPE html>
<html lang="en">
   <head>
        @include('admin.meta')
    </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')
        <!-- partial -->

        <div class="main-panel">
            <div class="content-wrapper">

                @include('message')

                <div class="text-center pt-2">
                    <h2 class="fs-1 pb-md-5 p-0">All Orders</h2>
                </div>

                <div>
                    <form action="{{ route('search_order') }}">
                    @csrf
                        <input type="text" name="search" id="" placeholder="Search" class="text-dark">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>
                <div class="mt-md-5" style="overflow-x: auto">
                    <table class="border border-success mx-auto w-md-50 text-center table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Product Title</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Payment Status</th>
                                <th>Delivery Status</th>
                                <th>Product Image</th>
                                <th>Action</th>
                                <th>Reciept</th>
                                <th>Send Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (isset($order) && $order->isNotEmpty()) --}}
                                @forelse ($order as $order)

                                    <tr>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->product_title }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->price }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>{{ $order->delivery_status }}</td>
                                        <td>
                                            <img src="/product/{{ $order->image }}" alt="" class="img img-fluid">
                                        </td>
                                        <td>
                                            @if ($order->delivery_status == 'processing')
                                                <a href="{{ route('delivered', $order->id) }}" class="btn btn-success" onclick="return confirm('Please Confirm That Product Is Delivered Before Proceeding. Are you sure Order has been delivered?')">Delivered</a>
                                            @else
                                            Delivered
                                            @endif
                                        </td>
                                        <td>
                                                {{-- <a href="{{ route('generate_pdf', $order->id) }}" class="btn btn-success">Print</a> --}}
                                                <a href="{{ route('view_pdf', $order->id) }}" class="btn btn-info">View</a>
                                        </td>
                                        <td>
                                                <a href="{{ route('send_email', $order->id) }}" class="btn btn-info">Send Email</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="16"><p class="text-danger">No Data Found</p></td>
                                    </tr>
                                @endforelse
                            {{-- @else
                                    <tr>
                                        <td colspan="11">
                                             <p class="text-danger">No Orders Available.</p>
                                        </td>
                                    </tr>
                            @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')
</body>
</html>
