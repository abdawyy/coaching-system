@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ __('packages.edit_title') }}</h4>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> {{ __('packages.back') }}
        </a>
    </div>

    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('POST')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('packages.name') }}</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $package->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('packages.description') }}</label>
            <textarea name="description" id="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="4">{{ old('description', $package->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">{{ __('packages.price') }}</label>
            <input type="number" step="0.01" name="price" id="price"
                   class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $package->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label for="duration" class="form-label">{{ __('packages.duration') }}</label>
            <input type="number" name="duration" id="duration"
                   class="form-control @error('duration') is-invalid @enderror"
                   value="{{ old('duration', $package->duration) }}" 
                   placeholder="{{ __('packages.duration_placeholder') }}">
            @error('duration')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">{{ __('packages.duration_hint') }}</small>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> {{ __('packages.update') }}
        </button>
    </form>
</div>
@endsection
