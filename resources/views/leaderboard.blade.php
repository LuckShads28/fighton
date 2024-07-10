@extends('layout')

@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('/') }}assets/css/leaderboard.css">
    @endpush
    <div class="container my-5 text-white">
        <div id="player">
            <div id="top3player">
                <h2 class="fw-bold">TOP 3 PLAYER</h2>
                <div class="row">
                    @foreach ($top3Player as $t3)
                        @php
                            $currRank = $loop->iteration;
                        @endphp
                        <div class="col-12 col-md-4">
                            <a href="#">
                                <div
                                    class="card mb-4 bg-custom-primary-2 {{ $loop->iteration == 1 ? 'border border-warning' : '' }}">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row text-white align-items-center">
                                                @foreach ($t3->user as $t3u)
                                                    <div class="col-4">
                                                        @if ($t3u->profile_pic != null)
                                                            <img src="{{ asset('storage/' . $t3u->profile_pic) }}"
                                                                alt="logo_aog"
                                                                style="width: 100%; object-fit: cover; border-radius: 50%" />
                                                        @else
                                                            <img src="{{ asset('/' . 'assets/img/default-ava.png') }}"
                                                                alt="logo_aog"
                                                                style="width: 100%; object-fit: cover; border-radius: 50%" />
                                                        @endif
                                                    </div>
                                                    <div class="col-6" style="line-height: 0;">
                                                        <h5 class="fw-bold" style="font-size: 30px;">
                                                            {{ $t3u->nickname }}
                                                        </h5>
                                                        <p class="fw-bold text-white-half my-3">
                                                            Total Menang: {{ $t3->totalMenang }}
                                                        </p>
                                                    </div>
                                                    <div class="col-2">
                                                        <h3>#{{ $currRank }}</h3>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="top5player">
                <h2 class="fw-bold">TOP 5 PLAYER</h2>
                @foreach ($top5Player as $t5p)
                    @php
                        $currRank = $loop->iteration;
                    @endphp
                    <div class="list-group w-auto">
                        <a href="#"
                            class="leaderboard list-group-item list-group-item-action d-flex gap-3 py-3 bg-custom-primary-2 text-white {{ $currRank == 1 ? 'border border-warning' : '' }}"
                            aria-current="true">
                            @foreach ($t5p->user as $t5u)
                                @if ($t5u->profile_pic != null)
                                    <img src="{{ asset('storage/' . $t5u->profile_pic) }}" alt="logo_aog" width="64"
                                        height="64" class="rounded-circle flex-shrink-0" />
                                @else
                                    <img src="{{ asset('/' . 'assets/img/default-ava.png') }}" alt="logo_aog" width="64"
                                        height="64" class="rounded-circle flex-shrink-0" />
                                @endif
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <h5 class="mb-0">{{ $t5u->nickname }}</h5>
                                        <p class="mb-0 opacity-75">Total Menang: {{ $t5p->totalMenang }}</p>
                                    </div>
                                    <small class="opacity-50 text-nowrap">#{{ $currRank }}</small>
                                </div>
                            @endforeach
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="team" class="mt-5">
            <h5>Leaderboard Team</h5>
            @foreach ($team as $t)
                @php
                    $currRank = $loop->iteration;
                @endphp
                <div class="list-group w-auto">
                    <a href="#"
                        class="leaderboard list-group-item list-group-item-action d-flex gap-3 py-3 bg-custom-primary-2 text-white {{ $currRank == 1 ? 'border border-warning' : '' }}"
                        aria-current="true">
                        @foreach ($t->team as $td)
                            @if ($td->logo_img != null)
                                <img src="{{ asset('storage/' . $td->logo_img) }}" alt="logo_aog" width="64"
                                    height="64" class="rounded-circle flex-shrink-0" />
                            @else
                                <img src="{{ asset('/' . 'assets/img/default-ava.png') }}" alt="logo_aog" width="64"
                                    height="64" class="rounded-circle flex-shrink-0" />
                            @endif
                            <div class="d-flex gap-2 w-100 justify-content-between">
                                <div>
                                    <h5 class="mb-0">{{ $td->name }}</h5>
                                </div>
                                <small class="opacity-50 text-nowrap">#{{ $currRank }}</small>
                            </div>
                        @endforeach
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
