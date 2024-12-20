<?php

namespace App\Livewire\Authentication;

use App\Traits\HasApiHelper;
use Illuminate\Http\Request;
use Livewire\Component;

class RecoverPassword extends Component
{
    use HasApiHelper;
    public $title = "Lupa Password";
    public $token, $password, $re_password, $data;

    public function boot(Request $request)
    {
        // Check for q in url
        if (!$request->has('q')) {
            session()->flash('error', 'Tidak dapat memverifikasi token pemulihan password');
            return redirect('/');
        }
        $this->token = $request->q;
        // Check for q in database
        $response =  $this->API_getJSON(
            'check-forgot-token',
            [
                'q' => $this->token
            ]
        );
        if ($response->status != 200) {
            session()->flash('error', $response->data->message);
            return redirect('/');
        };
        $this->data = $response->data->token;
        if (session()->has('error')) {
            $this->dispatch('notify', type: 'error', message: session()->get('error'));
        }
    }
    public function render()
    {
        return view('livewire.authentication.recover-password')
            ->layout('components.layouts.authentication', [
                'title' => $this->title
            ]);
    }
    public function change_password()
    {
        if ($this->password != $this->re_password) {
            session()->flash('error', "Password dan ulangi password tidak sama");
            return redirect('/recovery-password?q=' . $this->token);
        }
        $response =  $this->API_postJSON(
            'change-forgot-password',
            [
                'q' => $this->token,
                'password' => $this->password
            ]
        );
        if ($response->status != 200) {
            session()->flash('error', $response->data->message);
            return redirect('/recovery-password?q=' . $this->token);
        };
        session()->flash('success', $response->data->message);
        return redirect('/');
    }
}
