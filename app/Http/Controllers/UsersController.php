<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Avantage;
use App\Models\Tarif;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function Index()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.dashboard', compact('user'));
    }
    #region Abonnement

    public function AddAbonnementPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $formules = Tarif::where('Etat', '0')->get();
        $avantages = Avantage::join('tarif_avantage', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
            ->where('tarifs.Etat',0)
            ->where('avantages.Etat',0)
            ->where('tarif_avantage.Etat',0)
            ->select('avantages.Description')
            ->groupBy('avantages.Description');
        return view('client.pages.Abonnements.ajouter', compact('user', 'formules', 'avantages'));
    }

    public function Abonnements()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $tempId = $user->id;
        if ($user->Role != "Gérant") {
            $tempId = Utilisateur::join('personnes', 'personnes.id', '=', 'utilisateurs.id')
                ->where('BoutiqueId', $user->BoutiqueId)
                ->where('personnes.Etat', 0)
                ->where('utilisateurs.Role', 'Gérant')
                ->first()->id;
        }
        $abonnements = Abonnement::join('tarifs', 'tarifs.id', '=', 'abonnements.Tarif_id')
            ->join('personnes', 'abonnements.User_Id', '=', 'personnes.id')
            ->join('boutiques', 'boutiques.id', '=', 'personnes.id')
            ->where('abonnements.Etat', '<>', '1')
            ->where('boutiques.Etat', '<>', '1')
            ->where('personnes.Etat', '<>', '1')
            ->where('tarifs.Etat', '<>', '1')
            ->where('abonnements.User_id', $tempId)
            ->select('abonnements.*', 'tarifs.Libelle as Tarif', 'personnes.Nom', 'personnes.Prenom', 'boutiques.Nom as Boutique')
            ->orderby('DateAbonnement', 'desc')->get();
        return view('client.pages.Abonnements.lister', compact('user', 'abonnements'));
    }
    #endregion
}
