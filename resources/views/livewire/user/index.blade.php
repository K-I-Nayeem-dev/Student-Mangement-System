<?php

use Livewire\Volt\Component;
use App\Models\Link;
use App\Models\User;
use App\Mail\AdminResetPassword;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $users, $links, $id , $status = 0;

    #Validate[]
    public $Urole;

    public $Uname, $Uemail;


    
    // public function with(): array{
    //     return [
            
    //     ];
    // }

    public function mount(){
        $this->users = User::all();
        // foreach ($this->users as $key => $user) {
        //     $this->links =  Link::where('status' , 1)->orWhere('user_id', $user->id)->get();
        // }
    }


        /**
     * Retrieves a user by ID and populates the component's properties with the user's data.
     *
     * @param int $id The ID of the user to retrieve.
     */
    public function userEdit($id)
    {
        $user = User::find($id);
        $this->id = $user->id;
        $this->Uname = $user->name;
        $this->Uemail = $user->email;
        $this->Urole = $user->role;
    }

    public function resetPassword(){
        $this->status = 1;
    }

        /**
     * Resets the status property to 0.
     */
    public function formReset(){
        $this->status = 0;
    }

        /**
     * Returns an array of validation error messages for the `Urole` field.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'Urole.required' => ':attribute can not be empty.',
        ];
    }

    /**
     * Updates the role of a user.
     *
     * @param int $id The ID of the user to update.
     * @return void
     */
    public function Edit($id)
    {
        $this->validate([
            'Urole' => 'required',
        ]);

        $data = [
            'role' => $this->Urole,
        ];

        User::find($id)->update($data);

        flash()
            ->title('Update')
            ->options(['timeout' => 1500])
            ->addSuccess('User Update Successfully');
    }

    /**
     * Resets the password for the specified user.
     *
     * @param int $id The ID of the user to reset the password for.
     * @return void
     */
    public function sendPassword($id)
    {
        $user = User::find($id);

        $password = Str::random(5) . rand(0, 999) . Str::random(5) . rand(0, 999);

        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
        ];

        Mail::to($user->email)->send(new AdminResetPassword($mailData));

        User::find($id)->update([
            'password' => Hash::make($password),
        ]);

        flash()
            ->title('Reset Password')
            ->options(['timeout' => 1500])
            ->addSuccess($user->name . ' Password Reset Succesfully');
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
                                        <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">All User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                @foreach ($users as $user)
                <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4">
                        <div class="card social-profile">
                            <div class="card-body">
                                <div class="social-img-wrap">
                                    <div class="social-img">
                                        @if (!Auth::user()->profile_picture)
                                            <img alt="" src="{{ asset('dashboard_assests') }}/images/avtar/default_profile.jpg">
                                        @else
                                            <img width="80px" src="{{ asset('uploads/profile_pictures') }}/{{ $user->profile_picture }}"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="edit-icon">
                                        <svg>
                                            <use href="{{ asset('dashboard_assests') }}/svg/icon-sprite.svg#profile-check">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="social-details">
                                    <h5 class="mb-1"><a href="#">{{ $user->name }} {{ Auth::user()->email == $user->email ? '(You)' : '' }}</a></h5><span
                                        class="f-light">{{ $user->email }}</span>
                                    {{-- <ul class="card-social">
                                        @foreach ($links as $link)
                                            <li><a href="{{ $link->url }}" target="_blank"><i style="font-size: 20px;" class="fa fa-{{ $link->relToType->icon }}"></i></a></li>
                                        @endforeach
                                    </ul> --}}
                                </div>
                                <div class="d-flex my-4 justify-content-around">
                                    <button class="btn btn-dark" disabled>
                                        @if ($user->role == 3)
                                            User
                                        @elseif ($user->role == 1)
                                            Moderator
                                        @else
                                            Admin
                                        @endif
                                    </button>

                                @if ($user->role != 'admin')
                                    <!-- Button trigger modal -->
                                    <button type="button" wire:click='userEdit({{ $user->id }})' class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Edit
                                    </button>

                                    <abbr title="View {{ $user->name }} Profile">
                                        <button class="btn btn-primary"><i style="font-size: 18px" class="fa fa-eye" aria-hidden="true"></i></button>
                                    </abbr>
                                @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $status ? 'Reset Password' : 'Edit User' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='Edit({{ $id }})' >
                        @if (!$status)
                            <div class="my-3">
                                <label class="form-label">Name</label>
                                <input wire:model='Uname' type="text" class="form-control" disabled>
                            </div>
                            <div class="my-3">
                                <label class="form-label">Email</label>
                                <input wire:model='Uemail' type="email" class="form-control" disabled>
                            </div>
                            <div class="my-3">
                                <label class="form-label">Role</label>
                                <select wire:model='Urole' class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="1" {{ $Urole != 3 ? 'selected' : '' }}>Moderator</option>
                                    <option value="3" {{ $Urole == 3 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                            @error('Urole')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        @endif
                        <div class="d-flex justify-content-end mt-3">
                            @if (!$status)
                                <p wire:click='resetPassword' class="btn btn-primary me-2">Reset Password</p>
                                <button class="btn btn-danger">Update</button>
                            @else
                                <p wire:click='formReset' class="btn btn-primary me-2">Edit User</p>
                                <p wire:click='sendPassword({{ $id }})' class="btn btn-primary me-2" data-bs-dismiss="modal">Send Password</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
