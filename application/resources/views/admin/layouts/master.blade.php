<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/general/1488847961.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/general/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/general/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/general/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/general/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/general/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/general/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/general/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/general/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/general/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/general/android-icon-192x192.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

    @stack('style-lib')

    <link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/custom-style.css')}}">


    @stack('style')
</head>

<body>
    @yield('content')
    <script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/apexcharts.min.js')}}"></script>
    @include('includes.notify')
    @stack('script-lib')


    <script src="{{asset('assets/admin/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/admin.js')}}"></script>
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
    {{-- LOAD EDITOR --}}
    <script>
        "use strict";
        if ($(".trumEdit")[0]) {
            ClassicEditor
                .create(document.querySelector('.trumEdit'))
                .then(editor => {
                    window.editor = editor;
                });
        }
    </script>

    @stack('script')

</body>

</html>