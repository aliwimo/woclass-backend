<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimezoneMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $timezone = $request->header('Timezone', config('app.timezone'));
        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);

        return $next($request);
    }
}
