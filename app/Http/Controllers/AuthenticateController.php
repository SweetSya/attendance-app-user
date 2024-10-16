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
        if ($this->AUTH_logout($checked)) {
            $request->session()->invalidate();
            // Forget authentication token cookie
            $cookie = Cookie::forget($this->COOKIES_getSessionName());

            return redirect('/')->withCookie($cookie);
        }
    }
}
