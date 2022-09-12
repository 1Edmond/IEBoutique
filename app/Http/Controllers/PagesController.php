<?php

namespace App\Http\Controllers;

use App\Models\Avantage;
use App\Models\Personne;
use App\Models\Tarif;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function Index()
    {
        $formules = Tarif::where('Etat', '0')->get();
        $data = array();
        foreach ($formules as $key => $value) {
            $data[$value->id] = Avantage::join('tarif_avantage', 'tarif_avantage.avantage_id', '=', 'avantages.id')
                ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
                ->where('tarifs.Etat', 0)
                ->where('avantages.Etat', 0)
                ->where('tarif_avantage.Etat', 0)
                ->select('avantages.Description')
                ->where('tarifs.id', $value->id)
                ->get();
        }
        return view('index', compact('formules', 'data'));
    }

    public function SignIn(Request $request)
    {
        return view('auth.login');
    }

    public function LoginPage()
    {
        return view('auth.login');
    }

    public function SignInPageWith($id)
    {
        // dd($id);
        $formules = Tarif::where('Etat', '0')->get();
        return view('auth.signInWith', compact('formules', 'id'));
    }
    public function SignInPage()
    {
        $formules = Tarif::where('Etat', '0')->get();
        return view('auth.signIn', compact('formules'));
    }

    public function Login(Request $request)
    {
        $this->validate($request, [
            'Pseudo' => ['required'],
            'Password' => ['required'],
        ]);
        $user = Utilisateur::where('Pseudo', '=', $request->input('Pseudo'))->first();
        if ($user) {
            $personne = Personne::find($user->id);
            if ($personne->Etat == 0) {
                //Hash::check($request->input('Password'),$user->Password)
                if (Hash::check($request->input('Password'), $user->Password)) {
                    $request->session()->put('logged', $user->id);
                    if ($user->Role == 'Admin')
                        return redirect()->route('Admin.Home');
                    return redirect()->route('User.Home');
                } else {
                    return back()->with('fail', 'Pseudo ou mot de passe incorrecte');
                }
            } else {
                return back()->with('fail', 'Votre compte à été supprimé.');
            }
        } else
            return back()->with('fail', 'Compte indisponible');
    }
    public function Add()
    {
        return view('admin.pages.Admin.ajouter');
    }
}
