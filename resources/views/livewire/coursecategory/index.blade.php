<?php

use Livewire\Volt\Component;
use App\Models\CourseCategory;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

new class extends Component {

    use WithFileUploads;

    #Validate[]
    public $name, $icon, $status;

    public function addCategory(){
        
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
        $image = $Image->read($this->icon)->resize(32, 32);
        $image->save('uploads/course_category/' . $new_name, quality: 32);

        CourseCategory::create(
            $data + [
                'icon' => $new_name,
                'updated_at' => null,
            ]);

        flash()
                ->title('Course')
                ->options(['timeouts' => 1500])
                ->addSuccess('Category Added Successfully');
        
        $this->reset();

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
                                    <input wire:model='name' type="text" class="form-control"/>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> 

                                <div class="my-2">
                                    <label class="form-label">Icon</label>
                                    <input wire:model='icon' type="file" class="form-control"/>
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
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
