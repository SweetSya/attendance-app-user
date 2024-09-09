<?php

namespace App\Livewire\Authentication;

use Livewire\Component;

class ForgotPassword extends Component
{
    public $title = "Lupa Password";
    public function render()
    {
        return view('livewire.authentication.forgot-password')
        ->layout('components.layouts.authentication', [
            'title' => $this->title
        ]);
    }
}
