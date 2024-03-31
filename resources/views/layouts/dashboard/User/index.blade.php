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
                                    <h5 class="mb-1"><a href="#">{{ $user->name }}</a></h5><span
                                        class="f-light">{{ $user->email }}</span>
                                    <ul class="card-social">
                                        {{-- @if ($user->id && $link)

                                        @else

                                        @endif --}}
                                        @foreach ($links as $link)
                                            <li><a href="{{ $link->url }}" target="_blank"><i style="font-size: 20px;" class="fa fa-{{ $link->relToType->icon }}"></i></a></li>
                                        @endforeach
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
