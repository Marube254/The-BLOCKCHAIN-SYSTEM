<x-filament::page>
    <!-- Debug Info -->
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <strong>Debug:</strong> Fingerprint Required: {{ $fingerprint_required ? 'Yes' : 'No' }} |
        Fingerprint Verified: {{ $fingerprint_verified ? 'Yes' : 'No' }} |
        Has Voted: {{ $hasVoted ? 'Yes' : 'No' }}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Fingerprint Section -->
        <div class="lg:col-span-1">
            @include('filament.resources.voter-resource.pages.fingerprint-capture')
        </div>
        
        <!-- Voting Section -->
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold mb-4">
                Cast Vote for {{ $voter->first_name }} {{ $voter->last_name }}
            </h2>

            @if ($hasVoted)
                <div class="p-4 bg-green-100 text-green-800 rounded-lg mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    This voter has already cast their vote.
                </div>
            @endif

            @if ($fingerprint_required && !$fingerprint_verified)
                <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg mb-4">
                    <i class="fas fa-fingerprint mr-2"></i>
                    Fingerprint verification required before voting.
                </div>
            @endif

            <form wire:submit.prevent="submitVote">
                @foreach ($candidatesBySector as $sector => $candidates)
                    <div class="border rounded-lg p-4 mb-6 bg-white">
                        <h3 class="font-bold text-xl mb-4 text-[#8B0000]">{{ $sector }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($candidates as $candidate)
                                <label class="flex items-center space-x-3 border p-3 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    @if ($candidate['photo'])
                                        <img src="{{ asset('storage/'.$candidate['photo']) }}"
                                             class="w-12 h-12 object-cover rounded-full">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    @endif

                                    <input type="radio"
                                           wire:model="selectedVotes.{{ $sector }}"
                                           value="{{ $candidate['id'] }}"
                                           class="w-4 h-4 text-[#8B0000]"
                                           @disabled($hasVoted || ($fingerprint_required && !$fingerprint_verified))>

                                    <span class="font-medium">{{ $candidate['name'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit"
                        class="px-6 py-3 bg-[#8B0000] hover:bg-[#6a0000] text-white font-semibold rounded-lg shadow-md transition"
                        @disabled($hasVoted || ($fingerprint_required && !$fingerprint_verified))>
                    <i class="fas fa-vote-yea mr-2"></i>
                    Submit Vote
                </button>
            </form>
        </div>
    </div>
</x-filament::page>
