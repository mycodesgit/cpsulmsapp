<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('web')->check()) {
            $userRole = auth()->guard('web')->user()->role;
            //dd($userRole);
            // if (in_array($userRole, [1, 2])) {
            //     if ($request->is('enmod/enrollment', 'schedmod/scheduler', 'assessmod/assessment', 'cashmod/cashiering', 'studschmod/scholarship', 'estudgrdmod/grades', 'emp/request') || $request->is('enmod/enrollment/*', 'schedmod/scheduler/*', 'assessmod/assessment/*', 'cashmod/cashiering/*', 'studschmod/scholarship/*', 'estudgrdmod/grades/*')) {
            //         return redirect()->route('home')->with('error', 'You have no permission to access this page');
            //     }
            // }
        } elseif (auth()->guard('faculty')->check()) {
            if ($request->is('emp/admission') || $request->is('emp/admission/*') || $request->is('enmod/enrollment') || $request->is('enmod/enrollment/*')) {
                return redirect()->route('home')->with('error', 'No permission to access this page');
            }
        }else {
            return redirect()->route('getLogin')->with('error', 'You have to sign in first to access this page');
        }
        
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
        // return $next($request);
    }
}
