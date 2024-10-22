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
            session()->flash('logged_out', 'Berhasil logout, selamat melanjutkan aktivitas!');
            $cookie = Cookie::forget($this->COOKIES_getSessionName());
            return redirect('/')->withCookie($cookie);
        }
    }
}
