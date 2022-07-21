<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Article;
use App\Models\Avantage;
use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\Entrepot;
use App\Models\Tarif;
use App\Models\Utilisateur;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class UsersController extends Controller
{
    public function Index()
    {
        $user = Utilisateur::find(session()->get('logged'));
        if (Entrepot::where('Etat', 0)->where('Description', 'Local')->count() == 0)
            Entrepot::create([
                'Description' => 'Local',
                'Etat' => 0,
                'Adresse' => Boutique::where('Etat', 0)->where('id', $user->BoutiqueId)->first()->Adresse,
                'DateAjout' => now(),
                'BoutiqueId' => $user->BoutiqueId,
            ]);
        else
        if (Entrepot::where('Etat', 0)->where('Description', 'Local')->count() == 0)
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
        return view('client.pages.Ventes.ajouter', compact('user', 'articles'));
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
       // dd($Total);
        return view('client.pages.Articles.lister', compact('user', 'articles', 'entrepots', 'categories', 'AllEntrepots', 'data', 'Total'));
    }

    public function AddArticlePage()
    {
        $user = Utilisateur::find(session()->get('logged'));
        $categories = Categorie::where('Etat', 0)->get();
        $entrepots = Entrepot::where('Etat', 0)->where('BoutiqueId', $user->BoutiqueId)->get();
        return view('client.pages.Articles.ajouter', compact('user', 'categories', 'entrepots'));
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
}
