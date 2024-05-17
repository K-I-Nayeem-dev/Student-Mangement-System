<?php

use Livewire\Volt\Component;
use App\Models\CourseCategory;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;

new class extends Component {
    use WithFileUploads;

    #Validate[]
    public $name, $icon, $status;

    public $id
    , $cateName, $cateIcon, $cateStatus;

    public function with(): array
    {
        return [
            'categories' => CourseCategory::latest()->paginate(10),
        ];
    }

    public function addCategory()
    {
        $this->validate([
            'name' => 'required|min:3',
            'icon' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required',
        ]);

        $data = [
            'name' => $this->name,
            'status' => $this->status,
        ];

        $Image = new ImageManager(new Driver());
        $new_name = Str::random(5) . time() . '.' . $this->icon->getClientOriginalExtension();
        $image = $Image->read($this->icon)->resize(52, 52);
        $image->save('uploads/course_category/' . $new_name, quality: 52);

        CourseCategory::create(
            $data + [
                'icon' => $new_name,
                'updated_at' => null,
            ],
        );

        flash()
            ->title('Course')
            ->options(['timeouts' => 1500])
            ->addSuccess('Category Added Successfully');

        $this->reset();

    }

    public function cateEdit($id)
    {
        $course = CourseCategory::find($id);
        $this->id = $course->id;
        $this->cateName = $course->name;
        $this->cateIcon = $course->icon;
        $this->cateStatus = $course->status;
    }

    public function cateDel($id)
    {
        sweetalert()
            ->showDenyButton()
            ->info('Are you sure you want to delete the Category' . $id);
    }

    #[On('sweetalert:confirmed')]
    public function onConfirmed(array $payload): void
    {
        flash()->info('User successfully deleted.');
    }

    #[On('sweetalert:denied')]
    public function onDeny(array $payload): void
    {
        flash()->info('Deletion cancelled.');
    }

    public function cateUpdate($id){

        $this->validate([
            'cateName' => 'required|min:3',
            'cateIcon' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
            'cateStatus' => 'required',
        ]);

        $data = 
        [
            'name' => $this->cateName,
            'icon' => $this->cateIcon,
            'status' => $this->cateStatus,
            'updated_at' => Carbon::now(),
        ];

        $imagePath = CourseCategory::select('icon')->where('id', $id)->first();
        $filePath = public_path('uploads/course_category/') . $imagePath->image;

        if ($this->cateIcon != null) {

            if (file_exists($filePath)) {

                unlink($filePath);

                $Image = new ImageManager(new Driver());
                $new_name = Str::random(5) . time() . '.' . $this->cateIcon->getClientOriginalExtension();
                $image = $Image->read($this->cateIcon)->resize(52, 52);
                $image->save('uploads/course_category/' . $new_name, quality: 52);

                CourseCategory::find($id)->update($data + ['icon' => $new_name]);
                $this->successMessage('Course Update Successfully');

            } else {

                CourseCategory::find($id)->update($data);
                $this->successMessage('Course Update Successfully');

            }

            } else {

                CourseCategory::find($id)->update($data);
                $this->successMessage('Course Update Successfully');

        }

        flash()
            ->title('Update')
            ->options(['timeouts' => 1500])
            ->addSuccess('Category Update Successfully');

    }

}; 

?>

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
                                        <use
                                            href="http://127.0.0.1:8000/dashboard_assests/svg/icon-sprite.svg#stroke-home">
                                        </use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">Course Category</li>
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
                            <h4>Add Course Category</h4>
                        </div>
                        <div class="card-body">
                            <form wire:submit='addCategory' enctype="multipart/form-data">

                                <div class="my-2">
                                    <label class="form-label">Name</label>
                                    <input wire:model='name' type="text" class="form-control" />
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="my-2">
                                    <label class="form-label">Icon</label>
                                    <input wire:model='icon' type="file" class="form-control" />
                                    @error('icon')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>

                                <div class="my-2">
                                    <label class="form-label">Status</label>
                                    <select wire:model='status' class="form-select">
                                        <option value=''>Select Status</option>
                                        <option value='1' class="bg-success">Active</option>
                                        <option value='0' class="bg-danger">Deactive</option>
                                    </select>

                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>

                                <button class="btn btn-success mt-2" type="submit">Add</button>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 p-0 m-0">
                    <div class="card">
                        <div class="card-header">
                            <h4>Course Category Lists</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>

                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <img draggable="false" class="rounded"
                                                src="{{ asset('uploads/course_category') }}/{{ $category->icon }}"
                                                alt="{{ $category->icon }}">
                                        </td>
                                        <td class="text-center">
                                            @if ($category->status == 1)
                                                <p style="font-size: 12px" class="py-1 px-1 rounded bg-success">Active
                                                </p>
                                            @else
                                                <p style="font-size: 12px" class="py-1 px-1 rounded bg-danger">Deactive
                                                </p>
                                            @endif
                                        </td>
                                        <td class="text-center">

                                            <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                wire:click='cateEdit({{ $category->id }})'
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </button>

                                            <button wire:click='cateDel({{ $category->id }})' class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Data Found</td>
                                    </tr>
                                @endforelse

                            </table>

                            <div class="mt-3">
                                {{ $categories->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Category Edit</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit='cateUpdate({{ $id }})' enctype="multipart/form-data">

                                <div class="mt-4">
                                    <label class="mb-2">Name</label>
                                    <input class="form-control" wire:model='cateName' type="text">
                                    @error('cateName')
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="my-4 d-flex justify-content-around align-items-center">

                                    <div>
                                        <label class="mb-2">Icon</label>
                                        <input class="form-control" wire:model='cateIcon' type="file">
                                        @error('cateIcon')
                                            <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <img width="60" height="60" class="rounded" src="{{ asset('uploads/course_category') }}/{{ $cateIcon }}" alt="{{ $cateIcon }}">
                                    </div>

                                </div>

                                <div class="mt-4">
                                    <label class="mb-2">Status</label>
                                    <select class="form-select" wire:model='cateStatus'>
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $cateStatus == 1 ? 'selected' : '' }}
                                            class="bg-success">Active</option>
                                        <option value="0" {{ $cateStatus == 0 ? 'selected' : '' }}
                                            class="bg-danger">Deactive</option>
                                    </select>
                                    @error('cateStatus')
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror

                                </div>

                        </div>

                        <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>

                            </form>
                        
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
