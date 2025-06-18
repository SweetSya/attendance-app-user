<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

trait HasSessionAuthentication
{
    use HasApiHelper;

    protected $poll_fetch = 120; //in seconds
    protected $always_prefecth = true;

    public function invalidateSession($data)
    {
        session()->invalidate();
        $this->dispatch('invalidate-force-logout', message: $data->message);
    }

    public function setPageSessionRefresh(array $route_name)
    {
        $refresh_pages = Session::get('refresh_pages', []);
        foreach ($route_name as $route) {
            if (!in_array($route, $refresh_pages, true)) {
                $refresh_pages[] = $route;
                Session::put('refresh_pages', $refresh_pages);
            }
        }
    }
    public function getPageSessionData($route_name, $fetch_url, $always_prefecth = null)
    {
        if ($always_prefecth !== null) {
            $this->always_prefecth = $always_prefecth;
        }
        // Get session data
        $pages = Session::get('pages', []);
        $refresh_pages = Session::get('refresh_pages', []);
        $shouldFetch = $this->always_prefecth || !isset($pages[$route_name]) || in_array($route_name, $refresh_pages) || $pages[$route_name]->last_fetch < Carbon::now()->subSeconds($this->poll_fetch)->timestamp;

        if ($shouldFetch) {
            $response = $this->API_get($fetch_url);

            if ($response->ok()) {
                $data = json_decode($response->body());
                if ($data) {
                    $data->last_fetch = Carbon::now()->timestamp;
                    $pages[$route_name] = $data;
                    Session::put('pages', $pages);
                }
            } else {
                $error_data = json_decode($response->body());
                if ($response->status() === 401 && $error_data && isset($error_data->reason) && $error_data->reason === 'Unauthorized') {
                    $pages = Session::get('pages', []);
                    $pages[$route_name]->error = $error_data->reason ?? 'Unauthorized';
                    $pages[$route_name]->message = $error_data->message ?? 'Sesi telah berakhir atau double';
                    return $pages[$route_name] ?? null;
                }
                // Return error data for other errors as well
                $pages = Session::get('pages', []);
                $pages[$route_name]->error = $error_data->reason ?? 'Error';
                $pages[$route_name]->message = $error_data->message ?? 'Terjadi kesalahan';
                return $pages[$route_name] ?? null;
            }

            // Remove from refresh list if present
            if (in_array($route_name, $refresh_pages)) {
                $refresh_pages = array_diff($refresh_pages, [$route_name]);
                Session::put('refresh_pages', $refresh_pages);
            }
        }

        // Always return the latest data from session
        $pages = Session::get('pages', []);
        return $pages[$route_name] ?? null;
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
