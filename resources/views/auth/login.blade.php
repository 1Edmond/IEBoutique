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
    <link rel="shortcut icon" type="image/x-icon" href="client/img/favicon.ico">
    <!-- Google Fonts
  ============================================ -->
    <link href="client/https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/bootstrap.min.css">
    <!-- font awesome CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/font-awesome.min.css">
    <!-- owl.carousel CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/owl.carousel.css">
    <link rel="stylesheet" href="client/css/owl.theme.css">
    <link rel="stylesheet" href="client/css/owl.transitions.css">
    <!-- animate CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/animate.css">
    <!-- normalize CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/normalize.css">
    <!-- mCustomScrollbar CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- wave CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/wave/waves.min.css">
    <!-- Notika icon CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/notika-custom-icon.css">
    <!-- main CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/main.css">
    <!-- style CSS
  ============================================ -->
    <link rel="stylesheet" href="client/style.css">
    <!-- responsive CSS
  ============================================ -->
    <link rel="stylesheet" href="client/css/responsive.css">
    <!-- modernizr JS
  ============================================ -->
    <script src="client/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="client/http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Login Register area Start-->
    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled" id="l-login">
            <form action="{{ route('Login') }}" method="POST">
                @csrf
                @if (Session::get('fail'))
                <div class="row">
                    <div class="col-md-24">
                        <span class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </span>
                    </div>
                </div>
                @endif
                <div class="nk-form">
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" name="Pseudo" class="form-control" value="{{old('Pseudo')}}" placeholder="Pseudo">
                        </div>
                    </div>
                    @error('Pseudo')
                    <div class="alert alert-danger">
                            {{$message}}
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
                            {{$message}}
                        </div>
                        @enderror
                    <div class="fm-checkbox">
                        <label><input type="checkbox" class="i-checks" checked> <i></i> Garder ma session active</label>
                    </div>
                    <button type="submit" data-ma-block="#l-register"
                        class="btn btn-login btn-success btn-float"><i
                            class="notika-icon notika-right-arrow right-arrow-ant"></i></button>
                </div>
            </form>

            <div class="nk-navigation nk-lg-ic">
                {{-- <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-register"><i
                        class="notika-icon notika-plus-symbol"></i> <span>Inscription</span></a> --}}
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Mot
                        de passe oublié</span></a>
            </div>
        </div>
        <!-- Register -->
        {{-- <div class="nk-block" id="l-register">
            <div class="nk-form">
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Username">
                        </div>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-mail"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Email Address">
                        </div>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                        <div class="nk-int-st">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <a href="client/#l-login" data-ma-action="nk-login-switch" data-ma-block="#l-login"
                        class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></a>
                </form>
            </div>
            <div class="nk-navigation rg-ic-stl">
                <a href="client/#" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i
                        class="notika-icon notika-right-arrow"></i> <span>Sign in</span></a>
                <a href="client/" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password"><i>?</i>
                    <span>Forgot Password</span></a>
            </div>
        </div> --}}
        <!-- Forgot Password -->
        <div class="nk-block" id="l-forget-password">
            <form action="{{route('Login')}}" method="post">
                @csrf
                <div class="nk-form">
                    <p class="text-left">Saisissez votre email pour que l'on modifie vos indformation.</p>
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-mail"></i></span>
                        <div class="nk-int-st">
                            <input type="email" name="Email"  class="form-control" placeholder="Adresse Email">
                        </div>
                    </div>
                    <span class="alert alert-danger">
                        Erreur
                    </span>
                    <button data-ma-block="#l-login" type="submit"
                        class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></button>
                </div>

            </form>
            <div class="nk-navigation nk-lg-ic rg-ic-stl">
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i
                        class="notika-icon notika-right-arrow"></i> <span>Connexion</span></a>
            </div>
        </div>
    </div>
    <!-- Login Register area End-->
    <!-- jquery
  ============================================ -->
    <script src="client/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
  ============================================ -->
    <script src="client/js/bootstrap.min.js"></script>
    <!-- wow JS
  ============================================ -->
    <script src="client/js/wow.min.js"></script>
    <!-- price-slider JS
  ============================================ -->
    <script src="client/js/jquery-price-slider.js"></script>
    <!-- owl.carousel JS
  ============================================ -->
    <script src="client/js/owl.carousel.min.js"></script>
    <!-- scrollUp JS
  ============================================ -->
    <script src="client/js/jquery.scrollUp.min.js"></script>
    <!-- meanmenu JS
  ============================================ -->
    <script src="client/js/meanmenu/jquery.meanmenu.js"></script>
    <!-- counterup JS
  ============================================ -->
    <script src="client/js/counterup/jquery.counterup.min.js"></script>
    <script src="client/js/counterup/waypoints.min.js"></script>
    <script src="client/js/counterup/counterup-active.js"></script>
    <!-- mCustomScrollbar JS
  ============================================ -->
    <script src="client/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sparkline JS
  ============================================ -->
    <script src="client/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="client/js/sparkline/sparkline-active.js"></script>
    <!-- flot JS
  ============================================ -->
    <script src="client/js/flot/jquery.flot.js"></script>
    <script src="client/js/flot/jquery.flot.resize.js"></script>
    <script src="client/js/flot/flot-active.js"></script>
    <!-- knob JS
  ============================================ -->
    <script src="client/js/knob/jquery.knob.js"></script>
    <script src="client/js/knob/jquery.appear.js"></script>
    <script src="client/js/knob/knob-active.js"></script>
    <!--  Chat JS
  ============================================ -->
    <script src="client/js/chat/jquery.chat.js"></script>
    <!--  wave JS
  ============================================ -->
    <script src="client/js/wave/waves.min.js"></script>
    <script src="client/js/wave/wave-active.js"></script>
    <!-- icheck JS
  ============================================ -->
    <script src="client/js/icheck/icheck.min.js"></script>
    <script src="client/js/icheck/icheck-active.js"></script>
    <!--  todo JS
  ============================================ -->
    <script src="client/js/todo/jquery.todo.js"></script>
    <!-- Login JS
  ============================================ -->
    <script src="client/js/login/login-action.js"></script>
    <!-- plugins JS
  ============================================ -->
    <script src="client/js/plugins.js"></script>
    <!-- main JS
  ============================================ -->
    <script src="client/js/main.js"></script>
</body>

</html>
