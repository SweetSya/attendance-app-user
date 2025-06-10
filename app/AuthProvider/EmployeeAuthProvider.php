<?php

namespace App\AuthProvider;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class EmployeeAuthProvider implements UserProvider
{
    use HasSessionAuthentication, HasApiHelper;

    public function retrieveById($identifier)
    {
        // You can:
        // 1. Re-fetch user data from your API using the ID (preferred in production)
        // 2. OR retrieve it from the session (fast & simple, works only if session has it)

        $authData = Session::get('employee_access');

        if ($authData && ($authData['id'] ?? null) == $identifier) {
            return new GenericUser($authData);
        }

        // Optional: re-fetch from API if session doesn't have it
        // $response = Http::get('.../user/'.$identifier);
        // if ($response->ok()) {
        //     return new GenericUser($response->json());
        // }

        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        // Not used unless you're implementing remember tokens
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not required unless using "remember me"
    }

    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->API_post(
            'login',
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), ''),
            ]
        );
        if (!$response->ok()) {
            return null;
    }
        $authData = $response->json();
        $authData['device_uuid'] = Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '');
        // Save user data for later use in session
        Session::put('employee_access', $authData);

        // Return a user object with 'id' key
        return new GenericUser($authData);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $response = $this->API_post(
            'login',
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'remember' => $credentials['remember'] ?? false,
                'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), ''),
            ]
        );
        
        if (!$response->ok()) {
            return false;
        }

        $authData = $response->json();
        $authData['device_uuid'] = Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '');
        // Store user data in session or cache as needed
        Session::put('employee_access', $authData);
        return true;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // This method is not used in this implementation
        return false;
    }
}
