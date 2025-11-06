@extends('layouts.admin')

@section('title', __('dashboard.title'))

@section('content')
<div class="container">
    <h1>{{ __('dashboard.dashboard') }}</h1>
    <p class="text-muted">{{ __('dashboard.admin_panel') }}</p>
</div>
@endsection
