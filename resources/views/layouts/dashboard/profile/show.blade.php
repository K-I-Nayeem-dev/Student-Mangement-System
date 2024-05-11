@extends('layouts.dashboard.dashboard')

@section('content')
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
            <div class="logo-wrapper"><a href="http://127.0.0.1:8000/dashboard"><img class="ms-5" width="120" height="50"
                        class="img-fluid" src="http://127.0.0.1:8000/dashboard_assests/images/logo/logo1.jpg"
                        alt=""></a>
                <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                    </i></div>
            </div>
            <div class="logo-icon-wrapper"><a href="http://127.0.0.1:8000/dashboard"><img width="50" height="50"
                        class="img-fluid" src="http://127.0.0.1:8000/dashboard_assests/images/logo/logo1.jpg"
                        alt=""></a>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"><a href="http://127.0.0.1:8000/dashboard"><img class="img-fluid"
                                    src="http://127.0.0.1:8000/dashboard_assests/images/logo/logo-icon.png"
                                    alt=""></a>
                            <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i></div>
                        </li>
                        <li class="pin-title sidebar-main-title">
                            <div>
                                <h6>Pinned</h6>
                            </div>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="lan-1">General</h6>
                            </div>
                        </li>






                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <svg class="stroke-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Users</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="http://127.0.0.1:8000/user"><i class="fa fa-user me-1"
                                            aria-hidden="true"></i>All User</a></li>
                                <li><a href="http://127.0.0.1:8000/user/create"><i class="fa fa-user-plus"
                                            aria-hidden="true"></i>
                                        Add User</a></li>
                            </ul>
                        </li>


                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <i style="color: white" class="fa fa-cogs" aria-hidden="true"></i>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Role & permission</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="http://127.0.0.1:8000/role"><i class="fa fa-gear me-1"
                                            aria-hidden="true"></i>Role</a></li>
                                <li><a href="http://127.0.0.1:8000/user"><i class="fa fa-gear me-1"
                                            aria-hidden="true"></i>Permission</a></li>
                            </ul>
                        </li>


                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <i style="color: white" class="fa fa-book" aria-hidden="true"></i>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Courses</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="http://127.0.0.1:8000/course"><i class="fa fa-plus-square me-1"
                                            aria-hidden="true"></i>Add Course</a></li>
                                <li><a href="http://127.0.0.1:8000/course/create"><i class="fa fa-address-book-o me-1"
                                            aria-hidden="true"></i>View Course</a></li>
                            </ul>
                        </li>


                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <i style="color: white" class="fa fa-cart-plus" aria-hidden="true"></i>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Purchase Course</span></a>
                            <ul class="sidebar-submenu" style="font-size: 12px">
                                <li><a href="http://127.0.0.1:8000/purchase"><i class="fa fa-users me-1"
                                            aria-hidden="true"></i>Reffer To Studnets</a></li>
                                <li><a href="http://127.0.0.1:8000/purchase"><i class="fa fa-user-circle me-1"
                                            aria-hidden="true"></i>Self Purchase Students</a></li>
                            </ul>
                        </li>


                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <i style="color: white" class="fa fa-percent" aria-hidden="true"></i>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Coupon</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="http://127.0.0.1:8000/coupon"><i class="fa fa-file-text me-1"
                                            aria-hidden="true"></i>Coupon Type</a></li>
                                <li><a href="http://127.0.0.1:8000/coupon"><i class="fa fa-bookmark me-1"
                                            aria-hidden="true"></i>Coupons</a></li>
                            </ul>
                        </li>


                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title"
                                href="#">
                                <i style="color: white" class="fa fa-link" aria-hidden="true"></i>
                                <svg class="fill-icon">
                                    <use href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#fill-home">
                                    </use>
                                </svg><span>Links</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="http://127.0.0.1:8000/links"><i class="fa fa-external-link me-1"
                                            aria-hidden="true"></i>Add Links Type</a></li>
                                <li><a href="http://127.0.0.1:8000/links"><i class="fa fa-link me-1"
                                            aria-hidden="true"></i>Users Links</a></li>
                            </ul>
                        </li>

                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </div>


        <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;FvsBGDVKDy3NA9LjOJsO&quot;,&quot;name&quot;:&quot;coupon.index&quot;,&quot;path&quot;:&quot;coupon&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;4bca958f19db111d725fbfec260541d24c6c16b48840baa531bdfa68e28fa9be&quot;}"
            wire:effects="[]" wire:id="FvsBGDVKDy3NA9LjOJsO">
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
                                    <li class="breadcrumb-item active">Kamrul Islam Nayeem</li>
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
                                            alt="cWLrc1711371298.jpg">
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="user-image">
                                        <div class="avatar">
                                            <!--[if BLOCK]><![endif]--> <img
                                                src="{{ asset('uploads/profile_pictures') . '/' . $user->profile_picture }}"
                                                alt="">
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
