<?php

namespace App\Livewire\Authentication;

use App\Traits\HasApiConfiguration;
use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        //    Check if the user is already logged in
        if (Auth::check()) {
            session()->flash('logged_in');
            return redirect('/home');
        }
        if (session()->has('error')) {
            $this->dispatch('notify', type: 'error', message: session()->get('error'));
        }
        if (session()->has('success')) {
            $this->dispatch('notify', type: 'success', message: session()->get('success'));
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
        $attempt = Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ]);
        if ($attempt) {
            // If login is successful, redirect to home
            session()->flash('welcome');
            // Before login, try to prefetch the pages data for attendance and home
            $this->getPageSessionData('home', 'view/home');
            $this->getPageSessionData('attendance', 'view/attendance');

            return redirect()->intended('/home');
        }
        // If login fails, flash an error message
        $this->dispatch('notify', type: 'error', message: 'Email atau password salah.');
    }
}
