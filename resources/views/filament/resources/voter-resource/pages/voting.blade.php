<x-filament::page>
    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-300 rounded text-green-700 font-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 bg-yellow-100 border border-yellow-300 rounded text-yellow-700 font-semibold">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold">
            Voting for: {{ $voter->first_name }} {{ $voter->last_name }}
            ({{ $voter->voter_id }})
        </h2>

        <form method="POST" action="{{ url()->current() }}">
            @csrf
            @foreach($candidatesBySector as $sector => $candidates)
                <div class="p-4 border rounded shadow-sm bg-white mb-4">
                    <h3 class="text-lg font-semibold mb-3">{{ $sector }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($candidates as $candidate)
                            <label class="flex items-center space-x-2 p-2 border rounded cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="votes[{{ $sector }}]"
                                       value="{{ $candidate['id'] }}"
                                       @if($hasVoted) disabled @endif
                                       @if(isset($selectedVotes[$sector]) && $selectedVotes[$sector] == $candidate['id']) checked @endif
                                       class="form-radio text-green-600">
                                <span class="text-gray-700">{{ $candidate['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="p-4 border rounded bg-gray-50 space-y-3 mb-4">
                <label class="block font-semibold text-gray-700">Fingerprint:</label>
                <input type="text"
                       name="fingerprint"
                       @if($hasVoted) disabled @endif
                       value="{{ old('fingerprint', $voter->fingerprint_hash) }}"
                       placeholder="Scan fingerprint or type manually"
                       class="w-full border rounded p-2">
            </div>

            <button type="submit"
                    @if($hasVoted) disabled @endif
                    class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50">
                Submit Vote
            </button>
        </form>
    </div>
</x-filament::page>

