@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ __('packages.title') }}</h4>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> {{ __('packages.create_button') }}
        </a>
    </div>

    <x-datatable 
        :ajaxUrl="route('admin.packages.data')" 
        :columns="$columns" 
        :renderComponents="$renderComponents"
        :customActionsView="$customActionsView" 
    />
</div>
@endsection
