<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $position = strpos(url()->current(), '/user/');

        if (false !== $position) {
            $arUrl = explode("/", url()->current());
            //user_id from url
            $needUser = $arUrl[4];
            if (Auth::id() != $needUser) {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
