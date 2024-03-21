<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Mail\SendPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public function with(): array
    {
        return [
            'users' => User::Where('added_by_admin', 1)->latest()->get(),
            'roles' => Role::all(),
        ];
    }

    // define properties & Validate
    #[Validate]
    #[Validate]
    #[Validate]
    public $name, $email, $password, $role;

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|unique:users,email',
            'role' => 'required',
            // 'content' => 'required|min:5',
        ];
    }

    // form submit for Add User;
    public function addUser()
    {
        /**
         * Validates form input.
         * Creates a new user with the form data.
         * Generates a random password.
         * Sends the password to the user via email.
         * Resets the form fields after successful creation.
         */

        $this->validate();

        $password = Str::random(5) . rand(0, 999) . Str::random(5) . rand(0, 999);
        $this->password = $password;

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role
        ];

        $mailData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        Mail::to($this->email)->send(new SendPasswordMail($mailData));

        User::create(
            $data + [
                'password' => Hash::make($this->password),
                'added_by_admin' => 1,
                'role' => 'user',
            ],
        );

        $this->reset();

        flash()
            ->options(['timeout' => 1500])
            ->addSuccess('User Invitaion Send Successfully');
    }

    public function userDelete($id)
    {
        User::find($id)->delete();
        flash()
            ->title('Delete')
            ->options(['timeout' => 1500])
            ->addError('User Deleted Successfully');
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
                            <li class="breadcrumb-item active">Create User</li>
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
                            <h4>Add User</h4>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form wire:submit='addUser'>
                                    <x-input.input label='Name' fiwe='name' type='text'
                                        placeholder='Enter User Name' />
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <x-input.input label='Email' fiwe='email' type='email'
                                        placeholder='Enter User Email' />
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="role">Role</label>
                                    <select wire:model='role' id="role" class="form-control mb-2">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->type }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <button
                                        type="submit"class="mt-2 btn btn-pill btn-outline-primary btn-sm">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 m-0 p-0">
                    <div class="card">
                        <div class="card-header">
                            <h4>Users Info</h4>
                        </div>
                        <div>
                            <table class="table table-hover" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->relToRole->type }}</td>
                                            <td>
                                                @if ($user->status == 0)
                                                    <p class="badge rounded-pill badge-danger">Pending</button>
                                                @else
                                                    <p class="badge rounded-pill badge-success">Accepted</button>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                <button type="submit" wire:click="userDelete({{ $user->id }})"
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
