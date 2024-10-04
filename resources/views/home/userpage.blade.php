@extends('home.layouts.app')

@section('title')
    Famms - Fashion HTML Template
@endsection

@section('content')
    {{-- @include('message') --}}
    @include('sweetalert::alert')

    <div class="hero_area">

        @include('home.header')

        @include('home.slider')

     </div>

        @include('home.why')

        @include('home.arrival')

        @include('home.product')

        @include('home.comment')

        @include('home.subscribe')

        @include('home.client')

        @include('home.footer')

      <div class="cpy_">
         <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://emperor-khay.github.io/Dev-Khay-Portfolio/" target="_blank">Dev Khay</a><br>

            {{-- Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a> --}}

         </p>
      </div>

      <script>
        function reply(caller) {
            document.getElementById('commentId').value=$(caller).attr('data-Commentid');
            document.getElementById('parentId').value = null; // Reset parentId for top-level replies
            $('#reply').insertAfter($(caller).closest('div'));
            $('#reply').removeClass('d-none');
        }

        function reply_to_reply(caller, parentId) {
        document.getElementById('commentId').value = $(caller).attr('data-Commentid');
        document.getElementById('parentId').value = parentId;
        $('#reply').insertAfter($(caller).closest('.mb-3 .ml-5')); // Adjust selector as per your structure
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


        function confirmAction(ev, title, text, callback) {
              ev.preventDefault();

              swal({
                  title: title,
                  text: text,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                  confirmButtonText: 'Yes, do it!',
              }).then((willConfirm) => {
                  if (willConfirm) {
                      callback();
                  }
              });
          }

          function confirmLink(ev, title, text) {
              confirmAction(ev, title, text, function() {
                  window.location.href = ev.currentTarget.href;
              });
          }

        function confirmForm(ev, title, text) {
              confirmAction(ev, title, text, function() {
                  ev.target.submit();
                  setTimeout(function() {
                    location.reload(true);
                }, 500); // Adjust the delay as needed
              });
          }

          //   function confirmForm(ev, title, text) {
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


    </script>
@endsection
