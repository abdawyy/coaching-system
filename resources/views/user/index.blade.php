<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Mobile improvements */
    .list-group-item {
        flex-wrap: wrap;
    }
    .file-controls {
        display: flex;
        gap: 6px;
        justify-content: flex-start;
    }
    @media (min-width: 768px) {
        .file-controls {
            justify-content: flex-end;
        }
    }
</style>

<!-- ============================
        NAVBAR
============================ -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-person-fill"></i> My Profile
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm ms-2">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>



<!-- ============================
        MAIN CONTENT
============================ -->
<div class="container my-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- ============================
            PROFILE UPDATE SECTION
    ============================ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold"><i class="bi bi-person-circle"></i> {{ __('users.profile_title') }}</div>
        <div class="card-body">
            <form action="{{ route('user.updateProfile') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('users.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('users.mobile') }}</label>
                        <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('users.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('users.leave_blank') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('users.password_confirmation') }}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 w-100 w-md-auto">
                    <i class="bi bi-save"></i> {{ __('users.update_profile') }}
                </button>
            </form>
        </div>
    </div>


    <!-- ============================
            UPLOAD FILES SECTION
    ============================ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold"><i class="bi bi-upload"></i> {{ __('users.upload_files') }}</div>
        <div class="card-body">
            <form action="{{ route('user.uploadFiles') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="files-wrapper">
                    <div class="file-item p-3 border rounded mb-2 bg-light">
                        <input type="file" name="files[]" class="form-control mb-2">
                        <input type="text" name="descriptions[]" class="form-control" placeholder="{{ __('users.file_description') }}">
                    </div>
                </div>

                <button type="button" id="add-file" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-plus-circle"></i> {{ __('users.add_file') }}
                </button>

                <br>
                <button type="submit" class="btn btn-success w-100 w-md-auto">
                    <i class="bi bi-check-circle"></i> {{ __('users.upload_button') }}
                </button>
            </form>
        </div>
    </div>


    <!-- ============================
            MY FILES SECTION
    ============================ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold"><i class="bi bi-folder"></i> {{ __('users.my_files') }}</div>
        <div class="card-body p-0">

            @if($user->files->count())
                <ul class="list-group list-group-flush">

                    @foreach($user->files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span class="text-wrap">{{ $file->file_path }}</span>

                            <div class="file-controls">
                                <a href="{{ route('user.downloadFile', $file->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-download"></i>
                                </a>

                                <a href="javascript:void(0)"
                                   onclick="submitDeleteFile({{ $file->id }})"
                                   class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>

            @else
                <p class="p-3">{{ __('users.no_files') }}</p>
            @endif
        </div>
    </div>


    <!-- ============================
            MY WORKOUTS SECTION
    ============================ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold"><i class="bi bi-activity"></i> {{ __('users.my_workouts') }}</div>
        <div class="card-body p-0">

            @if($user->workouts->count())
                <ul class="list-group list-group-flush">
                    @foreach($user->workouts as $workout)
                        <li class="list-group-item">
                            <strong>{{ $workout->title }}</strong><br>
                            <a href="{{ $workout->link }}" target="_blank">{{ $workout->link }}</a><br>
                            <small>{{ $workout->description }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="p-3">{{ __('users.no_workouts') }}</p>
            @endif

        </div>
    </div>

</div>


<!-- ============================
        FOOTER
============================ -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <div class="container">
        <p class="mb-1">&copy; {{ date('Y') }} Your App Name</p>
        <small>All rights reserved</small>
    </div>
</footer>



{{-- Hidden Delete Form --}}
<form id="deleteFileForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function submitDeleteFile(id) {
        if (!confirm("Delete this file?")) return;
        let form = document.getElementById('deleteFileForm');
        form.action = "/user/delete-file/" + id;
        form.submit();
    }

    document.getElementById('add-file').addEventListener('click', function () {
        const wrapper = document.getElementById('files-wrapper');
        wrapper.insertAdjacentHTML('beforeend', `
            <div class="file-item p-3 border rounded bg-light mb-2">
                <input type="file" name="files[]" class="form-control mb-2">
                <input type="text" name="descriptions[]" class="form-control" placeholder="{{ __('users.file_description') }}">
            </div>
        `);
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
