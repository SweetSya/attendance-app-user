<?php

namespace App\Livewire\Authentication;

use Livewire\Component;

class Login extends Component
{
    public $title = "Login";
    public function render()
    {
        return view('livewire.authentication.login')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }
}
