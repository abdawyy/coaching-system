@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>{{ __('users.register_title') }}</h4>
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

                    <form action="{{ route('user.register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('users.name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('users.email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('users.mobile') }}</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('users.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('users.password_confirm') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">{{ __('users.register_button') }}</button>
                    </form>

                    <p class="mt-3 text-center">
                        {{ __('users.have_account') }} 
                        <a href="{{ route('user.login') }}">{{ __('users.login_here') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
