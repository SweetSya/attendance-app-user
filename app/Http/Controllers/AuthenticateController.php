<?php

namespace App\Http\Controllers;

use App\Traits\HasSessionAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthenticateController extends Controller
{
    use HasSessionAuthentication;
    public function logout(Request $request)
    {
        $checked = $request->has('wipe_session') ? true : false;
        $response = $this->AUTH_logout($checked);
        if ($response->status == 200) {
            $request->session()->invalidate();
            // Forget authentication token cookie
            session()->flash('success', 'Berhasil logout, selamat melanjutkan aktivitas!');
            $cookie = Cookie::forget($this->COOKIES_getSessionName());
            return redirect('/')->withCookie($cookie);
        }
    }

    public function verify_email(Request $request)
    {
        // Check for q in url
        if (!$request->has('q')) {
            session()->flash('error', 'Tidak dapat memverifikasi token verifikasi email');
            return redirect('/');
        }
        $token = $request->q;
        // Check for q in database
        $response =  $this->API_getJSON(
            'verify-email',
            [
                'q' => $token
            ]
        );
        if ($response->status != 200) {
            session()->flash('error', $response->data->message);
        } else {
            session()->flash('success', $response->data->message);
        }
        $response = $this->API_get(
            'renew-session',
        );
        if ($response->ok()) {
            return redirect('/home');
        } else {
            return redirect('/');
        }
    }
}
