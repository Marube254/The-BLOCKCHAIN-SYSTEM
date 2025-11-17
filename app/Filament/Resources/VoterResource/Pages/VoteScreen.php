<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use App\Models\Candidate;
use App\Models\Vote;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class VoteScreen extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = VoterResource::class;

    protected static string $view = 'filament.resources.voter-resource.pages.vote-screen';


    public ?array $formData = [];
    public $voter;

    public function mount($record): void
    {
        $this->voter = $record;
        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {
        $candidates = Candidate::where('status', 'active')
            ->orderBy('sector')
            ->get()
            ->groupBy('sector');

        $sections = [];

        foreach ($candidates as $sector => $sectorCandidates) {
            $options = $sectorCandidates->mapWithKeys(function ($candidate) use ($sector) {
                $label = <<<HTML
                    <div class="flex items-center space-x-3 candidate-option border rounded-lg p-2 transition-all duration-200">
                        <img src="{$candidate->photo_filename_url}" alt="" class="w-10 h-10 rounded-full object-cover border" />
                        <div>
                            <div class="font-semibold">{$candidate->display_name}</div>
                            <div class="text-xs text-gray-500">{$candidate->program}</div>
                        </div>
                    </div>
                HTML;
                return [$candidate->id => $label];
            });

            $sections[] = Forms\Components\Section::make($sector)
                ->schema([
                    Forms\Components\Radio::make("formData.$sector")
                        ->label("Select your preferred $sector")
                        ->options($options->toArray())
                        ->required()
                        ->inline()
                        ->reactive()
                        ->extraAttributes(function () use ($sector) {
                            return [
                                'class' => 'space-y-2 w-full',
                                'x-data' => '{}',
                                'x-init' => <<<JS
                                    Livewire.on('refreshSelections', () => {
                                        document.querySelectorAll('[data-sector="{$sector}"] .candidate-option')
                                            .forEach(el => el.classList.remove('bg-green-100', 'border-green-500'));
                                        const selected = document.querySelector('[data-sector="{$sector}"] input:checked');
                                        if (selected) {
                                            selected.closest('.candidate-option')
                                                .classList.add('bg-green-100', 'border-green-500');
                                        }
                                    });
                                    Livewire.emit('refreshSelections');
                                JS,
                                'data-sector' => $sector,
                            ];
                        })
                        ->afterStateUpdated(fn () => $this->dispatch('refreshSelections')),
                ])
                ->columns(1)
                ->collapsible();
        }

        return $form->schema($sections);
    }

    #[On('fingerprint-scanned')]
    public function confirmVote(): void
    {
        $missing = collect($this->formData)->filter(fn ($v) => empty($v));
        if ($missing->count() > 0) {
            Notification::make()
                ->title('Incomplete vote')
                ->body('You must vote for each sector before confirming.')
                ->danger()
                ->send();
            return;
        }

        DB::transaction(function () {
            foreach ($this->formData as $sector => $candidateId) {
                Vote::create([
                    'voter_id' => $this->voter->id,
                    'candidate_id' => $candidateId,
                    'sector' => $sector,
                    'confirmed_at' => now(),
                    'metadata' => ['confirmation' => 'fingerprint'],
                ]);
            }

            $this->voter->update(['has_voted' => true]);
        });

        Notification::make()
            ->title('Vote successfully recorded!')
            ->success()
            ->send();

        redirect(VoterResource::getUrl('index'));
    }

    public function simulateFingerprint()
    {
        $this->dispatch('fingerprint-scanned');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('confirmVote')
                ->label('Confirm via Fingerprint (Manual)')
                ->icon('heroicon-o-finger-print')
                ->color('success')
                ->action(fn () => $this->simulateFingerprint()),
        ];
    }
}
