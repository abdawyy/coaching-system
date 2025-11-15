<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5 col-sm-10">
        <div class="card shadow-lg border-0 rounded-4">
            
            <!-- Header -->
            <div class="card-header text-center bg-primary text-white rounded-top-4">
                <h4 class="mt-2 mb-2">{{ __('users.login_title') }}</h4>
            </div>

            <!-- Body -->
            <div class="card-body p-4">

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

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('users.email') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="{{ __('users.email') }}" 
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('users.password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="{{ __('users.password') }}" 
                                   required>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               name="remember" 
                               class="form-check-input" 
                               id="remember">
                        <label class="form-check-label" for="remember">
                            {{ __('users.remember_me') }}
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        {{ __('users.login_button') }}
                    </button>
                </form>

                <!-- Register Link -->
                <p class="mt-3 text-center">
                    {{ __('users.no_account') }}
                    <a href="{{ route('user.register') }}" class="fw-bold">
                        {{ __('users.register_now') }}
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>
