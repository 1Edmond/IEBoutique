<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Approvisionnement;
use App\Models\Article;
use App\Models\Avantage;
use App\Models\Boutique;
use App\Models\BoutiqueHistorique;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Entrepot;
use App\Models\Fournisseur;
use App\Models\Modele;
use App\Models\Personne;
use App\Models\Tarif;
use App\Models\Utilisateur;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    private static $Informations = [];

    public static function GetInformations()
    {

        $user = Utilisateur::find(session()->get('logged'));
        $data = [];
        $articleInfo =
            Article::join('article_entrepot', 'articles.id', '=', 'article_entrepot.ArticleId')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->where('articles.Etat', 0)
            ->where('entrepots.BoutiqueId', $user->BoutiqueId)
            ->where('article_entrepot.Quantite', '<=', 'article_entrepot.Seuil')
            ->count();
        return $data;
    }
    public function Index()
    {
        UsersController::$Informations = UsersController::GetInformations();
        $user = Utilisateur::find(session()->get('logged'));
        if (Entrepot::where('Etat', 0)->where('Description', 'Local')->where("BoutiqueId", $user->BoutiqueId)->count() == 0)
            Entrepot::create([
                'Description' => 'Local',
                'Etat' => 0,
                'Adresse' => Boutique::where('Etat', 0)->where('id', $user->BoutiqueId)->first()->Adresse,
                'DateAjout' => now(),
                'BoutiqueId' => $user->BoutiqueId,
            ]);
        else
        if (Entrepot::where('Etat', 1)->where('Description', 'Local')->where("BoutiqueId", $user->BoutiqueId)->count() == 0)
            Entrepot::where('Etat', 0)->where('Description', 'Local')
                ->update(['Etat' => 0]);

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
        $abonnements = Abonnement::join('tarifs', 'tarifs.id', '=', 'abonnements.Tarif_id')
            ->join('personnes', 'abonnements.User_Id', '=', 'personnes.id')
            ->join('boutiques', 'boutiques.id', '=', 'personnes.id')
            ->where('abonnements.Etat', '<>', '1')
            ->where('boutiques.Etat', '<>', '1')
            ->where('personnes.Etat', '<>', '1')
            ->where('tarifs.Etat', '<>', '1')
            ->where('abonnements.User_id', $user->id)
            ->select('abonnements.*', 'tarifs.Libelle as Tarif', 'personnes.Nom', 'personnes.Prenom', 'boutiques.Nom as Boutique')
            ->orderByDesc('DateAbonnement')->get();
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
        $categories = Categorie::where('Etat', 0)
            ->orderByDesc('DateAjout')
            ->get();
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
        $message = array();
        $message[2000] = 'Ajout réussi de la catégorie ' . $request->input('Libelle') . ' réussie';
        AdministrateursController::CreateHistorique(
            "Ajout de catégorie",
            "La catégorie " . $request->input("Libelle") . " a été ajoutée."
        );
        return redirect()->route('User.Categorie.AddPage')
            ->with('Success', $message);
    }

    #endregion

    #region Entrepôt

    public function Entrepots()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->orderByDesc('DateAjout')
            ->get();
        $entrepotsQte = DB::table('article_entrepot')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('EntrepotId', DB::raw('sum(quantite) as total'))
            ->groupBy('EntrepotId')
            ->where('article_entrepot.Etat', 0)
            ->get();
        $entrepotsTotal = DB::table('article_entrepot')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('EntrepotId', DB::raw('count(article_entrepot.id) as nbrArticle'))
            ->groupBy('EntrepotId')
            ->where('article_entrepot.Etat', 0)
            ->get();
        $Quantite = array();
        foreach ($entrepotsQte as $key => $value)
            $Quantite[$value->EntrepotId] = $value->total;
        $entrepotArticle = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('articles.*', 'entrepots.id as entrepot', 'article_entrepot.Quantite as Quantite')
            ->get();
        $entrepotArticleSeuil = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('articles.*', 'entrepots.id as entrepot', 'article_entrepot.Quantite as Quantite')
            ->where('article_entrepot.Quantite', '<', 'articles.Seuil')
            ->get();
        $Total = array();
        foreach ($entrepotsTotal as $key => $value)
            $Total[$value->EntrepotId] = $value->nbrArticle;

        return view('client.pages.Entrepots.lister', compact('user', 'entrepots', 'Quantite', 'Total', 'entrepotArticle', 'entrepotArticleSeuil'));
    }

    public function EntrepotApprovisionnement()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('BoutiqueId', '=', $user->BoutiqueId)
            ->where('Etat', 0)
            ->get();
        return view('client.pages.Entrepots.approvisionnement', compact('user', 'entrepots'));
    }


    public function AddEntrepotPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.Entrepots.ajouter', compact('user'));
    }

    public function AddEntrepot(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Description' => ['required'],
            'Adresse' => ['required']
        ]);
        $entrepot = Entrepot::where('Description', $request->input('Description'))
            ->where('BoutiqueId', $user->BoutiqueId)
            ->first();
        if ($entrepot && $entrepot->Etat == 0)
            return back()->with('fail', "Votre boutique a déjà un entrepôt avec la description " . $entrepot->Description . " .");
        else
            if ($entrepot && $entrepot->Etat != 0) {
            $entrepot->Etat = 0;
            $entrepot->update();
        }
        Entrepot::create([
            'Description' => $request->input('Description'),
            'Adresse' => $request->input('Adresse'),
            'BoutiqueId' => $user->BoutiqueId,
            'DateAjout' => now(),
            'Etat' => 0
        ]);
        $message = array();
        $message[2000] = "Ajout de l'entrepôt " . $request->input('Description') . " réussie.";
        $this->AddHistorique(
            "Ajout d'entrepôt",
            "L'entrepôt " . $request->input('Description') . " a été ajouté.",
            $user->BoutiqueId
        );
        return redirect()->route('User.Entrepot.AddPage')->with('Success', $message);
    }

    public function EntrepotUpdate(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Description' => ['required'],
            'Adresse' => ['required'],
        ]);
        $entrepot = Entrepot::find($request->input('Id'));
        $oldDescription = $entrepot->Description;
        $oldAdresse = $entrepot->Adresse;
        $modif = array();
        if ($entrepot->Description != $request->input('Description')) {
            $temp = Entrepot::where('Description', $request->input('Description'))
                ->where('BoutiqueId', $user->BoutiqueId)
                ->first();
            if ($temp)
                return back()->with('fail', "Impossible de modifier la description de l'entrepôt car vous avez déjà un entrepôt avec cette description");
            $entrepot->Description = $request->input('Description');
            $modif[2000] = 'Modification de ' . $oldDescription . ' en ' . $request->input('Description') . ' réussie.';
        }
        if ($entrepot->Adresse != $request->input('Adresse')) {
            $entrepot->Adresse = $request->input('Adresse');
            $modif[4000] = 'Modification de ' . $oldAdresse . ' en ' . $request->input('Adresse') . ' réussie.';
        }
        if (count($modif) != 0) {
            $entrepot->update();
            $this->AddHistorique(
                "Mise à jour d'un entrepôt",
                "Les informations de l'entrepôt " . $oldDescription . " ont été modifiées.",
                $user->BoutiqueId
            );
            return redirect()->route('User.Entrepot.List')->with('Success', $modif);
        } else
            return redirect()->route('User.Entrepot.List');
    }

    public function EntrepotDelete($id)
    {
        $entrepot = Entrepot::find($id);
        $entrepot->Etat = 1;
        $this->AddHistorique(
            "Suppression d'un entrepôt",
            "L'entrepôt " . $entrepot->Description . " a été supprimé.",

        );
        $entrepot->update();
        $modif = array();
        $modif[2000] = 'Suppression de ' . $entrepot->Description . ' réussie.';
        return redirect()->route('User.Entrepot.List')->with('Success', $modif);
    }

    #endregion

    #region Vente

    public function VentePage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $articles = Article::where('Etat', 0)->get();
        $entrepots = Entrepot::where('Etat', 0)->get();
        $data = array();
        foreach ($articles as $ArticleKey => $ArticleValue) {
            $data[$ArticleValue->id] = Entrepot::join('article_entrepot', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
                ->where('article_entrepot.Etat', 0)
                ->where('article_entrepot.ArticleId', $ArticleValue->id)
                ->where('entrepots.Etat', 0)
                ->select('entrepots.id')->get();
        }
        $clients = Personne::join('clients', 'clients.id', '=', 'personnes.id')
            ->join('client_boutique', 'client_boutique.ClientId', '=', 'clients.id')
            ->join('boutiques', 'boutiques.id', '=', 'client_boutique.BoutiqueId')
            ->select('personnes.*')
            ->where('personnes.Etat', 0)
            ->where('client_boutique.BoutiqueId', $user->BoutiqueId)
            ->groupBy('Nom', 'Prenom', 'Adresse', 'Contact', 'Email')
            ->get();
        $temp = Article::join('article_entrepot', 'articles.id', '=', 'article_entrepot.ArticleId')
            ->join('entrepots', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
            ->where('articles.Etat', 0)
            ->where('entrepots.Etat', 0)
            ->where('entrepots.Description', 'Local')
            ->where('article_entrepot.Etat', 0)
            ->select('articles.id as articleId', DB::raw('sum(Quantite) as Qte'))
            ->groupBy('articles.id')
            ->get();
        $ArticleData = array();
        foreach ($temp as $key => $value)
            $ArticleData[$value->articleId] = $value->Qte;

        //dd($data);
        return view('client.pages.Ventes.ajouter', compact('user', 'articles', 'entrepots', 'data', 'ArticleData', 'clients'));
    }

    public function VentePrint($id)
    {
        $vente = Vente::join('article_ventes', 'article_ventes.VenteId', '=', 'ventes.id')
            ->join('articles', 'articles.id', '=', 'article_ventes.ArticleId')
            ->join('boutiques', 'boutiques.id', '=', 'ventes.BoutiqueId')
            ->where('article_ventes.Etat', 0)
            ->where('ventes.id', $id)
            ->select('ventes.ClientId', 'ventes.DateVente', 'Nom', 'Site', 'Adresse', 'Email', DB::raw('sum(PrixVente) as PrixTotal'), DB::raw('sum(article_ventes.Reduction) / count(article_ventes.Reduction) as Reduction '), DB::raw('sum(article_ventes.Quantite) as Quantite'), 'ventes.id as id')
            ->groupBy('ClientId', 'DateVente', 'Nom', 'Site', 'Adresse', 'Email', 'id')
            ->first();
        $boutique = Boutique::find(Utilisateur::find(session()->get('logged'))->BoutiqueId);
        $venteArticle = DB::table('article_ventes')
            ->where('Etat', 0)
            ->where('VenteId', $id)
            ->get();
        $articles = Article::join('categories', 'categories.id', '=', 'articles.CategorieId')
            ->join('article_entrepot', 'articles.id', '=', 'article_entrepot.ArticleId')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('articles.*', 'categories.Libelle as Categorie')
            ->where('articles.Etat', 0)
            ->where('entrepots.BoutiqueId', $boutique->id)
            ->groupBy('articles.Libelle', 'articles.Description', 'articles.DateAjout', 'articles.Seuil', 'articles.Prix', 'articles.id', 'articles.Etat', 'Categorie')
            ->get();
        $info  = [];
        $count = 0;
        foreach ($venteArticle as $item) {
            foreach ($articles as $art) {
                if ($art->id == $item->ArticleId) {
                    $info[$count]['article'] = $art->Libelle;
                    $info[$count]['categorie'] = $art->Categorie;
                    $info[$count]['quantite'] = $item->Quantite;
                    $info[$count]['Prix'] = $art->Prix;
                    $info[$count]['Reduction'] = $item->Reduction;
                    $info[$count]['Total'] = $this->CalculePrix($art->Prix, $item->Reduction);
                    $count += 1;
                }
            }
        }
        $this->AddHistorique(
            "Impression d'une vente",
            "La vente " . $id . " a été imprimée.",
        );
        $personnes = Personne::where('Etat', 0)->get();
        $pdf = Pdf::loadView(
            'client.pages.Pdf.vente',
            compact('vente', 'boutique', 'personnes', 'info')
        )->setPaper('a5', 'landscape');
        return $pdf->download('reçu ' . $id . '.pdf');
    }


    public function VenteDelete($id)
    {
        $vente =  Vente::find($id)->update([
            'Etat' => 1
        ]);
        $this->AddHistorique(
            "Suppression d'une vente",
            "La vente " . Vente::find($id)->DateVente . " a été supprimé.",

        );
        return back()->with('Success', [2000 => 'Suppression de la vente réussie.']);
    }

    public function VenteAdd(Request $request)
    {
        // dd($request);
        $user = Utilisateur::find(session()->get('logged'));
        $message = [];
        $clientId = 0;
        $count = 2000;
        // Partie du client
        if ($request->input("Info") == "New") {
            if ($request->input('Nom') != "" || $request->input('Prenom') != "" || $request->input('Adresse') != "" || $request->input('Contact') != "" || $request->input('Email') != "") {
                $this->validate($request, [
                    "Nom" => ['required'],
                    "Prenom" => ['required'],
                    "Adresse" => ['required'],
                    "Contact" => ['required'],
                    "Email" => ['required'],
                ]);
            }
            $client = Personne::where("Email", $request->input("Email"))->first();
            if ($client) { // Le client existe
                $test = DB::table('client_boutique')
                    ->where('ClientId', $client->id)
                    ->where('BoutiqueId', $user->BoutiqueId)
                    ->where('Etat', 0)
                    ->count();
                if ($test != 0)  // La boutique a déjà ce client
                    return back()->with('fail', 'Impossible, vous avez déjà un client avec cet email.');
                else {
                    if (
                        !DB::table('client_boutique')
                            ->where('ClientId', $client->id)
                            ->where('BoutiqueId', $user->BoutiqueId)
                            ->where('Etat', 1)
                            ->count() != 0
                    ) {
                        return back()->with('fail', 'Impossible, il existe déjà un client avec cet email.');
                    } else {
                        // Le client à été supprimer des relations de la boutique
                        $clientId = DB::table('client_boutique') // Mise à jour des relations de la boutique avec le client
                            ->where('ClientId', $client->id)
                            ->where('BoutiqueId', $user->BoutiqueId)
                            ->where('Etat', 1)
                            ->update([
                                'Etat' => 0,
                            ]);
                    }
                }
            } else { // Le client n'existe pas
                if ($request->input("Nom")) {
                    $clientId = $this->ClientAdd($request);
                    $message[$count] = "Ajout du client " . $request->input("Nom") . " réussie.";
                    $count += 2000;
                }
            }
        } else {
            if ($request->input("Info") == "Select" && $request->input("Nom")) {
                $clientId = Personne::where("Email", $request->input('Email'))->first()->id;
            }
        }
        // Fin de la partie du client

        // Partie de la vente
        $articles = $request->input('FormArticle');
        $quantites = $request->input('FormQuantite');
        $reductions = $request->input('FormReduction');
        $vente = Vente::create([
            "DateVente" => now(),
            "Etat" => 0,
            "ClientId" => $clientId,
            "BoutiqueId" => $user->BoutiqueId,

        ]);
        if (is_array($articles)) { // Partie des paniers
            for ($i = 0; $i < count($articles); $i++) {
                DB::insert("insert into article_ventes(Quantite, Reduction, Etat, ArticleId, VenteId, PrixVente) values(?,?,?,?,?,?)", [
                    $quantites[$i],
                    $reductions[$i],
                    0,
                    $articles[$i],
                    $vente->id,
                    $this->CalculePrix(Article::find($articles[$i])->Prix, $reductions[$i])
                ]);
                // Retrait des quantités
                $oldQuantite = DB::table('entrepots')
                    ->join('article_entrepot', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
                    ->where('article_entrepot.Etat', 0)
                    ->where('article_entrepot.ArticleId', $articles[$i])
                    ->where('entrepots.Description', 'Local')
                    ->first()
                    ->Quantite;
                DB::table('entrepots')
                    ->join('article_entrepot', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
                    ->where('article_entrepot.Etat', 0)
                    ->where('article_entrepot.ArticleId', $articles[$i])
                    ->where('entrepots.Description', 'Local')
                    ->update([
                        "Quantite" => $oldQuantite - $quantites[$i]
                    ]);
                // Fin retrait des quantités
            }
        } // Fin partie des paniers
        else { // Partie Simple vente
            DB::insert("insert into article_ventes(Quantite, Reduction, Etat, ArticleId, VenteId, PrixVente) values(?,?,?,?,?,?)", [
                $quantites,
                $reductions,
                0,
                $articles,
                $vente->id,
                $this->CalculePrix(Article::find($articles)->Prix, $reductions)
            ]);
            $oldQuantite = DB::table('entrepots')
                ->join('article_entrepot', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
                ->where('article_entrepot.Etat', 0)
                ->where('article_entrepot.ArticleId', $articles)
                ->where('entrepots.Description', 'Local')
                ->first()
                ->Quantite;
            DB::table('entrepots')
                ->join('article_entrepot', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
                ->where('article_entrepot.Etat', 0)
                ->where('article_entrepot.ArticleId', $articles)
                ->where('entrepots.Description', 'Local')
                ->update([
                    "Quantite" => $oldQuantite - $quantites
                ]);
        } // Fin Partie Simple Vente
        if (is_array($articles))
            $message[$count] = "Vente effectuée avec succès, nombre d'articles vendus " . count($articles) . ".";
        else
            $message[$count] = "Vente effectuée avec succès, nombre d'articles vendus 1.";
        // Fin de la partie de la vente



        $this->AddHistorique(
            "Vente d'articles",
            "L'utilisateur " . Utilisateur::find(session()->get('logged'))->Pseudo . " a effectué une vente.",
        );
        return back()->with('Success', $message);
    }

    public static function CalculePrix($prix, $reduction)
    {
        return $prix - ($prix * ($reduction / 100));
    }


    public static function ClientAdd(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $id =  Personne::create([
            "Nom" => $request->input('Nom'),
            "Prenom" => $request->input('Prenom'),
            "Contact" => $request->input('Contact'),
            "Adresse" => $request->input('Adresse'),
            "Email" => $request->input('Email'),
            "Etat" => 0,
        ]);
        Client::create([
            "id" => $id->id,
        ]);
        DB::insert("insert into client_boutique(ClientId, BoutiqueId, Etat) values(?,?,?)", [
            $id->id,
            $user->BoutiqueId,
            0
        ]);
        return $id->id;
    }

    public function Ventes()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $clients = Vente::where('Etat', 0)
            ->select('ClientId')
            ->get();
        $personnes = Personne::where('Etat', 0)->get();
        $ventes = Vente::join('article_ventes', 'article_ventes.VenteId', '=', 'ventes.id')
            ->join('articles', 'article_ventes.ArticleId', '=', 'articles.id')
            ->where('articles.Etat', 0)
            ->where('article_ventes.Etat', 0)
            ->where('ventes.Etat', 0)
            ->where('ventes.BoutiqueId', $user->BoutiqueId)
            ->select(
                'ventes.DateVente',
                'ventes.id',
                'ventes.ClientId',
                DB::raw('count(article_ventes.id) as NbrVente'),
                DB::raw('sum(article_ventes.Quantite) as TotalVente'),
                DB::raw('(sum(article_ventes.Reduction) / count(article_ventes.Reduction)) as TotalReduction'),
                DB::raw('sum(article_ventes.PrixVente) as PrixTotalVente'),
            )
            ->groupBy('ventes.DateVente', 'ventes.id')
            ->orderByDesc('DateVente')
            ->get();
        $articles = Article::where('Etat', 0)->get();
        $ventesInfo = DB::table('article_ventes')
            ->where('Etat', 0)
            ->get();
        $clients = Personne::where('Etat', 0)->get();
        return view('client.pages.Ventes.lister', compact(
            'user',
            'ventes',
            'clients',
            'personnes',
            'articles',
            'ventesInfo',
            'clients',
        ));
    }

    #endregion

    #region Déconnexion

    public function LogOut()
    {
        if (session()->has('logged')) {
            $this->AddHistorique(
                "Déconnexion",
                "Déconnexion de l'utilisateur " . Utilisateur::find(session()->get('logged'))->Pseudo . ".",

            );
            return redirect()->route('Index');
        }
    }

    #endregion

    #region Article
    public function Articles()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $articles = Article::join('categories', 'categories.id', '=', 'articles.CategorieId')
            ->join('article_entrepot', 'articles.id', '=', 'article_entrepot.ArticleId')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('articles.*', 'categories.Libelle as Categorie')
            ->where('articles.Etat', 0)
            ->where('entrepots.BoutiqueId', $user->BoutiqueId)
            ->groupBy('articles.Libelle', 'articles.Description', 'articles.DateAjout', 'articles.Seuil', 'articles.Prix', 'articles.id', 'articles.Etat', 'Categorie')
            ->orderByDesc('articles.DateAjout')
            ->get();
        $categories = Categorie::where('Etat', 0)->get();
        $AllEntrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        $entrepots = Entrepot::join('article_entrepot', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->where('article_entrepot.Etat', 0)
            ->where('entrepots.Etat', 0)
            ->where('entrepots.BoutiqueId', $user->BoutiqueId)
            ->get();

        $entrepotsTotal = DB::table('article_entrepot')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('EntrepotId', DB::raw('count(article_entrepot.id) as nbrArticle'))
            ->groupBy('EntrepotId')
            ->where('article_entrepot.Etat', 0)
            ->get();
        $data = array();
        $Total = array();
        foreach ($entrepotsTotal as $key => $value)
            $Total[$value->EntrepotId] = $value->nbrArticle;
        foreach ($articles as $key => $value) {
            $data[$value->id] = array();
            $count = 0;
            foreach ($entrepots as $keyEn => $valueEn) {
                if ($value->id == $valueEn->ArticleId) {
                    $data[$value->id][$count] = $valueEn->EntrepotId;
                    $count += 1;
                }
            }
        }
        $temp = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->where('articles.Etat', 0)
            ->where('article_entrepot.Etat', 0)
            ->select('articles.id', DB::raw('sum(Quantite) as Qte'))
            ->groupBy('articles.id')
            ->get();
        $ArticleTotal = array();
        foreach ($temp as $key => $value)
            $ArticleTotal[$value['id']] = $value->Qte;
        return view('client.pages.Articles.lister', compact('user', 'articles', 'entrepots', 'categories', 'AllEntrepots', 'data', 'Total', 'ArticleTotal'));
    }

    public function AddArticlePage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $categories = Categorie::where('Etat', 0)->get();
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        $modeles = Modele::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        return view('client.pages.Articles.ajouter', compact('user', 'categories', 'entrepots', 'modeles'));
    }
    public function AddArticle(Request $request)
    {
        $nbr = count($request->input('FormCategorie'));
        $Libelle = $request->input('FormArticle');
        $Description = $request->input('FormDescription');
        $Seuil = $request->input('FormSeuil');
        $Prix = $request->input('FormPrix');
        $Entrepots = $request->input('FormEntrepot');
        $Categorie = $request->input('FormCategorie');
        $Quantite = $request->input('FormQuantite');
        $message = array();
        $count = 2000;
        for ($i = 0; $i < $nbr; $i++) {
            $existArticle = Article::where('Libelle', $Libelle[$i])->first();
            $entrepotId = Entrepot::where('Description', $Entrepots[$i])
                ->first()
                ->id;
            if ($existArticle) { // l'article existe déjà
                $articleId = Article::where('Libelle', $Libelle[$i])
                    ->where('Description', $Description[$i])
                    ->first()
                    ->id;
                if ($existArticle->Etat != 0) { // Mais elle à été supprimée
                    // Restauration de l'article
                    $existArticle->Etat = 0;
                    DB::table('article_entrepot') // Mise à jour des entrepots
                        ->where('ArticleId', $articleId)
                        ->where('EntrepotId', $entrepotId)
                        ->where('Etat', 1)
                        ->update([
                            'Quantite' => $Quantite[$i],
                            'Etat' => 0,
                        ]);
                    $existArticle->save();
                    $message[$count] = "Ajout de l'article " . $Libelle[$i] . " réussie.";
                } else { // Ajouter la quantité à l'entrepot en question
                    DB::insert(
                        'insert into article_entrepot(ArticleId, EntrepotId, Etat, Quantite) values (?,?,?,?)',
                        [
                            $articleId,
                            $entrepotId,
                            0,
                            $Quantite[$i],
                        ]
                    );
                    $message[$count] = "L'article " . $Libelle[$i] . " existe déjà, la quantité à éte ajouté à l'entrepot " . $Entrepots[$i] . " ";
                }
            } else { // l'article n'existe pas
                Article::create([
                    'Libelle' => $Libelle[$i],
                    'Description' => $Description[$i],
                    'Prix' => $Prix[$i],
                    'Seuil' => $Seuil[$i],
                    'Etat' => 0,
                    'DateAjout' => now(),
                    'CategorieId' => Categorie::where('Libelle', $Categorie[$i])->first()->id,
                ]);
                DB::insert(
                    'insert into article_entrepot(ArticleId, EntrepotId, Etat, Quantite) values (?,?,?,?)',
                    [
                        Article::where("Libelle", $Libelle[$i])->where("Description", $Description[$i])->first()->id,
                        $entrepotId,
                        0,
                        $Quantite[$i],
                    ]
                );
                $message[$count] = "Ajout de l'article " . $Libelle[$i] . " réussie.";
            }
            $count += 2000;
        }
        $this->AddHistorique(
            "Ajout d'article",
            "L'utilisateur " . Utilisateur::find(session()->get('logged'))->Pseudo . " a ajouté des articles.",

        );

        return back()->with('Success', $message);
    }
    public function ArticleDelete($id)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $article = Article::find($id);
        $message = array();
        $message[2000] =  "Suppression de l'article " . $article->Libelle . " réussie.";
        if ($user->Role == "Gérant") {
            $this->AddHistorique(
                "Suppression d'un article",
                "L'article " . $article->Libelle . " a été supprimé.",

            );
            $article->Etat = 1;
            $article->update();
            return redirect()->route('User.Article.List')->with('Success', $message);
        }
        return redirect()->back()->with('fail', "Suppression de l'article " . $article->Libelle . " impossible, vous n'avez pas ce droit.");
    }
    public function ArticleUpdate(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Libelle' => ['required'],
            'Description' => ['required'],
            'Prix' => ['required'],
            'Seuil' => ['required'],
            'Categorie' => ['required'],
        ]);
        $article = Article::find($request->input('Id'));
        $modif = array();
        $oldLibelle = $article->Libelle;
        $oldDescription = $article->Description;
        $oldPrix = $article->Prix;
        $oldSeuil = $article->Seuil;
        $temp = 2000;
        $oldCategorie = Categorie::find($article->CategorieId)->Libelle;
        if ($oldLibelle != $request->input('Libelle')) {
            $modif[$temp] = 'Modification de ' . $article->Libelle . ' en ' . $request->input('Libelle');
            $article->Libelle = $request->input('Libelle');
            $temp += 2000;
        }
        if ($oldDescription != $request->input('Description')) {
            $modif[$temp] = 'Modification de' . $article->Description . ' en ' . $request->input('Description');
            $article->Description = $request->input('Description');
            $temp += 2000;
        }
        if ($oldPrix != $request->input('Prix')) {
            $modif[$temp] = 'Modification de ' . $article->Prix . ' en ' . $request->input('Prix');
            $article->Prix = $request->input('Prix');
            $temp += 2000;
        }
        if ($oldSeuil != $request->input('Seuil')) {
            $modif[$temp] = 'Modification de ' . $article->Seuil . ' en ' . $request->input('Seuil');
            $article->Seuil = $request->input('Seuil');
            $temp += 2000;
        }
        if ($oldCategorie != $request->input('Categorie')) {
            $modif[$temp] = "Modification de la catégorie de l'article " . $request->input('Libelle') . " " . $oldCategorie . " en " . $request->input('Categorie');
            $temp += 2000;
            $article->CategorieId = Categorie::where('Libelle', $request->input('Categorie'))
                ->where('Etat', 0)->first()->id;
        }
        if (count($modif) > 0) {
            $this->AddHistorique(
                "Mise à jour d'un article",
                "L'article " . $article->Libelle . " a été mise à jour.",

            );
        }
        return redirect()->route('User.Article.List')->with('Success', $modif);
    }

    #endregion

    #region Modèle

    public function ModeleAddPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.pages.Modeles.ajouter', compact('user'));
    }
    public function ModeleDelete($id)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $modele = Modele::find($id);
        $modele->Etat = 1;
        $message = array();
        $message[2000] = "Suppression du modèle " . $modele->Description . " réussie.";
        $modele->save();
        $this->AddHistorique(
            "Suppression d'un modèle d'article",
            "Le modèle " . $modele->Description . " a été supprimé.",

        );
        return back()->with('Success', $message);
    }
    public function Modeles()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $modeles = Modele::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->orderByDesc('DateAjout')
            ->get();
        return view('client.pages.Modeles.lister', compact('user', 'modeles'));
    }
    public function ModeleAdd(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Description' => ['required'],
            'Quantite' => ['required', 'min:1'],
        ]);
        Modele::create([
            'Description' => $request->input('Description'),
            'Quantite' => $request->input('Quantite'),
            'BoutiqueId' => $user->BoutiqueId,
            'Etat' => 0,
            'DateAjout' => now(),
        ]);
        $message = array();
        $this->AddHistorique(
            "Ajout d'un modèle",
            "Le modèle " . $request->input('Description') . " a été ajouté.",

        );
        $message[2000] = "Ajout du modèle " . $request->input('Description') . " réussie.";
        return back()->with('Success', $message);
    }
    public function ModeleUpdate(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Description' => ['required'],
            'Quantite' => ['required', 'min:1'],
        ]);
        $modele = Modele::find($request->input('Id'))->first();
        $oldDescription = $modele->Description;
        $oldQuantite = $modele->Quantite;
        $message = array();
        $count = 2000;
        if ($oldDescription != $request->input('Description')) {
            $modele->Description = $request->input('Description');
            $message[$count] = "Modification du libellé du modèle " . $oldDescription . " en " . $request->input('Description');
            $count += 2000;
        }
        if ($oldQuantite != $request->input('Quantite')) {
            $modele->Quantite = $request->input('Quantite');
            $message[$count] = "Modification de la quantité du modèle " . $oldDescription . " en " . $request->input('Quantite');
        }
        if (count($message) > 0) {
            $modele->save();
            $this->AddHistorique(
                "Mise à jour de modèle",
                "Les informations du modèle " . $modele->Description . " ont été mise à jour.",

            );
            return back()->with('Success', $message);
        } else
            return back();
    }

    #endregion

    #region Fournisseur

    public function FournisseurAddPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view("client.pages.Fournisseurs.ajouter", compact('user'));
    }
    public function FournisseurAdd(Request $request)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Nom' =>  ['required'],
            'Prenom' =>  ['required'],
            'Contact' =>  ['required'],
            'Adresse' =>  ['required'],
        ]);
        $message = [];
        if (Personne::where('Email', $request->input("Email"))->count() == 0) {
            Personne::create([
                'Nom' => $request->input('Nom'),
                'Prenom' => $request->input('Prenom'),
                'Adresse' => $request->input('Adresse'),
                'Contact' => $request->input('Contact'),
                'Email' => $request->input('Email'),
            ]);
            $personne = Personne::where('Email', $request->input('Email'))->first();
            Fournisseur::create([
                'Site' => $request->input('Site'),
                'BoutiqueId' => $user->BoutiqueId,
                'id' => $personne->id,
            ]);
            $message[2000] = "Ajout du fournisseur " . $request->input('Nom') . " réussie.";
        } else 
            if (Personne::where('Email', $request->input("Email"))->where('Etat', 1)->count() != 0) {
            $personne = Personne::where('Email', $request->input('Email'))->first();
            $personne->Etat = 0;
            $personne->update();
        } else
        if (Personne::where('Email', $request->input("Email"))->count() != 0)
            return back()->with('fail', 'Il existe déjà un fournisseur avec cet mail');
        $this->AddHistorique(
            "Ajout d'un fournisseur",
            "Le fournisseur " . $request->input('Nom') . "à été ajouté.",

        );
        return redirect()->route('User.Fournisseur.AddPage')->with('Success', $message);
    }

    public function FournisseurUpdate(Request $request)
    {
        //  $user = Utilisateur::find(session()->get('logged'));
        $this->validate($request, [
            'Nom' =>  ['required'],
            'Prenom' =>  ['required'],
            'Contact' =>  ['required'],
            'Adresse' =>  ['required'],
            'Site' =>  ['required'],
        ]);
        $personne = Personne::find($request->input("Id"));
        $oldAdresse = $personne->Adresse;
        $oldNom = $personne->Nom;
        $oldPrenom = $personne->Prenom;
        $oldContact = $personne->Contact;
        $oldEmail = $personne->Email;
        $fournisseur = Fournisseur::find($personne->id);
        $oldSite = $fournisseur->Site;
        $message = array();
        $count = 2000;
        if ($oldAdresse != $request->input('Adresse')) {
            $personne->Adresse = $request->input('Adresse');
            $message[$count] = "Modification de l'adresse du fournisseur " . $oldAdresse . " en " . $request->input('Adresse');
            $count += 2000;
        }
        if ($oldNom != $request->input('Nom')) {
            $personne->Nom = $request->input('Nom');
            $message[$count] = "Modification du nom du fournisseur " . $oldNom . " en " . $request->input('Nom');
            $count += 2000;
        }
        if ($oldPrenom != $request->input('Prenom')) {
            $personne->Prenom = $request->input('Prenom');
            $message[$count] = "Modification de prénom du fournisseur " . $oldPrenom . " en " . $request->input('Prenom');
            $count += 2000;
        }
        if ($oldContact != $request->input('Contact')) {
            $personne->Contact = $request->input('Contact');
            $message[$count] = "Modification du contact du fournisseur " . $oldContact . " en " . $request->input('Contact');
            $count += 2000;
        }
        if ($oldEmail != $request->input('Email')) {
            $this->validate($request, [
                'Email' => ['required', 'unique:personnes']
            ]);
            $personne->Email = $request->input('Email');
            $message[$count] = "Modification du mail du fournisseur " . $oldEmail . " en " . $request->input('Email');
            $count += 2000;
        }
        if ($oldSite != $request->input('Site')) {
            $fournisseur->Site = $request->input('Site');
            $message[$count] = "Modification de l'adresse du fournisseur " . $oldSite . " en " . $request->input('Site');
            $fournisseur->update();
        }
        if (count($message) > 0) {
            $personne->save();
            $this->AddHistorique(
                "Mise à jour  d'un fournisseur",
                "Les informations du fournisseur " . $$oldNom . " ont été modifié.",

            );
            return back()->with('Success', $message);
        } else
            return back();
    }

    public function FournisseurDelete($id)
    {
        $personne = Personne::find($id);
        $personne->Etat = 1;
        $personne->update();
        $this->AddHistorique(
            "Suppression d'un fournisseur",
            "Le fournisseur " . $personne->Nom . " à été supprimé.",

        );
        return back()->with('Success', [2000 => 'Suppression du fournisseur ' . $personne->Nom . ' réussie.']);
    }

    public function Fournisseurs()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $fournisseurs = Personne::join('fournisseurs', 'fournisseurs.id', '=', 'personnes.id')
            ->where('personnes.Etat', 0)
            ->where('fournisseurs.BoutiqueId', $user->BoutiqueId)
            ->orderByDesc('DateAjout')
            ->get();
        return view("client.pages.Fournisseurs.lister", compact('user', "fournisseurs"));
    }

    #endregion

    #region Commande

    public function CommandeAddPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $articles = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->join('entrepots', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
            ->where('articles.Etat', 0)
            ->where('entrepots.Etat', 0)
            ->where('article_entrepot.Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->select('articles.Libelle', 'articles.id', 'articles.Prix')
            ->groupBy('articles.Libelle', 'articles.id', 'articles.Prix')
            ->get();
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        $fournisseurs = Fournisseur::join('personnes', 'personnes.id', '=', 'fournisseurs.id')
            ->where('personnes.Etat', 0)
            ->select('personnes.Nom', 'personnes.id')
            ->where('BoutiqueId', $user->BoutiqueId)
            ->get();
        $modeles = Modele::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        return view('client.pages.Commandes.ajouter', compact('user', 'articles', 'entrepots', 'fournisseurs', 'modeles'));
    }


    public function CommandeAdd(Request $request)
    {
        $this->validate($request, [
            "FormArticle" => ['required'],
            "FormEntrepot" => ['required'],
            "FormFournisseur" => ['required'],
            "FormQuantite" => ['required'],
            "FormModele" => ['required'],
        ]);
        $message = [];
        $articles = $request->input('FormArticle');
        $entrepots = $request->input('FormEntrepot');
        $fournisseurs = $request->input('FormFournisseur');
        $quantites = $request->input('FormQuantite');
        $modeles = $request->input('FormModele');
        $distinctFournisseur = [];
        $nbrFournisseurs = 0;
        for ($i = 0; $i < count($fournisseurs); $i++) {
            if (!in_array($fournisseurs[$i], $distinctFournisseur)) {
                $distinctFournisseur[$nbrFournisseurs] = $fournisseurs[$i];
                $nbrFournisseurs += 1;
            }
        }
        $tempData = [];
        for ($i = 0; $i < count($distinctFournisseur); $i++) {
            $tempData[$distinctFournisseur[$i]] = [];
            $element = 0;
            for ($u = 0; $u < count($fournisseurs); $u++) {
                if ($fournisseurs[$u] == $distinctFournisseur[$i]) {
                    $tempData[$distinctFournisseur[$i]][$element] = [
                        "fournisseur" => $fournisseurs[$u],
                        "article" => $articles[$u],
                        "entrepot" => $entrepots[$u],
                        "quantite" => $quantites[$u],
                        "modele" => $modeles[$u],
                    ];
                    $element += 1;
                }
            }
        }
        //dd($tempData);
        $count = 2000;
        foreach ($tempData as $key => $value) {
            $commandesFournisseur = $tempData[$key];
            $nbr = 0;
            $idFournisseur = 0;
            for ($u = 0; $u < count($commandesFournisseur); $u++) {
                $nbr += 1;
                $commande  = $commandesFournisseur[$u];
                $idFournisseur = $commande["fournisseur"];
                $mod = 0;
                if ($commande["modele"])
                    $mod = $commande["modele"];
                $commandeAdd =  Commande::create([
                    "DateCommande" => now(),
                    "Etat" => 0,
                    "FournisseurId" => $commande["fournisseur"],
                    "ModeleId" => $mod,
                    "EntrepotId" => $commande["entrepot"]
                ]);
                DB::insert('insert into commande_article(
                    Quantite,
                    ArticleId,
                    CommandeId,
                    Etat
                ) values (?,?,?,?)', [
                    $commande["quantite"],
                    $commande["article"],
                    $commandeAdd->id,
                    0
                ]);
            }
            if ($nbr == 1)
                $message[$count] = "Une commande à été demandée au fournisseur " . Personne::find($idFournisseur)->Nom;
            else
                $message[$count] = $nbr . " commandes à été demandée au fournisseur " . Personne::find($idFournisseur)->Nom;
            $count += 2000;
        }
        return back()->with('Success', $message);
    }

    public static function SendMail($message, $to)
    {
    }

    public function Commandes()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $commandes = Commande::join('personnes', 'personnes.id', '=', 'commandes.FournisseurId')
            ->join('commande_article', 'commande_article.CommandeId', '=', 'commandes.id')
            ->join('entrepots', 'entrepots.id', '=', 'commandes.EntrepotId')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where("personnes.Etat", 0)
            ->where("entrepots.Etat", 0)
            ->where("entrepots.BoutiqueId", $user->BoutiqueId)
            ->where("commande_article.Etat", 0)
            ->where("commandes.Etat", "<>", 1)
            ->select('commandes.id as id', 'commandes.DateCommande', 'personnes.Nom as Fournisseur', 'commande_article.Quantite', 'commande_article.ArticleId as ArticleId', 'entrepots.id as EntrepotId', 'articles.Libelle as Article', 'personnes.id as FournisseurId', 'commandes.Etat as Etat')
            ->groupBy('Fournisseur', 'commande_article.Quantite', 'EntrepotId', 'Article', 'id', 'ArticleId', 'FournisseurId')
            ->get();
        $articles = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->where('entrepots.Etat', 0)
            ->where('articles.Etat', 0)
            ->where('entrepots.BoutiqueId', $user->BoutiqueId)
            ->select('articles.Libelle as Libelle', 'articles.id as Id')
            ->groupBy('Libelle', 'Id')
            ->get();
        $fournisseurs = Fournisseur::join('personnes', 'personnes.id', '=', 'fournisseurs.id')
            ->where('personnes.Etat', 0)
            ->select('personnes.Nom', 'personnes.id')
            ->where('BoutiqueId', $user->BoutiqueId)
            ->get();
        $entrepots = Entrepot::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->get();
        $commandeModele = Commande::where('Etat', '<>', 1)
            ->select('ModeleId', 'id')
            ->get();
        $temp = Modele::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->get();
        $modeles = [];
        $modData = [];
        for ($i = 0; $i < count($temp); $i++)
            $modeles[$temp[$i]['id']] = $temp[$i]['Description'];
        for ($i = 0; $i < count($commandeModele); $i++)
            $modData[$commandeModele[$i]['id']] = $commandeModele[$i]['ModeleId'];
        return view('client.pages.Commandes.lister', compact('user', 'commandes', 'modeles', 'commandeModele', 'articles', 'entrepots', 'temp', 'modData', 'fournisseurs'));
    }

    public function CommandeRestore($id)
    {
        $commande = Commande::find($id);
        $detailsCommande = DB::table('commande_article')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where('CommandeId', $id)
            ->select('Libelle')
            ->first();
        $commande->Etat = 0;
        $commande->DateCommande = now();
        $commande->update();
        $this->AddHistorique("Restoration d'une commande", "La commande du produit " . $detailsCommande->Libelle . " a été restaurée.");
        return back()->with('Success', [2000 => 'Annulation de la commande du produit ' . $detailsCommande->Libelle . ' réussie.']);
    }
    public function CommandeDelete($id)
    {
        $commande = Commande::find($id);
        $detailsCommande = DB::table('commande_article')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where('CommandeId', $id)
            ->select('Libelle')
            ->first();
        $commande->Etat = 1;
        $commande->update();
        $this->AddHistorique("Suppression d'une commande", "La commande du produit " . $detailsCommande->Libelle . " a été supprimée.");
        return back()->with('Success', [2000 => 'Annulation de la commande du produit ' . $detailsCommande->Libelle . ' réussie.']);
    }
    public function CommandeCancel($id)
    {
        $commande = Commande::find($id);
        $detailsCommande = DB::table('commande_article')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where('CommandeId', $id)
            ->select('Libelle')
            ->first();
        $commande->Etat = 3;
        $commande->update();
        $this->AddHistorique("Annulation d'une commande", "La commande du produit " . $detailsCommande->Libelle . " a été annulée.");
        return back()->with('Success', [2000 => 'Annulation de la commande du produit ' . $detailsCommande->Libelle . ' réussie.']);
    }
    public function CommandeUpdate(Request $request)
    {
        $commande = Commande::join('entrepots', 'entrepots.id', '=', 'commandes.EntrepotId')
            ->join('personnes', 'personnes.id', '=', 'commandes.FournisseurId')
            ->join('commande_article', 'commande_article.CommandeId', '=', 'commandes.id')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where('commandes.id', '=', $request->input('Id'))
            ->select('articles.id as Article', 'commandes.ModeleId as ModeleId', 'entrepots.id as Entrepot', 'commande_article.Quantite as Quantite', 'personnes.id as Fournisseur')
            ->groupBy('Article', 'ModeleId', 'Entrepot', 'Quantite', 'Fournisseur')
            ->first();
        $updateCommande = Commande::find($request->input('Id'));
        $updateCommandeArticle = DB::table('commande_article')
            ->where('CommandeId', $updateCommande->id)
            ->first();
        $message = [];
        $count = 2000;
        if ($commande->ModeleId != $request->input("Modele")) {
            $updateCommande->ModeleId = $request->input("Modele");
            $message[$count] = "Modification du modèle de la commande.";
            $count += 2000;
        }
        if ($commande->Article != $request->input("Article")) {
            DB::table('commande_article')
                ->where('CommandeId', $updateCommande->id)
                ->update([
                    "ArticleId" => $request->input("Article")
                ]);
            $message[$count] = "Modification de l'article de la commande.";
            $count += 2000;
        }
        if ($commande->Quantite != $request->input("Quantite")) {
            DB::table('commande_article')
                ->where('CommandeId', $updateCommande->id)
                ->update([
                    "Quantite" => $request->input("Quantite")
                ]);
            $message[$count] = "Modification de la quantité de la commande.";
            $count += 2000;
        }
        if ($commande->Entrepot != $request->input("Entrepot")) {
            $updateCommande->Entrepot = $request->input("Entrepot");
            $message[$count] = "Modification de l'entrepôt de livraison de la commande.";
            $count += 2000;
        }
        if ($commande->Fournisseur != $request->input("Fournisseur")) {
            $updateCommande->Fournisseur = $request->input("Fournisseur");
            $message[$count] = "Modification du fournisseur de la commande.";
        }
        $detailsCommande = DB::table('commande_article')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where('CommandeId', $request->input('Id'))
            ->select('Libelle')
            ->first();
        // $commande = Commande::find($request->input('Id'));
        if (count($message) > 0) {
            $updateCommande->update();
            $this->AddHistorique("Modification d'une commande", "La commande du produit " . $detailsCommande->Libelle . " a été modifiée.");
            return back()->with('Success', $message);
        }
        return back();
    }

    #endregion

    #region Client

    public function Clients()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $clients = Personne::join('client_boutique', 'personnes.id', '=', 'client_boutique.ClientId')
            ->where('BoutiqueId', $user->BoutiqueId)
            ->where('client_boutique.Etat', 0)
            ->where('personnes.Etat', 0)
            ->select('Nom', 'Prenom', 'Email', 'Contact', 'Adresse', 'personnes.id')
            ->groupBy('Nom', 'Prenom', 'Email', 'Contact', 'Adresse', 'personnes.id')
            ->orderByDesc('DateAjout')
            ->get();
        return view('client.pages.Clients.lister', compact('user', 'clients'));
    }

    public function ClientDelete($id)
    {
        $user = Utilisateur::find(session()->get('logged'));
        Personne::find($id)->update([
            "Etat" => 1
        ]);
        Vente::where('ClientId', $id)->update([
            "Etat" => 1
        ]);
        $client = Personne::find($id);
        DB::table('client_boutique')
            ->where('ClientId', $id)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->update([
                "Etat" => 1
            ]);
        $this->AddHistorique(
            "Suppression de client",
            "Le client " . $client->Nom . " " . $client->Prenom . " a été supprimé",

        );
        return back()->with('Success', [2000 => 'Suppression du client ' . $client->Nom . ' ' . $client->Prenom  . ' réussie.']);
    }

    public function ClientUpdate(Request $request)
    {
        $this->validate($request, [
            'Nom' => ['required'],
            'Prenom' => ['required'],
            'Adresse' => ['required'],
            'Contact' => ['required'],
            'Email' => ['required'],
        ]);
        $count = 2000;
        $message = array();
        $client = Personne::find($request->input('Id'));
        $temp = $client;
        if ($client->Nom != $request->input('Nom')) {
            $message[$count] = "Modification du nom du client " . $client->Nom . " en " . $request->input('Nom');
            $client->Nom = $request->input('Nom');
            $count += 2000;
        }
        if ($client->Prenom != $request->input('Prenom')) {
            $message[$count] = "Modification du prénom du client " . $client->Prenom . " en " . $request->input('Prenom');
            $client->Prenom = $request->input('Prenom');
            $count += 2000;
        }
        if ($client->Adresse != $request->input('Adresse')) {
            $message[$count] = "Modification de l' adresse du client " . $client->Adresse . " en " . $request->input('Adresse');
            $client->Adresse = $request->input('Adresse');
            $count += 2000;
        }
        if ($client->Contact != $request->input('Contact')) {
            $message[$count] = "Modification du contact du client " . $client->Contact . " en " . $request->input('Contact');
            $client->Contact = $request->input('Contact');
            $count += 2000;
        }
        if ($client->Email != $request->input('Email')) {
            $this->validate($request, [
                "Email" => ['unique:personnes']
            ]);
            $message[$count] = "Modification de l' email du client " . $client->Email . " en " . $request->input('Email');
            $client->Email = $request->input('Email');
        }
        if (count($message) > 0) {
            $this->AddHistorique(
                "Mise à jour d'un client",
                "Les informations du client " . $temp->Nom . " ont été modifié",
            );
            return back()->with('Success', $message);
        }
        return back();
    }


    #endregion

    #region Historique
    public static function AddHistorique($Libelle, $Description)
    {
        BoutiqueHistorique::create([
            'Libelle' => $Libelle,
            'Description' => $Description,
            'DateOperation' => now(),
            'Etat' => 0,
            'CommanditaireId' => session()->get('logged'),
            'BoutiqueId' =>  Utilisateur::find(session()->get('logged'))->BoutiqueId,
        ]);
    }

    public function HistoriqueDelete($id)
    {
        BoutiqueHistorique::find($id)->update([
            "Etat" => 1
        ]);
        return back()->with('Success', [2000 => "Suppression de l'historique réussie"]);
    }

    public function Historiques()
    {
        $user = Utilisateur::find(session()->get('logged'));

        $historiques = DB::table('boutique_historiques')->where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->orderBy('DateOperation', 'DESC')
            ->get();
        $personnes = Personne::join('utilisateurs', 'personnes.id', '=', 'utilisateurs.id')
            ->where('Etat', 0)
            ->select('Nom', 'Prenom', 'personnes.id as id', 'Pseudo')
            ->groupBy('Nom', 'Prenom', 'personnes.id', 'Pseudo')
            ->get();

        return view('client.pages.Historiques.lister', compact('user', 'historiques', 'personnes'));
    }

    #endregion

    #region Profil
    public function Profil()
    {

        $user = Utilisateur::find(session()->get('logged'));
        $boutique = Boutique::find($user->BoutiqueId);
        $users = Personne::join('utilisateurs', 'utilisateurs.id', '=', 'personnes.id')
            ->where('Personnes.Etat', 0)
            ->where('Personnes.id', '<>', $user->id)
            ->where('utilisateurs.BoutiqueId', $user->BoutiqueId)
            ->select('personnes.*', 'utilisateurs.Pseudo')
            ->get();
        $Nbrclient = DB::table('client_boutique')
            ->where('BoutiqueId', $user->BoutiqueId)
            ->count();
        $info = Personne::join('utilisateurs', 'utilisateurs.id', '=', 'personnes.id')
            ->where('personnes.id', $user->id)
            ->select('personnes.*', 'Pseudo')
            ->first();
        return view('client.pages.Profil.info', compact('user', 'boutique', 'users', 'Nbrclient', 'info'));
    }
    #endregion

    #region Approvisionnement
    public function ApprovisionnementPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $articles = Article::join('article_entrepot', 'article_entrepot.ArticleId', '=', 'articles.id')
            ->join('entrepots', 'article_entrepot.EntrepotId', '=', 'entrepots.id')
            ->where('articles.Etat', 0)
            ->where('entrepots.Etat', 0)
            ->where('article_entrepot.Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->select('articles.Libelle', 'articles.id', 'articles.Prix')
            ->groupBy('articles.Libelle', 'articles.id', 'articles.Prix')
            ->get();
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        $modeles = Modele::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        $commandes = Commande::join('personnes', 'personnes.id', '=', 'commandes.FournisseurId')
            ->join('commande_article', 'commande_article.CommandeId', '=', 'commandes.id')
            ->join('entrepots', 'entrepots.id', '=', 'commandes.EntrepotId')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where("personnes.Etat", 0)
            ->where("entrepots.Etat", 0)
            ->where("entrepots.BoutiqueId", $user->BoutiqueId)
            ->where("commande_article.Etat", 0)
            ->where("commandes.Etat", 0)
            ->select('commandes.id as id', 'commandes.ModeleId as ModeleId', 'commandes.DateCommande', 'personnes.Nom as Fournisseur', 'commande_article.Quantite', 'commande_article.ArticleId as ArticleId', 'entrepots.id as EntrepotId', 'articles.Libelle as Article', 'personnes.id as FournisseurId', 'commandes.Etat as Etat')
            ->groupBy('Fournisseur', 'commande_article.Quantite', 'EntrepotId', 'Article', 'id', 'ArticleId', 'FournisseurId', 'ModeleId')
            ->get();
        return view('client.pages.Approvisionnements.ajouter', compact('user', 'articles', 'entrepots', 'modeles', 'commandes'));
    }

    public function ApprovisionnementAdd(Request $request)
    {
        $this->validate($request, [
            "Quantite" => ['required'],
            "Modele" => ['required'],
            "Prix" => ['required'],
            "type" => ['required'],
        ]);
        $user = Utilisateur::find(session()->get('logged'));
        if ($request->input('type') == 'Commande') {
            $this->validate($request, [
                "Commande" => ['required']
            ]);
            $commande = Commande::find($request->input('Commande'));
            $commandeQuantite = DB::table('commande_article')->where('CommandeId', $commande->id)->first()->Quantite;
            if ($commande->ModeleId > 0) {
                $commandeQuantite = $commandeQuantite * Modele::find($commande->ModeleId)->Quantite;
            }
            $approModeleQuantite = $request->input('Quantite');
            if ($request->input('Modele') > 0) {
                $approModeleQuantite = $approModeleQuantite * Modele::find($request->input('Modele'))->Quantite;
            }
            $article = DB::table('commande_article')
                ->where('CommandeId', $commande->id)
                ->first();
            $oldApproQuantite = 0;
            $oldAppro = Approvisionnement::where('CommandeId', $commande->id)->first();
            if ($oldAppro) {
                $temp = 1;
                if ($oldAppro->ModeleId > 0) {
                    $temp = Modele::find($oldAppro->ModeleId)->Quantite;
                }
                $oldQuantite = DB::table('approvisionnement_article')
                    ->where('ApproId', $oldAppro->id)
                    ->first()->Quantite;
                $oldApproQuantite = $oldQuantite * $temp;
            }
            $approModeleQuantite += $oldApproQuantite;
            if ($approModeleQuantite >= $commandeQuantite) {
                $commande->Etat = 2;
                $commande->update();
            }
            $approvisionnement = Approvisionnement::create([
                'DateAppro' => now(),
                'Etat' => 0,
                'Prix' => $request->input('Prix'),
                'CommandeId' => $commande->id,
                'BoutiqueId' => $user->BoutiqueId,
                'ModeleId' => $request->input('Modele')
            ]);

            DB::insert('insert into approvisionnement_article (ApproId,ArticleId,Quantite) values(?,?,?)', [
                $approvisionnement->id,
                $article->id,
                $request->input('Quantite'),
            ]);
            if (
                DB::table('article_entrepot')->where('EntrepotId', $commande->EntrepotId)
                ->where('ArticleId', $article->ArticleId)->count() > 0
            ) {

                DB::table('article_entrepot')
                    ->where('EntrepotId', $commande->EntrepotId)
                    ->where('ArticleId', $article->ArticleId)
                    ->increment('Quantite', $approModeleQuantite);
            } else {
                DB::insert('insert into article_entrepot(ArticleId,EntrepotId,Quantite) values(?,?,?)', [
                    $article->ArticleId,
                    $commande->EntrepotId,
                    $approModeleQuantite
                ]);
            }
            $this->AddHistorique("Ajout d'approvisionnement", "L'approvisionnement du " . $approvisionnement->DateAppro . " a été ajoutée.");
            return back()->with('Success', [2000 => "Ajout de l'approvisionnement réussie."]);
        } else {
            $this->validate($request, [
                "Article" => ['required'],
                "Entrepot" => ['required'],
            ]);
            $approModeleQuantite = $request->input('Quantite');
            if ($request->input('Modele') > 0) {
                $approModeleQuantite = $approModeleQuantite * Modele::find($request->input('Modele'))->Quantite;
            }
            $approvisionnement = Approvisionnement::create([
                'DateAppro' => now(),
                'Etat' => 0,
                'BoutiqueId' => $user->BoutiqueId,
                'Prix' => $request->input('Prix'),
                'ModeleId' => $request->input('Modele'),
            ]);
            DB::insert('insert into approvisionnement_article (ApproId,ArticleId,Quantite) values(?,?,?)', [
                $approvisionnement->id,
                $request->input('Article'),
                $approModeleQuantite,
            ]);
            if (

                DB::table('article_entrepot')
                ->where('ArticleId', $request->input('Article'))
                ->where('EntrepotId', $request->input('Entrepot'))->count() > 0
            ) {

                DB::table('article_entrepot')
                    ->where('ArticleId', $request->input('Article'))
                    ->where('EntrepotId', $request->input('Entrepot'))
                    ->increment('Quantite', $approModeleQuantite);
            } else {
                DB::insert('insert into article_entrepot(ArticleId,EntrepotId,Quantite) values(?,?,?)', [
                    $request->input('Article'),
                    $request->input('Entrepot'),
                    $approModeleQuantite
                ]);
            }
            $this->AddHistorique("Ajout d'un ravitaillement", "Lee ravitaillement du " . $approvisionnement->DateAppro . " a été ajoutée.");
            return back()->with('Success', [2000 => "Ajout du ravitaillement " . $approvisionnement->DateAppro  . " réussie."]);
        }
    }

    public function Approvisionnements()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $approvisionnements = Approvisionnement::join('approvisionnement_article', 'approvisionnement_article.ApproId', '=', 'approvisionnements.id')
            ->where("BoutiqueId", $user->BoutiqueId)
            ->where("approvisionnements.Etat", 0)
            ->select('DateAppro', 'CommandeId', 'Prix', 'Quantite', 'ModeleId', 'ArticleId', 'approvisionnements.id')
            ->get();
        $articles = Article::join('categories', 'categories.id', '=', 'articles.CategorieId')
            ->join('article_entrepot', 'articles.id', '=', 'article_entrepot.ArticleId')
            ->join('entrepots', 'entrepots.id', '=', 'article_entrepot.EntrepotId')
            ->select('articles.*', 'categories.Libelle as Categorie')
            ->where('articles.Etat', 0)
            ->where('entrepots.BoutiqueId', $user->BoutiqueId)
            ->groupBy('articles.Libelle', 'articles.Description', 'articles.DateAjout', 'articles.Seuil', 'articles.Prix', 'articles.id', 'articles.Etat', 'Categorie')
            ->orderByDesc('articles.DateAjout')
            ->get();
        $commandes = Commande::join('personnes', 'personnes.id', '=', 'commandes.FournisseurId')
            ->join('commande_article', 'commande_article.CommandeId', '=', 'commandes.id')
            ->join('entrepots', 'entrepots.id', '=', 'commandes.EntrepotId')
            ->join('articles', 'articles.id', '=', 'commande_article.ArticleId')
            ->where("personnes.Etat", 0)
            ->where("entrepots.Etat", 0)
            ->where("entrepots.BoutiqueId", $user->BoutiqueId)
            ->where("commande_article.Etat", 0)
            ->where("commandes.Etat", "<>", 1)
            ->select('commandes.id as id', 'commandes.DateCommande', 'personnes.Nom as Fournisseur', 'commande_article.Quantite', 'commande_article.ArticleId as ArticleId', 'entrepots.id as EntrepotId', 'articles.Libelle as Article', 'personnes.id as FournisseurId', 'commandes.Etat as Etat')
            ->groupBy('Fournisseur', 'commande_article.Quantite', 'EntrepotId', 'Article', 'id', 'ArticleId', 'FournisseurId')
            ->get();
        $modeles = Modele::where("BoutiqueId", $user->BoutiqueId)->where("Etat", 0)->get();
        $entrepots = Entrepot::where('BoutiqueId', $user->BoutiqueId)->where('Etat', 0)->get();
        return view('client.pages.Approvisionnements.lister', compact('user', 'entrepots', 'commandes', 'articles', 'approvisionnements', 'modeles'));
    }

    public function ApprovisionnementDelete($id)
    {

        $appro = Approvisionnement::find($id);
        $appro->Etat = 1;
        $appro->update();
        if ($appro->CommandeId > 0)
            $this->AddHistorique("Suppression d'approvisionnement", "L'approvisionnement du " . $appro->DateAppro . " a été supprimée.");
        else {

            $this->AddHistorique("Suppression de ravitaillement", "Le ravitaillement du " . $appro->DateAppro . " a été supprimée.");
        }
        if ($appro->CommandeId > 0) {
            return back()->with('Success', [2000 => "Suppression de l'approvisionnement du " . $appro->DateAppro . " réussie."]);
        } else {
            return back()->with('Success', [2000 => "Suppression du ravitaillement du " . $appro->DateAppro . " réussie."]);
        }
    }
    #endregion

    #region Statistiques
    public function Statistiques()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $month = Vente::where('Etat', 0)
            ->select(DB::raw('Month(DateVente) as Date'))
            ->get();
        $dataMonth = [];
        for ($i = 0; $i < count($month); $i++)
            $dataMonth[$i] = $month[$i]['Date'];
        //dd($dataMonth);
        $Ventes = Vente::where('Etat', 0)
            ->select('ventes.id', DB::raw('count(ventes.id) as nbr', DB::raw('Month(DateVente) as mon')))
            ->whereIn(DB::raw('Month(DateVente)'), $dataMonth)
            ->groupBy('ventes.id')
            ->get();
        dd($Ventes);
        return view('client.pages.Statistique.lister', compact('user'));
    }
    #endregion

    #region Ajout d'utilisateur
    public function UserAddPage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        return view('client.Other.addUser', compact('user'));
    }



    #endregion
}
