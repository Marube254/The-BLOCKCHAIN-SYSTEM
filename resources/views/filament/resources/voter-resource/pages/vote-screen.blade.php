<x-filament::page>
    <div class="space-y-6">
        <h2 class="text-xl font-bold">Voting Screen for {{ $voter->first_name }} {{ $voter->last_name }}</h2>

        <form wire:submit.prevent="confirmVote">
            {{ $this->form }}

            <div class="flex justify-end mt-6">
                <x-filament::button color="success" type="submit">
                    Confirm Vote via Fingerprint
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament::page>
