@extends('layout')

@section('content')
    <img src="{{ asset('/') }}assets/img/default-profile-banner.jpg" class="img-fluid" alt="Responsive image"
        style="height: 350px; object-fit: cover">


    <div class="container-fluid bg-custom-primary-2 text-white">
        <div class="container">
            <div class="row my-4">
                <!-- Profile Pict-->
                <div class="col-md-6">
                    <div class="d-flex">
                        <div class="me-4">
                            <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('/') . 'assets/img/default-ava.png' }}"
                                alt="profile-pic" class="detail-organizer-profile" />
                        </div>
                        <div class="">
                            <span style="font-size: 24px" class="text-white-half">{{ Auth::user()->nickname }}<br></span>
                            <p style="font-size: 24px; text-decoration: none" class="text-white">
                                {{ !Auth::user()->role ? 'Belum ada role' : Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 d-flex">
                    <div class="ms-md-auto align-self-center">
                        <a href="{{ route('profile.edit', Auth::user()->slug) }}" class="btn btn-custom">Pengaturan Akun</a>
                    </div>
                </div>
            </div>

            <nav class="mt-5">
                <div class="nav nav-tabs" id="custom-tournament-top-tab" role="tablist">
                    <button class="nav-link active" id="nav-history-tournaments-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-history-tournaments" type="button" role="tab"
                        aria-controls="nav-history-tournaments" aria-selected="true">
                        History Turnamen
                    </button>
                    <button class="nav-link" id="nav-teams-tab" data-bs-toggle="tab" data-bs-target="#nav-teams"
                        type="button" role="tab" aria-controls="nav-teams" aria-selected="false">
                        Tim
                </div>
            </nav>
        </div>
    </div>
    <div class="container mt-3 mb-5">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-history-tournaments" role="tabpanel"
                aria-labelledby="nav-history-tournaments-tab" tabindex="0">
                <h1 class="text-white-half text-center">Tidak ada history</h1>
            </div>
            <div class="tab-pane fade" id="nav-teams" role="tabpanel" aria-labelledby="nav-teams-tab" tabindex="0">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('team.create') }}"
                        class="btn btn-custom {{ !Auth::user()->role ? 'disabled' : '' }}">Buat
                        Tim</a>
                </div>
                <div id="team-list">
                    @if ($teamList->count() > 0)
                        <div class="row">
                            @foreach ($teamList->all() as $teamData)
                                @foreach ($teamData->team as $t)
                                    <div class="col-md-2 mb-3 mb-md-0">
                                        <a href="{{ route('team.show', $t->slug) }}" style="text-decoration: none">
                                            <div class="card d-flex flex-column align-items-center"
                                                style="background-color: rgba(255, 255, 255, 0)">
                                                <div id="user-team-profile">
                                                    <img src="{{ asset('storage/' . $t->logo_img) }}" alt="" />
                                                </div>
                                                <div class="mt-2 text-white" id="team-name">
                                                    <h4 class="fw-bold">{{ $t->name }}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <h1 class="text-white-half text-center">Tidak ada tim</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
