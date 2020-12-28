<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>nss factory</title>

    <!-- links -->
    <link href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css">
    <link rel="shortcut icon" type="image/png" href="https://www.nssfactory.com/assets/extensions/nss/images/favicon.ico">

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body>


    <div class="container-page">

        @include('partials/navbar')

        <main class="">
            @yield('content')
        </main>

        @include('partials/footer')

    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
