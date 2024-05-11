<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home">
                                        </use>
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
                            <div style="position: relative;">
                                @if (Auth::user()->cover_photo != null)
                                    <img width="100%" src="{{ asset('uploads/cover_photos') }}/{{ Auth::user()->cover_photo }}"
                                        alt="{{ Auth::user()->cover_photo }}">
                                @else
                                    <img width="100%"
                                        src="{{ asset('dashboard_assests') }}/images/banner/default-cover.jpg"
                                        alt="cover Photo">
                                @endif
                            </div>
                            <div class="user-image">
                                <div class="avatar">
                                    @if (!Auth::user()->profile_picture)
                                        <img
                                            alt=""src="{{ asset('dashboard_assests') }}/images/avtar/default_profile.jpg">
                                    @else
                                        <img src="{{ asset('uploads/profile_pictures') }}/{{ Auth::user()->profile_picture }}"
                                            alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-envelope"></i> Email</h6>
                                                    <span>{{ auth()->user()->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                        <div class="user-designation">
                                            <div class="title"><a target="_blank"
                                                    href="">{{ auth()->user()->name }}</a></div>
                                            @if (auth()->user()->role == 'admin')
                                                <div class="desc">Admin</div>
                                            @else
                                                {{-- <div class="desc">{{ Auth::user()->relToRole->type }}</div> --}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6><i class="fa fa-phone"></i> Contact</h6><span>{{ Auth::user()->phone_number ? Auth::user()->phone_number : '01xxxxxxxxxx' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                {{-- <div class="social-media">
                                    <ul class="list-inline">
                                        @forelse ($links as $link)
                                            <li class="list-inline-item"><a href="{{ $link->url }}" target="_blank"><i class="fa fa-{{ $link->relToType->icon }}"></i></a></li>
                                        @empty
                                            <li>No Link Added</li>
                                        @endforelse
                                    </ul>
                                </div> --}}
                                @if (Auth::user()->role == 'admin')
                                    <div class="follow">
                                        <div class="row">
                                            <div class="col-6 text-md-end border-right">
                                                <div class="follow-num counter">User Count</div><span>Users</span>
                                            </div>
                                            <div class="col-6 text-md-start">
                                                <div class="follow-num counter">Moderator Count</div><span>Moderator</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- user profile first-style end-->
                </div>
            </div>
        </div>
    </div>
</div>
