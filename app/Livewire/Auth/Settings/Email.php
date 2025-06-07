<?php

namespace App\Livewire\Auth\Settings;

use App\Traits\HasApiHelper;
use Livewire\Component;

class Email extends Component
{
    use HasApiHelper;
    public $title = 'Pengaturan - Email';
    public $email, $verified_at;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $data = $this->API_getJSON('view/settings/email')->data;
        $this->email = $data->email;
        $this->verified_at = $data->verified_at;
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
        $response = $this->API_postJSON('view/settings/email/change', [
            'email' => $this->email,
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
    public function send_verification_email()
    {
        $response = $this->API_postJSON('send-email-verification', [
            'email' => $this->email,
            'host' => env('APP_URL')
        ]);
        if ($response->status != 200) {
            $this->dispatch('notify', type: 'error', message: $response->data->message);
            return;
        }
        $this->dispatch('notify', type: 'success', message: $response->data->message);
        $this->refresh();
    }
}
