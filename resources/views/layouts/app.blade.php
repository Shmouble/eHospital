<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'eHospital' }}</title>

    <!-- Scripts -->
    
    <script>
        var isRoot = false;
        var isManager = false;
        var isPatient = false;
        @auth
        @if(Auth::user()->hasRole('root.hospital'))
        isRoot = true;
        @endif
        
        
        @if(Auth::user()->hasRole('manager.hospital'))
        isManager = true;
        @endif
        
        @if(Auth::user()->hasRole('patient.hospital'))
        isPatient = true;
        @endif
        @endauth
    </script>
    
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        @include('parts.header')

        <main class="py-4">
            @yield('content')
        </main>

        @include('parts.footer')

    </div>
    
    
</body>
</html>
