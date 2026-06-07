<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && !$request->ajax()) {
            $ip = $request->ip();
            $date = Carbon::today()->toDateString();
            
            // Ignore some known bot user agents if necessary, but for simplicity we log all non-ajax GET requests
            Visitor::updateOrCreate(
                ['ip_address' => $ip, 'date' => $date],
                ['user_agent' => $request->userAgent()]
            )->increment('hits');
        }

        return $next($request);
    }
}
