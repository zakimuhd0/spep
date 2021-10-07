<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @stack('styles')
</head>
<body>
    @yield('content')
</div>
</body>
</html>
