<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Avantage;
use App\Models\Boutique;
use App\Models\Historique;
use App\Models\Personne;
use App\Models\Tarif;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdministrateursController extends Controller
{
    public function Index()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $this->CreateHistorique("Connexion", "Connexion de l'administrateur " . $admin->Pseudo . ".");
        return view('admin.pages.dashboard', compact('admin'));
    }

    public function CreateHistorique($libelle, $description)
    {
        Historique::create([
            'Libelle' => $libelle,
            'Description' => $description,
            'DateOperation' => now(),
        ]);
    }

    #region Ajout d'administrateur
    public function AddAdmin(Request $request)
    {
        $this->validate(
            $request,
            [
                'Nom' => ['required'],
                'Prenom' => ['required'],
                'Contact' => ['required'],
                'Adresse' => ['required'],
                'Pseudo' => ['required', 'unique:utilisateurs'],
                'Email' => ['required', 'email', 'unique:personnes'],
                'Password' => ['required', 'min:6', 'max:12'],
            ]
        );
        Personne::create([
            'Nom' => $request->input('Nom'),
            'Prenom' => $request->input('Prenom'),
            'Adresse' => $request->input('Adresse'),
            'Contact' => $request->input('Contact'),
            'Email' => $request->input('Email'),
        ]);
        $id = Personne::where('Email', '=', $request->input('Email'))->first()->id;
        Utilisateur::create(
            [
                'id' => $id,
                'Pseudo' => $request->input('Pseudo'),
                'Password' => Hash::make($request->input('Password')),
                'Role' => 'Admin'
            ]
        );
        $this->CreateHistorique("Ajout d'administrateur", "Administrateur " . $request->input('Pseudo') . " à été ajouté");
        return back()->with('success', 'Enregistrement réussi.');
    }

    #endregion

    #region Déconnexion
    public function LogOut()
    {
        if (session()->has('logged')) {
            $this->CreateHistorique("Déconnexion", "Déconnexion de l'administrateur " . Utilisateur::find(session()->get('logged'))->Pseudo . ".");
            session()->pull('logged');
            return redirect()->route('Index');
        }
    }

    #endregion

    #region Abonnement
    public function Abonnements()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $abonnements = Abonnement::join('tarifs', 'tarifs.id', '=', 'abonnements.Tarif_id')
            ->join('personnes', 'abonnements.User_Id', '=', 'personnes.id')
            ->join('boutiques', 'boutiques.id', '=', 'personnes.id')
            ->where('abonnements.Etat', '<>', '1')
            ->where('boutiques.Etat', '<>', '1')
            ->where('personnes.Etat', '<>', '1')
            ->where('tarifs.Etat', '<>', '1')
            ->select('abonnements.*', 'tarifs.Libelle as Tarif', 'personnes.Nom', 'personnes.Prenom', 'boutiques.Nom as Boutique')
            ->orderby('DateAbonnement', 'desc')
            ->paginate(5);
        return view('admin.pages.Abonnements.lister', compact('admin', 'abonnements'));
    }

    public function AbonnementSearch(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $date = " ";
        if ($request->input('Date')) {
            $date = $request->input('Date');
            if (isset($request['Formule']))
                $formule = $request->input('Formule');
            $abonnements = Abonnement::join('tarifs', 'tarifs.id', '=', 'abonnements.Tarif_id')
                ->join('personnes', 'abonnements.User_Id', '=', 'personnes.id')
                ->join('boutiques', 'boutiques.id', '=', 'personnes.id')
                ->where('abonnements.Etat', '<>', '1')
                ->where('boutiques.Etat', '<>', '1')
                ->where('personnes.Etat', '<>', '1')
                ->where('tarifs.Etat', '<>', '1')
                ->whereDate('DateAbonnement', $date)
                ->where('tarifs.Libelle', 'LIKE', '%' . $formule . '%')
                ->select('abonnements.*', 'tarifs.Libelle as Tarif', 'personnes.Nom', 'personnes.Prenom', 'boutiques.Nom as Boutique')
                ->orderby('DateAbonnement', 'desc')
                ->paginate(5);

            return view('admin.pages.Abonnements.lister', compact('admin', 'abonnements'))->with('Info',"Recherche sur l'abonnement ayant pour date : ".$date." et pour formule ".$formule);
        } else
        if (isset($request['Formule']))
            $formule = $request->input('Formule');
        $abonnements = Abonnement::join('tarifs', 'tarifs.id', '=', 'abonnements.Tarif_id')
            ->join('personnes', 'abonnements.User_Id', '=', 'personnes.id')
            ->join('boutiques', 'boutiques.id', '=', 'personnes.id')
            ->where('abonnements.Etat', '<>', '1')
            ->where('boutiques.Etat', '<>', '1')
            ->where('personnes.Etat', '<>', '1')
            ->where('tarifs.Etat', '<>', '1')
            ->where('tarifs.Libelle', 'LIKE', '%' . $formule . '%')
            ->select('abonnements.*', 'tarifs.Libelle as Tarif', 'personnes.Nom', 'personnes.Prenom', 'boutiques.Nom as Boutique')
            ->orderby('DateAbonnement', 'desc')
            ->paginate(5);

        return view('admin.pages.Abonnements.lister', compact('admin', 'abonnements'))->with('Info',"Recherche sur l'abonnement ayant pour formule ".$formule);
    }

    #endregion

    #region Formule
    public function Formules()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $formules = DB::table('tarif_avantage')
            ->join('avantages', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
            ->select('tarifs.*', DB::raw('count(tarif_avantage.id) as nbr'))
            ->where('tarifs.Etat', '0')
            ->groupBy('tarifs.id', 'tarifs.DureeTarif', 'tarifs.DateAjout', 'tarifs.Prix', 'tarifs.Libelle', 'tarifs.Description')
            ->paginate(5);
        return view('admin.pages.Formules.lister', compact('admin', 'formules'));
    }

    public function AddFormulePage()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $avantages = Avantage::where('Etat', '0')->get();
        return view('admin.pages.Formules.ajouter', compact('admin', 'avantages'));
    }

    public function FormuleDetails($id)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $data = DB::table('tarif_avantage')
            ->join('avantages', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
            ->where('tarifs.id', $id)
            ->where('tarifs.Etat', '0')
            ->select('tarifs.*')
            ->first();
        $avantages = DB::table('avantages')
            ->join('tarif_avantage', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->where('tarif_id', $id)
            ->where('avantages.Etat', '0')
            ->select('avantages.*')
            ->get();

        return view('admin.pages.Formules.details', compact('admin', 'data', 'avantages'));
    }

    public function FormuleSearch(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $libelle = " ";
        $description = " ";
        if (isset($request['Libelle']))
            $libelle = $request->input('Libelle');
        if (isset($request['Description']))
            $description = $request->input('Description');
        $formules = DB::table('tarif_avantage')
            ->join('avantages', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
            ->select('tarifs.*', DB::raw('count(tarif_avantage.id) as nbr'))
            ->where('tarifs.Etat', '0')
            ->groupBy('tarifs.id', 'tarifs.DureeTarif', 'tarifs.DateAjout', 'tarifs.Prix', 'tarifs.Libelle', 'tarifs.Description')
            ->where('tarifs.Libelle', 'LIKE', '%' . $libelle . '%')->where('tarifs.Description', 'LIKE', '%' . $description . '%')->paginate(5);
        if ($libelle != " " && $description == " ")
            $this->CreateHistorique("Recherche de formule d'abonnement", "La formule ayant pour libellé " . $libelle . " à été recherchée.");
        else
            if ($libelle == " " && $description != " ")
            $this->CreateHistorique("Recherche de formule d'abonnement", "La formule ayant pour description " . $description . " à été recherchée.");
        else
            if ($libelle != " " && $description != " ")
            $this->CreateHistorique("Recherche de formule d'abonnement", "La formule ayant pour libelle " . $request->input('Libelle') . " et description " . $description . "à été recherchée.");
        return view('admin.pages.Formules.lister', compact('admin', 'formules'));
    }

    public function DeleteFormule($id)
    {
        $formule = Tarif::find($id);
        $formule->Etat = 1;
        $formule->update();
        return redirect()->route('Admin.Formule.List')->with('success', 'La formule ' . $formule->Libelle . ' a bien été supprimée.');
    }

    public function AddFormule(Request $request)
    {
        $this->validate($request, [
            'Libelle' => ['unique:tarifs'],
            'Description' => ['unique:tarifs'],
            'Prix' => ['min:0'],
            'Duree' => ['min:1'],
        ]);
        Tarif::create([
            'Libelle' => $request->input('Libelle'),
            'Description' => $request->input('Description'),
            'Prix' => $request->input('Prix'),
            'DureeTarif' => $request->input('Duree'),
            'DateAjout' => now()
        ]);
        $avantages = $request->input('Avantages');
        $tarif_id = Tarif::where('Libelle', $request->input('Libelle'))->first()->id;
        foreach ($avantages as $value)
            DB::insert('insert into tarif_avantage(tarif_id, avantage_id) values(?,?)', [$tarif_id, $value]);
        $this->CreateHistorique("Création de formule d'abonnement", "La formule " . $request->input('Libelle') . " à été ajoutée.");
        return redirect()->route('Admin.Formule.AddPage')->with('success', 'Ajout réussie de la formule ' . $request->input('Libelle') . ' réussie');
    }

    public function UpdateFormulePage($id)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $data = DB::table('tarif_avantage')
            ->join('avantages', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->join('tarifs', 'tarif_avantage.tarif_id', '=', 'tarifs.id')
            ->where('tarifs.id', $id)
            ->where('tarifs.Etat', '0')
            ->select('tarifs.*')
            ->first();
        $avantage = DB::table('avantages')
            ->join('tarif_avantage', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->where('tarif_id', $id)
            ->where('avantages.Etat', '0')
            ->select('avantages.id')
            ->get();
        $avantages = Avantage::where('Etat', '0')->get();
        return view('admin.pages.formules.modifier', compact('admin', 'data', 'avantages', 'avantage'));
    }

    public function UpdateFormule(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $formule = Tarif::find($request->input('Id'));
        $oldLibelle = $formule->Libelle;
        $oldDescription = $formule->Description;
        $oldPrix = $formule->Prix;
        $oldDuree = $formule->DureeTarif;
        $this->validate($request, [
            'Description' => ['required'],
            'Prix' => ['required', 'min:1'],
            'Duree' => ['min:1'],
            'Avantages' => ['required'],
        ]);
        if ($oldLibelle != $formule->Libelle)
            $this->validate($request, [
                'Libelle' => ['unique:tarifs']
            ]);
        $oldAvantages = DB::table('avantages')
            ->join('tarif_avantage', 'tarif_avantage.avantage_id', '=', 'avantages.id')
            ->where('tarif_id', $formule->id)
            ->where('avantages.Etat', '0')
            ->select('avantages.*')
            ->get();

        $tarif_avantages = DB::table('tarif_avantage')->where('tarif_id', $formule->id)->get();
        $newAvantages = $request->input('Avantages');
        foreach ($tarif_avantages as $key)
            DB::table('tarif_avantage')->delete($key->id);
        foreach ($newAvantages as $value)
            DB::insert('insert into tarif_avantage(tarif_id, avantage_id) values(?,?)', [$formule->id, $value]);
        $formule->Libelle = $request->input('Libelle');
        $formule->Description = $request->input('Description');
        $formule->DureeTarif = $request->input('Duree');
        $formule->Prix = $request->input('Prix');
        $formule->update();
        $message = " ";
        $modif = array();
        if ($oldDescription != $formule->Description)
            $modif[0] = "Modification de " . $oldDescription . " en " . $formule->Description . ". ";
        if ($oldLibelle != $formule->Libelle)
            $modif[1] = "Modification de " . $oldLibelle . " en " . $formule->Libelle . ". ";
        if ($oldPrix != $formule->Prix)
            $modif[2] = "Modification de " . $oldPrix . " en " . $formule->Prix . ". ";
        if ($oldDuree != $formule->DureeTarif)
            $modif[3] = "Modification de " . $oldDuree . " en " . $formule->DureeTarif . ". ";
        if (count($oldAvantages) != count($request->input('Avantages')))
            $modif[4] = "Le nombre d'avantages de la formule " . $formule->Libelle . " a été modifié.";
        $this->CreateHistorique("Mise à jour de formule d'abonnement", "La formule " . $request->input('Libelle') . " à été modifiée.");
        if (count($modif) != 0)
            return redirect()->route('Admin.Formule.UpdatePage', ['id' => $formule->id])->with('success', $modif);
        else
            return redirect()->route('Admin.Formule.UpdatePage', ['id' => $formule->id]);
    }
    #endregion

    #region Avantage
    public function AddAvantagePage()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        return view('admin.pages.Avantages.ajouter', compact('admin'));
    }

    public function UpdateAvantagePage($id)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $avantage = Avantage::find($id);
        return view('admin.pages.Avantages.modifier', compact('admin', 'avantage'));
    }

    public function SearchAvantage(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $description = " ";
        if (isset($request['Description']))
            $description = $request->input('Description');
        $avantages = Avantage::where('Description', 'LIKE', '%' . $description . '%')->paginate(5);
        return view('admin.pages.Avantages.lister', compact('admin', 'avantages'));
    }

    public function Avantages()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $avantages = Avantage::paginate(5);
        return view('admin.pages.Avantages.lister', compact('admin', 'avantages'));
    }

    public function AddAvantage(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $this->validate($request, [
            'Description' => ['required']
        ]);
        $avantage = Avantage::where('Description', $request->input('Description'))->first();
        if ($avantage) {
            $avantage->Etat = 0;
            $avantage->update();
        } else {
            Avantage::create([
                'Description' => $request->input('Description')
            ]);
        }
        return redirect()->route('Admin.Avantage.AddPage', compact('admin'))->with("success", "Ajout de l'avantage " . $request['Description'] . " réussie");
    }

    public function AvantageDelete($id)
    {
        $avantage = Avantage::find($id);
        $avantage->Etat = 1;
        $avantage->update();
        return redirect()->route('Admin.Avantage.List')->with('success', "Suppression de l'avantage " . $avantage->Description . " réussie.");
    }

    public function AvantageUpdate(Request $request)
    {
        $this->validate($request, [
            'Description' => ['required'],
        ]);
        $avantage = Avantage::find($request->input('Id'));
        $old = $avantage->Description;
        $avantage->Description = $request->input('Description');
        $avantage->update();
        return redirect()->route('Admin.Avantage.List')->with('success', "Modification de l'avantage " . $old . " en " . $avantage->Description . " réussie.");
    }

    public function AvantageHide($id)
    {
        $avantage = Avantage::find($id);
        $avantage->Etat = 2;
        $avantage->update();
        return redirect()->route('Admin.Avantage.List')->with('success', "L'avantage " . $avantage->Description . " a bien été masqué.");
    }

    public function AvantageRestore($id)
    {
        $avantage = Avantage::find($id);
        $avantage->Etat = 0;
        $avantage->update();
        return redirect()->route('Admin.Avantage.List')->with('success', "L'avantage " . $avantage->Description . " a bien été restauré.");
    }
    #endregion

    #region Historique
    public function HistoriqueSearch(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $description = " ";
        $libelle = " ";
        if (isset($request['Description']))
            $description = $request->input('Description');
        if (isset($request['Libelle']))
            $libelle = $request->input('Libelle');
        $historiques = Historique::orderBy('DateOperation', 'desc')->where('Description', 'LIKE', '%' . $description . '%')->where('Libelle', 'LIKE', '%' . $libelle . '%')->paginate(5);
        return view('admin.pages.Historiques.lister', compact('admin', 'historiques'));
    }

    public function Historiques()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $historiques = Historique::orderBy('DateOperation', 'desc')->where('Etat', '0')->orderBy('DateOperation', 'asc')->paginate(5);
        return view('admin.pages.Historiques.lister', compact('admin', 'historiques'));
    }

    public function HistoriqueDelete($id)
    {
        $historique = Historique::find($id);
        $historique->Etat = 1;
        $historique->update();
        return redirect()->route('Admin.Historique.List')->with('success', "L'historique " . $historique->Description . " a bien été supprimée.");
    }

    #endregion

    #region Utilisateur
    public function Utilisateur()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $users = DB::table('utilisateurs')
            ->join('boutiques', 'boutiques.id', 'utilisateurs.BoutiqueId')
            ->join('personnes', 'personnes.id', 'utilisateurs.id')
            ->select('utilisateurs.Pseudo', 'personnes.*', 'boutiques.Nom as boutique')
            ->where('personnes.Etat', '<>', 1)
            ->where('Role', '<>', 'Admin')->paginate(5);
        return view('admin.pages.Users.lister', compact('admin', 'users'));
    }

    public function UtilisateurSearch(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $nom = " ";
        $pseudo = " ";
        $email = " ";
        $boutique = " ";
        $prenom = " ";
        if (isset($request['Nom']))
            $nom = $request->input('Nom');
        if (isset($request['Prenom']))
            $prenom = $request->input('Prenom');
        if (isset($request['Pseudo']))
            $pseudo = $request->input('Pseudo');
        if (isset($request['Boutique']))
            $boutique = $request->input('Boutique');
        if (isset($request['Email']))
            $email = $request->input('Email');
        $users = DB::table('utilisateurs')
            ->join('boutiques', 'boutiques.id', 'utilisateurs.BoutiqueId')
            ->join('personnes', 'personnes.id', 'utilisateurs.id')
            ->where('personnes.Nom', 'LIKE', '%' . $nom . '%')
            ->where('Prenom', 'LIKE', '%' . $prenom . '%')
            ->where('personnes.Etat', 0)
            ->where('boutiques.Etat', 0)
            ->where('personnes.Email', 'LIKE', '%' . $email . '%')
            ->where('pseudo', 'LIKE', '%' . $pseudo . '%')
            ->where('boutiques.Nom', 'LIKE', '%' . $boutique . '%')
            ->select('utilisateurs.Pseudo', 'personnes.*', 'boutiques.Nom as boutique')
            ->paginate(5);
        $this->CreateHistorique("Recherche", "Recherche sur l'utilisateur : Nom = " . $nom . ", Prénom : " . $prenom . ", Email : " . $email . ", Pseudo : " . $pseudo . ", Boutique :" . $boutique . ".");
        return view('admin.pages.Users.lister', compact('admin', 'users'));
    }
    #endregion

    #region Boutique
    public function Boutiques()
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $boutiques = DB::table('boutiques')
            ->join('utilisateurs', 'boutiques.id', '=', 'utilisateurs.BoutiqueId')
            ->where('Etat', 0)
            ->select('boutiques.*', DB::raw('count(utilisateurs.id) as nbr'))
            ->groupBy('boutiques.id', 'Nom', 'Site', 'Adresse', 'Email', 'DateAjout', 'boutiques.Etat')
            ->paginate(5);
        return view('admin.pages.Boutiques.lister', compact('admin', 'boutiques'));
    }

    public function BoutiqueDetails($id)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $boutique = Boutique::find($id);
        $users = DB::table('personnes')
            ->join('utilisateurs', 'personnes.id', '=', 'utilisateurs.id')
            ->where('personnes.Etat', 0)
            ->where('BoutiqueId', $id)
            ->select('personnes.*', 'utilisateurs.Pseudo', 'utilisateurs.Role')
            ->paginate(5);
        $usersId = array();
        $u = 0;
        foreach ($users as $keys => $vals) {
            $usersId[$u] = $vals->id;
            $u = $u + 1;
        }
        $abonnements = DB::table('abonnements')
            ->join('tarifs', 'tarif_id', '=', 'tarifs.id')
            ->select('abonnements.*', 'Libelle')
            ->whereIn('abonnements.User_id', $usersId)
            ->orderBy('DateAbonnement', 'desc')
            ->paginate(5);
        $this->CreateHistorique("Détails", "Obtention des détails sur la boutique " . $boutique->Nom);
        return view('admin.pages.Boutiques.details', compact('admin', 'boutique', 'users', 'abonnements'));
    }

    private static $ordre = "";
    public function TrieBoutique(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $trie = " ";
        $ordre = $request->input('Order');
        if (isset($request['Trie'])) {
            AdministrateursController::$ordre = $ordre;
            $trie = $request->input('Trie');
            $ordre = $request->input('Order');
            $boutiques = DB::table('boutiques')->orderBy($trie, AdministrateursController::$ordre)->paginate(5);
            return view('admin.pages.Boutiques.lister', compact('admin', 'boutiques'));
        }
        return redirect()->route('Admin.Boutique.List');
    }

    public function RechercheBoutique(Request $request)
    {
        $admin = Utilisateur::find(Session::get('logged'));
        $nom = " ";
        $adresse = " ";
        $email = " ";
        $site = " ";
        if (isset($request['Nom']))
            $nom = $request->input('Nom');
        if (isset($request['Adresse']))
            $adresse = $request->input('Adresse');
        if (isset($request['Email']))
            $email = $request->input('Email');
        if (isset($request['Site']))
            $site = $request->input('Site');
        $boutiques = DB::table('boutiques')
            ->join('utilisateurs', 'boutiques.id', '=', 'utilisateurs.BoutiqueId')
            ->where('Etat', 0)
            ->select('boutiques.*', DB::raw('count(utilisateurs.id) as nbr'))
            ->groupBy('boutiques.id', 'Nom', 'Site', 'Adresse', 'Email', 'DateAjout', 'boutiques.Etat')
            ->where('Etat', 0)
            ->where('Nom', 'LIKE', '%' . $nom . '%')
            ->where('Site', 'LIKE', '%' . $site . '%')
            ->where('Email', 'LIKE', '%' . $email . '%')
            ->where('Adresse', 'LIKE', '%' . $adresse . '%')
            ->orderBy('DateAjout', 'desc')
            ->paginate(5);
        $this->CreateHistorique("Recherche", "Recherche sur la boutique : Nom = " . $nom . ", Site : " . $site . ", Email : " . $email . ", Adresse : " . $adresse . ".");
        return view('admin.pages.Boutiques.lister', compact('admin', 'boutiques'));
    }
    #endregion

}
