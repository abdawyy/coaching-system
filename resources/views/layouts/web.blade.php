<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Webinar' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<x-web.header />

{{-- aside Component --}}
<x-web.sidebar />

<x-web.navbar />

{{-- Header Component --}}

{{-- Main Content --}}
<main class="flex-grow container mx-auto py-6">
    @yield('content')
</main>

{{-- Footer Component --}}
<x-web.footer />

</body>

</html>