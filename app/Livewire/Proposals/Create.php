<?php

namespace App\Livewire\Proposals;

use App\Models\Project;

use Livewire\Component;

class Create extends Component
{
    public bool $modal = true;
    public Project $project;
    public string $email = '';
    public int $hours = 0;

    public function render()
    {
        return view('livewire.proposals.create');
    }

    public function save()
    {
        $this->project->proposals()
            ->updateOrCreate(
                ['email' => $this->email],
                ['hours' => $this->hours],
            );
    }
}
