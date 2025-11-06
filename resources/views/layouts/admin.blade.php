<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('dashboard.title'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        /* ✅ Header stays on top */
        header {
            width: 100%;
            background-color: #343a40;
            color: white;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* ✅ Sidebar starts under header */
        .sidebar {
            position: fixed;
            top: 80px; /* header height */
            bottom: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            overflow-y: auto;
            padding-top: 10px;
            z-index: 900;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }

        /* ✅ Main content pushed down and sideways */
        .main-content {
            margin-top: 60px; /* same as header height */
            margin-left: {{ app()->getLocale() === 'ar' ? '0' : '250px' }};
            margin-right: {{ app()->getLocale() === 'ar' ? '250px' : '0' }};
            padding: 20px;
            min-height: calc(100vh - 60px);
        }

        [dir="rtl"] .sidebar {
            right: 0;
            left: auto;
        }

        footer {
            background-color: #343a40;
            color: #adb5bd;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>
    <!-- ✅ Fixed Header -->
    <x-admin.header />

    <!-- ✅ Sidebar and Content -->
    <x-admin.aside />
    
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ✅ Footer below all -->
    <x-admin.footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
