<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>404 Page | Notika - Notika Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
  ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
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
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- 404 Page area Start-->
    <div class="error-page-area">
        <div class="error-page-wrap">
            <i class="fa fa-plus"></i>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{ route('User.AddUser') }}" method="POST">
                        @csrf
                        <div class="form-example-wrap mg-t-30">
                            <div class="cmp-tb-hd cmp-int-hd">
                                <h2>Information sur l'utilisateur</h2>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Email</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Email" class="form-control input-sm"
                                                    placeholder="L'email de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Nom</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Nom" class="form-control input-sm"
                                                    placeholder="Le nom de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Prénom</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Prenom" class="form-control input-sm"
                                                    placeholder="Le prénom de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Adresse</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Adresse" class="form-control input-sm"
                                                    placeholder="L'adresse de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Contact</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Contact" class="form-control input-sm"
                                                    placeholder="Le contact de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Pseudo</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" name="Pseudo" class="form-control input-sm"
                                                    placeholder="Le pseudo de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental mg-t-15">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Mot de passe</label>
                                        </div>
                                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="password" name="Password" class="form-control input-sm"
                                                    placeholder="Le mot de passe de l'utilisateur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int mg-t-15">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <button class="btn btn-success notika-btn-success">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 Page area End-->
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
    <!--  wave JS
  ============================================ -->
    <script src="/client/js/wave/waves.min.js"></script>
    <script src="/client/js/wave/wave-active.js"></script>
    <!--  Chat JS
  ============================================ -->
    <script src="/client/js/chat/jquery.chat.js"></script>
    <!--  todo JS
  ============================================ -->
    <script src="/client/js/todo/jquery.todo.js"></script>
    <!-- plugins JS
  ============================================ -->
    <script src="/client/js/plugins.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>

    <!-- main JS
  ============================================ -->
    <script src="/client/js/main.js"></script>
    @if (Session::get('Success'))
        @if (count(Session::get('Success')) > 0)
            @foreach (Session::get('Success') as $item => $value)
                <script>
                    $.growl('{{ $value }}', {
                        type: 'success',
                        delay: 2000 + {{ $item }},
                    });
                </script>
            @endforeach
        @else
            <script>
                $.growl("{{ Session::get('Success') }}", {
                    type: 'success',
                    delay: 2000,
                });
            </script>
        @endif
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $.growl("{{ $error }}", {
                    type: 'info',
                    delay: 5000,
                });
            </script>
        @endforeach
    @endif
    @if (Session::get('fail'))
        <script>
            $.growl("{{ Session::get('fail') }}", {
                type: 'danger',
                delay: 7000,
            });
        </script>
    @endif
</body>

</html>
