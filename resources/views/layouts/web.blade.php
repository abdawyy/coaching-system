<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Coaching' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<x-web.header />

<body style="background-color: black !important; color: white;">


{{-- aside Component --}}

<x-web.navbar />

{{-- Header Component --}}

{{-- Main Content --}}
    @yield('content')

{{-- Footer Component --}}
<x-web.footer />

</body>

</html>