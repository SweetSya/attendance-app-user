<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

trait HasSessionAuthentication
{
    use HasApiHelper;
    public function AUTH_login($request)
    {
        try {
            $response = $this->API_post(
                'login',
                [
                    'email' => $request->email,
                    'password' => $request->password,
                    'remember' => $request->remember,
                    'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '')
                ]
            );
            if (!$response->ok()) {
                return redirect('/');
            }
            $response_body = json_decode($response->body());
            $this->_setCookie($response_body->auth_access_token, $response_body->expired_at);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AUTH_loginWithPIN($request)
    {
        try {
            $response = $this->API_post(
                'login-with-pin',
                [
                    'pin' => $request->pin,
                    'device_uuid' =>  Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '')
                ]
            );
            if (!$response->ok()) {
                return redirect('/');
            }
            $response_body = json_decode($response->body());
            $this->_setCookie($response_body->auth_access_token, $response_body->expired_at);
            return true;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
    public function AUTH_logout($wipe = false)
    {
        try {
            $response = $this->API_get(
                'authenticated/logout',
                [
                    'wipe' => $wipe
                ]
            );
            if ($response->ok()) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
    public function AUTH_check()
    {
        try {
            $response = $this->API_get(
                'authenticated/renew-session',
            );
            if (!$response->ok()) {
                return redirect('/');
            }
            $response_body = json_decode($response->body());
            $this->_checkCookie($response_body->auth_access_token);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AUTH_get()
    {
        try {
            $response = $this->API_get(
                'authenticated/get-session-data',
            );
            if (!$response->ok()) {
                return redirect('/');
            }
            $data = json_decode($response->body());

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
    protected function _setCookie($token, $expired_at)
    {
        Cookie::queue($this->COOKIES_getSessionName(), $token, Carbon::now()->diffInMinutes(Carbon::parse($expired_at)));
    }
    protected function _checkCookie($server_token)
    {
        $present_token = Cookie::get($this->COOKIES_getSessionName(), '');
        if ($present_token === $server_token) {
            return true;
        }
        return false;
    }
}
