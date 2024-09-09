<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Home extends Component
{
    public $title = "Home";
    public function render()
    {
        return view('livewire.auth.home')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
}
