<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="home/images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />

   </head>
   <body>
    {{-- @include('message') --}}
    @include('sweetalert::alert')

    <div class="mt-5 hero_area">
        <div class="container text-center">
            <h1>404</h1>
            <h2>Page Not Found</h2>
            <p>Sorry, the page you are looking for could not be found.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
        </div>
     </div>

     {{-- <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

           Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
     </div> --}}


      <script>
        function reply(caller) {
            document.getElementById('commentId').value=$(caller).attr('data-Commentid');
            $('#reply').insertAfter($(caller).closest('div'));
            $('#reply').removeClass('d-none');
        }

        function reply_close(caller) {
            $('#reply').addClass('d-none');
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        }
    </script>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>

   </body>
</html>
