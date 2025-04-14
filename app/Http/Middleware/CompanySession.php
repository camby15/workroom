<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanySession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('selected_company_id')) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company session expired. Please login again.'
                ], 401);
            }
            return redirect()->route('auth.login')->with('error', 'Company session expired. Please login again.');
        }

        return $next($request);
    }
}
