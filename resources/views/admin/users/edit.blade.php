@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-flash-success />
        <x-flash-error />

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ __('users.edit_title') }}</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('users.back_to_list') }}
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('users.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">{{ __('users.email') }}</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="mobile" class="form-label">{{ __('users.mobile') }}</label>
                    <input type="text" name="mobile" id="mobile" class="form-control"
                        value="{{ old('mobile', $user->mobile) }}">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">{{ __('users.password') }}</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ __('users.password_placeholder') }}">
                    <small class="text-muted">{{ __('users.leave_blank_to_keep') }}</small>
                </div>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">{{ __('users.file') }}</label>
                <input type="file" name="files[]" id="file" class="form-control">
                @if ($user->files && $user->files->count())
                    <div class="mt-2">
                        @foreach ($user->files as $file)
                            @php
                                $ext = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                $fileName = basename($file->file_path);
                            @endphp

                            <div class="mb-2 d-flex align-items-center">
                                @if (in_array($ext, ['pdf', 'xls', 'xlsx']))
                                    {{-- Downloadable link --}}
                                    <a href="{{ asset('storage/' . $file->file_path) }}" download="{{ $fileName }}" class="me-2">
                                        📄 {{ $fileName }}
                                    </a>
                                @else
                                    {{-- Image preview --}}
                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="User file" class="img-thumbnail me-2"
                                        width="100">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" download="{{ $fileName }}">Download</a>
                                @endif

                               <a href="javascript:void(0)" 
   class="btn btn-sm btn-danger ms-2"
   onclick="submitDeleteFile({{ $file->id }})">
    Delete
</a>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

            <hr>

            <h5>{{ __('users.workouts_title') }}</h5>
            <div id="workouts-container">
                @foreach($user->workouts ?? [] as $index => $workout)
                    <div class="workout-item mb-3 border p-3 rounded">
                        <input type="text" name="workouts[{{ $index }}][title]" class="form-control mb-2"
                            value="{{ $workout['title'] }}" placeholder="{{ __('users.workout_title') }}">
                        <input type="url" name="workouts[{{ $index }}][link]" class="form-control mb-2"
                            value="{{ $workout['link'] }}" placeholder="{{ __('users.workout_link') }}">
                        <textarea name="workouts[{{ $index }}][description]" class="form-control"
                            placeholder="{{ __('users.workout_description') }}">{{ $workout['description'] }}</textarea>
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-workout">
                            <i class="bi bi-trash"></i> {{ __('users.remove_workout') }}
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-workout" class="btn btn-outline-primary mt-3">
                <i class="bi bi-plus-circle"></i> {{ __('users.add_workout') }}
            </button>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> {{ __('users.save_changes') }}
                </button>
            </div>
        </form>
    </div>
    <form id="deleteFileForm" method="POST" style="display:none;">
    @csrf
    @method('get')
</form>

<script>
function submitDeleteFile(fileId) {
    if (!confirm('Are you sure you want to delete this file?')) return;

    let form = document.getElementById('deleteFileForm');
    form.action = "{{ url('admin/users/delete/') }}/" + fileId;
    form.submit();
}
</script>


    <script>
        document.getElementById('add-workout').addEventListener('click', function () {
            const index = document.querySelectorAll('.workout-item').length;
            const container = document.getElementById('workouts-container');
            const html = `
                    <div class="workout-item mb-3 border p-3 rounded">
                        <input type="text" name="workouts[${index}][title]" class="form-control mb-2" placeholder="{{ __('users.workout_title') }}">
                        <input type="url" name="workouts[${index}][link]" class="form-control mb-2" placeholder="{{ __('users.workout_link') }}">
                        <textarea name="workouts[${index}][description]" class="form-control" placeholder="{{ __('users.workout_description') }}"></textarea>
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-workout">
                            <i class="bi bi-trash"></i> {{ __('users.remove_workout') }}
                        </button>
                    </div>
                `;
            container.insertAdjacentHTML('beforeend', html);
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-workout')) {
                e.target.closest('.workout-item').remove();
            }
        });
    </script>
@endsection