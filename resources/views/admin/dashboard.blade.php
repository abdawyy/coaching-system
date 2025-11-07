@extends('layouts.admin')

@section('title', __('dashboard.title'))

@section('content')
<div class="container">
    <h1>{{ __('dashboard.dashboard') }}</h1>
    <p class="text-muted">{{ __('dashboard.admin_panel') }}</p>

    <div class="row mt-4">
        <!-- Packages Count -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ __('dashboard.packages') }}</h5>
                    <h2 class="fw-bold">{{ $packagesCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Guest Users Count -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ __('dashboard.guest_users') }}</h5>
                    <h2 class="fw-bold">{{ $guestUsersCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Registered Users Count -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ __('dashboard.users') }}</h5>
                    <h2 class="fw-bold">{{ $usersCount }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
