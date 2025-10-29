<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
         <script src="{{asset('assets/js/layout/layout-default.js')}}"></script>

    <script src="{{asset('assets/js/layout/layout.js')}}"></script>

    <!-- Choice Css -->
    <link rel="stylesheet" href="{{asset('assets/libs/choices.js/public/assets/styles/choices.min.css')}}">
    <!-- Simplebar Css -->
    <link href="{{asset('assets/libs/simplebar/simplebar.min.css')}}" rel="stylesheet">
    <!--icons css-->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Sweet Alert -->
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css">

    <link href="{{asset('assets/css/custom.min.css')}}" id="custom-style" rel="stylesheet" type="text/css">
        <!-- Styles -->
        {{-- @livewireStyles --}}
    </head>
    <body class="font-sans antialiased">
        {{-- <x-banner /> --}}

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
