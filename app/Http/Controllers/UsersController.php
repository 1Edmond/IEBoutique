<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Avantage;
use App\Models\Categorie;
use App\Models\Entrepot;
use App\Models\Tarif;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

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
        return view('client.pages.Abonnements.ajouter', compact('user', 'formules', 'data'));
    }

    public function AddAbonnement(Request $request)
    {
        return redirect()->route('User.Paiement.Page');
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

    #region Payement
    public function PaiementPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.Paiements.ajouter', compact('user'));
    }
    #endregion

    #region Categorie

    public function Categories()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $categories = Categorie::where('Etat', 0)->get();
        return view('client.pages.Categories.lister', compact('user', 'categories'));
    }

    public function AddCategoriePage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.Categories.ajouter', compact('user'));
    }

    public function AddCategorie(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Libelle' => ['unique:categories', 'required'],
            'Description' => ['required'],
        ]);

        Categorie::create([
            'Libelle' => $request->input('Libelle'),
            'Description' => $request->input('Description'),
            'DateAjout' => now(),
            'UserId' => $user->id,
        ]);
        return redirect()->route('User.Categorie.AddPage')
            ->with('success', 'Ajout réussi de la catégorie ' . $request->input('Libelle') . ' réussie');
    }

    #endregion

    #region Entrepôt

    public function Entrepots()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        return view('client.pages.Entrepots.lister', compact('user', 'entrepots'));
    }

    public function AddEntrepotPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)->get();
        return view('client.pages.Entrepots.ajouter', compact('user', 'entrepots'));
    }

    public function AddEntrepot(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)->get();
        return view('client.pages.Entrepots.lister', compact('user', 'entrepots'));
    }

    public function EntrepotUpdate(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)->get();
        return view('client.pages.Entrepots.lister', compact('user', 'entrepots'));
    }

    public function EntrepotDelete($id)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepot = Entrepot::find($id);
        $entrepot->Etat = 1;
        $entrepot->update();
        return redirect()->route('User.Entrepot.List')->with('Success', 'Suppression de ' . $entrepot->Description . ' réussie.');
    }

    #endregion

}
