<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-bold mb-4" style="color: #8B0000;">
            <i class="fas fa-trophy mr-2"></i>Live Election Results
        </h3>
        
        @php $results = $this->getResults(); @endphp
        
        @foreach($results as $sector => $candidates)
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">{{ $sector }}</h4>
                <div class="space-y-2">
                    @foreach($candidates as $candidate)
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ $candidate->display_name }}</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#8B0000] h-2 rounded-full" 
                                         style="width: {{ $candidate->votes_count > 0 ? ($candidate->votes_count / max($candidates->pluck('votes_count')->max(), 1)) * 100 : 0 }}%">
                                    </div>
                                </div>
                                <span class="text-sm font-bold">{{ $candidate->votes_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </x-filament::card>
</x-filament::widget>