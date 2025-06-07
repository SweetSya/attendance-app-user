<?php

namespace App\Auth;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class EmployeeApiProvider implements UserProvider
{
    use HasApiHelper, HasSessionAuthentication;
    public function retrieveById($identifier)
    {
        // This method is called from subsequent calls until the session expires.
        //
        // As you don't have a local users database we are going
        // to assume the identifier saved into the session is fine.
        //
        // Session cookies are encrypted by default
        //
        // This avoid calling the external service on every navigation.
        //
        // The downside is that if the user is not authorized anymore
        // in the external service, you won't know until their session expires.
        //
        // Ideally you should set a lower session duration so user
        // gets logged out quickier.
        //
        // An alternative is to save encrypted the user's credentials
        // and call the external service every time.
        //
        // But that would make a external API call on every request,
        // making your app slower. But is the most secure way.
        //
        // If you want I can make an modified version exemplifying 
        // how you could do this.
        return new GenericUser([
            'id' => $identifier,
            'email' => $identifier,
        ]);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token) {}

    public function retrieveByCredentials(array $credentials)
    {
        if (! array_key_exists('email', $credentials)) {
            return null;
        }

        // GenericUser is a class from Laravel Auth System
        return new GenericUser([
            'id' => $credentials['email'],
            'email' => $credentials['email'],
        ]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (! array_key_exists('password', $credentials)) {
            return false;
        }
        // This is a simplified usage of Laravel's HTTP Client to call the external API
        // You might need to send more info to the external service.
        // Please refer to the HTTP Client docs to learn how to use it properly.
        $response = $this->API_post(
            'login',
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'device_uuid' => Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '')
            ]
        );
        return $response->ok();
    }
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        return '';
    }
}
