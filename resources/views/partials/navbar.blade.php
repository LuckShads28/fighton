<nav class="navbar navbar-expand-lg navbar-dark bg-custom-primary">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{ asset('/') }}assets/img/logo/logo-web.png" width="50px"
                alt="logo" /><span class="fw-bold">FIGHTON</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $title === 'Turnamen' ? 'active' : '' }}" aria-current="page"
                        href="{{ route('tournament.index') }}">Turnamen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $title === 'Tim' ? 'active' : '' }} " aria-current="page"
                        href="{{ route('team.index') }}">Tim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $title === 'Leaderboard' ? 'active' : '' }}" aria-current="page"
                        href="{{ route('leaderboard') }}">Leaderboard</a>
                </li>
                <li class="nav-item">
                    @auth
                    <li class="nav-item dropdown ms-md-2">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                            <span class="fw-bold ms-1">{{ Auth::user()->nickname }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('organizer.index') }}">Kelola Turnamen</a>
                            </li>
                            @if (Auth::user()->role == 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard Admin</a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#login">
                        Login
                    </button>
                @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
