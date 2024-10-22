<?php

namespace App\Livewire\Authentication;

use App\Traits\HasApiConfiguration;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Login extends Component
{
    use HasSessionAuthentication;
    public $title = "Login";

    public $email, $password, $remember, $email_by_device;

    public function boot()
    {
        $response = $this->API_get(
            'renew-session',
        );
        if ($response->ok()) {
            session()->flash('logged_in');
            return redirect('/home');
        }

        $response = $this->API_get(
            'get-device-uuid',
            ['device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName())]
        );
        if ($response->ok()) {
            $response_body = json_decode($response->body());
            $this->email_by_device = $response_body->email;
        }
        if (session()->has('error')) {
            $this->dispatch('notify', type: 'error', message: session()->get('error'));
        }
        if (session()->has('logged_out')) {
            $this->dispatch('notify', type: 'success', message: session()->get('logged_out'));
        }
    }
    public function render()
    {
        return view('livewire.authentication.login')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }

    public function login()
    {
        $login = $this->AUTH_login($this);
        if ($login->status == 200) {
            session()->flash('welcome');
            return redirect('/home');
        };
        session()->flash('error', $login->data->message);
        return redirect('/');
    }
}
