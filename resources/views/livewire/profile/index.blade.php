<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

new class extends Component {
    use WithFileUploads;
    #Validate[]
    public $image;

    #Validate[]
    public $cover;

    public function with(): array{
        return [
            'users' => User::Select('role')->get(),
            'links' => Link::Where('user_id', auth()->id())->get(),
        ];
    }

    /**
     * Updates the user's profile picture. Validates the image upload, generates a random filename,
     * resizes the image, saves it to the uploads folder, updates the database with the new filename,
     * and shows a success message. Handles replacing an existing profile picture if one exists.
     */
    public function updateProfile($id)
    {
        $this->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $data = [
            'image' => $this->image,
        ];

        if (Auth::user()->profile_picture == null) {
            $Image = new ImageManager(new Driver());
            $new_name = Str::random(5) . time() . '.' . $this->image->getClientOriginalExtension();
            $image = $Image->read($this->image)->resize(1280, 720);
            $image->save('uploads/profile_pictures/' . $new_name, quality: 30);

            User::find($id)->update([
                'profile_picture' => $new_name,
            ]);

            flash()
                ->title('Profile Picture')
                ->options(['timeouts' => 1500])
                ->addSuccess('Image Upload Successfully');
            $this->reset();
        } else {
            $imagePath = User::select('profile_picture')->where('id', $id)->first();
            $filePath = public_path('uploads/profile_pictures/') . $imagePath->profile_picture;

            if (file_exists($filePath)) {
                unlink($filePath);
                $Image = new ImageManager(new Driver());
                $new_name = Str::random(5) . time() . '.' . $this->image->getClientOriginalExtension();
                $image = $Image->read($this->image)->resize(1280, 720);
                $image->save('uploads/profile_pictures/' . $new_name, quality: 30);

                User::find($id)->update([
                    'profile_picture' => $new_name,
                ]);
                flash()
                    ->title('Profile Picture')
                    ->options(['timeouts' => 1500])
                    ->addSuccess('Image Update Successfully');
                $this->reset();
            }
        }
    }

    /**
     * Updates the user's cover photo.
     * Validates the cover image.
     * If no existing cover photo, uploads new image.
     * If existing cover photo, deletes old image and uploads new image.
     * Updates database with new cover photo name.
     * Shows success flash message.
     */
    public function coverPhoto($id)
    {
        $this->validate([
            'cover' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $data = [
            'cover' => $this->cover,
        ];

        if (Auth::user()->cover_photo == null) {

            $Image = new ImageManager(new Driver());
            $new_name = Str::random(5) . time() . '.' . $this->cover->getClientOriginalExtension();
            $image = $Image->read($this->cover)->resize(1002, 290);
            $image->save('uploads/cover_photos/' . $new_name, quality: 30);

            User::find($id)->update([
                'cover_photo' => $new_name,
            ]);

            flash()
                ->title('Cover Photo')
                ->options(['timeouts' => 1500])
                ->addSuccess('Image Upload Successfully');

            $this->reset();

        } else {

            $imagePath = User::select('cover_photo')->where('id', $id)->first();
            $filePath = public_path('uploads/cover_photos/') . $imagePath->cover_photo;

            if (file_exists($filePath)) {
                
                unlink($filePath);

                $Image = new ImageManager(new Driver());
                $new_name = Str::random(5) . time() . '.' . $this->cover->getClientOriginalExtension();
                $image = $Image->read($this->cover)->resize(1280, 300);
                $image->save('uploads/cover_photos/' . $new_name, quality: 30);

                User::find($id)->update([
                    'cover_photo' => $new_name,
                ]);

                flash()
                    ->title('Cover Photo')
                    ->options(['timeouts' => 1500])
                    ->addSuccess('Image Update Successfully');

                $this->reset();
            }
        }
    }
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

                                <button
                                    style="position: absolute; bottom: 0;left: 100px; transform: translate(-50%, -50%); z-index: 1;"
                                    id="coverPhoto" wire:click="coverPhoto({{ auth()->id() }})" data-bs-toggle="modal"
                                    data-bs-target="#cover" class="coverPhoto btn btn-outline-secondary btn-sm">
                                    <span class="me-1">Change Cover</span>
                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                </button>
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
                                <div class="icon-wrapper">
                                    <abbr style="cursor: pointer;" title="Uplaod Profile Picture">
                                        <i data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            class="icofont icofont-pencil-alt-5"></i>
                                    </abbr>
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
                                <div class="social-media">
                                    <ul class="list-inline">
                                        @forelse ($links as $link)
                                            <li class="list-inline-item"><a href="{{ $link->url }}" target="_blank"><i class="fa fa-{{ $link->relToType->icon }}"></i></a></li>
                                        @empty
                                            <li>No Link Added</li>
                                        @endforelse
                                    </ul>
                                </div>
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
        <!-- Profile Picture Upload Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Picture Uplaod</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit='updateProfile({{ auth()->id() }})' enctype="multipart/form-data">
                            {{-- <div class="my-2 d-flex justify-content-center">
                                    <img src="{{ asset('uploads/profile_pictures') }}/{{ Auth::user()->profile_picture }}" style="border-radius: 50%" class="rounded-r-full" src="" alt="{{ Auth::user()->profile_picture }}" width="200" height="200"> 
                            </div> --}}
                            <div class="my-2">
                                <div class="my-2">
                                    <label>Select Picture</label>
                                    <input wire:loading.remove type="file" class="form-control"
                                        wire:model='image'>
                                </div>
                                <div wire:loading wire:target='image'>
                                    <h4>Uploading Image...</h4>
                                </div>
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <p type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Close</p>
                                <button type="submit" class="btn btn-primary">Update </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cover Picture Uplaod Modal --}}
        <div wire:ignore.self class="modal fade" id="cover" tabindex="-1" aria-labelledby="cover"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cover">Cover Photo Upload</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit='coverPhoto({{ auth()->id() }})' enctype="multipart/form-data">
                            <div class="my-2">
                                <div class="my-2">
                                    <label>Select Picture</label>
                                    <input wire:model='cover' wire:loading.remove type="file" class="form-control">
                                </div>
                                <div wire:loading wire:target='cover'>
                                    <h4>Uploading Image...</h4>
                                </div>
                                @error('cover')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <p type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Close</p>
                                <button type="submit" class="btn btn-primary">Update </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container-fluid Ends-->
    </div>
</div>
