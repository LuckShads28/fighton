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
                <form action="{{ route('matches.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $tournamentData->id }}">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="round" class="form-label text-white-half">
                                    Ronde
                                </label>
                                <input type="text" class="form-control search-input-custom" required name="round"
                                    value="1" disabled />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="round" class="form-label text-white-half">
                                    Jadwal Pertandingan
                                </label>
                                <input type="datetime-local" class="form-control search-input-custom" required
                                    name="match_date" />
                            </div>
                        </div>
                    </div>
                    <div id="match-score" class="my-3">
                        <div class="row my-3">
                            <div class="col-5">
                                <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                    style="border:none" name="team1" id="team1" required>
                                    <option value="{{ null }}">Pilih Tim</option>
                                    @foreach ($registeredTeam as $rt)
                                        @foreach ($rt->team as $t)
                                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 text-center align-self-center">
                                <h5>VS</h5>
                            </div>
                            <div class="col-5">
                                <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                    style="border:none" name="team2" id="team2" required>
                                    <option value="{{ null }}">Pilih Tim</option>
                                    @foreach ($registeredTeam as $rt)
                                        @foreach ($rt->team as $t)
                                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-custom">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
