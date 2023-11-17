<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->type == UserType::ADMIN && $request->user()->status == Status::ACTIVE) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized action or you do not have administrator rights.'], 403);
    }
}
