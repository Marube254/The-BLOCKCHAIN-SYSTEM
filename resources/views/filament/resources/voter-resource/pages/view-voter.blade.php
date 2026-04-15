<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-[#8B0000] mb-4">Personal Information</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Voter ID</label>
                    <p class="text-gray-800">{{ $record->voter_id }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Full Name</label>
                    <p class="text-gray-800">{{ $record->first_name }} {{ $record->last_name }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Email</label>
                    <p class="text-gray-800">{{ $record->email }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Registered On</label>
                    <p class="text-gray-800">{{ $record->created_at ? $record->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-[#8B0000] mb-4">Academic Information</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Faculty</label>
                    <p class="text-gray-800">{{ $record->faculty ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Faculty Code</label>
                    <p class="text-gray-800">{{ $record->faculty_code ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Program</label>
                    <p class="text-gray-800">{{ $record->program ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Year of Study</label>
                    <p class="text-gray-800">{{ $record->year_of_study ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Voting Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-[#8B0000] mb-4">Voting Status</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Has Voted</label>
                    <div>
                        @if($record->has_voted)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Yes, voted
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> Not yet voted
                            </span>
                        @endif
                    </div>
                </div>
                @if($record->has_voted)
                <div>
                    <label class="text-sm font-semibold text-gray-500">Voted At</label>
                    <p class="text-gray-800">{{ $record->voted_at ? \Carbon\Carbon::parse($record->voted_at)->format('d M Y, h:i A') : 'N/A' }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Biometric Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-[#8B0000] mb-4">Biometric Status</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Fingerprint</label>
                    <div>
                        @if($record->fingerprint_hash)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-fingerprint mr-1"></i> Registered
                            </span>
                            <p class="text-xs text-gray-500 mt-1">Registered on {{ $record->fingerprint_registered_at ? \Carbon\Carbon::parse($record->fingerprint_registered_at)->format('d M Y') : 'N/A' }}</p>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Not registered
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex gap-3">
        @if(!$record->has_voted)
            <a href="{{ VoterResource::getUrl('voting', ['record' => $record]) }}" 
               class="inline-flex items-center px-4 py-2 bg-[#8B0000] text-white rounded-lg hover:bg-[#6a0000] transition">
                <i class="fas fa-vote-yea mr-2"></i> Cast Vote
            </a>
        @endif
        <a href="{{ VoterResource::getUrl('edit', ['record' => $record]) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <a href="{{ VoterResource::getUrl('index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>
</x-filament::page>
