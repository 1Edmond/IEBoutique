<?php

namespace App\Http\Middleware;

use App\Models\Utilisateur;
use Closure;
use Illuminate\Http\Request;

class AdminCheck
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
        if (!session()->has('logged')) {
            return back();
        } else {
            $id = session()->get('logged');
            $user = Utilisateur::find($id);
            if ($user->Role != 'Admin')
                return back();
            if ($user->Etat != 0)
                return back();
        }
        if (!session()->has('logged') && ($request->path() != 'AddAdmin' && $request->path() != 'admin/dashboard')) {
            return redirect()->route('Admin.Index')
                ->with('fail', 'Veuillez vous connecter');
        }
        if (session()->has('logged') && ($request->path() == 'auth/admin/index')) {
            return back();
        } // A revoir

        return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
    }
}
