@extends('layout')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/bracket/jquery.bracket.min.css">
    @endpush

    <img src="{{ asset('storage/' . $tournament->banner_pic) }}" class="img-fluid" alt="Responsive image"
        style="height: 350px; object-fit: cover">
    </div>

    <div class="container-fluid bg-custom-primary-2 text-white">
        <div class="container">
            <div class="row justify-content-between my-4">
                <div class="col-6">
                    <h1>{{ $tournament->name }}</h1>
                    <div class="my-2">
                        <i class="fa-solid fa-calendar"></i>
                        <span class="fw-bold ms-1">{{ $tournament->start_date . ' ' . $tournament->start_time }}</span>
                    </div>
                    <div class="my-2">
                        <i class="fa-solid fa-dollar"></i>
                        <span class="fw-bold ms-1">{{ number_format($tournament->prizepool) }}</span>
                    </div>
                    <div class="my-2">
                        <i class="fa-solid fa-user"></i>
                        <span class="fw-bold ms-1">{{ $registeredTeam }}/{{ $tournament->team_slot }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end">
                        <div class="me-4">
                            <img src="{{ asset('/') }}assets/img/organizer-profile.jpeg" alt="profile-pic"
                                class="detail-organizer-profile" />
                        </div>
                        <div class="">
                            <span style="font-size: 24px" class="text-white-half">Organized
                                by<br></span>
                            <a href="{{ route('organizer.show', $tournament->organizer->slug) }}"
                                style="font-size: 24px; text-decoration: none"
                                class="text-white">{{ $tournament->organizer->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-3">
                @if ($userTeamRole === 'Leader' && ($userTeamStatus === null || $userTeamStatus > 1))
                    <a href="{{ route('select_team', $tournament->slug) }}" class="btn btn-custom" style="width: 150px">
                        Join
                    </a>
                @endif
                @if ($userTeamRole === 'Leader' && $userTeamStatus == 1)
                    <a class="btn btn-custom disabled" style="width: 150px">
                        Join
                    </a>
                @endif
            </div>

            <nav class="mt-5">
                <div class="nav nav-tabs nav-fill" id="custom-tournament-top-tab" role="tablist">
                    <button class="nav-link active" id="nav-overview-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview"
                        aria-selected="true">
                        Overview
                    </button>
                    <button class="nav-link" id="nav-tim-tab" data-bs-toggle="tab" data-bs-target="#nav-tim" type="button"
                        role="tab" aria-controls="nav-tim" aria-selected="false">
                        Tim
                    </button>
                    <button class="nav-link" id="nav-bracket-tab" data-bs-toggle="tab" data-bs-target="#nav-bracket"
                        type="button" role="tab" aria-controls="nav-bracket" aria-selected="false">
                        Bracket
                    </button>
                    <button class="nav-link" id="nav-kontak-tab" data-bs-toggle="tab" data-bs-target="#nav-kontak"
                        type="button" role="tab" aria-controls="nav-kontak" aria-selected="false">
                        Kontak
                    </button>
                </div>
            </nav>
        </div>
    </div>
    <div class="container my-5">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab"
                tabindex="0">
                <div class="banner d-flex justify-content-center">
                    <img src="{{ asset('/') }}assets/img/tournament-banner.jpg"class='img-fluid' alt="banner"
                        class="w-75" />
                </div>
                <div class="about mt-4">
                    <p class="text-white-half py-2">Tentang Turnamen</p>
                    {{ $tournament->about }}
                </div>
                <div class="rules mt-4">
                    <p class="text-white-half py-2">Peraturan Turnamen</p>
                    {{ $tournament->rules }}
                </div>
            </div>
            <div class="tab-pane fade" id="nav-tim" role="tabpanel" aria-labelledby="nav-tim-tab" tabindex="0">
                <div id="">
                    @if ($team->count() > 0)
                        <div class="row">
                            @foreach ($team as $td)
                                <div class="col-md-3">
                                    @foreach ($td->team as $t)
                                        <div class="card card-sm bg-dark-custom" style="background-color: rgba(0,0,0,0);">
                                            <div
                                                class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                                <a href="{{ route('team.show', $t->slug) }}"
                                                    class="w-100 h-100 btn btn-none text-white">
                                                    <img src="{{ asset('storage/' . $t->logo_img) }}" alt="profile"
                                                        width="50%" style="border-radius: 50%" />
                                                    <div class="mt-3">
                                                        <h5 id="team-name">{{ $t->name }}</h5>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h1 class="text-white-half text-center">Belum ada tim mendaftar</h1>
                    @endif

                </div>
            </div>
            <div class="tab-pane fade" id="nav-bracket" role="tabpanel" aria-labelledby="nav-bracket-tab"
                tabindex="0">
                <div id="bracket"></div>
            </div>
            <div class="tab-pane fade" id="nav-kontak" role="tabpanel" aria-labelledby="nav-kontak-tab" tabindex="0">
                {{ $tournament->organizer->contact }}
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('/') }}assets/vendor/bracket/jquery.bracket.min.js"></script>
        <script>
            var id = {{ $tournament->id }}
            $(function() {
                $.get("http://127.0.0.1:8000/bracket/get/" + id, function(data) {
                    console.log(data)
                    var container = $('div#bracket')
                    container.bracket({
                        skipConsolationRound: true,
                        init: data,
                    })
                    var data = container.bracket('data')
                });

                /* You can also inquiry the current data */
                // $('#dataOutput').text(jQuery.toJSON(data))
            })
        </script>
    @endpush
@endsection
