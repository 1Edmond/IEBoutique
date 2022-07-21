<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard One | Notika - Notika Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
  ============================================ -->
    @yield('style')
    <link rel="shortcut icon" type="image/x-icon" href="/client/img/favicon.ico">
    <!-- Google Fonts
  ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/bootstrap.min.css">
    <!-- Bootstrap CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/font-awesome.min.css">
    <!-- owl.carousel CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/owl.carousel.css">
    <link rel="stylesheet" href="/client/css/owl.theme.css">
    <link rel="stylesheet" href="/client/css/owl.transitions.css">
    <!-- meanmenu CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/meanmenu/meanmenu.min.css">
    <!-- animate CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/animate.css">
    <!-- normalize CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/normalize.css">
    <!-- mCustomScrollbar CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- jvectormap CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/jvectormap/jquery-jvectormap-2.0.3.css">
    <!-- notika icon CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <!-- wave CSS
  ============================================ -->
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
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
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="/client/http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Start Header Top Area -->
    @include('client.shared.headerPanel')
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
    @include('client.shared.mobileMenu')
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->
    @include('client.shared.navbar')
    <!-- Main Menu area End-->
    @include('client.shared.pageInfo')
    <!-- Start Status area -->
    @yield('content')
    <!-- End Realtime sts area-->
    <!-- Start Footer area-->
    @include('client.shared.footer')
    <!-- End Footer area-->
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
    <!-- jvectormap JS
  ============================================ -->
    <script src="/client/js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/client/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/client/js/jvectormap/jvectormap-active.js"></script>
    <!-- sparkline JS
  ============================================ -->
    <script src="/client/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="/client/js/sparkline/sparkline-active.js"></script>
    <!-- sparkline JS
  ============================================ -->
    <script src="/client/js/flot/jquery.flot.js"></script>
    <script src="/client/js/flot/jquery.flot.resize.js"></script>
    <script src="/client/js/flot/curvedLines.js"></script>
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
    <!--  todo JS
  ============================================ -->
    <script src="/client/js/todo/jquery.todo.js"></script>
    <!-- plugins JS
  ============================================ -->
    <script src="/client/js/plugins.js"></script>
    <!--  Chat JS
  ============================================ -->
    <script src="/client/js/chat/moment.min.js"></script>
    <script src="/client/js/chat/jquery.chat.js"></script>
    <!-- main JS
  ============================================ -->
    <script src="/client/js/main.js"></script>
    <!-- tawk chat JS
  ============================================ -->
    <script src="/client/js/tawk-chat.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>

    @yield('script')

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
    @if (Session::get('fail'))
        <script>
            $.growl("{{ Session::get('fail') }}", {
                type: 'danger',
                delay: 7000,
            });
        </script>
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
</body>

</html>
