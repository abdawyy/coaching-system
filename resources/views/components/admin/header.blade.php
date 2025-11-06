<header class="navbar navbar-dark bg-dark sticky-top">
     <x-lang />

    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            🧭 {{ __('dashboard.admin_panel') }}
        </a>

        <div class="d-flex align-items-center">
 \

            {{-- User Info --}}
            <span class="text-white me-3">{{ auth('admin')->user()->name ?? __('dashboard.admin') }}</span>
            <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm">
                {{ __('dashboard.logout') }}
            </a>
        </div>
    </div>
</header>
