@extends('layout')

@section('content')
    <img src="{{ asset('/') }}assets/img/tournament-banner.jpg" class="img-fluid" alt="Responsive image"
        style="height: 350px; object-fit: cover">
    </div>
    <div class="container">
        <!-- List Turnamen -->
        <div class="text-white mb-3 mt-5">
            <!-- Search & Filter -->
            <div class="row">
                <div class="col-12 col-md-4">
                    <div id="search-box">
                        <div class="row my-md-4">
                            <div class="col">
                                <form action="{{ route('tournament.index') }}">
                                    <div class="input-group">
                                        <input type="search" class="form-control search-input-custom"
                                            placeholder="Cari Turnamen..." name="search" />
                                        <span class="input-group-text ms-0" style="background-color: #343434; border: none">
                                            <button class="btn search-btn-custom" type="submit">
                                                <i class="fas fa-search text-white"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="dropdown my-md-4 my-2">
                        <button class="btn btn-dark-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            id="filter" style="width:180px">
                            Filter Prizepool<span><i class="fa-solid fa-filter ms-1"></i></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li>
                                <a class="dropdown-item" href="{{ route('tournament.index') }}?filter=1">0 -
                                    1.000.000</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('tournament.index') }}?filter=2">1.000.000 -
                                    5.000.000</a></li>
                            <li><a class="dropdown-item" href="{{ route('tournament.index') }}?filter=3">5.000.000 -
                                    10.000.000</a></li>
                            <li><a class="dropdown-item" href="{{ route('tournament.index') }}?filter=4">>=
                                    10.000.000</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($tournaments->count() > 0)
                    @foreach ($tournaments as $t)
                        <div class="col-md-4">
                            <div class="card mb-4 bg-custom-primary-2">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row text-white">
                                            <div class="col-4">
                                                <img src="{{ asset('/') }}assets/img/logo/logo_aov.png" alt="logo_aog"
                                                    style="width: 100%" />
                                            </div>
                                            <div class="col-8 pt-2">
                                                <h5 class="fw-bold text-white-half" style="font-size: 12px">
                                                    {{ $t->start_time }}
                                                </h5>
                                                <h5 class="fw-bold" style="font-size: 20px; margin-top: -5px">
                                                    {{ $t->name }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row text-white-half mt-3">
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Prize Pool</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-trophy" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span
                                                            style="font-size: 11px">{{ number_format($t->prizepool) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Kategori Tim</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-user" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span style="font-size: 11px">{{ $t->team_category }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Tim Terdaftar</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-people-group" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span style="font-size: 11px">0/{{ $t->team_slot }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-custom-secondary">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-5">
                                                    <img src="{{ asset('/') }}assets/img/organizer-profile.jpeg"
                                                        alt="profile-pic" class="organizer-profile" />
                                                </div>
                                                <div class="col-7 bg">
                                                    <span style="font-size: 12px" class="text-white-half">Organized
                                                        by<br></span>
                                                    <a href="#" style="font-size: 12px; text-decoration: none"
                                                        class="text-white">{{ $t->organizer->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('tournament.show', $t->slug) }}"
                                                class="btn btn-custom w-100">Join</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 class="text-white-half text-center mt-3">Belum ada turnamen</h5>
                @endif
                {{ $tournaments->links() }}
            </div>

            <!-- Pagination -->
            {{-- <nav aria-label="...">
                <ul class="pagination justify-content-end">
                    <li class="page-item-custom active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item-custom">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item-custom">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item-custom">
                        <a class="page-link" href="#">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </div>

    <!-- Modal Login & Daftar -->
    @include('partials.modal-login-daftar')
@endsection
