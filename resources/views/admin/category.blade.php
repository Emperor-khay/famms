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

                    <div class="text-center pt-2">
                        <h2 class="fs-1 pb-5">Add Category</h2>
                        <form action="{{ url('/add_category') }}" method="POST" class="">
                            @csrf
                            <input type="text" name="category" placeholder="Write category name" class="text-dark" value="{{ old('name') }}" required autofocus>
                            <input type="submit" value="Add Category" class="btn btn-primary" name="submit">
                        </form>
                    </div>

                    <div class="mt-5">
                        <table class="border border-success mx-auto w-100 w-md-50 text-center table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data) && $data->isNotEmpty())
                                    @foreach ($data as $data)

                                    <tr>
                                        <td>{{ $data->category_name }}</td>
                                        <td>
                                            <a href="{{ route('edit_category', $data->id) }}" class="btn btn-primary mr-2">Edit</a>
                                            <a href="{{ route('delete_category', $data->id) }}" class="btn btn-danger mr-2" onclick="return confirm('Are You Sure You Want To Delete This Category')">Delete</a>
                                            {{-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Delete
                                            </button> --}}
                                        </td>
                                    </tr>
                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Category</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <h1>Are You Sure You Want To Delete This</h1>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <a href="{{ url('/delete_category', $data->id) }}" class="btn btn-danger">Delete</a>

                                                </div>
                                            </div>
                                            </div>
                                        </div> --}}

                                    @endforeach
                                @else
                                        <tr>
                                            <td colspan="2">
                                                 <p class="text-danger">No items available.</p>
                                            </td>
                                        </tr>
                                @endif
                            </tbody>
                        </table>
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
