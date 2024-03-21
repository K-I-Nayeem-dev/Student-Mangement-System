<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Isolate;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Course;


new class extends Component {
    use WithFileUploads;

    //define Properties
    #Validate[]
    public $title, $name, $regular_price, $discount_price, $image, $status;

    public function with(): array{
        return [
            'courses' => Course::all(),
        ];
    }

    // public function rules()
    // {
    //     return [
    //         'title' => 'required|min:4',
    //         'name' => 'required|min:4',
    //         'regular_price' => 'required',
    //         'discount_price' => 'required',
    //         'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
    //     ];
    // }

    // public function addCourse()
    // {
    //     $this->validate();

    //     $data = [
    //         'title' => $this->title,
    //         'name' => $this->name,
    //         'regular_price' => $this->regular_price,
    //         'discount_price' => $this->discount_price,
    //     ];

    //     $Image = new ImageManager(new Driver());
    //     $new_name = Str::random(5).time().".". $this->image->getClientOriginalExtension();
    //     $image = $Image->read($this->image)->resize(1280,720);
    //     $image->save(('uploads/courses/'.$new_name),quality: 30);

    //     // Course::create($data + [
    //     //     'image' => $new_name,
    //     //     'updated_at' => null,
    //     // ]);
        
    //     $this->reset();

    //     flash()->options(['timeout'=>1500,])->title('Add Item')->addSuccess('Course Added Successfully');
        
    // }

    // public function courseDelete($id)
    // {
    //     Course::find($id)->delete();
    //     flash()
    //         ->title('Delete')
    //         ->options(['timeout' => 1500])
    //         ->addError('Course Deleted');
    // }

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
                <div class="col-lg-4">
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


                                <label wire:loading.remove for="file-upload">Upload Image</label>
                                <input wire:loading.remove wire:model.lazy='image' class="form-control mb-2" type="file" id="file-upload"
                                    {{-- accept="image/*" onchange="previewImage(event);"  --}} />
                                <div wire:loading='image'> 
                                    <label class="form-label"><h4>Uploading Image...</h4></label>
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
                <div class="col-lg-8 p-0 m-0">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Courses</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Regualr Price</th>
                                        <th scope="col">Discount Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses as $course)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->regular_price }}</td>
                                            <td>{{ $course->discount_price }}</td>
                                            <td>
                                                {{-- @if ($course->status == 0)
                                                    <p class="badge rounded-pill badge-danger">Hold</button>
                                                @else
                                                    <p class="badge rounded-pill badge-success">Active</button>
                                                @endif --}}
                                                <select wire:model.live='status'>
                                                    <option value="">Select Status</option>
                                                    <option class="badge rounded-pill badge-danger" value="0" >Hold</option>
                                                    <option class="badge rounded-pill badge-success" value="1">Active</option>
                                                </select>
                                                {{ $status }}
                                            </td>
                                            <td>{{ $course->created_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                <button type="submit" wire:click="courseDelete({{ $course->id }})"
                                                    class="btn btn-sm btn-pill btn-danger">
                                                    <i style="font-size: 12px" class="fa fa-trash"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="">No Invitaion Sent To User</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
