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

                <div class="text-center pt-2 mt-5">
                    <h2 class="fs-1 pb-md-5 p-0 mb-3">Send Email to {{ $order->email }}</h2>
                    <d class="d-flex justify-content-center">
                        <div class="row col-md-8 col-sm-11">
                            <form action="{{ route('send_user_email', $order->id) }}"  method="POST" class="w-100 text-light">
                                <div class="mb-3">
                                    <label for="greeting" >Email Greeting:</label>
                                    <input type="text" name="greeting" class="form-control text-light" required>
                                </div>
                                <div class="mb-3">
                                    <label for="firstline">Email Firstline:</label>
                                    <input type="text" name="firstline" class="form-control text-light" required>
                                </div>
                                <div class="mb-3">
                                    <label for="body">Email Body:</label>
                                    <input type="text" name="body" class="form-control text-light" required>
                                </div>
                                <div class="mb-3">
                                    <label for="button_name">Email Button Name:</label>
                                    <input type="text" name="button_name" class="form-control text-light" required>
                                </div>
                                <div class="mb-3">
                                    <label for="url" class="form-label">Email URL:</label>
                                    <input type="text" name="url" class="form-control text-light" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lastline" class="form-label">Email Lastline:</label>
                                    <input type="text" name="lastline" class="form-control text-light" required>
                                </div>
                                <div class="pt-3">
                                    <input type="submit" value="Send Mail" class=" text-light btn btn-primary" required>
                                </div>

                            </form>
                        </div>
                    </d>
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
