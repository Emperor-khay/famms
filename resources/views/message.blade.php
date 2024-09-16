{{-- success message --}}
@if(session('message'))
    <div class="alert alert-danger text-center my-3">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success text-center my-3">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    </div>
@endif

{{-- error message --}}
@if ($errors->any())
    <div class="alert alert-danger text-center my-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
