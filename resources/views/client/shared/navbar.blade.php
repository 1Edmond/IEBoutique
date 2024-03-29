<div class="main-menu-area mg-tb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li id="AbonnementNavHeader"><a data-toggle="tab" href="#NavAbonnement"><i
                                class="notika-icon notika-house"></i>
                            Abonnement</a>
                    </li>
                    <li id="ApprovisonnementNavHeader"><a data-toggle="tab" href="#NavApprovisionnements"><i
                                class="notika-icon notika-mail"></i>
                            Approvisonnement</a>
                    </li>
                    <li id="ArticleNavHeader"><a data-toggle="tab" href="#NavArticles"><i
                                class="notika-icon notika-edit"></i> Article</a>
                    </li>
                    <li id="CategorieNavHeader"><a data-toggle="tab" href="#NavCategories"><i
                                class="notika-icon notika-bar-chart"></i>
                            Categorie</a>
                    </li>
                    <li id="CommandeNavHeader"><a data-toggle="tab" href="#NavCommandes"><i
                                class="notika-icon notika-windows"></i>
                            Commande</a>
                    </li>
                    <li id="EntrepotsNavHeader"><a data-toggle="tab" href="#NavEntrepots"><i
                                class="notika-icon notika-form"></i> Entrepôts</a>
                    </li>
                    <li id="FournisseursNavHeader"><a data-toggle="tab" href="#NavFournisseurs"><i
                                class="notika-icon notika-app"></i>
                            Fournisseurs</a>
                    </li>
                    <li id="ModelsNavHeader"><a data-toggle="tab" href="#NavModels"><i class="fa fa-archive"></i>
                            Modèles</a>
                    </li>
                    <li id="VentesNavHeader"><a data-toggle="tab" href="#NavVentes"><i class="fa fa-money"></i>
                            Ventes</a>
                    </li>

                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="NavAbonnement" class="tab-pane in notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Abonnement.List') }}">Voir mes abonnements</a>
                            </li>
                            <li><a href="{{ route('User.Abonnement.AddPage') }}">Faire un abonnement</a>
                            </li>
                        </ul>
                    </div>
                    <div id="NavApprovisionnements" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Approvisionnement.List') }}">Lister les approvisonnements</a>
                            </li>
                            <li><a href="{{ route('User.Approvisionnement.AddPage') }}">Ajouter un approvisonnement</a>
                            </li>
                        </ul>
                    </div>
                    <div id="NavArticles" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Article.List') }}">Lister les articles</a></li>
                            <li><a href="{{ route('User.Article.AddPage') }}">Ajouter un article</a></li>
                        </ul>
                    </div>
                    <div id="NavCategories" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Categorie.List') }}">Lister les catégories</a></li>
                            <li><a href="{{ route('User.Categorie.AddPage') }}">Ajouter une catégorie</a></li>
                        </ul>
                    </div>
                    <div id="NavCommandes" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Commande.List') }}">Voir toutes les commandes</a></li>
                            <li><a href="{{ route('User.Commande.AddPage') }}">Faire une demande</a></li>
                        </ul>
                    </div>
                    <div id="NavEntrepots" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Entrepot.List') }}">Voir tous les entrepôts</a></li>
                            <li><a href="{{ route('User.Entrepot.AddPage') }}">Ajouter un entrepôt</a></li>
                            <li class="hidden">
                                <a href="{{ route('User.Entrepot.Approvisionnement') }}">
                                    Approvisionnement entre entrepôt
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="NavFournisseurs" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Fournisseur.List') }}">Lister vos fournisseurs</a></li>
                            <li><a href="{{ route('User.Fournisseur.AddPage') }}">Ajouter un fournisseur</a>
                            </li>
                        </ul>
                    </div>
                    <div id="NavModels" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Modele.List') }}">Voir les modèles disponible</a></li>
                            <li><a href="{{ route('User.Modele.AddPage') }}">Ajouter un modèle</a></li>
                        </ul>
                    </div>
                    <div id="NavVentes" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{ route('User.Vente.List') }}">Voir toutes les ventes</a></li>
                            <li><a href="{{ route('User.Vente.AddPage') }}">Faire une vente</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
