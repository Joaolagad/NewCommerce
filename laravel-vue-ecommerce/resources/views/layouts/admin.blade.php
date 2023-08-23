<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['public/admin/css/material-dashboard.css', 'public/admin/js/popper.min.js', 'public/admin/js/bootstrap.min.js', 'public/admin/js/perfect-scrollbar.min.js', 
    'public/frontend/js/bootstrap.bundle.min.js', 'public/admin/js/smooth-scrollbar.min.js', 'public/admin/js/chartjs.min.js' ])
  
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    @yield('scripts')
    @yield('styles')
</head>
<body class="g-sidenav-show  bg-gray-200">

    <div class="container-fluid">
        <div class="row">
            @include('layouts.inc.sidebar')
    
            <div class="col-lg-10 col-md-8">
                <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
                    <div class="adminnav custom-margin">
                        @include('layouts.inc.adminnav')
                    </div>
                    <div class="container-fluid py-20">
                        @yield('content')
                    </div>
                    <div class="adminfooter custom-margin">
                        @include('layouts.inc.adminfooter')
                    </div>
                </main>
            </div>
        </div>
    </div>
    
    
</body>


</html>
