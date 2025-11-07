<aside class="sidebar">
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            🏠 {{ __('dashboard.dashboard') }}
        </a>

        <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
            📦 {{ __('dashboard.packages') }}
        </a>

        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            👤 {{ __('dashboard.users') }}
        </a>

        <a href="{{ route('admin.guests.index') }}" class="{{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
            🧑‍💻 {{ __('dashboard.guest_users') }}
        </a>

        <a href="{{ route('admin.admin.index') }}" class="{{ request()->routeIs('admin.admin.*') ? 'active' : '' }}">
            🔑 {{ __('dashboard.admins') }}
        </a>
    </nav>
</aside>
