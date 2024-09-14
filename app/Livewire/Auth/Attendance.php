<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Attendance extends Component
{
    public $title = "Absensi";
    public function render()
    {
        return view('livewire.auth.attendance')
            ->layout('components.layouts.app', [
                'title' => $this->title
            ]);
        ;
    }
}
