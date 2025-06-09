<?php

namespace App\Http\Middleware;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class VerifySessionAuthentication
{
    use HasApiHelper, HasSessionAuthentication;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            $request->session()->invalidate();
            session()->flash('error', 'Harap autentikasi terlebih dahulu.');
            return redirect('/');
        }
        return $next($request);
    }
}
