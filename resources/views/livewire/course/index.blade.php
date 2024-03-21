<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
// use Livewire\Attributes\Isolate;

new class extends Component {
    use WithFileUploads;

    //define Properties
    #Validate[]
    public $title, $name, $regular_price, $discount_price, $image;

    public function rules()
    {
        return [
            'title' => 'required|min:4',
            'name' => 'required|min:4',
            'regular_price' => 'required',
            'discount_price' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    public function addCourse()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'name' => $this->name,
            'regular_price' => $this->regular_price,
            'discount_price' => $this->discount_price,
            'image' => $this->image,
        ];

        dd($data);
    }
}; ?>

<div>
    <style>
        img {
            max-width: 250px;
            border-radius: 5px;
        }
    </style>
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home">
                                        </use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">Courses</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Course</h4>
                        </div>
                        <div class="card-body">

                            <form wire:submit='addCourse' enctype="multipart/form-data">

                                <x-input.input label='Title' fiwe='title' type='text'
                                    placeholder='Course Title' />
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <x-input.input label='Name' fiwe='name' type='text' placeholder='Course Name' />
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <x-input.input label='Regular Price' fiwe='regular_price' type='number'
                                    placeholder='Course Regular Price' />
                                @error('regular_price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <x-input.input label='Discount Price' fiwe='discount_price' type='number'
                                    placeholder='Course Discount Price' />
                                @error('discount_price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                {{-- <label class="form-label mb-2" for="image">Course Image</label>
                                <input id="image"  class="form-control mb-2" wire:model='image' type="file" placeholder="Enter Course Image" />
                                <img src="" width="200" height="150" alt="Preview Uploaded Image" id="blah" /> --}}

                                {{-- <x-input.input label='Course Image' fiwe='image' type='file' placeholder='Course Image Upload'/>
                                <img src="" width="200" height="150" alt="Preview Uploaded Image" id="blah" /> --}}


                                <label for="file-upload">Upload Image</label>
                                <input wire:model.lazy='image' class="form-control mb-2" type="file" id="file-upload" accept="image/*" onchange="previewImage(event);" />
                                
                                <div class="preview">
                                    <img alt="Preview Uplaod Image" id="preview-selected-image" />
                                </div>
                                {{-- <div >
                                    <label for="file-upload">Upload Image</label>
                                    <input wire:model='image' class="form-control mb-2" type='file' onchange="readURL(this);" />
                                    <img id="blah" alt="Preview Course Image" />
                                </div> --}}

                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <x-button.button submit='submit' buttonName='Add' />

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    @push('scripts')
        <script src="{{ asset('dashboard_assests') }}/js/custom.js"></script>
    @endpush
