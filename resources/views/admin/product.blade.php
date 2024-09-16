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
                    <h2 class="fs-1 pb-5">Add Product</h2>

                    <div class="container">
                        <form action="{{ route('add_product') }}" method="POST" enctype="multipart/form-data" class="card p-5 col-md-6 mx-auto">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Product Title:</label>
                                <input type="text" name="title" placeholder="Write a title" class="text-light form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Product Description:</label>
                                <input type="text" name="description" placeholder="Write a description" class="text-light form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Price:</label>
                                <span>$</span><input type="text" name="price" placeholder="Write a price" class="text-light form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Discount Price:</label>
                                <span>$</span><input type="text" name="dis_price" placeholder="Apply Discount" class="text-light form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Product Quantity:</label>
                                <input type="number"  min="0" name="quantity" placeholder="Write a quantity" class="text-light form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Product Category:</label>
                                <select name="category" id="" class="text-light form-control" required>
                                    <option value="" selected>Add Category Here</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="img-fluid">Product Image Here:</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <div class="m-3">
                                <input type="submit" value="Add Product" class="btn btn-primary">
                            </div>
                        </form>
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
