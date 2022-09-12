<?php

namespace App\Http\Middleware;

use App\Models\Utilisateur;
use Closure;
use Illuminate\Http\Request;

class AuthorisationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!session()->has('logged')) {
            return back();
        }
        $user = Utilisateur::find(session()->get('logged'));
        if ($user->Role !== $role) {
            $url = $request->header()['referer'];
            return response()->view('client.Other.unauthorisate',compact('url'));
        }
        return $next($request);
    }
}
