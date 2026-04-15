<x-filament::page>
    {{ $this->form }}

    @include('filament.resources.voter-resource.components.fingerprint-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Create voter page loaded');
        });
    </script>

    <x-filament::button wire:click="create" class="mt-4">
        Create Voter
    </x-filament::button>
</x-filament::page>
