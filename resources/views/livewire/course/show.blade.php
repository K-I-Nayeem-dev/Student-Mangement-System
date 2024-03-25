<?php

use Livewire\Volt\Component;
use App\Models\Course;

new class extends Component {
    public function with(): array
    {
        return [
            'courses' => Course::all(),
        ];
    }
}; ?>

<div>
    <!-- Page Sidebar Ends-->
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
                            <li class="breadcrumb-item">Courses</li>
                            <li class="breadcrumb-item active">All Course</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                @forelse ($courses as $course)
                    <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4">
                        <div class="card" style="width: 22rem;">
                            <img src="{{ asset('uploads/courses') }}/{{ $course->image }}" class="card-img-top"
                                alt="{{ $course->image }}">
                            <div class="card-body">
                                <h6 class="my-2">{{ $course->name }}</h6>
                                <h5 class="my-2">{{ $course->title }}</h6>
                                <div>
                                    <p class="p-0 m-0">Discount Fee : &#2547;{{ $course->discount_price }}</p>
                                    <p class="p-0 m-0">Regular Fee : &#2547;<del style="color: red">{{ $course->regular_price }}</del></p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    @if ($course->status != 0)
                                        <p class="px-3 py-2 rounded bg-success">Active</p>
                                    @else
                                        <p class="px-3 py-2 rounded bg-danger">Hold</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row text-center">
                        <h4>No Course Found</h4>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
