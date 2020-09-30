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

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'url'   => secure_url('/'),
        ]); ?>
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ secure_asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/app.min.css') }}?{{ rand(1000,23456) }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/hunterPopup.css') }}?{{ rand(1000,23456) }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/redactor.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/js/plugins/filemanager.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/bootstrap-datepicker.min.css') }}">
    <link href="{{ secure_asset('assets/css/flatpickr.min.css') }}?{{ rand(1000,23456) }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/css/custom.css') }}?{{ rand(1000,23456) }}" rel="stylesheet">

</head>
<body>
    <!-- Begin page -->
    <div id="wrapper">

        @include('backend.partials.topbar')
        @include('backend.partials.navigation')

        <div class="content-page">
            <div class="content">

                @include('flash::message')
                @include('partials.messages')

                @yield('content')

            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{ date('Y') }} &copy; Faculté de droit, Université de Neuchâtel. All Rights Reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <script src="{{ secure_asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="{{ secure_asset('assets/js/bootstrap.min.js') }}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ secure_asset('js/datatables.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/parsley.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/i18n/fr.js') }}"></script>

    <script src="{{ secure_asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <script src="{{ secure_asset('assets/js/flatpickr.js') }}"></script>
    <script src="{{ secure_asset('assets/js/redactor.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/fr.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/alignment.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/filemanager.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/fontcolor.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/fontsize.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/imagemanager.min.js') }}"></script>

    <script src="{{ secure_asset('assets/js/jquery-popup.js') }}"></script>
    <script src="{{ secure_asset('assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/list.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/main.js') }}"></script>
    <script src="{{ secure_asset('js/app.js') }}"></script>

</body>
</html>
