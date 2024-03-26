<?php

use Livewire\Volt\Component;
use App\Models\UserDetails;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    // Define Properties
    #Validate[]
    public $bio, $website;

    #Validate[]
    public $new_password;

    #Validate[]
    public $number;

    #Validate[]
    public $password = '', $password_confirmation = '';

    #Validate[]
    public $company, $username, $email, $first_name, $last_name, $address, $city, $postal_code , $division, $about_me;

    public $status = 0;

    public function with(): array{
        return [
            'user' => UserDetails::Where('user_id', auth()->id())->first(),
        ];
    }
    
    public function profileSave($id)
    {
        $this->validate([
            'bio' => 'required', 
            'website' => 'required', 
        ]);

        $data = [
            'bio' => $this->bio,
            'website' => $this->website,
        ];

        $user = UserDetails::Where('user_id', $id)->first();

        UserDetails::Where('user_id', $user->user_id)->update($data);

        flash()->title('Info')->options(['timeouts' => 1500])->addSuccess('Save Info Successfully');
    }

    public function editInfo($id){

        $this->validate([
            'company' => 'required',
            'username' => 'required',
            'email' => 'required',
            'first_name' => 'required', 
            'last_name' => 'required',
            'address' => 'required', 
            'city' => 'required',
            'postal_code' => 'required',
            'division' => 'required', 
            'about_me' => 'required',
        ]);
        $data = [
            'company' => $this->company,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name, 
            'last_name' => $this->last_name,
            'address' => $this->address, 
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'division' => $this->division, 
            'about_me' => $this->about_me,
        ];

        $user = UserDetails::Where('user_id', $id)->first();

        UserDetails::Where('user_id', $user->user_id)->update($data);

        User::find($id)->update([
            'email' => $this->email,
        ]);

        flash()->title('Edit Profile')->options(['timeouts' => 1500])->addSuccess('Update Profile Successfully');
    }


    public function passwordCheck($id){

        $this->validate([
            'new_password' => 'required',
        ]);

        if(Hash::check($this->new_password, auth()->user()->password)){
            $this->status = 1;
        }
        else{
            flash()->title('Error')->options(['timeouts' => 1500, 'position' => 'top-center',])->addError("Password Doesn't Match");
        }

    }

    public function passwordChange($id){

        $this->validate([
            'password' =>   'required|min:5',
            'password_confirmation' => 'required',
        ]);

        if($this->password == $this->password_confirmation){
            User::find($id)->update([
                'password'=> Hash::make($this->password),
            ]);

            $this->status = 0;
            flash()->title('Password')->options(['timeouts' => 1500])->addSuccess('Change Password Successfully');

        }
        else{
            flash()->title('Error')->options(['timeouts' => 1500, 'position' => 'top-center',])->addError("Password Doesn't Match");
        }
        
    }

    public function addPhone($id){
        User::find($id)->update([
            'phone_number' => $this->number,
        ]);
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
                            <li class="breadcrumb-item active"> Edit Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">My Profile</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <form wire:submit='profileSave({{ auth()->id() }})'>
                                    <div class="row mb-2">
                                        <div class="profile-title">
                                            <div class="media">
                                                @if (Auth::user()->profile_picture)
                                                    <img width="100px" height="100px" style="border-radius: 50%"
                                                        src="{{ asset('uploads/profile_pictures') }}/{{ Auth::user()->profile_picture }}"
                                                        alt="{{ Auth::user()->name }} profile Photo">
                                                @else
                                                    <img class="img-70 rounded-circle" alt=""
                                                        src="{{ asset('dashboard_assests') }}/images/avtar/default-profile.jpg">
                                                @endif
                                                <div class="media-body">
                                                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                                    @if (Auth::user()->role == 'admin')
                                                        <p>{{ Auth::user()->role }}</p>
                                                    @else
                                                        <p>{{ Auth::user()->relToRole->type }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="form-label">Bio</h6>
                                        <textarea wire:model='bio' class="form-control" rows="5" placeholder="Enter Your Bio" value='{{ $user->bio }}'></textarea>
                                        @error('bio')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email-Address</label>
                                        <input class="form-control" disabled value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input wire:model='website' class="form-control"
                                            placeholder="Enter Your Website" value="{{ $user->website }}">
                                        @error('website')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-footer">
                                        <button wire:loading.remove wire:target='profileSave'
                                            class="btn btn-primary btn-block">Save</button>
                                        <div wire:loading wire:target='profileSave'>
                                            <h5>Saving...</h5>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <form wire:submit='editInfo({{ auth()->id() }})'>
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Edit Profile</h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#"
                                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                                class="fe fe-x"></i></a></div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label">Company</label>
                                                <input wire:model='company' value="{{ $user->company }}"
                                                    class="form-control" type="text" placeholder="Company">
                                                @error('company')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input wire:model='username' value="{{ $user->username }}"
                                                    class="form-control" type="text" placeholder="Username">
                                                @error('username')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Email address</label>
                                                <input wire:model='email' value="{{ auth()->user()->email }}"
                                                    class="form-control" type="email" placeholder="Email">
                                                    @error('email')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name</label>
                                                <input wire:model='first_name' value="{{ $user->first_name }}"
                                                    class="form-control" type="text" placeholder="First Name">
                                                    @error('first_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input wire:model='last_name' value="{{ $user->last_name }}"
                                                    class="form-control" type="text" placeholder="Last Name">
                                                    @error('last_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input wire:model='address' value="{{ $user->address }}"
                                                    class="form-control" type="text" placeholder="Home Address">
                                                    @error('address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input wire:model='city' value="{{ $user->city }}"
                                                    class="form-control" type="text" placeholder="City">
                                                    @error('city')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Postal Code</label>
                                                <input wire:model='postal_code' value="{{ $user->postal_code }}"
                                                    class="form-control" type="number" placeholder="ZIP Code">
                                                    @error('postal_code')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <input wire:model='division' value="{{ $user->division }}"
                                                    class="form-control" type="text" placeholder="Division">
                                                    @error('division')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label class="form-label">About Me</label>
                                                <textarea wire:model='about_me' class="form-control" rows="4" placeholder="Enter About your description">{{ $user->about_me }}</textarea>
                                                @error('about_me')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button wire:loading.remove wire:target='editInfo' class="btn btn-primary"
                                        type="submit">Update Profile</button>
                                    <div wire:loading wire:target='editInfo'>
                                        <h5>Updating Info...</h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Password Change</h4>
                            </div>
                            <div class="card-body">
                                @if($status == 0)
                                <form wire:submit='passwordCheck({{ auth()->id() }})'>
                                    <div class="my-2">
                                        <label>Check Passoword</label>
                                        <input wire:model='new_password' type="password" class="form-control">
                                        @error('new_password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button  wire:target='passwordCheck' class="btn btn-primary btn-block">Check</button>
                                    <div wire:loading wire:target='passwordCheck'>
                                        <h5>Checking...</h5>
                                    </div>
                                </form>
                                @else
                                    <form wire:submit='passwordChange({{ auth()->id() }})'>
                                        <div class="my-2">
                                            <label>New Passoword</label>
                                            <input wire:model='password' type="password" class="form-control">
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label>Confirm Passoword</label>
                                            <input wire:model='password_confirmation' type="password" class="form-control">
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button wire:model='toggle' wire:target='passwordChange' class="btn btn-primary btn-block">Change</button>
                                        <div wire:loading wire:target='passwordChange'>
                                            <h5>Password Changing...</h5>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Contact Number</h4>
                            </div>
                            <div class="card-body">
                                @if(!Auth::user()->phone_number)
                                <form wire:submit='addPhone({{ auth()->id() }})'>
                                    <div class="my-2">
                                        <label>Add Number</label>
                                        <input wire:model='number' type="number" class="form-control">
                                        @error('number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button  wire:target='number' class="btn btn-primary btn-block">Add</button>
                                    <div wire:loading wire:target='number'>
                                        <h5>Add Number...</h5>
                                    </div>
                                </form>
                                @else
                                    <form wire:submit='passwordChange({{ auth()->id() }})'>
                                        <div class="my-2">
                                            <label>New Passoword</label>
                                            <input wire:model='password' type="password" class="form-control">
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="my-2">
                                            <label>Confirm Passoword</label>
                                            <input wire:model='password_confirmation' type="password" class="form-control">
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button wire:model='toggle' wire:target='passwordChange' class="btn btn-primary btn-block">Change</button>
                                        <div wire:loading wire:target='passwordChange'>
                                            <h5>Password Changing...</h5>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
