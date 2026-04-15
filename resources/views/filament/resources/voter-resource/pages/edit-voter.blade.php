<x-filament::page>
    {{ $this->form }}

    @include('filament.resources.voter-resource.components.fingerprint-modal')

    <x-filament::button wire:click="save" class="mt-4">
        Save Changes
    </x-filament::button>
</x-filament::page>
