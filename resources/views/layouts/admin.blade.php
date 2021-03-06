<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="nofollow" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>(Admin) {{ config('app.name', 'Laravel') }}</title>
    @include('include._script')
    @stack('css')
</head>
<body id="app-layout">
    @include('include._header')
    @yield('content')
    @stack('js')
    {!! js_notify() !!}
</body>
</html>
