<?php

namespace App\Livewire\Auth;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;

class Home extends Component
{
    use HasApiHelper, HasSessionAuthentication;
    public $title = "Home";
    public $distance = 0;
    public $employee;

    public function boot()
    {
        $this->employee = $this->AUTH_get();
    }
    public function render()
    {
        return view('livewire.auth.home')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
    }
}
