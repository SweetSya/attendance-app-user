<?php

namespace App\Livewire\Auth\Settings;

use App\Livewire\BaseComponent;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Livewire\Component;

class Password extends BaseComponent
{
    use HasApiHelper, HasSessionAuthentication;

    protected $route_name = 'settings/password';
    protected $api_url = 'view/settings/password';

    public $title = 'Pengaturan - Password';
    public $password, $re_password, $old_password;
    public $original;
    public function boot()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $this->password = '';
        $this->re_password = '';
        // $this->old_password = '';
    }

    public function render()
    {
        return view('livewire.auth.settings.password', [
            'title' => $this->title
        ]);
    }
    public function change_password()
    {
        if ($this->password != $this->re_password) {
            $this->dispatch('notify', type: 'error', message: 'Konfirmasi password tidak sesuai');
            return;
        }
        $response = $this->API_post('view/settings/password/change', [
            // 'old_password' => $this->old_password,
            'password' => $this->password,
        ]);
        if (!$response->ok()) {
            dd(json_decode($response->body()));
        }
        $this->dispatch('notify', type: 'success', message: 'Perubahan berhasil disimpan');
        $this->refresh();
    }
}
