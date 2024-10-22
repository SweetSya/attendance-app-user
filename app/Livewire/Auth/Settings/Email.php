<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Livewire\Component;

class Email extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Email';
    public $email;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/settings/email')->data;
        $this->email = $data->email;
        $this->original = $data;
    }
    public function render()
    {
        return view('livewire.auth.settings.email')->layout('components.layouts.app', [
            'title' => $this->title
        ]);
    }
    public function change_email()
    {
        $response = $this->API_post('view/settings/email/change', [
            'email' => $this->email,
        ]);
        if (!$response->ok()) {
            dd($response);
        }
        $this->dispatch('notify', type: 'success', message: 'Perubahan berhasil disimpan');
        $this->refresh();
    }
}
