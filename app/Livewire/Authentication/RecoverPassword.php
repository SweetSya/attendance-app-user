<?php

namespace App\Livewire\Authentication;

use Livewire\Component;

class RecoverPassword extends Component
{
    public $title = "Lupa Password";
    public function render()
    {
        return view('livewire.authentication.recover-password')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }
}
