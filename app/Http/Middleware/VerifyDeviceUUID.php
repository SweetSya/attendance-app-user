<?php

namespace App\Http\Middleware;

use App\Traits\HasApiHelper;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeviceUUID
{
    use HasApiHelper;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $device = Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '');
        if ($device) {
            $response = $this->API_get(
                'check-device-uuid',
                ['device_uuid' => $device]
            );
            if ($response->ok()) {
                return $next($request);
            }
        }
        return redirect('/');
    }

    public function COOKIES_getDeviceUUIDSessionName()
    {
        return env('APP_DEVICE_UUID_COOKIES_NAME');
    }
}
