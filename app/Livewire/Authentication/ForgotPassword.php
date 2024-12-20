<?php

namespace App\Livewire\Authentication;

use App\Traits\HasApiHelper;
use Livewire\Component;

class ForgotPassword extends Component
{
    use HasApiHelper;
    public $title = "Lupa Password";
    public $email;

    public function boot()
    {
        if (session()->has('success')) {
            $this->dispatch('notify', type: 'success', message: session()->get('success'));
        }
        if (session()->has('error')) {
            $this->dispatch('notify', type: 'error', message: session()->get('error'));
        }
    }
    public function render()
    {
        return view('livewire.authentication.forgot-password')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }

    public function send_email()
    {
        // Check email availability
        $response =  $this->API_getJSON(
            'send-forgot-password?',
            [
                'email' => $this->email,
                'host' => env('APP_URL')
            ]
        );
        if ($response->status == 200) {
            session()->flash('success', $response->data->message);
            return redirect('/forgot-password');
        };
        session()->flash('error', $response->data->message);
        return redirect('/forgot-password');
    }
}
