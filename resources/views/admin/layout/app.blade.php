<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sufee Admin - HTML5 Admin Template</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="/admin/apple-icon.png">
    <link rel="shortcut icon" href="/admin/favicon.ico">
    @yield('styles')

    <link rel="stylesheet" href="/admin/vendors/chosen/chosen.min.css">
    <link rel="stylesheet" href="/admin/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/admin/vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="/admin/vendors/jqvmap/dist/jqvmap.min.css">


    <link rel="stylesheet" href="/admin/assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <!--Navbar --->
    @include('admin.shared.navbar')
    <!--Fin Navbar --->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- TopPanel-->
        @include('admin.shared.topPanel')
        <!-- Fin Top Panel -->
        <!--Page info-->
        @include('admin.shared.pageInfo')
        <!--Fin Page info-->
        <!-- Contenu -->
        @yield('content')
        <!-- Fin Contenu -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="/admin/vendors/jquery/dist/jquery.min.js"></script>
    <script src="/admin/vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/admin/assets/js/main.js"></script>
    <script src="/admin/vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="/admin/assets/js/dashboard.js"></script>
    <script src="/admin/assets/js/widgets.js"></script>
    <script src="/admin/vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/admin/vendors/chosen/chosen.jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script >
      $(document).ready( function () {
        $('#historiquesTable').DataTable();
      });
      </script>
    @yield('script')

    
</body>

</html>
