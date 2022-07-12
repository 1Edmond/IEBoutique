    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="/admin/images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="/admin/images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{route('Admin.Home')}}"> <i class="menu-icon fa fa-dashboard"></i>Accueil </a>
                    </li>
                    <h3 class="menu-title">Gestion</h3><!-- /.menu-title -->
                    <li class="menu-item">
                        <a href="{{route("Admin.Boutique.List")}}" > <i class="menu-icon fa fa-credit-card"></i>Boutique</a>
                  </li>
                    <li class="menu-item">
                        <a href="{{route("Admin.Utilisateur.List")}}" > <i class="menu-icon fa fa-users"></i>Utilisateur</a>
                    </li>
                  <li class="menu-item">
                        <a href="{{route("Admin.Abonnement.List")}}" > <i class="menu-icon fa fa-money"></i>Abonnement</a>
                  </li>
                 
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bookmark-o"></i>Avantages de formules</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-list"></i><a href="{{route("Admin.Avantage.List")}}">Lister les avantages</a></li>
                            <li><i class="menu-icon fa fa-plus"></i><a href="{{route("Admin.Avantage.AddPage")}}">Ajouter avantage</a></li>
                           {{-- <li><i class="menu-icon fa fa-info"></i><a href="{{route("Admin.formule.List")}}">Modifier</a></li>
                            <li><i class="menu-icon fa fa-trash"></i><a href="{{route("Admin.formule.List")}}">Supprimer</a></li>--}}
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-building-o"></i>Formules</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-list"></i><a href="{{route("Admin.Formule.List")}}">Lister les formules</a></li>
                            <li><i class="menu-icon fa fa-plus"></i><a href="{{route("Admin.Formule.AddPage")}}">Ajouter formule</a></li>
                           {{-- <li><i class="menu-icon fa fa-info"></i><a href="{{route("Admin.formule.List")}}">Modifier</a></li>
                            <li><i class="menu-icon fa fa-trash"></i><a href="{{route("Admin.formule.List")}}">Supprimer</a></li>--}}
                        </ul>
                    </li>
                    {{-- 
                    <h3 class="menu-title">Icons</h3><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="font-fontawesome.html">Font Awesome</a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="font-themify.html">Themefy Icons</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="widgets.html"> <i class="menu-icon ti-email"></i>Widgets </a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Charts</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-line-chart"></i><a href="charts-chartjs.html">Chart JS</a></li>
                            <li><i class="menu-icon fa fa-area-chart"></i><a href="charts-flot.html">Flot Chart</a></li>
                            <li><i class="menu-icon fa fa-pie-chart"></i><a href="charts-peity.html">Peity Chart</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Maps</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-map-o"></i><a href="maps-gmap.html">Google Maps</a></li>
                            <li><i class="menu-icon fa fa-street-view"></i><a href="maps-vector.html">Vector Maps</a></li>
                        </ul>
                    </li>
                    <h3 class="menu-title">Extras</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Pages</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="page-login.html">Login</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="page-register.html">Register</a></li>
                            <li><i class="menu-icon fa fa-paper-plane"></i><a href="pages-forget.html">Forget Pass</a></li>
                        </ul>
                    </li>--}}
                    <li class="menu-item">
                        <a href="{{route('Admin.Historique.List')}}"> <i class="menu-icon fa  fa-archive"></i>Historique des activités</a>
                  </li>
                    <li class="menu-item">
                        <a href="{{route('Admin.AddAdmin.Page')}}"> <i class="menu-icon fa  fa-user"></i>Ajouter un administrateur</a>
                  </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>