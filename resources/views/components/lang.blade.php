   {{-- 🌍 Language Switcher --}}
    <div class="lang-switch dropdown">
        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="langDropdown" data-bs-toggle="dropdown"
            aria-expanded="false">
            @if(app()->getLocale() === 'en')
                <img src="https://flagcdn.com/w20/gb.png" alt="English" class="flag-icon"> English
            @else
                <img src="https://flagcdn.com/w20/sa.png" alt="Arabic" class="flag-icon"> العربية
            @endif
        </button>
        <ul class="dropdown-menu" aria-labelledby="langDropdown">
            <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                    <img src="https://flagcdn.com/w20/gb.png" alt="English" class="flag-icon"> English
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">
                    <img src="https://flagcdn.com/w20/sa.png" alt="Arabic" class="flag-icon"> العربية
                </a>
            </li>
        </ul>

    </div>