<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use App\Notifications\NewProposal;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public bool $modal = true;
    public Project $project;

    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required', 'numeric', 'gt: 0'])]
    public int $hours = 0;

    public bool $agree = false;

    public function render()
    {
        return view('livewire.proposals.create');
    }

    public function save()
    {
        $this->validate();

        if (!$this->agree) {
            $this->addError('agree', 'Você precisa concordar com os termos de uso.');
            return;
        }

        $this->project->proposals()
            ->updateOrCreate(
                ['email' => $this->email],
                ['hours' => $this->hours],
            );
        
        $this->project->author->notify(new NewProposal($this->project));
        $this->dispatch('proposal::created');
        $this->modal = false;
    }
}
