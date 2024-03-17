@extends('layouts.dashboard.dashboard')
@section('content') 
       <!-- Page Sidebar Ends-->
       <div class="page-body">
        <div class="container">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">
                                    <svg class="stroke-icon">
                                        <use
                                            href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home">
                                        </use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Container-fluid starts-->
        
        <!-- Container-fluid Ends-->
    </div>
@endsection