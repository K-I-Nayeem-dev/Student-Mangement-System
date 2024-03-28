<?php

use Livewire\Volt\Component;
use App\Models\LinkType;

new class extends Component {
    #Validate[]
    public $name, $icon, $status;

    public $file, $icons, $fontAwesome;

    public function with(): array{
        return [
            'links' => LinkType::latest()->paginate(5),
        ];
    }

    // public function mount()
    // {
    //     $this->file = file_get_contents('icons/fonstAwesome.json');
    //     $this->icons = json_decode($this->file);
    //     $this->fontAwesome = $this->icons->icons;
    // }
    /**
     * Validates the name, url, icon and status fields, creates a new Link model instance
     * with the validated data, persists it to the database, and shows a success flash
     * message.
     */
    public function addLinks()
    {
        $this->validate([
            'name' => 'required',
            'icon' => 'required',
            'status' => 'required',
        ]);

        $data = [
            'name' => $this->name,
            'icon' => $this->icon,
            'status' => $this->status,
        ];

        LinkType::create($data);

        flash()
            ->title('Link')
            ->options(['timeout' => 1500])
            ->addSuccess('Link Added Successfully');

        $this->reset();
    }

    public function editLink($id){
        dd($id);
    }

    public function deleteLink($id){
        dd($id);
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
                            <li class="breadcrumb-item">{{ auth()->user()->role == 'admin' ? 'Admin' : 'User' }}</li>
                            <li class="breadcrumb-item active">Links</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <form wire:submit='addLinks'>
                        <div class="card">
                            <div class="card-header">
                                <h5>Add Link</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input wire:model='name' type="text" class="form-control">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="my-3">
                                        <label class="form-label">Icon</label>
                                        <input wire:model='icon' type="text" class="form-control" name="icon">
                                        @error('icon')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    {{-- <div class="text-center ms-5 mt-4">
                                        <p class="icon" style="font-size: 35px;"></p>
                                    </div> --}}
                                </div>

                                {{-- /**
                                * Commented out code to display a grid of Font Awesome icons.
                                * Allows selecting an icon to use for the link.
                                */ --}}
                                {{-- <div class="d-flex justify-content-center flex-wrap py-1 rounded get_icon mb-2"
                                    style="width: 400px; height: 200px; overflow: auto; border: 1px solid black">
                                    @foreach ($fontAwesome as $icon)
                                        <p class="btn btn-rounded btn-primary mx-2">
                                            <abbr style="cursor: pointer;" title="{{ $icon }}">
                                                <i style="font-size: 18px"class="fa {{ $icon }}"aria-hidden="true"></i>
                                            </abbr>
                                        </p>
                                    @endforeach
                                </div> --}}

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select wire:model='status' class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Links for User</h4>
                        </div>
                        <div class="card-body">
                            <table class="table mb-3 text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($links as $link)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $link->name }}</td>
                                            <td>
                                                <i style="font-size: 25px" class="fa fa-{{ $link->icon }}" aria-hidden="true">
                                                </i>
                                            </td>
                                            <td style="text-align: center">
                                                @if (!$link->status)
                                                    <p class="bg-danger rounded py-2 px-2">Inactive</p>
                                                @else
                                                    <p class="bg-success rounded px-2 py-2">Active</p>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click='editLink({{ $link->id }})' class="btn btn-primary">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='deleteLink({{ $link->id }})' class="btn btn-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No Links Founds</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $links->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

</div>

<script>
    /**
     * Adds click event listeners to each icon that update 
     * the input value and icon class when clicked
     * 
     * @param {HTMLInputElement} input - The input element for the icon name
     * @param {NodeListOf<HTMLElement>} icons - The icon elements  
     * @param {HTMLElement} icon - The element to update with icon class
     * @param {NodeListOf<HTMLElement>} getIcon - The icon container elements
     */
    // let input = document.querySelector('input[name="icon"]');
    // let icons = document.querySelectorAll('p abbr i');
    // let icon = document.querySelector('.icon');
    // let getIcon = document.querySelectorAll('.get_icon p');

    // for (let i = 0; i < icons.length; i++) {
    //     getIcon[i].addEventListener('click', () => {
    //         input.value = icons[i].getAttribute('class');
    //         icon.setAttribute('class', icons[i].getAttribute('class'));
    //         // input.setAttribute('wire:model.live', 'icon');
    //     });
    // }
</script>
