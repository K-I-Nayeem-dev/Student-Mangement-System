<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <button wire:click="logout" class="btn btn-pill btn-outline-primary btn-sm">
        <x-responsive-nav-link>
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </button>
</div>
