@extends('layouts.admin')

@section('content')
<div class="container">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">{{ __('users.profile_title') }}</div>
        <div class="card-body">
            {{-- Profile Form --}}
            <form action="{{ route('user.updateProfile') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label>{{ __('users.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>{{ __('users.mobile') }}</label>
                        <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label>{{ __('users.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('users.leave_blank') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label>{{ __('users.password_confirmation') }}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">{{ __('users.update_profile') }}</button>
            </form>
        </div>
    </div>

    {{-- Upload Files --}}
    <div class="card mb-4">
        <div class="card-header">{{ __('users.upload_files') }}</div>
        <div class="card-body">
            <form action="{{ route('user.uploadFiles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="files-wrapper">
                    <div class="file-item mb-2">
                        <input type="file" name="files[]" class="form-control mb-1">
                        <input type="text" name="descriptions[]" class="form-control mb-2" placeholder="{{ __('users.file_description') }}">
                    </div>
                </div>
                <button type="button" id="add-file" class="btn btn-secondary mb-2">+ {{ __('users.add_file') }}</button>
                <button type="submit" class="btn btn-success">{{ __('users.upload_button') }}</button>
            </form>
        </div>
    </div>

    {{-- Show Uploaded Files --}}
    <div class="card mb-4">
        <div class="card-header">{{ __('users.my_files') }}</div>
        <div class="card-body p-0">
            @if($user->files->count())
                <ul class="list-group list-group-flush">
                    @foreach($user->files as $file)
                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <span class="text-truncate mb-2 mb-md-0">{{ $file->file_path }}</span>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('user.downloadFile', $file->id) }}" class="btn btn-primary">{{ __('users.download') }}</a>
                                <form action="{{ route('user.deleteFile', $file->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">{{ __('users.delete') }}</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="p-3">{{ __('users.no_files') }}</p>
            @endif
        </div>
    </div>

    {{-- Show Workouts --}}
    <div class="card mb-4">
        <div class="card-header">{{ __('users.my_workouts') }}</div>
        <div class="card-body p-0">
            @if($user->workouts->count())
                <ul class="list-group list-group-flush">
                    @foreach($user->workouts as $workout)
                        <li class="list-group-item">
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div>
                                    <strong>{{ $workout->title ?? __('users.no_title') }}</strong><br>
                                    <a href="{{ $workout->link }}" target="_blank">{{ $workout->link }}</a><br>
                                    <small>{{ $workout->description ?? '' }}</small>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="p-3">{{ __('users.no_workouts') }}</p>
            @endif
        </div>
    </div>

</div>

{{-- JS to add multiple file upload fields --}}
<script>
document.getElementById('add-file').addEventListener('click', function () {
    const wrapper = document.getElementById('files-wrapper');
    const html = `
        <div class="file-item mb-2">
            <input type="file" name="files[]" class="form-control mb-1">
            <input type="text" name="descriptions[]" class="form-control mb-2" placeholder="{{ __('users.file_description') }}">
        </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});
</script>
@endsection
