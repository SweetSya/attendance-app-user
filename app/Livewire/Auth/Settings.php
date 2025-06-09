<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use Livewire\Component;

class Settings extends BaseComponent
{

    public $title = "Pengaturan";
    public function render()
    {
        return view('livewire.auth.settings')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
}
