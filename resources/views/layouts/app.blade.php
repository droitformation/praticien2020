<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Backend Droitpraticien" name="description" />
    <meta content="@DesignPond" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="{{ secure_asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/custom.css') }}" rel="stylesheet">

    <script src="{{ secure_asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ secure_asset('js/datatables.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/main.js') }}"></script>

</head>
<body>
    <!-- Begin page -->
    <div id="wrapper">

        @include('backend.partials.topbar')
        @include('backend.partials.navigation')

        @yield('content')

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        2019 &copy; Shreyu. All Rights Reserved. Crafted with <i class='uil uil-heart text-danger font-size-12'></i> by <a href="https://coderthemes.com" target="_blank">Coderthemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>



    <!-- Scripts -->
{{--    <script src="{{ asset('assets/js/app.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}" defer></script>--}}

</body>
</html>
