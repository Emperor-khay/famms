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
                    <h2 class="fs-1 pb-5"> Products</h2>

                    <div>
                        <form action="{{ route('search_product') }}">
                        @csrf
                            <input type="text" name="search" id="" placeholder="Search" class="text-dark">
                            <input type="submit" value="Search" class="btn btn-primary">
                        </form>
                    </div>

                    <div class="container ">
                        <div class="">
                            <div class="table table-striped table-responsive ">
                                <table class=" text-light mx-auto">
                                    <thead>
                                        <tr>
                                            <th>Product Title</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Discount Price</th>
                                            <th>Product Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($product as $item)
                                            <tr>
                                                <td class="text-truncate " style="max-width: 150px;">{{ $item->title }}</td>
                                                <td class="text-truncate d-inline-block" style="max-width: 150px;">{{ $item->description }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ $item->price }}</td>
                                                <td>${{ $item->discount_price }}</td>
                                                <td>
                                                    <img src="{{ asset('/product/{{ $item->image }}') }}" alt="" class="img-fluid">
                                                </td>
                                                <td>
                                                    <a href="{{ route('edit_product',$item->id) }}" class="btn btn-primary mx-1">Edit</a>
                                                    <a href="{{ route('delete_product',$item->id) }}" class="btn btn-danger mx-1" onclick="return confirm('Are you Sure?')">Delete</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9"><p class="text-danger">No Products Available</p></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('product_form') }}" class="btn btn-primary p-2">Add Products</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
      <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')
</body>
</html>
