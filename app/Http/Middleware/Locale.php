<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $acceptLang = $request->header('Accept-Language', 'ar') ?: 'ar';

        $locale = strtolower(trim(explode(',', $acceptLang)[0]));
        $locale = preg_replace('/[^a-z]/', '', $locale);

        $supported = ['en', 'ar'];
        if (! in_array($locale, $supported)) {
            $locale = 'ar';
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
