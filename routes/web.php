<?php

use App\Http\Controllers\AdministrateursController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Models\Personne;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('auth/admin/login', [PagesController::class, 'Login'])->name('Login'); // Faut créer une page pour les utilisateurs aussi
Route::get('/', [PagesController::class, 'Index'])->name('Index');

Route::get('/login', [PagesController::class, 'LoginPage'])->name('LoginPage');
Route::get('/signIn', [PagesController::class, 'SignInPage'])->name('SignInPage');
Route::post('/signIn', [PagesController::class, 'SignIn'])->name('SignIn');
Route::get('/signIn/{id}', [PagesController::class, 'SignInPageWith'])->name('SignInPageWith');


#region Utilisateur
Route::group(
        ['middleware' => ['UserCheck', 'AbonnementCheck']],
        function () {

                /* 
        Page d'accueil de l'utilisateur
*/
                Route::get('user/', [UsersController::class, 'Index'])->name('User.Home');
                Route::get('addPage', [UsersController::class, 'UserAddPage'])->name('User.AddUserPage')->middleware('AutorisationCheck:Gérant');
                Route::post('addMethod', function (Request $request) {
                        $request->validate([
                                "Email" => ['required'],
                                "Nom" => ['required'],
                                "Prenom" => ['required'],
                                "Password" => ['required'],
                                "Contact" => ['required'],
                                "Adresse" => ['required'],
                                "Pseudo" => ['required', 'unique:Utilisateurs'],
                        ]);
                        $personne = Personne::create([
                                "Nom" => $request->input("Nom"),
                                "Prenom" => $request->input("Prenom"),
                                "Contact" => $request->input("Contact"),
                                "Adresse" => $request->input("Adresse"),
                                "Email" => $request->input("Email"),
                        ]);
                        $user = Utilisateur::find(session()->get('logged'));
                        Utilisateur::create([
                                'Pseudo'  => $request->input('Pseudo'),
                                'Password' => Hash::make($request->input('Password')),
                                'Role' => "user",
                                'BoutiqueId' => $user->BoutiqueId,
                                'id' => $personne->id,
                        ]);
                        return redirect()->route('User.Home')->with('Success', [2000 => "Création de l'utilisateur réussie."]);
                })->name('User.AddUser')->middleware('AutorisationCheck:Gérant');

                #region Abonnement

                /* 
        Page de la liste des abonnements
*/
                Route::get('user/abonnement/list', [UsersController::class, 'Abonnements'])->name('User.Abonnement.List');

                /* 
        Page d'ajout d'abonnement
*/
                Route::get('user/abonnement/add', [UsersController::class, 'AddAbonnementPage'])->name('User.Abonnement.AddPage');

                /* 
        Méthode d'ajout d'abonnement
*/
                Route::post('user/abonnement/add', [UsersController::class, 'AddAbonnement'])->name('User.Abonnement.Add');
                #endregion

                #region Catégorie

                /*
    Page de la liste des catégories disponibles
*/
                Route::get('user/categorie/list', [UsersController::class, 'Categories'])->name('User.Categorie.List');

                /*
    Page d'ajout de catégorie
*/
                Route::get('user/categorie/add', [UsersController::class, 'AddCategoriePage'])->name('User.Categorie.AddPage');

                /*
 Méthode d'ajout de catégorie
*/
                Route::post('user/categorie/add', [UsersController::class, 'AddCategorie'])->name('User.Categorie.Add');

                #endregion

                #region Article


                /* 
        Page de la liste des articles
*/
                Route::get('user/article/list', [UsersController::class, 'Articles'])->name('User.Article.List');

                /* 
        Page d'ajout d'un article
*/
                Route::get('user/article/add', [UsersController::class, 'AddArticlePage'])->name('User.Article.AddPage');

                /* 
        Méthode d'ajout d'un article
*/
                Route::post('user/article/add', [UsersController::class, 'AddArticle'])->name('User.Article.Add');

                /* 
        Méthode de suppression d'un article
*/
                Route::get('user/article/delete/{id}', [UsersController::class, 'ArticleDelete'])->name('User.Article.Delete');
                /* 
       Méthode de modification d'un article
*/
                Route::post('user/article/update', [UsersController::class, 'ArticleUpdate'])->name('User.Article.Update');


                #endregion

                #region Modèle

                /* 
        Page d'ajout de modèle d'article.
*/
                Route::get('user/modele/add', [UsersController::class, 'ModeleAddPage'])->name('User.Modele.AddPage');


                /* 
        Page de la liste des modèles d'article.
*/
                Route::get('user/modele/list', [UsersController::class, 'Modeles'])->name('User.Modele.List');

                /* 
        Méthode de suppression de modèle d'article.
*/
                Route::get('user/modele/delete/{id}', [UsersController::class, 'ModeleDelete'])->name('User.Modele.Delete');

                /* 
       Méthode d'ajout de modèle d'article.
*/
                Route::post('user/modele/add', [UsersController::class, 'ModeleAdd'])->name('User.Modele.Add');

                /* 
       Méthode de modification de modèle d'article.
*/
                Route::post('user/modele/update', [UsersController::class, 'ModeleUpdate'])->name('User.Modele.Update');

                #endregion

                #region Vente


                /* 
        Page de la liste des ventes.
*/
                Route::get('user/vente/list', [UsersController::class, 'Ventes'])->name('User.Vente.List');

                /* 
        Page d'ajout de vente.
*/
                Route::get('user/vente/add', [UsersController::class, 'VentePage'])->name('User.Vente.AddPage');

                /* 
        Méthode d'ajout de vente.
*/
                Route::post('user/vente/add', [UsersController::class, 'VenteAdd'])->name('User.Vente.Add');

                /* 
        Méthode de suppression de vente.
*/
                Route::get('user/vente/delete/{id}', [UsersController::class, 'VenteDelete'])->name('User.Vente.Delete');

                /* 
        Méthode d'impression d'une vente.
*/
                Route::get('user/vente/print/{id}', [UsersController::class, 'VentePrint'])->name('User.Vente.Print');


                #endregion

                #region Entrepôt

                /*
    Page de la liste des entrepôts disponibles
*/
                Route::get('user/entrepot/list', [UsersController::class, 'Entrepots'])->name('User.Entrepot.List');

                /*
    Page d'approvisionnement entre entrepots
*/
                Route::get('user/entrepot/approvisionnement', [UsersController::class, 'EntrepotApprovisionnement'])->name('User.Entrepot.Approvisionnement');

                /*
    Page d'ajout d'un entrepôt
*/
                Route::get('user/entrepot/add', [UsersController::class, 'AddEntrepotPage'])->name('User.Entrepot.AddPage');

                /*
    Méthode d'ajout d'un entrepôt
*/
                Route::post('user/entrepot/add', [UsersController::class, 'AddEntrepot'])->name('User.Entrepot.Add');

                /*
    Méthode de modification d'un entrepôt
*/
                Route::post('user/entrepot/update/{id}', [UsersController::class, 'EntrepotUpdate'])->name('User.Entrepot.Update');

                /*
    Méthode de suppression d'un entrepôt
*/
                Route::get('user/entrepot/delete/{id}', [UsersController::class, 'EntrepotDelete'])->name('User.Entrepot.Delete')->whereNumber('id');

                #endregion

                #region Paiement
                /* 
        Page de payement d'abonnement
*/
                Route::get('user/paiement', [UsersController::class, 'PaiementPage'])->name('User.Paiement.Page');
                #endregion

                #region Fournisseur

                /* 
        Page de la liste des fournisseur.
*/
                Route::get('user/fournisseur/list', [UsersController::class, 'Fournisseurs'])->name('User.Fournisseur.List');

                /* 
        Page d'ajout de fournisseur.
*/
                Route::get('user/fournisseur/add', [UsersController::class, 'FournisseurAddPage'])->name('User.Fournisseur.AddPage');

                /* 
        Méthode d'ajout de fournisseur.
*/
                Route::post('user/fournisseur/add', [UsersController::class, 'FournisseurAdd'])->name('User.Fournisseur.Add');

                /* 
        Méthode de modification de fournisseur.
*/
                Route::post('user/fournisseur/update', [UsersController::class, 'FournisseurUpdate'])->name('User.Fournisseur.Update');

                /* 
        Méthode de suppression de fournisseur.
*/
                Route::get('user/fournisseur/delete/{id}', [UsersController::class, 'FournisseurDelete'])->name('User.Fournisseur.Delete');


                #endregion

                #region Historique
                Route::group(['middleware' => ['AutorisationCheck:Gérant']], function () {
                        /* 
                        Page de la liste des commandes.
                        */
                        Route::get('user/historique/list', [UsersController::class, 'Historiques'])->name('User.Historique.List');

                        /* 
                        Méthode de suppression de commande.
                        */
                        Route::get('user/historique/delete/{id}', [UsersController::class, 'HistoriqueDelete'])->name('User.Historique.Delete');
                });
                #endregion

                #region Statistique

                Route::get('user/stats', [UsersController::class, 'Statistiques'])->name('User.Statistique');

                #endregion

                #region Profil utilisateur

                /* 
        Page d'information sur le profil.
*/
                Route::get('user/profil', [UsersController::class, 'Profil'])->name('User.Profil');
                /* 
        Page de mise à jour des informations sur le profil.
*/
                Route::get('user/profil/details/{id}', [UsersController::class, 'DetailsProfil'])->name('User.Profil.Details');
                /* 
        Méthode de mise à jour des informations sur le profil.
*/
                Route::post('user/profil/update', [UsersController::class, 'UpdateProfil'])->name('User.Profil.Update');
                /* 
       Méthode de suppression d'un utilisateur.
*/
                Route::get('user/delete/{id}', [UsersController::class, 'DeleteProfil'])->name('User.Profil.Delete');
                #endregion

                #region Client

                /* 
        Page de la liste des clients.
*/
                Route::get('user/client/list', [UsersController::class, 'Clients'])->name('User.Client.List');

                /* 
        Méthode du suppression d'un client.
*/
                Route::get('user/client/delete/{id}', [UsersController::class, 'ClientDelete'])->name('User.Client.Delete');

                /* 
        Méthode de mise à jour d'un client.
*/
                Route::post('user/client/update', [UsersController::class, 'ClientUpdate'])->name('User.Client.Update');
                #endregion

                #region Déconnexion
                Route::get('user/logout', [UsersController::class, 'LogOut'])->name('User.LogOut');
                #endregion

                #region Commande

                /* 
        Page de la liste des commandes.
*/
                Route::get('user/commande/list', [UsersController::class, 'Commandes'])->name('User.Commande.List');

                /* 
        Page d'ajout de commande.
*/
                Route::get('user/commande/add', [UsersController::class, 'CommandeAddPage'])->name('User.Commande.AddPage');

                /* 
        Méthode d'ajout de commande.
*/
                Route::post('user/commande/add', [UsersController::class, 'CommandeAdd'])->name('User.Commande.Add');

                /* 
        Méthode de modification de commande.
*/
                Route::post('user/commande/update', [UsersController::class, 'CommandeUpdate'])->name('User.Commande.Update');

                /* 
        Méthode de suppression de commande.
*/
                Route::get('user/commande/delete/{id}', [UsersController::class, 'CommandeDelete'])->name('User.Commande.Delete');

                /* 
        Méthode d'annulation d'une commande.
*/
                Route::get('user/commande/cancel/{id}', [UsersController::class, 'CommandeCancel'])->name('User.Commande.Cancel');
                /* 
        Méthode de restoration d'une commande.
*/
                Route::get('user/commande/restore/{id}', [UsersController::class, 'CommandeRestore'])->name('User.Commande.Restore');





                #endregion

                #region Approvisionnement
                /* 
                        Page de la liste des approvisionnement.
                */
                Route::get('user/approvisionnement/list', [UsersController::class, 'Approvisionnements'])->name('User.Approvisionnement.List');

                /* 
                        Page d'ajout de approvisionnement.
                */
                Route::get('user/approvisionnement/add', [UsersController::class, 'ApprovisionnementPage'])->name('User.Approvisionnement.AddPage');

                /* 
                        Méthode d'ajout de approvisionnement.
                */
                Route::post('user/approvisionnement/add', [UsersController::class, 'ApprovisionnementAdd'])->name('User.Approvisionnement.Add');

                /* 
                        Méthode de suppression de approvisionnement.
                */
                Route::get('user/approvisionnement/delete/{id}', [
                        UsersController::class, 'ApprovisionnementDelete'
                ])->name('User.Approvisionnement.Delete');
                #endregion

        }
);


#endregion

#region Admin
Route::group(['middleware' => ['AdminCheck']], function () {

        /* 
        Page d'ajout d'un administrateur
    */
        Route::get('add', [PagesController::class, 'Add'])->name('Admin.AddAdmin.Page');

        /* 
        Méthode pour ajouter un admin
    */
        Route::post('AddAdmin', [AdministrateursController::class, 'AddAdmin'])->name('Admin.AddAdmin');

        /* 
        Méthode de déconnexion
    */
        Route::get('admin/logout', [AdministrateursController::class, 'LogOut'])->name('Admin.LogOut');

        /* 
        Page d'accueil de l'admin
    */
        Route::get('admin/dashboard', [AdministrateursController::class, 'Index'])->name('Admin.Home');

        #region Utilisateur
        /* 
    Page de la liste des utilisateurs
    */
        Route::get('admin/utilisateur', [AdministrateursController::class, 'Utilisateur'])->name('Admin.Utilisateur.List');

        /* 
        Page de recherche utilisateur
    */
        Route::get('admin/utilisateur/search', [AdministrateursController::class, 'UtilisateurSearch'])->name('Admin.Utilisateur.Search');
        #endregion

        #region Abonnement
        /* 
       Page de la liste des abonnements
   */
        Route::get('admin/abonnement', [AdministrateursController::class, 'Abonnements'])->name('Admin.Abonnement.List');

        /* 
       méthode de recherche d'abonnement
   */
        Route::get('admin/abonnement/search', [AdministrateursController::class, 'AbonnementSearch'])->name('Admin.Abonnement.Search');
        #endregion

        #region Formule
        /* 
        Page de la liste des formules d'abonnement
    */
        Route::get('admin/formule', [AdministrateursController::class, 'Formules'])->name('Admin.Formule.List');

        /* 
        Page d'ajout de formule d'abonnement
    */
        Route::get('admin/formule/add', [AdministrateursController::class, 'AddFormulePage'])->name('Admin.Formule.AddPage');

        /* 
       Méthode d'ajout de formule d'abonnement
    */
        Route::post('admin/formule/add', [AdministrateursController::class, 'AddFormule'])->name('Admin.Formule.Add');

        /* 
        Page de détails de formule d'abonnement
    */
        Route::get('admin/formule/details/{id}', [AdministrateursController::class, 'FormuleDetails'])->name('Admin.Formule.Details')->whereNumber('id');

        /* 
        Méthode de recherche de formule d'abonnement
    */
        Route::get('admin/formule/search', [AdministrateursController::class, 'FormuleSearch'])->name('Admin.Formule.Search');

        /* 
       Méthode de modification de formule d'abonnement
    */
        Route::post('admin/formule/update', [AdministrateursController::class, 'UpdateFormule'])->name('Admin.Formule.Update');

        /* 
       Page de modification de formule d'abonnement
    */
        Route::get('admin/formule/update/{id}', [AdministrateursController::class, 'UpdateFormulePage'])->name('Admin.Formule.UpdatePage')->whereNumber('id');

        /* 
       Méthode de suppression de formule d'abonnement
    */
        Route::get('admin/formule/delete/{id}', [AdministrateursController::class, 'DeleteFormule'])->name('Admin.Formule.Delete')->whereNumber('id');
        #endregion

        #region Avantage

        /* 
        Page de la liste des avantages de formules 
    */
        Route::get('admin/avantage/list', [AdministrateursController::class, 'Avantages'])->name('Admin.Avantage.List');

        /* 
        Page d'ajout d'avantage de formule 
    */
        Route::get('admin/avantage/add', [AdministrateursController::class, 'AddAvantagePage'])->name('Admin.Avantage.AddPage');

        /* 
        Page de modification d'avantage de formule 
    */
        Route::get('admin/avantage/update/{id}', [AdministrateursController::class, 'UpdateAvantagePage'])->name('Admin.Avantage.UpdatePage')->whereNumber('id');

        /* 
        Méthode de masquage d'avantage de formule 
    */
        Route::get('admin/avantage/hide/{id}', [AdministrateursController::class, 'AvantageHide'])->name('Admin.Avantage.Masquer');

        /* 
        Méthode de suppression d'avantage de formule 
    */
        Route::get('admin/avantage/delete/{id}', [AdministrateursController::class, 'AvantageDelete'])->name('Admin.Avantage.Delete')->whereNumber('id');

        /* 
        Méthode de restauration d'avantage de formule 
    */
        Route::get('admin/avantage/restore/{id}', [AdministrateursController::class, 'AvantageRestore'])->name('Admin.Avantage.Restore')->whereNumber('id');

        /* 
        Méthode de modification d'avantage de formule 
    */
        Route::post('admin/avantage/update', [AdministrateursController::class, 'AvantageUpdate'])->name('Admin.Avantage.Update');

        /* 
        Méthode de recherche d'avantage de formule 
    */
        Route::get('admin/avantage/search', [AdministrateursController::class, 'SearchAvantage'])->name('Admin.Avantage.Search');

        /* 
       Méthode d'ajout d'avantage de formule
    */
        Route::post('admin/avantage/add', [AdministrateursController::class, 'AddAvantage'])->name('Admin.Avantage.Add');

        #endregion

        #region Boutique
        /* 
        Page de la liste des boutiques
    */
        Route::get('admin/boutique', [AdministrateursController::class, 'Boutiques'])->name('Admin.Boutique.List');

        /* 
        Page de trie des boutiques
    */
        Route::get('admin/boutique/trie', [AdministrateursController::class, 'TrieBoutique'])->name('Admin.Boutique.Trie');

        /* 
        Page de la liste des boutiques
    */
        Route::get('admin/boutique/search', [AdministrateursController::class, 'RechercheBoutique'])->name('Admin.Boutique.Search');

        /* 
        Page de détails de boutique
    */
        Route::get('admin/boutique/details/{id}', [AdministrateursController::class, 'BoutiqueDetails'])->name('Admin.Boutique.Details')->whereNumber('id');

        /* 
    Méthode de suppression de boutique
    */
        Route::post('admin/boutique/delete', [AdministrateursController::class, 'DeleteBoutique'])->name('Admin.Boutique.Delete');
        #endregion

        #region Historique    
        /* 
        Page de la liste des historiques
    */
        Route::get('admin/historique', [AdministrateursController::class, 'Historiques'])->name('Admin.Historique.List');

        /* 
        Méthode de recherche d'historiques
    */
        Route::get('admin/historique/search', [AdministrateursController::class, 'HistoriqueSearch'])->name('Admin.Historique.Search');

        /* 
        Méthode de suppression d'historiques
    */
        Route::get('admin/historique/delete/{id}', [AdministrateursController::class, 'HistoriqueDelete'])->name('Admin.Historique.Delete')->whereNumber('id');

        #endregion
});
#endregion
