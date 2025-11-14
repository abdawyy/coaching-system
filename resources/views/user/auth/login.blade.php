@extends('layouts.user') {{-- Make a simple layout for user auth --}}

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>{{ __('users.login_title') }}</h4>
                </div>
                <div class="card-body">
                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('users.email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('users.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">{{ __('users.remember_me') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ __('users.login_button') }}</button>
                    </form>

                    <p class="mt-3 text-center">
                        {{ __('users.no_account') }} 
                        <a href="{{ route('user.register') }}">{{ __('users.register_now') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
