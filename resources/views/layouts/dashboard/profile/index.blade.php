@extends('layouts.dashboard.dashboard')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">{{ Auth::user()->name }}</li>
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
                            <div class="cardheader"></div>
                            <div class="user-image">
                                <div class="avatar"><img alt=""
                                        src="{{ asset('dashboard_assests') }}/images/user/7.jpg"></div>
                                <div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-envelope"></i> Email</h6>
                                                    <span>Marekjecno@yahoo.com</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-calendar"></i> BOD</h6><span>02 January 1988</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                        <div class="user-designation">
                                            <div class="title"><a target="_blank" href="">Mark jecno</a></div>
                                            <div class="desc">designer</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-phone"></i> Contact Us</h6><span>India +91
                                                        123-456-7890</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-location-arrow"></i> Location</h6><span>B69 Near
                                                        Schoool Demo Home</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="social-media">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><a href="https://www.facebook.com/" target="_blank"><i
                                                    class="fa fa-facebook"></i></a></li>
                                        <li class="list-inline-item"><a href="https://accounts.google.com/"
                                                target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                        <li class="list-inline-item"><a href="https://twitter.com/" target="_blank"><i
                                                    class="fa fa-twitter"></i></a></li>
                                        <li class="list-inline-item"><a href="https://www.instagram.com/" target="_blank"><i
                                                    class="fa fa-instagram"></i></a></li>
                                        <li class="list-inline-item"><a href="https://rss.app/" target="_blank"><i
                                                    class="fa fa-rss"></i></a></li>
                                    </ul>
                                </div>
                                <div class="follow">
                                    <div class="row">
                                        <div class="col-6 text-md-end border-right">
                                            <div class="follow-num counter">25869</div><span>Follower</span>
                                        </div>
                                        <div class="col-6 text-md-start">
                                            <div class="follow-num counter">659887</div><span>Following</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- user profile first-style end-->
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    @endsection
