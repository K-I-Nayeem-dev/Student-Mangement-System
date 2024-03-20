<?php

use Livewire\Volt\Component;
use App\Models\Role;

new class extends Component {
    /**
     * Validates the type input field.
     * Defines rules for type field validation.
     * Validates type before creating a new role.
     * Fetches and paginates roles for display.
     */

    #Validate[]
    public $type;

    public function with(): array
    {
        return [
            'roles' => Role::paginate(10),
        ];
    }

    public function rules()
    {
        return [
            'type' => 'required|min:4',
        ];
    }

    public function addType()
    {
        $this->validate();

        $data = [
            'type' => $this->type,
        ];

        Role::create($data + [
            'updated_at' => null,
        ]);

        $this->reset();

        flash()->options(['timeout' => 1500])->addSuccess('Role Type Added Successfully');
        
    }
    
    public function roleDelete($id){
        Role::find($id)->delete();
        flash()->title('Delete')->options(['timeout' => 1500])->addError('Role  Deleted');
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
                            <li class="breadcrumb-item">Apps</li>
                            <li class="breadcrumb-item active">Role</li>
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
                            <h4>Add Role</h4>
                        </div>
                        <div class="card-body">
                            <form wire:submit='addType'>
                                <x-input.input label='Type' fiwe='type' type='text'
                                    placeholder='Enter Role Type' />
                                @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="mt-2 btn btn-pill btn-outline-primary btn-sm">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Role Types</h4>
                        </div>
                        <div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Role Type</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <th scope="row">{{ $role->id }}</th>
                                            <td>{{ $role->type }}</td>
                                            <td>{{ $role->created_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                <button type="submit" wire:click="roleDelete({{ $role->id }})"
                                                    class="btn btn-sm btn-pill btn-danger">
                                                    <i style="font-size: 16px" class="fa fa-trash cursor-pointer"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No Role Found</td>
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
