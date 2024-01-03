<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>SKOOL SHELL SCHOOL ADMIN</title>
        <meta name="description" content="">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">
        <link rel="stylesheet" href="/assets/css/normalize.css">
        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/select2.min.css">
        <link rel="stylesheet" href="/assets/fonts/flaticon.css">
        <link rel="stylesheet" href="/assets/css/datepicker.min.css">
        <link rel="stylesheet" href="/assets/css/fullcalendar.min.css">
        <link rel="stylesheet" href="/assets/css/animate.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="/assets/themify-icons-font/themify-icons.css">
        <link rel="stylesheet" href="/assets/css/vue-datepicker.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="/assets/js/modernizr-3.6.0.min.js"></script>

        <link rel="stylesheet" href="/assets/css/dropify.min.css">
    </head>

    <body>
        <div id="preloader"></div>
        <div id="app">
            <main-component></main-component>
        </div>
        <script src="/assets/js/jquery-3.3.1.min.js"></script>
        <script src="/assets/js/plugins.js"></script>
        <script src="/assets/js/popper.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <!-- Select 2 Js -->
        <script src="/assets/js/select2.min.js"></script>
        <script src="/assets/js/datepicker.min.js"></script>
        <script src="/assets/js/jquery.dataTables.min.js"></script>
        <script src="/assets/js/jquery.counterup.min.js"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/jquery.waypoints.min.js"></script>
        <script src="/assets/js/jquery.scrollUp.min.js"></script>
        <script src="/assets/js/fullcalendar.min.js"></script>
        <script src="/assets/js/Chart.min.js"></script>
        {{-- <script src="/assets/js/main.js"></script> --}}
        {{-- <script src="/assets/js/jquery.smoothscroll.min.html"></script> --}}
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>

</html>
