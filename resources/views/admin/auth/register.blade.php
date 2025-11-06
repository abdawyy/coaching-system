<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('auth.register_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 450px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};
        }
        .lang-switch {
            position: absolute;
            top: 15px;
            right: 20px;
        }
        [dir="rtl"] .lang-switch {
            right: auto;
            left: 20px;
        }
    </style>
</head>
<body>
  <x-lang />



    <div class="register-card">
        <h3 class="text-center mb-4">{{ __('auth.register_title') }}</h3>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



        <form method="POST" action="{{ route('admin.register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('auth.name') }}</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email') }}</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('auth.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('auth.password_confirm') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">{{ __('auth.register_button') }}</button>

            <div class="text-center mt-3">
                <a href="{{ route('admin.login') }}">{{ __('auth.already_account') }}</a>
            </div>
        </form>
    </div>
</body>
</html>
