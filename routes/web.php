<?php

use App\Http\Controllers\AdministrateursController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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



#region Utilisateur

/* 
        Page d'accueil de l'utilisateur
*/
Route::get('user/', [UsersController::class, 'Index'])->name('User.Home');

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

#region Entrepôt

/*
    Page de la liste des entrepôts disponibles
*/
Route::get('user/entrepot/list', [UsersController::class, 'Entrepots'])->name('User.Entrepot.List');

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
