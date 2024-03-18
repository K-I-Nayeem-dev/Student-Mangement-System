<?php

use Livewire\Volt\Component;

new class extends Component {
    // define properties & Validate

    #[Validate]
    public $name, $email;

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|min:5',
            // 'content' => 'required|min:5',
        ];
    }

    // form submit for Add User;
    public function addUser()
    {
        $this->validate();
        $data = [
            'name' => $this->name, 
            'email' => $this->email
        ];
        dd($data['name']);
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
                <div class="col-lg-6">
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
                                    <button
                                        type="submit"class="mt-2 btn btn-pill btn-outline-primary btn-sm">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
