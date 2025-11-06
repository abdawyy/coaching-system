<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('auth.title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 400px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align:
                {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}
            ;
            position: relative;
        }

        .lang-switch {
            position: absolute;
            top: 20px;
            {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}
            : 20px;
        }

        .dropdown-toggle::after {
            margin-left: 6px;
        }

        [dir="rtl"] .dropdown-toggle::after {
            margin-left: 0;
            margin-right: 6px;
        }

        .flag-icon {
            width: 20px;
            height: 14px;
            margin-right: 6px;
            border-radius: 2px;
            object-fit: cover;
        }

        [dir="rtl"] .flag-icon {
            margin-right: 0;
            margin-left: 6px;
        }
    </style>
</head>

<body>
 <x-lang />

    <div class="login-card">



        {{-- 🔐 Login Form --}}
        <h3 class="text-center mb-4 mt-3">{{ __('auth.title') }}</h3>

        @if($errors->any())
            <div class="alert alert-danger text-center">{{ __('auth.error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required
                    autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('auth.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">{{ __('auth.remember') }}</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">{{ __('auth.login_button') }}</button>

        </form>
        <div class="text-center mt-3">
            <a href="{{ route('admin.register') }}">{{ __('auth.register_link') }}</a>
        </div>
    </div>

</body>

</html>