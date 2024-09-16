@extends('home.layouts.app')

@section('title')
    Famms - Profile Information
@endsection

@section('content')

@include('home.header')

<div class="hero_area">
    <div class="container ">
        <div class="heading_container heading_center py-2">
            <h2>Profile Information</h2>
        </div>
        <div class="m-3">
            <form action="{{ route('update_profile', $user->id) }}" method="POST"  class="card p-3 col-md-6 mx-auto">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Name:</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="text-dark form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" name="email" value="{{ $user->email }}" class="text-dark form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number:</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="text-dark form-control" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address" value="{{ $user->address }}" class="text-dark form-control" required>
                </div>
                <input type="submit" value="Save Changes" class="p-2 rounded">
           </form>
        </div>
    </div>
</div>

@include('home.footer')
<div class="cpy_">
    <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://nwokikekelechi-portfolio.000webhostapp.com/" target="_blank">Dev Khay</a><br>

       Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

    </p>
</div>

@endsection
