<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RefreshDeviceUUID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $device = Cookie::get($this->COOKIES_getDeviceUUIDSessionName(), '');
        if (!$device) {
            Cookie::queue($this->COOKIES_getDeviceUUIDSessionName(), Str::uuid(), Carbon::now()->addMonths(6)->getTimestampMs());
        } else {
            Cookie::queue($this->COOKIES_getDeviceUUIDSessionName(), $device, Carbon::now()->addMonths(6)->getTimestampMs());
        }
        return $next($request);
    }

    public function COOKIES_getDeviceUUIDSessionName()
    {
        return env('APP_DEVICE_UUID_COOKIES_NAME');
    }
}
