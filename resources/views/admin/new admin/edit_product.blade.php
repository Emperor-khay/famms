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

                <div class="mt-3 float-end">
                    <a href="{{ route('show_product') }}" class="btn btn-secondary"><</a>
                </div>

                <div class="text-center pt-2">
                    <h2 class="fs-1 pb-5">Edit Product</h2>

                    <div class="container ">
                        <div class="">
                            <form action="{{ route('update_product', $product->id) }}" method="POST" enctype="multipart/form-data" class="card p-5 col-md-6 mx-auto">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Product Title:</label>
                                    <input type="text" name="title" value="{{ $product->title }}" class="text-light form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Product Description:</label>
                                    <input type="text" name="description" value="{{ $product->description }}" class="text-light form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Price:</label>
                                    <span>$</span><input type="number" name="price" value="{{ $product->price }}" class="text-light form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Discount Price:</label>
                                    <span>$</span><input type="number" name="dis_price" value="{{ $product->discount_price }}" class="text-light form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Product Quantity:</label>
                                    <input type="number"  min="0" name="quantity" value="{{ $product->quantity }}" class="text-light form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Product Category:</label>
                                    <select name="category" id="" class="text-light form-control" required>
                                        <option value="{{ $product->category }}" selected>{{ $product->category }}</option>
                                        <hr>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Current Product Image:</label>
                                    <img src="{{ asset('/product/{{ $product->image }}') }}" alt="" class="img img-fluid mb-3">
                                    <label for="title" class="img-fluid">Change Product Image Here:</label><br>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="m-3">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('show_product') }}" class="btn btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
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
