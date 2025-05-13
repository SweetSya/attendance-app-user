<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FaceBiometric extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Biometrik Wajah';
    public $password = '';
    private $current_password = '$2y$10$ka25Q/rPht/kA78.l4LYTusHYeoTCIGWlJMEzRwTCJxiWA7QO/Fam';
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        // $data = $this->API_getJSON('view/settings/email')->data;
        // $this->email = $data->email;
        // $this->verified_at = $data->verified_at;
        // $this->original = $data;
    }
    public function render()
    {
        return view('livewire.auth.settings.face-biometric')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function match_password()
    {
        if (Hash::check($this->password, $this->current_password)) {
            return true;
        }
        return false;
    }
}
