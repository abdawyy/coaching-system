@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-flash-success />
        <x-flash-error />

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ isset($user) ? __('users.edit_button') : __('users.create_button') }}</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>

        <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="row">
                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('users.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}"
                        required>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('users.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
                        required>
                </div>

                {{-- Password --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('users.password') }}</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="{{ isset($user) ? __('Leave blank to keep current') : '' }}">
                </div>

                {{-- Mobile --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('users.mobile') }}</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile ?? '') }}">
                </div>

                {{-- Package --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('users.package') }}</label>
                    <select name="package_id" class="form-select">
                        <option value="">{{ __('Select Package') }}</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ old('package_id', $user->package_id ?? '') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('users.description') }}</label>
                    <textarea name="description" class="form-control"
                        rows="3">{{ old('description', $user->description ?? '') }}</textarea>
                </div>

                {{-- File Upload --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('users.upload_button') }}</label>
                    <input type="file" name="files[]" class="form-control">
                    <input type="text" name="file_description" class="form-control mt-2"
                        placeholder="{{ __('users.description') }}">
                </div>
            </div>

            {{-- Workouts Section --}}
            <hr>
            <h5>{{ __('users.workouts') }}</h5>
            <div id="workouts-wrapper">
                @if(isset($user) && $user->workouts->count())
                    @foreach($user->workouts as $i => $workout)
                        <div class="workout-item mb-3 border p-3 rounded">
                            <input type="text" name="workouts[{{ $i }}][title]" class="form-control mb-2"
                                value="{{ $workout->title }}" placeholder="{{ __('users.workout_title') }}">
                            <input type="url" name="workouts[{{ $i }}][link]" class="form-control mb-2" value="{{ $workout->link }}"
                                placeholder="{{ __('users.workout_link') }}">
                            <textarea name="workouts[{{ $i }}][description]" class="form-control mb-2"
                                placeholder="{{ __('users.workout_description') }}">{{ $workout->description }}</textarea>
                            <button type="button" class="btn btn-danger btn-sm remove-workout">
                                <i class="bi bi-trash"></i> {{ __('users.remove_workout') }}
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="workout-item mb-3 border p-3 rounded">
                        <input type="text" name="workouts[0][title]" class="form-control mb-2"
                            placeholder="{{ __('users.workout_title') }}">
                        <input type="url" name="workouts[0][link]" class="form-control mb-2"
                            placeholder="{{ __('users.workout_link') }}">
                        <textarea name="workouts[0][description]" class="form-control mb-2"
                            placeholder="{{ __('users.workout_description') }}"></textarea>
                        <button type="button" class="btn btn-danger btn-sm remove-workout">
                            <i class="bi bi-trash"></i> {{ __('users.remove_workout') }}
                        </button>
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-outline-secondary mb-3" id="addWorkoutBtn">
                + {{ __('users.workout_button') }}
            </button>

            <div>
                <button type="submit" class="btn btn-primary">
                    {{ isset($user) ? __('users.update_button') : __('users.create_button') }}
                </button>
            </div>
        </form>
    </div>

    {{-- JavaScript for adding/removing workouts dynamically --}}
    <script>
        document.getElementById('addWorkoutBtn').addEventListener('click', function () {
            const wrapper = document.getElementById('workouts-wrapper');
            const index = wrapper.children.length;
            const html = `
            <div class="workout-item mb-3 border p-3 rounded">
                <input type="text" name="workouts[${index}][title]" class="form-control mb-2" placeholder="{{ __('users.workout_title') }}">
                <input type="url" name="workouts[${index}][link]" class="form-control mb-2" placeholder="{{ __('users.workout_link') }}">
                <textarea name="workouts[${index}][description]" class="form-control mb-2" placeholder="{{ __('users.workout_description') }}"></textarea>
                <button type="button" class="btn btn-danger btn-sm remove-workout">
                    <i class="bi bi-trash"></i> {{ __('users.remove_workout') }}
                </button>
            </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
        });

        // Handle remove workout button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-workout')) {
                e.target.closest('.workout-item').remove();
            }
        });
    </script>
@endsection