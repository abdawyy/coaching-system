@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-flash-success />
        <x-flash-error />

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ __('guest_messages.title') }}</h4>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> {{ __('guest_messages.back') }}
            </a>
        </div>

        <x-datatable :ajaxUrl="route('admin.guests.data')" :columns="$columns" :renderComponents="$renderComponents"
            :customActionsView="$customActionsView" />
    </div>
@endsection