@extends('layouts.dashboard.dashboard')

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="http://127.0.0.1:8000">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#stroke-home">
                                                </use>
                                            </svg></a></li>
                                    <li class="breadcrumb-item">Users</li>
                                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="user-profile">
                        <div class="row">
                            <!-- user profile first-style start-->
                            <div class="col-sm-12">
                                <div class="card hovercard text-center">
                                    <div style="position: relative;">
                                        <!--[if BLOCK]><![endif]--> <img width="100%"
                                            src="{{ asset('uploads/cover_photos') . '/' . $user->cover_photo }}"
                                            alt="{{ $user->cover_photo }}">
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="user-image">
                                        <div class="avatar">
                                            <!--[if BLOCK]><![endif]--> <img
                                                src="{{ asset('uploads/profile_pictures') . '/' . $user->profile_picture }}"
                                                alt="{{ $user->profile_picture }}">
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    <div class="info">
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="ttl-info text-start">
                                                            <h6><i class="fa fa-envelope"></i> Email</h6>
                                                            <span>{{ $user->email }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                                <div class="user-designation">
                                                    <div class="title"><a target="_blank" href="">{{ $user->name }}</a></div>
                                                    <!--[if BLOCK]><![endif]-->
                                                    <div class="desc">
                                                        @if ($user->role == 'admin')
                                                            Admin
                                                        @elseif($user->role == 2)
                                                            Moderator
                                                        @elseif($user->role == 3)
                                                            User
                                                        @endif
                                                    </div>
                                                    <!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="ttl-info text-start">
                                                            <h6><i class="fa fa-phone"></i> Contact</h6>
                                                            <span>{{ $user->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <!-- user profile first-style end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
