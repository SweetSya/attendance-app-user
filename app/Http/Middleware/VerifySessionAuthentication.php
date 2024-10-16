<?php

namespace App\Http\Middleware;

use App\Traits\HasApiHelper;
use App\Traits\HasSessionAuthentication;
use Closure;
use Illuminate\Http\Request;
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
        // Check if token are present and valid on parent server's session,
        // if it is the update the session's expired at
        if (!$this->AUTH_check()) {
            return redirect('/');
        }

        // Check if token are valid on parent server's session
        $authed = $this->AUTH_get();
        if (!$authed) {
            return redirect('/');
        }
        return $next($request);
    }
}
