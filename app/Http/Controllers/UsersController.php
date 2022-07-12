<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function Index(){
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.dashboard',compact('user'));
    }
}
