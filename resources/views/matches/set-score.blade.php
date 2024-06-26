@extends('layout')

@section('content')
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Tambah Pertandingan</h4>
            </div>
        </div>

        <div class="card bg-custom-primary text-white">
            <div class="card-body">
                @if (session()->has('errors'))
                    @foreach (session('errors')->all() as $e)
                        <p class="text-white">{{ $e }}</p>
                    @endforeach
                @endif
                <form action="{{ route('match.update_score', [$tournamentData->slug, $matchData->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="round" class="form-label text-white-half">
                                    Ronde
                                </label>
                                <input type="text" class="form-control search-input-custom" required name="round"
                                    value="{{ $matchData->round }}" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="round" class="form-label text-white-half">
                                    Jadwal Pertandingan
                                </label>
                                <input type="datetime-local" class="form-control search-input-custom" required
                                    name="match_date" value="{{ $matchData->match_date }}" />
                            </div>
                        </div>
                    </div>
                    <div id="match-score" class="my-3">
                        <div class="row my-3">
                            <div class="col-3">
                                <label for="team1">Team 1</label>
                                <input type="text" class="form-control search-input-custom" disabled name="team1"
                                    value="{{ $matchData->team1->name }}" />
                            </div>
                            <div class="col-1">
                                <label for="team1_score">Skor Tim 1</label>
                                <input type="text" class="form-control search-input-custom" name="team1_score"
                                    value="{{ $matchData->team1_score }}" />
                            </div>
                            <div class="col-1">
                                <label for="#">Status</label>
                                <div>
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="team1_wo"
                                        value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">WO</label>
                                </div>
                            </div>
                            <div class="col-2 text-center align-self-center">
                                <h5>VS</h5>
                            </div>
                            <div class="col-1">
                                <label for="#">Status</label>
                                <div>
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="team1_wo"
                                        value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">WO</label>
                                </div>
                            </div>
                            <div class="col-1">
                                <label for="team2_score">Skor Tim 2</label>
                                <input type="text" class="form-control search-input-custom" name="team2_score"
                                    value="{{ $matchData->team2_score }}" />
                            </div>
                            <div class="col-3">
                                <label for="team2">Team 2</label>
                                <input type="text" class="form-control search-input-custom" disabled name="team2"
                                    value="{{ $matchData->team2->name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-custom">Atur Score</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
