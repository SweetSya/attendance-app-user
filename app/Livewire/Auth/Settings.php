<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Settings extends Component
{

    public $title = "Home";
    public function render()
    {
        return view('livewire.auth.settings')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
        ;
    }
}
