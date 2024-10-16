<?php

namespace App\Livewire;

use App\Traits\HasSessionAuthentication;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class LoginWithPin extends Component
{
    use HasSessionAuthentication;
    public $title = "Login With Pin";

    public $pin, $email_by_device;

    public function boot()
    {
        $response = $this->API_get(
            'get-device-uuid',
            ['device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName())]
        );
        if ($response->ok()) {
            $response_body = json_decode($response->body());
            $this->email_by_device = $response_body->email;
        }
    }
    public function render()
    {
        return view('livewire.authentication.login-with-pin')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }

    public function login()
    {
        if ($this->AUTH_loginWithPin($this)) {
            return redirect('/home');
        };
        return redirect('/');
    }
}
