<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function Index(){
        return view('auth.login');
    }
    
    public function Login(Request $request){
        $this->validate($request,[
            'Pseudo' => ['required'],
            'Password' => ['required'],
        ]);
        $user = Utilisateur::where('Pseudo','=',$request->input('Pseudo'))->first();
        $personne = Personne::find($user->id);
        if($personne->Etat == 0){
            if($user){
                //Hash::check($request->input('Password'),$user->Password)
                if(Hash::check($request->input('Password'),$user->Password)){
                $request->session()->put('logged',$user->id);
                if($user->Role == 'Admin')
                    return redirect()->route('Admin.Home');
                return redirect()->route('User.Home');
            }else{
                return back()->with('fail','Mot de passe incorrecte');
            }
        }else{
            return back()->with('fail','Pseudo ou mot de passe incorrecte');
        }
    }
    else
        return back()->with('fail','Compte indisponible');
    }
    public function Add(){
        return view('admin.pages.Admin.ajouter');
    }
}
