<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login Register | Notika - Notika Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
  ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="/client/img/favicon.ico">
    <!-- Google Fonts
  ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/bootstrap.min.css">
    <!-- font awesome CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/font-awesome.min.css">
    <!-- owl.carousel CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
    <link rel="stylesheet" href="/client/css/owl.carousel.css">
    <link rel="stylesheet" href="/client/css/owl.theme.css">
    <link rel="stylesheet" href="/client/css/owl.transitions.css">
    <!-- animate CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/animate.css">
    <!-- normalize CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/normalize.css">
    <!-- mCustomScrollbar CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- wave CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <!-- Notika icon CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <!-- main CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/main.css">
    <!-- style CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/style.css">
    <!-- responsive CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/responsive.css">
    <!-- modernizr JS
  ============================================ -->
    <script src="/client/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <form action="{{ route('SignIn') }}" method="POST">
        @csrf
        <div class="login-content">
            <!-- Register -->
            <div class="nk-block toggled" id="Boutique">
                <div class="nk-form">
                    <div class="nk-form-header">
                        Information sur votre boutique
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-shopping-bag"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" name="BoutiqueName"
                                placeholder="Nom de la boutique">
                        </div>
                    </div>
                    <div class="input-group  mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-archive"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" name="BoutiqueSite"
                                placeholder="Site web de la boutique">
                        </div>
                        <small>Peut être vide</small>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-mail"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Addresse Email de la boutique"
                                name="BoutiqueEmail">
                        </div>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-at"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Adresse de la boutique"
                                name="BoutiqueAdresse">
                        </div>
                    </div>

                    <a href="#User" data-ma-action="nk-login-switch" data-ma-block="#User"
                        class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></a>
                </div>
            </div>
            <div class="nk-block" id="User">
                <div class="nk-form">
                    <div class="nk-form-header">
                        Information sur le gérant de la boutique
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Nom" class="form-control" value="{{ old('Nom') }}"
                                placeholder="Nom du gérant">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-user"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Prenom" class="form-control" value="{{ old('Prenom') }}"
                                placeholder="Prénom du gérant">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-mail"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Email" class="form-control" value="{{ old('Email') }}"
                                placeholder="Email du gérant">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-at"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Adresse" class="form-control" value="{{ old('Adresse') }}"
                                placeholder="Adresse">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><span
                                class="glyphicon glyphicon-minus"></span></span>
                        <div class="nk-int-st">
                            <input type="text" name="Contact" class="form-control" value="{{ old('Contact') }}"
                                placeholder="Contact">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Pseudo" class="form-control" value="{{ old('Pseudo') }}"
                                placeholder="Pseudo">
                        </div>
                    </div>
                    @error('Pseudo')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                        <div class="nk-int-st">
                            <input type="password" class="form-control" name="Password" placeholder="Mot de passe">
                        </div>
                    </div>
                    @error('Password')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#Abonnement"
                    class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></a>
                <div class="nk-navigation nk-lg-ic">
                    <a href="#" data-ma-action="nk-login-switch" data-ma-block="#Boutique">
                        <i class="notika-icon notika-left-arrow"></i>
                        <span>Retour à l'arrière</span>
                    </a>

                </div>
            </div>
            <div class="nk-block" id="Abonnement">
                <div class="nk-form">
                    <div class="nk-form-header">
                        Abonnement
                    </div>

                    <div class="form-example-int form-horizental mt-5">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm">Formule d'abonnement</label>
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <div class="chosen-select-act fm-cmp-mg">
                                        <select class="chosen" id="FormuleSelected" name="Formule">
                                            <option value="0"> Séléctionner la formule </option>
                                            @if ($id)
                                                @forelse ($formules as $item)
                                                    @if ($item->id == $id)
                                                        <option selected value="{{ $item->id }}">
                                                            {{ $item->Libelle }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->Libelle }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option disabled>Aucune formule</option>
                                                @endforelse
                                            @else
                                                @forelse ($formules as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->Libelle }}
                                                    </option>
                                                @empty
                                                    <option disabled>Aucune formule</option>
                                                @endforelse
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" data-ma-block="#l-register" class="btn btn-login btn-success btn-float"><i
                            class="notika-icon notika-right-arrow right-arrow-ant"></i></button>
                </div>
                <div class="nk-navigation nk-lg-ic">
                    <a href="#" data-ma-action="nk-login-switch" data-ma-block="#User">
                        <i class="notika-icon notika-left-arrow"></i>
                        <span>Retour à l'arrière</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
    <!-- Login Register area End-->
    <!-- jquery
  ============================================ -->
    <script src="/client/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
  ============================================ -->
    <script src="/client/js/bootstrap.min.js"></script>
    <!-- wow JS
  ============================================ -->
    <script src="/client/js/wow.min.js"></script>
    <!-- price-slider JS
  ============================================ -->
    <script src="/client/js/jquery-price-slider.js"></script>
    <!-- owl.carousel JS
  ============================================ -->
    <script src="/client/js/owl.carousel.min.js"></script>
    <!-- scrollUp JS
  ============================================ -->
    <script src="/client/js/jquery.scrollUp.min.js"></script>
    <!-- meanmenu JS
  ============================================ -->
    <script src="/client/js/meanmenu/jquery.meanmenu.js"></script>
    <!-- counterup JS
  ============================================ -->
    <script src="/client/js/counterup/jquery.counterup.min.js"></script>
    <script src="/client/js/counterup/waypoints.min.js"></script>
    <script src="/client/js/counterup/counterup-active.js"></script>
    <!-- mCustomScrollbar JS
  ============================================ -->
    <script src="/client/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sparkline JS
  ============================================ -->
    <script src="/client/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="/client/js/sparkline/sparkline-active.js"></script>
    <!-- flot JS
  ============================================ -->
    <script src="/client/js/flot/jquery.flot.js"></script>
    <script src="/client/js/flot/jquery.flot.resize.js"></script>
    <script src="/client/js/flot/flot-active.js"></script>
    <!-- knob JS
  ============================================ -->
    <script src="/client/js/knob/jquery.knob.js"></script>
    <script src="/client/js/knob/jquery.appear.js"></script>
    <script src="/client/js/knob/knob-active.js"></script>
    <!--  Chat JS
  ============================================ -->
    <script src="/client/js/chat/jquery.chat.js"></script>
    <!--  wave JS
  ============================================ -->
    <script src="/client/js/wave/waves.min.js"></script>
    <script src="/client/js/wave/wave-active.js"></script>
    <!-- icheck JS
  ============================================ -->
    <script src="/client/js/icheck/icheck.min.js"></script>
    <script src="/client/js/icheck/icheck-active.js"></script>
    <!--  todo JS
  ============================================ -->
    <script src="/client/js/todo/jquery.todo.js"></script>
    <!-- Login JS
  ============================================ -->
    <script src="/client/js/login/login-action.js"></script>
    <script src="/client/js/chosen/chosen.jquery.js"></script>

    <!-- plugins JS
  ============================================ -->
    <script src="/client/js/plugins.js"></script>
    <!-- main JS
      
  ============================================ -->
    <script src="/client/js/main.js"></script>
    <script>
        $(".chosen").chosen({
            disable_search_threshold: 2,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });
    </script>
</body>

</html>
