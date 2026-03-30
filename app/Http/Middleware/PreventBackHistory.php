<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Certains types de réponses (ex: StreamedResponse) n'ont pas ->header()
        if (method_exists($response, 'headers')) {
            $response->headers->set('Cache-Control','no-cache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma','no-cache');
            $response->headers->set('Expires','Sat, 01 Jan 1990 00:00:00 GMT');
        }

        return $response;
    }
}