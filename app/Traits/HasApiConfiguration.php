<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

trait HasApiConfiguration
{
    // Get public token used for end user program in ENV
    protected function API_getPublicToken()
    {
        return env('APP_API_PUBLIC_TOKEN');
    }
    // Function below are specialize to fetch
    // data from the ENV
    protected function API_getHost()
    {
        return env('APP_API_HOST');
    }
    protected function API_getVersion()
    {
        return env('APP_API_VERSION');
    }
    protected function API_getModel()
    {
        return env('APP_API_MODEL');
    }
    // Prepare URL for API call
    public function API_getURL($target_url)
    {
        $routes = [
            $this->API_getHost(),
            'api',
            $this->API_getModel(),
            $this->API_getVersion(),
            $target_url
        ];
        return implode('/', $routes);
    }
    // Prepare API call's header, becuase each call need to be verified
    // in the parent or data server by defining some properties below
    protected function API_getHeader()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->API_getPublicToken(),
            'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
            'IP-Address' => Request::ip(),
        ];
        // Check if employee are already logged in
        if (Auth::check() && Session::has('employee_access')) {
            // If it is then push the authorization token in the header
            // because some api gate need the employee to be logged in or authorize first
            $header['Employee-Authorization-Token'] = Session::get('employee_access')['auth_access_token'];
        }
        return $header;
    }
    protected function COOKIES_getSessionName()
    {
        return env('APP_API_AUTH_COOKIES_NAME');
    }
    public function COOKIES_getDeviceUUIDSessionName()
    {
        return env('APP_DEVICE_UUID_COOKIES_NAME');
    }
}
