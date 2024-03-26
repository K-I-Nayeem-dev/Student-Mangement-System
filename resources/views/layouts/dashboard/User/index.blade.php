@extends('layouts.dashboard.dashboard')
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">All User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                @foreach ($users as $user)
                <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4">
                        <div class="card social-profile">
                            <div class="card-body">
                                <div class="social-img-wrap">
                                    <div class="social-img">
                                        @if (!Auth::user()->profile_picture)
                                            <img alt="" src="{{ asset('dashboard_assests') }}/images/avtar/default_profile.jpg">
                                        @else
                                            <img width="80px" src="{{ asset('uploads/profile_pictures') }}/{{ $user->profile_picture }}"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="edit-icon">
                                        <svg>
                                            <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#profile-check">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="social-details">
                                    <h5 class="mb-1"><a href="social-app.html">{{ $user->name }}</a></h5><span
                                        class="f-light">{{ $user->email }}</span>
                                    <ul class="card-social">
                                        <li><a href="https://www.facebook.com/" target="_blank"><i
                                                    class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://accounts.google.com/" target="_blank"><i
                                                    class="fa fa-google-plus"></i></a></li>
                                        <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/" target="_blank"><i
                                                    class="fa fa-instagram"></i></a></li>
                                        <li><a href="https://rss.app/" target="_blank"><i class="fa fa-rss"></i></a></li>
                                    </ul>
                                    <ul class="social-follow">
                                        <li>
                                            <h5 class="mb-0">1,908</h5><span class="f-light">Posts</span>
                                        </li>
                                        <li>
                                            <h5 class="mb-0">34.0k</h5><span class="f-light">Followers</span>
                                        </li>
                                        <li>
                                            <h5 class="mb-0">897</h5><span class="f-light">Following</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
        <!-- Container-fluid Ends-->
    @endsection
