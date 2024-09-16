@extends('home.layouts.app')

@section('title')
    Famms - Profile Information
@endsection

@section('content')
<style>
    .profile-link{
        color: black;
    }
    .mb-3:hover .profile-link {
        color: red; /* Change this to the desired hover color */
    }
    .mb-3:hover .bi {
        padding-left: 10px; /* Adjust padding as needed */
        color: red; /* Change this to the desired hover color */
    }
</style>
    @include('sweetalert::alert')

    <div class="hero_area">
        @include('home.header')

        <div class="heading_container heading_center py-2">
            <h2>Profile Settings</h2>
        </div>

        <div class="card w-75 mx-auto p-3 m-3">
            <div class="mb-3 card-header p-2">
                <a href="{{ route('edit_profile', Auth::user()->id) }}" class=" profile-link" >
                    <div>
                        <h3>
                            Manage Profile Information
                            <i class="bi bi-arrow-right ml-1"></i>
                        </h3>
                    </div>
                </a>
            </div>
            <div class="mb-3 card-header p-2">
                <a href="{{ route('edit_profile', Auth::user()->id) }}" class=" profile-link" >
                    <div>
                        <h3>
                            Manage Passwords
                            <i class="bi bi-arrow-right ml-1"></i>
                        </h3>
                    </div>
                </a>
            </div>
            <div class="mb-3 card-header p-2">
                <a href="{{ route('edit_profile', Auth::user()->id) }}" class=" profile-link" >
                    <div>
                        <h3>
                            Two Factor Authentication
                            <i class="bi bi-arrow-right ml-1"></i>
                        </h3>
                    </div>
                </a>
            </div>
            <div class="mb-3 card-header p-2">
                <a href="{{ route('edit_profile', Auth::user()->id) }}" class=" profile-link" >
                    <div>
                        <h3>
                            Active Sessions
                            <i class="bi bi-arrow-right ml-1"></i>
                        </h3>
                    </div>
                </a>
            </div>
            <div class="mb-3 card-header p-2">
                <a href="{{ route('edit_profile', Auth::user()->id) }}" class=" profile-link" >
                    <div>
                        <h3>
                            Manage Account
                            <i class="bi bi-arrow-right ml-1"></i>
                        </h3>
                    </div>
                </a>
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
