<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class History extends Component
{
    public $title = "Histori";
    public function render()
    {
        return view('livewire.auth.history')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
        ;
    }
}
