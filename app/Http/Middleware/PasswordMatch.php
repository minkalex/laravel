<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PasswordMatch
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next): RedirectResponse
    {
        if ($request->input('password') !== $request->input('repeat_password')) {
            return back()->withErrors(['repeat' => 'Пароли не совпадают.',])->withInput();
        }
        return $next($request);
    }
}
