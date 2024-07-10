@extends('layout')

@section('content')
    <img src="{{ asset('storage/' . $teamData->banner_img) }}" class="img-fluid" alt="Responsive image"
        style="height: 350px; object-fit: cover">


    <div class="container-fluid bg-custom-primary-2 text-white">
        <div class="container">
            <div class="row my-4">
                <!-- Profile Pict-->
                <div class="col-md-6">
                    <div class="d-flex">
                        <div class="me-4">
                            <img src="{{ asset('storage/' . $teamData->logo_img) }}" alt="profile-pic"
                                class="detail-organizer-profile" />
                        </div>
                        <div class="">
                            <span style="font-size: 24px" class="text-white">{{ $teamData->name }}<br></span>
                            <p style="font-size: 18px; text-decoration: none" class="text-white-half">
                                {{ $teamData->description }}
                            </p>
                        </div>
                    </div>
                </div>
                @if ($userRole === 'Leader')
                    <div class="col-md-6 mt-3 mt-md-0 d-flex">
                        <div class="ms-md-auto align-self-center mx-auto mx-md-0">
                            <a href="{{ route('team.edit', $teamData->slug) }}"
                                class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Pengaturan
                                Tim</a>
                            <a href="#" class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Undang Anggota</a>
                        </div>
                    </div>
                @endif
                @auth
                    @if (Auth::user()->role)
                        @if ($userRole === null || $userStatus > 1)
                            <div class="col-md-6 mt-3 mt-md-0 d-flex">
                                <div class="ms-md-auto align-self-center mx-auto mx-md-0">
                                    <a href="{{ route('request_join_team', ['team' => $teamData->slug, 'userSlug' => Auth::user()->slug]) }}"
                                        class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Request Bergabung Tim</a>
                                </div>
                            </div>
                        @endif
                        @if ($userStatus === 0)
                            <div class="col-md-6 mt-3 mt-md-0 d-flex">
                                <div class="ms-md-auto align-self-center mx-auto mx-md-0">
                                    <a href="#" class="btn btn-custom disabled mx-3 mt-2 mt-md-0 mx-md-0">Menunggu
                                        Persetujuan</a>
                                </div>
                            </div>
                        @endif
                        @if ($userStatus === 1 && $userRole !== 'Leader')
                            <div class="col-md-6 mt-3 mt-md-0 d-flex">
                                <div class="ms-md-auto align-self-center mx-auto mx-md-0">
                                    <a href="#" class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Keluar Tim</a>
                                </div>
                            </div>
                        @endif
                    @endif
                @endauth

            </div>

            <nav class="mt-5">
                <div class="nav nav-tabs" id="custom-tournament-top-tab" role="tablist">
                    <button class="nav-link active" id="nav-history-tournaments-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-history-tournaments" type="button" role="tab"
                        aria-controls="nav-history-tournaments" aria-selected="true">
                        History Turnamen
                    </button>
                    <button class="nav-link" id="nav-members-tab" data-bs-toggle="tab" data-bs-target="#nav-members"
                        type="button" role="tab" aria-controls="nav-members" aria-selected="false">
                        Anggota
                    </button>
                    <button class="nav-link" id="nav-member-history-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-member-history" type="button" role="tab"
                        aria-controls="nav-member-history" aria-selected="false">
                        History Anggota
                    </button>
                </div>
            </nav>
        </div>
    </div>
    <div class="container mt-3 mb-5">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-history-tournaments" role="tabpanel"
                aria-labelledby="nav-history-tournaments-tab" tabindex="0">
                @if ($tournamentData->count() > 0)
                    @foreach ($tournamentData as $td)
                        <div class="col-md-3">
                            <?php
                            $rank = $td->rank;
                            ?>
                            @foreach ($td->tournament as $t)
                                <a href="{{ route('tournament.show', $t->slug) }}">
                                    <div class="card mb-4 bg-custom-primary-2">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row text-white align-items-center">
                                                    <div class="col-4">
                                                        <img src="{{ asset('/' . 'assets/img/organizer-profile.jpeg') }}"
                                                            alt="logo_aog"
                                                            style="width: 100%; object-fit: cover; border-radius: 50%" />
                                                    </div>
                                                    <div class="col-8" style="line-height: 0">
                                                        <h5 class="fw-bold">
                                                            {{ $t->name }}
                                                        </h5>
                                                        <p class="fw-bold text-white-half my-3">
                                                            Rank: #{{ $rank }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <h1 class="text-white-half text-center">Tidak ada history</h1>
                @endif
            </div>
            <div class="tab-pane fade" id="nav-members" role="tabpanel" aria-labelledby="nav-members-tab" tabindex="0">
                <div id="member-list">
                    <div class="d-flex flex-column flex-md-row">
                        @foreach ($data as $member)
                            @if ($member->status == 1)
                                @php
                                    $memberRole = $member->role;
                                @endphp
                                @foreach ($member->user as $m)
                                    <div class="me-4">
                                        <a href="#" style="text-decoration: none">
                                            <div class="card d-flex flex-column align-items-center"
                                                style="background-color: rgba(255, 255, 255, 0)">
                                                <div class="mt-2 text-white" id="team-name">
                                                    <h4 class="fw-bold">{{ $memberRole }}</h4>
                                                </div>
                                                <div id="user-team-profile">
                                                    <img src="{{ $m->profile_pic ? asset('storage/' . $m->profile_pic) : asset('/') . 'assets/img/default-ava.png' }}"
                                                        alt="profile" />
                                                </div>
                                                <div class="mt-2 text-white" id="team-name">
                                                    <h4 class="fw-bold">{{ $m->nickname }}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-member-history" role="tabpanel" aria-labelledby="nav-member-history"
                tabindex="0">
                @foreach ($data as $member)
                    @php
                        $memberRole = $member->role;
                        $memberStatus = $member->status;
                    @endphp
                    @if ($memberStatus !== 2)
                        @foreach ($member->user as $m)
                            <div class="card bg-custom-primary-2 text-white my-3">
                                <div class="card-body">
                                    <p>{{ $m->nickname }}</p>
                                    @if ($memberStatus === 1)
                                        <p>Status: Aktif</p>
                                    @endif
                                    @if ($memberStatus === 3)
                                        <p>Status: Keluar</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
