<x-filament::page>

    <h2 class="text-2xl font-bold mb-4">
        Cast Vote for {{ $voter->full_name }}
    </h2>

    @if ($hasVoted)
        <div class="p-4 bg-green-200 rounded mb-4">
            This voter has already cast their vote.
        </div>
    @endif

    <form wire:submit.prevent="submitVote">

        @foreach ($candidatesBySector as $sector => $candidates)
            <div class="border rounded p-4 mb-6">
                <h3 class="font-bold text-xl mb-4">{{ $sector }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    @foreach ($candidates as $candidate)
                        <label class="flex items-center space-x-3 border p-3 rounded cursor-pointer">

                            @if ($candidate['photo'])
                                <img src="{{ asset('storage/'.$candidate['photo']) }}"
                                     class="w-16 h-16 object-cover rounded-full">
                            @else
                                <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                            @endif

                            <input
                                type="radio"
                                wire:model="selectedVotes.{{ $sector }}"
                                value="{{ $candidate['id'] }}"
                            >

                            <span class="font-medium">{{ $candidate['name'] }}</span>
                        </label>
                    @endforeach

                </div>
            </div>
        @endforeach

        <button
            type="submit"
            class="px-4 py-2 bg-maroon-600 text-white rounded shadow"
        >
            Submit Vote
        </button>

    </form>

</x-filament::page>
