<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Không có quyền truy cập'], 403);
            }
            return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập khu vực này.');
        }

        return $next($request);
    }
}



