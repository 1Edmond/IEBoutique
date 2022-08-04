<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Article;
use App\Models\Avantage;
use App\Models\Boutique;
use App\Models\BoutiqueHistorique;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Entrepot;
use App\Models\Fournisseur;
use App\Models\Modele;
use App\Models\Personne;
use App\Models\Tarif;
use App\Models\Utilisateur;
use App\Models\Vente;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class UsersController extends Controller
{
    public function Index()
    {
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
        $message = array();
        $message[2000] = 'Ajout réussi de la catégorie ' . $request->input('Libelle') . ' réussie';
        return redirect()->route('User.Categorie.AddPage')
            ->with('Success', $message);
    }

    #endregion

    #region Entrepôt

    public function Entrepots()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
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
            return redirect()->route('User.Entrepot.List')->with('Success', $modif);
        } else
            return redirect()->route('User.Entrepot.List');
    }

    public function EntrepotDelete($id)
    {
        $entrepot = Entrepot::find($id);
        $entrepot->Etat = 1;
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


    public function VenteDelete($id)
    {
        Vente::find($id)->update([
            'Etat' => 1
        ]);
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
        } // Fin Partie Simple Vente
        if (is_array($articles))
            $message[$count] = "Vente effectuée avec succès, nombre d'articles vendus " . count($articles) . ".";
        else
            $message[$count] = "Vente effectuée avec succès, nombre d'articles vendus 1.";
        // Fin de la partie de la vente

        // Partie retrait des quantités dans les entrepôts

        // Fin de la partie retrait des quantités dans les entrepôts



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
            ->select(
                'ventes.DateVente',
                'ventes.id',
                'ventes.ClientId',
                DB::raw('count(article_ventes.id) as NbrVente'),
                DB::raw('sum(article_ventes.Quantite) as TotalVente'),
                DB::raw('sum(article_ventes.PrixVente) as PrixTotalVente'),
            )
            ->groupBy('ventes.DateVente', 'ventes.id')
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

        return back()->with('Success', $message);
    }
    public function ArticleDelete($id)
    {
        $user = Utilisateur::find(session()->get('logged'));
        $article = Article::find($id);
        $message = array();
        $message[2000] =  "Suppression de l'article " . $article->Libelle . " réussie.";
        if ($user->Role == "Gérant")
            return redirect()->route('User.Article.List')->with('Success', $message);
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
            'Entrepot' => ['required'],
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
        return back()->with('Success', $message);
    }
    public function Modeles()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $modeles = Modele::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
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
            return back()->with('Success', $message);
        } else
            return back();
    }

    public function FournisseurDelete($id)
    {
        $personne = Personne::find($id);
        $personne->Etat = 1;
        $personne->update();
        return back()->with('Success', [2000 => 'Suppression du fournisseur ' . $personne->Nom . ' réussie.']);
    }

    public function Fournisseurs()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $fournisseurs = Personne::join('fournisseurs', 'fournisseurs.id', '=', 'personnes.id')
            ->where('personnes.Etat', 0)
            ->where('fournisseurs.BoutiqueId', $user->BoutiqueId)->get();
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
        dd($request);
    }


    #endregion

    #region Historique
    public static function AddHistorique($Libelle, $Description, $BoutiqueId)
    {
        BoutiqueHistorique::create([
            'Libelle' => $Libelle,
            'Description' => $Description,
            'DateOperation' => now(),
            'Etat' => 0,
            'BoutiqueId' => $BoutiqueId,
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
        $historiques = BoutiqueHistorique::where('Etat', 0)
            ->where('BoutiqueId', $user->BoutiqueId)
            ->get();
        return view('client.pages.Historiques.lister', compact('user', 'historiques'));
    }

    #endregion
}
