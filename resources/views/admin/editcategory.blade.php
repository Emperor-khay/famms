<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.meta')
  </head>
  <body>
    <div class="container-scroller">

        @include('admin.sidebar')


      <div class="container-fluid page-body-wrapper">

            @include('admin.header')

            <div class="main-panel">
                <div class="content-wrapper">

                    @include('message')

                    <div class="float-end">
                        <a href="{{ route('view_category') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <div class="text-center pt-2">
                        <h2 class="fs-1 pb-5">Edit Category</h2>
                        <form action="{{ route('update_category', $data->id) }}" method="POST" class="">
                            @csrf
                            <label for="category">Category:</label><br>
                                <input type="text" name="category" value="{{ $data->category_name }}" class="text-dark" value="{{ old('name') }}" required><br>
                            <div class="mt-3">
                                <input type="submit" value="Update Category" class="btn btn-primary" name="submit">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('admin.script')
  </body>
</html>
