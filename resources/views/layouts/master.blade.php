<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droit pour le praticien</title>
    <meta name="author" content="@Designpond | Cindy Leschaud">
    <meta name="description" content="Droit pour le praticien">
    <meta name="_token" content="<?php echo csrf_token(); ?>">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <link rel="manifest" href="images/favicon/site.webmanifest">

    <!-- Fonts URL -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700%7CPlayfair+Display:400,500,600,700,800,900%7CWork+Sans:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ secure_asset('css/datatables-addon.css') }}?{{ rand(1,3000) }}" rel="stylesheet" >

    <link href="{{ secure_asset('css/all.css') }}" rel="stylesheet">
    <link href="//printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/muzex-icons.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}?{{ rand(1,3000) }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}?{{ rand(1,3000) }}">
    <link rel="stylesheet" href="{{ secure_asset('css/home.css') }}?{{ rand(1,3000) }}">
    <link rel="stylesheet" href="{{ secure_asset('css/responsive.css') }}">

</head>

<body>

<!--<div class="preloader">
    <div class="lds-ripple">
        <div></div>
        <div></div>
    </div>
</div> /.preloader -->
<div class="page-wrapper d-flex flex-column justify-content-between">

    <div class="main_nav_bar">
        @include('partials.header')
        @include('flash::message')
    </div>

    <div class="flex-grow-2 align-content-stretch">
        <!-- Contenu -->
        @yield('content')
        <!-- Fin contenu -->
    </div>

    @include('partials.footer')

</div><!-- /.page-wrapper -->

<div class="search-popup">
    <div class="search-popup__overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div><!-- /.search-popup__overlay -->
    <div class="search-popup__inner">
        <form action="#" class="search-popup__form">
            <input type="text" name="search" placeholder="Type here to Search....">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div><!-- /.search-popup__inner -->
</div><!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- Template JS -->

<script src="{{ secure_asset('js/jquery-3.5.1.min.js') }}"></script>
{<script src="{{ secure_asset('js/datatables.min.js') }}"></script>
<script src="{{ secure_asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ secure_asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ secure_asset('js/isotope.js') }}"></script>
<script src="{{ secure_asset('js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.counterup.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ secure_asset('js/messages_fr.js') }}"></script>
<script src="{{ secure_asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ secure_asset('js/TweenMax.min.js') }}"></script>
<script src="{{ secure_asset('js/wow.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.lettering.min.js') }}"></script>
<script src="{{ secure_asset('js/jquery.circleType.js') }}"></script>
<script src="//printjs-4de6.kxcdn.com/print.min.js"></script>
<!-- Custom Scripts -->
<script src="{{ secure_asset('js/theme.js') }}"></script>
<script src="{{ secure_asset('js/app.js') }}"></script>

</body>

</html>
