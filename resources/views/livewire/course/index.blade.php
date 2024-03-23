<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Isolate;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Carbon;

new class extends Component {
    use WithFileUploads;

    //define Properties
    #Validate[]
    public $title, $name, $regular_price, $discount_price, $image, $status;

    #Validate[]
    public $cTitle, $cName, $cRPrice, $cDPrice, $cImage, $cEImage = null, $cStatus;

    public $id,$courseDetail = null;

    // Course Delete message
    public function DeleteMessage()
    {
        flash()
            ->title('Delete')
            ->options(['timeout' => 1500])
            ->addError('Course Deleted');
    }

    // Course Success message
    public function successMessage($message)
    {
        flash()
            ->title('Success')
            ->options(['timeout' => 1500])
            ->addSuccess($message);
    }

    public function with(): array
    {
        return [
            'courses' => Course::latest()->paginate(6),
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|min:4',
            'name' => 'required|min:4',
            'regular_price' => 'required',
            'discount_price' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required',
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
            'status' => $this->status,
        ];

        $Image = new ImageManager(new Driver());
        $new_name = Str::random(5) . time() . '.' . $this->image->getClientOriginalExtension();
        $image = $Image->read($this->image)->resize(1280, 720);
        $image->save('uploads/courses/' . $new_name, quality: 30);

        Course::create(
            $data + [
                'image' => $new_name,
                'updated_at' => null,
            ],
        );

        $this->successMessage('Course Added Successfully');
        $this->reset();
    }

    public function courseDelete($id)
    {
        $imagePath = Course::select('image')->where('id', $id)->first();
        $filePath = public_path('uploads/courses/') . $imagePath->image;

        if (file_exists($filePath)) {
            unlink($filePath);
            Course::Where('id', $id)->delete();
            $this->DeleteMessage();
        } else {
            Course::Where('id', $id)->delete();
            $this->DeleteMessage();
        }
    }

    public function courseDetails($id)
    {
        $this->courseDetail = Course::find($id);
        // return $this->courseDetail;
        // dd($this->courseDetail->title);
    }

    public function courseEdit($id)
    {
        $course = Course::find($id);
        $this->id = $course->id;
        $this->cTitle = $course->title;
        $this->cName = $course->name;
        $this->cRPrice = $course->regular_price;
        $this->cDPrice = $course->discount_price;
        $this->cImage = $course->image;
        $this->cStatus = $course->status;
    }

    public function updateCourse($id)
    {
        $this->validate([
            'cTitle' => 'required|min:4',
            'cName' => 'required|min:4',
            'cRPrice' => 'required',
            'cDPrice' => 'required',
            'cStatus' => 'required',
        ]);

        $data = [
            'title' => $this->cTitle,
            'name' => $this->cName,
            'regular_price' => $this->cRPrice,
            'discount_price' => $this->cDPrice,
            'status' => $this->cStatus,
            'updated_at' => Carbon::now()
        ];

        
        $imagePath = Course::select('image')->where('id', $id)->first();
        $filePath = public_path('uploads/courses/') . $imagePath->image;

        if($this->cEImage != null){
            if(file_exists($filePath)){

                unlink($filePath);

                $Image = new ImageManager(new Driver());
                $new_name = Str::random(5) . time() . '.' . $this->cEImage->getClientOriginalExtension();
                $image = $Image->read($this->cEImage)->resize(1280, 720);
                $image->save('uploads/courses/' . $new_name, quality: 30);

                Course::find($id)->update($data + ['image' => $new_name]);
                $this->successMessage('Course Update Successfully');

            }
            else{
                Course::find($id)->update($data); 
                $this->successMessage('Course Update Successfully');
            }
        }
        else{
            Course::find($id)->update($data); 
            $this->successMessage('Course Update Successfully');
        }
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

                                <div class="my-2">
                                    <label for="status">Select Status</label>
                                    <select id="status" class="form-select" wire:model.live='status'>
                                        <option value="">Status</option>
                                        <option class="badge rounded-pill badge-danger" value="0">Hold
                                        </option>
                                        <option class="badge rounded-pill badge-success" value="1">
                                            Active</option>
                                    </select>
                                </div>

                                {{-- <label class="form-label mb-2" for="image">Course Image</label>
                                <input id="image"  class="form-control mb-2" wire:model='image' type="file" placeholder="Enter Course Image" />
                                <img src="" width="200" height="150" alt="Preview Uploaded Image" id="blah" /> --}}

                                {{-- <x-input.input label='Course Image' fiwe='image' type='file' placeholder='Course Image Upload'/>
                                <img src="" width="200" height="150" alt="Preview Uploaded Image" id="blah" /> --}}


                                <label wire:loading.remove wire:target='image' for="file-upload">Upload Image</label>
                                <input wire:loading.remove wire:model='image' class="form-control mb-2" type="file"
                                    id="file-upload" {{-- accept="image/*" onchange="previewImage(event);"  --}} />
                                <div wire:loading wire:target='image'>
                                    <label class="form-label">
                                        <h4>Uploading Image...</h4>
                                    </label>
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
                                        <th scope="col">Details</th>
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
                                            <td style="font-size: 16px">
                                                @if ($course->status == 0)
                                                    <p class="badge roPunded-pill badge-danger">Hold</button>
                                                    @else
                                                    <p class="badge rounded-pill badge-success">Active</button>
                                                @endif
                                            </td>
                                            <td class="fs-5 text-center">
                                                <!-- Button for Details  -->
                                                <button wire:click="courseDetails({{ $course->id }})" type="button"
                                                    class="btn btn-outline-success btn-pill btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i style="font-size: 15px" class="fa fa-book"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                {{-- Delete Course --}}
                                                <i wire:click="courseDelete({{ $course->id }})"
                                                    style="font-size: 16px; cursor: pointer; margin-right: 5px; color: red"
                                                    class="fa fa-trash"aria-hidden="true"></i>

                                                {{-- Edit Course --}}
                                                <i data-bs-toggle="modal" data-bs-target="#editModal"
                                                    wire:click="courseEdit({{ $course->id }})"
                                                    style="font-size: 16px; cursor: pointer; color: #00AC46"
                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="">No Invitaion Sent To User</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $courses->links('pagination::bootstrap-4') }}
                            {{-- {{ $courseDetail->name }} --}}
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Course</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit='updateCourse({{ $id }})'
                                        enctype="multipart/form-data">
                                        <div class="my-2">
                                            <label class="form-label" for="cTitle">Title</label>
                                            <input id="cTitle" class="form-control" wire:model='cTitle'
                                                type="text" value="{{ $cTitle }}">
                                            @error('cTitle')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label class="form-label" for="cName">Name</label>
                                            <input id="cName" class="form-control" wire:model='cName'
                                                type="text" value="{{ $cName }}">
                                            @error('cName')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label class="form-label" for="cRPrice">Regular Price</label>
                                            <input id="cRPrice" class="form-control" wire:model='cRPrice'
                                                type="text" value="{{ $cRPrice }}">
                                            @error('cRPrice')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label class="form-label" for="cDPrice">Discount Price</label>
                                            <input id="cDPrice" class="form-control" wire:model='cDPrice'
                                                type="text" value="{{ $cDPrice }}">
                                            @error('cDPrice')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label class="form-label" for="cImage">Image</label>
                                            <br>
                                            <img class="rounded text-center" width="400" height="200"
                                                src="{{ asset('uploads/courses') }}/{{ $cImage }}"
                                                alt="{{ $cImage }}">
                                        </div>
                                        <div class="my-2">
                                            <label class="form-label" for="cImage">Title</label>
                                            <select class="form-select" wire:model='cStatus' id="cStatus">
                                                <option value="">Select Status</option>
                                                <option class="bg-danger" value="0"
                                                    {{ $cStatus == 0 ? 'selected' : '' }}>Hold</option>
                                                <option class="bg-success" value="1"
                                                    {{ $cStatus == 1 ? 'selected' : '' }}>Active</option>
                                            </select>
                                            @error('cStatus')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <p class="d-inline-flex gap-1 my-2">
                                            <a class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse"
                                                href="#collapseExample" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">Update Photo (Optional)</a>
                                        </p>
                                        <div class="collapse" id="collapseExample">
                                            <input wire:loading.remove class="form-control" type="file"
                                                wire:model='cEImage'>
                                            <div wire:loading wire:target='cEImage'>
                                                <h4>Uploading Image...</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <p class="btn btn-outline-danger btn-sm btn-pill me-2" data-bs-dismiss="modal" >Close</p>
                                            <button type="submit" class="btn btn-outline-primary btn-sm btn-pill" >Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Modal -->
                    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Details Course</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                @if ($courseDetail != null)
                                    <div class="modal-body d-flex justify-content-center">
                                        <div class="card" style="width: 25rem;">
                                            <img src="{{ asset('uploads') }}/courses/{{ $courseDetail->image }}"
                                                class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $courseDetail->name }}</h5>
                                                <p class="card-text">{{ $courseDetail->title }}</p>
                                                <div class="d-flex ">
                                                    <p class="me-3 ">Discounted Fee :
                                                        &#2547;{{ $courseDetail->discount_price }}</p>
                                                    <p class="text-danger">Regular Fee :
                                                        &#2547;<del>{{ $courseDetail->regular_price }}</del></p>
                                                </div>
                                            </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('dashboard_assests') }}/js/custom.js"></script>
@endpush
