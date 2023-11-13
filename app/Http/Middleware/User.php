<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserType;
use App\Enums\Status;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->type == UserType::USER && $request->user()->status == Status::ACTIVE) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }
}
