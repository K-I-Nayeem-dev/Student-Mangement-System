<?php

use Livewire\Volt\Component;
use App\Models\UserDetails;
use App\Models\User;
use App\Models\LinkType;
use App\Models\Link;
use App\Models\Validate;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserPhoneNumberUpdate;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    // Define Properties
    /*
     * This class contains validation rules, data update methods,
     * password update logic, OTP generation and verification,
     * and phone number update requests for user profile management.
     *
     */

    #Validate[]
    public $bio, $website;

    #Validate[]
    public $new_password;

    #Validate[]
    public $number;

    #Validate[]
    public $otp;

    #Validate[]
    public $password = '',
        $password_confirmation = '';

    #Validate[]
    public $company, $username, $email, $first_name, $last_name, $address, $city, $postal_code, $division, $about_me;

    public $status = 0,
        $user;

    #Validate[]
    public $url, $type, $linkStatus;

    public $id;

    #Validate[]
    public $eUrl, $eType, $eStatus;

    public function with(): array
    {
        return [
            'links' => LinkType::Where('status', 1)->get(),
            'userLinks' => Link::Where('user_id', auth()->id())->latest()->paginate(3),
        ];
    }

    public function mount()
    {
        $this->user = UserDetails::Where('user_id', auth()->id())->first();
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

        flash()
            ->title('Info')
            ->options(['timeouts' => 1500])
            ->addSuccess('Save Info Successfully');
    }

    /*
     * It validates user input for profile fields like bio, website,
     * contact info, password etc. Updates user details in database
     * on successful validation.
     */

    public function editInfo($id)
    {
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

        flash()
            ->title('Edit Profile')
            ->options(['timeouts' => 1500])
            ->addSuccess('Update Profile Successfully');
    }

    /**
     * Validates new password and checks if it matches current password.
     * Shows error if new password matches current.
     *
     * Validates new password and confirmation. Updates user password
     * if new password and confirmation match. Shows success message.
     *
     * @param {number} id - The user ID
     */

    public function passwordCheck($id)
    {
        $this->validate([
            'new_password' => 'required',
        ]);

        if (Hash::check($this->new_password, auth()->user()->password)) {
            $this->status = 1;
        } else {
            flash()
                ->title('Error')
                ->options(['timeouts' => 1500, 'position' => 'top-center'])
                ->addError("Password Doesn't Match");
        }

        $this->password = '';
        $this->password_confirmation = '';
    }

    public function passwordChange($id)
    {
        $this->validate([
            'password' => 'required|min:5',
            'password_confirmation' => 'required',
        ]);

        if ($this->password == $this->password_confirmation) {
            User::find($id)->update([
                'password' => Hash::make($this->password),
            ]);

            $this->status = 0;
            flash()
                ->title('Password')
                ->options(['timeouts' => 1500])
                ->addSuccess('Change Password Successfully');
        } else {
            flash()
                ->title('Error')
                ->options(['timeouts' => 1500, 'position' => 'top-center'])
                ->addError("Password Doesn't Match");
        }
        $this->new_password = '';
    }

    /**
     * Generates and verifies OTP for phone number verification.
     * Sends email for phone number update requests.
     **/

    public function sendOtp()
    {
        flash()
            ->title('OTP')
            ->options(['timeouts' => 1500])
            ->addSuccess('OTP Code Sent');
    }

    public function addPhone($id)
    {
        $this->validate([
            'number' => 'required|min:11',
        ]);

        $user = User::find($id)->update([
            'phone_number' => $this->number,
        ]);

        $code = rand(0, 999999);

        Validate::insert([
            'user_id' => auth()->id(),
            'code' => $code,
            'number' => $this->number,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        flash()
            ->title('Phone')
            ->options(['timeouts' => 1500])
            ->addSuccess('phone Number Added Successfully');
        sleep(3);
        $this->sendOtp();
    }

    public function verifyNumber($id)
    {
        $this->validate([
            'otp' => 'required',
        ]);

        $user = Validate::Where('user_id', $id)->first();

        if ($this->otp == $user->code) {
            User::find($id)->update([
                'phone_verify' => 1,
            ]);

            Validate::Where('user_id', $id)->update([
                'status' => 1,
            ]);

            flash()
                ->title('Phone')
                ->options(['timeouts' => 1500])
                ->addSuccess('phone Number Verified');
        }
    }

    public function updatePhone($id)
    {
        $mailData = [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone_number' => auth()->user()->phone_number,
        ];

        User::find($id)->update([
            'phone_update' => 1,
        ]);

        Mail::to('naeem8541@gmail.com')
            ->cc(auth()->user()->email)
            ->send(new UserPhoneNumberUpdate($mailData));
        flash()
            ->title('Update')
            ->options(['timeouts' => 1500])
            ->addSuccess('phone Number Update Request Send');
    }

    public function linkAdd()
    {
        $this->validate([
            'type' => 'required',
            'url' => 'required',
            'linkStatus' => 'required',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'type_id' => $this->type,
            'url' => $this->url,
            'status' => $this->linkStatus,
            'created_at' => now(),
            'updated_at' => null,
        ];

        Link::create($data);

        flash()
            ->title('Link')
            ->options(['timeouts' => 1500])
            ->addSuccess('Link Added To Profile');
    }

    public function edit($id)
    {
        $link = Link::Where('id', $id)->first();
        $this->id = $link->id;
        $this->eUrl = $link->url;
        $this->eType = $link->relToType->id;
        $this->eStatus = $link->status;
    }

    public function deleteLink($id)
    {
        Link::find($id)->delete();
        flash()
            ->title('Delete')
            ->options(['timeouts' => 1500])
            ->addError('Link Delete From Profile');
    }

    public function editLink($id)
    {
        $this->validate([
            'eUrl' => 'required',
            'eType' => 'required',
            'eStatus' => 'required',
        ]);

        $data = [
            'url' => $this->eUrl,
            'type_id' => $this->eType,
            'status' => $this->eStatus,
        ];

        Link::find($id)->update($data);

        flash()
            ->title('Update')
            ->options(['timeouts' => 1500])
            ->addSuccess('Link Update Profile Successfully');
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
                                                        {{-- <p>{{ Auth::user()->relToRole->type }}</p> --}}
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
                                @if ($status == 0)
                                    <form wire:submit='passwordCheck({{ auth()->id() }})'>
                                        <div class="my-2">
                                            <label>Check Passoword</label>
                                            <input wire:model='new_password' type="password" class="form-control">
                                            @error('new_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button wire:target='passwordCheck'
                                            class="btn btn-primary btn-block">Check</button>
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
                                            <input wire:model='password_confirmation' type="password"
                                                class="form-control">
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button wire:model='toggle' wire:target='passwordChange'
                                            class="btn btn-primary btn-block">Change</button>
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

                                <h4>{{ !auth()->user()->phone_number ? 'Add Contact Number' : 'Contact Number' }}</h4>
                            </div>
                            <div class="card-body">
                                @if (Auth::user()->phone_number)
                                    <div class="my-3">
                                        <h6>phone Number : {{ Auth::user()->phone_number }}</h6>
                                        @if (!Auth::user()->phone_verify)
                                            <code class="text-danger">Unverified</code>
                                        @else
                                            <code>Verified</code>
                                        @endif
                                    </div>
                                @endif
                                @if (!Auth::user()->phone_number)
                                    <form wire:submit='addPhone({{ auth()->id() }})'>
                                        <div class="my-2">
                                            <label>Add Number</label>
                                            <input wire:model='number' type="number" class="form-control">
                                            @error('number')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button wire:target='number' class="btn btn-primary btn-block">Add</button>
                                        <div wire:loading wire:target='number'>
                                            <h5>Add Number...</h5>
                                        </div>
                                    </form>
                                @else
                                    @if (!Auth::user()->phone_verify)
                                        <form wire:submit='verifyNumber({{ auth()->id() }})'>
                                            <div class="my-2">
                                                <label class="text-center">
                                                    <h4>Enter OTP</h4>
                                                </label>
                                                <input wire:model='otp' type="number" class="form-control">
                                                @error('otp')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <button wire:target='passwordChange'
                                                class="btn btn-primary btn-block">Verify
                                                Number</button>
                                            <div wire:loading wire:target='passwordChange'>
                                                <h5>Verifying...</h5>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                                @if (Auth::user()->phone_verify && !Auth::user()->phone_update)
                                    <button wire:click='updatePhone({{ auth()->id() }})'
                                        class="btn btn-primary btn-block">Update Number</button>
                                    <div wire:loading wire:target='updatePhone'>
                                        <h5>Sending Request...</h5>
                                    </div>
                                @endif
                                @if (Auth::user()->phone_update && Auth::user()->phone_verify)
                                    {{-- <p class="bg-primary px-3 py-2 rounded">Request Sended for Update Number</p> --}}
                                    <button disabled class="btn btn-primary">Request Sended for Update Number</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Social Link Add</h4>
                            </div>
                            <div class="card-body">
                                <form wire:submit="linkAdd">
                                    <x-input.input type='text' fiwe='url' label='URL'
                                        placeholder='Your Social Url' />
                                    @error('url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="my-3">
                                        <select class="form-select" wire:model="type">
                                            <option value="">Social Name</option>
                                            @foreach ($links as $link)
                                                <option value="{{ $link->id }}">{{ $link->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <select class="form-select" wire:model='linkStatus'>
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('linkStatus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add</button>

                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-7 p-0 m-0">
                        <div class="card">
                            <div class="card-header">
                                <h4>Links</h4>
                            </div>
                            <div class="card-body">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">URL</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userLinks as $key => $link)
                                            <tr>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $link->relToType->name }}</td>
                                                <td>
                                                    <a href="{{ $link->url }}" target="_blank">Visit</a>
                                                </td>
                                                <td>
                                                    @if ($link->status)
                                                        <p class="btn btn-success btn-sm">Active</p>
                                                    @else
                                                        <p class="btn btn-danger btn-sm">Deactive</p>
                                                    @endif
                                                </td>
                                                <td class="d-flex justify-content-center">
                                                    <button wire:click="edit({{ $link->id }})" type="button"
                                                        class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"><i class="fa fa-edit"
                                                            aria-hidden="true"></i></button>
                                                    <button wire:click="deleteLink({{ $link->id }})"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-2">
                                    {{ $userLinks->links('pagination::bootstrap-4') }}
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
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Link</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form wire:submit='editLink({{ $id }})'>
                                    <div class="my-3">
                                        <label>Name</label>
                                        <input wire:model='eUrl' class="form-control" wire:model='LName'
                                            type="text">
                                    </div>
                                    <div class="my-3">
                                        <label>URL</label>
                                        <select wire:model='eType' class="form-select">
                                            <option value="">Select Social</option>
                                            @foreach ($links as $link)
                                                <option value="{{ $link->id }}"
                                                    {{ $link->id == $eType ? 'selected' : '' }}>{{ $link->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-3">
                                        <label>Name</label>
                                        <select wire:model='eStatus' class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>
