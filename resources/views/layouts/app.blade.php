<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} {{ app()->version() }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css">
    
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script charset="utf-8">
        window.App = {!! json_encode([
            'user' => Auth::user(),
            'signedIn' => \Auth::check()
        ]) !!};
    </script>

    @yield('head')
</head>
<body>
<div id="app">

    @include('layouts.nav')

    @yield('content')

    <flash message="{{ session('flash') }}"></flash>
    {{--  <flash message="A temporary flash message"></flash>  --}}

</div>

<style>
    .level {
        display: flex; 
        align-items: center; 
    }
    .flex {
        flex: 1;
    }

    .btn {
        cursor: pointer;
    }

    [v-cloak] {
        display: none;
    }

    .ais-highlight > em {
        background: yellow;
        font-style: normal;
    }
</style>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
