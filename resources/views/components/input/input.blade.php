<div>
    <label class="form-label mb-2" for="{{ $fiwe }}">{{ $label }}</label>
    <input  id="{{ $fiwe }}" class="form-control mb-2" wire:model.blur='{{ $fiwe }}' type="{{ $type }}"placeholder="{{ $placeholder }}">
</div>