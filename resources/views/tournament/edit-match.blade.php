@extends('layout')

@section('content')
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Edit Turnamen</h4>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-dark-custom dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pertandingan
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ Route::current()->url }}?page=basic">Basic</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=team">Tim</a></li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=match">Pertandingan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card bg-custom-primary text-white">
            <div class="card-body">
                <div>
                    <h5>Atur Pertandingan & Skor Antar Tim</h5>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="dropdown me-3">
                            <button class="btn btn-dark-custom dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Ronde
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                @for ($i = 1; $i <= $round; $i++)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ Route::current()->url }}?round={{ $i }}">Ronde
                                            {{ $i }}</a>
                                    </li>
                                @endfor
                                {{-- <li>
                                    <a class="dropdown-item" href="{{ Route::current()->url }}?round=1">1</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div>
                            @if ($matchData->count() > 0 && $nextRoundCount == 0)
                                <a href="{{ route('match.generateNextRound', $tournamentData->slug) }}"
                                    class="btn btn-custom">Generate
                                    Ronde Selanjutnya</a>
                            @endif
                            @if ($matchData->count() > 0 && $matchData->first()->round == $round)
                                <a href="{{ route('match.generateWinner', $tournamentData->slug) }}"
                                    class="btn btn-custom">Generate Winner</a>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('matches.create', $tournamentData->slug) }}" class="btn btn-custom">Tambah Data</a>
                </div>

                @if ($matchData->count() > 0)
                    @foreach ($matchData as $md)
                        <hr>
                        <div id="match-score" class="my-3">
                            <div class="row my-3">
                                <div class="col-4">
                                    <input type="text" class="form-control search-input-custom" disabled name="team1"
                                        value="{{ $md->team1->name }}" />
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control search-input-custom" disabled
                                        name="score_team1"
                                        value="{{ $md->team1_score == -1 ? 'WO' : $md->team1_score }}" />
                                </div>
                                <div class="col-2 text-center align-self-center">
                                    <h5>VS</h5>
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control search-input-custom" disabled
                                        name="score_team2"
                                        value="{{ $md->team2_score == -1 ? 'WO' : $md->team2_score }}" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control search-input-custom" disabled name="team2"
                                        value="{{ $md->team2->name }}" />
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="round">Ronde</label>
                                    <input type="text" class="form-control search-input-custom" disabled name="round"
                                        value="{{ $md->round }}" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('match.score', [$tournamentData->slug, $md->id, $md->team1_id, $md->team2_id]) }}"
                                class="btn btn-custom mx-2">Edit
                                Skor</a>
                            <form action="{{ route('match.destroy', [$tournamentData->slug, $md->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                    <hr>
                @else
                    <h4 class="text-white-half text-center my-5">Belum ada data pertandingan</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
