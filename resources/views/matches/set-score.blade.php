@extends('layout')

@section('content')
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Atur Pertandingan</h4>
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
                    <input type="hidden" name="tid" value="{{ $tournamentData->id }}">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="round" class="form-label text-white-half">
                                    Ronde
                                </label>
                                <input readonly type="text" class="form-control search-input-custom" required
                                    name="round" value="{{ $matchData->round }}" />
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
                                <input type="text" class="form-control search-input-custom" readonly name="team1"
                                    value="{{ $matchData->team1->name }}" />
                            </div>
                            <div class="col-1">
                                <label for="team1_score">Skor Tim 1</label>
                                <input type="text" class="form-control search-input-custom" name="team1_score"
                                    value="{{ $matchData->team1_score == -1 ? '0' : $matchData->team1_score }}" />
                            </div>
                            <div class="col-1">
                                <label for="#">Status</label>
                                <div>
                                    <input class="form-check-input" type="checkbox" id="team1" name="team1_wo"
                                        value="wo" {{ $matchData->team1_score == -1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="team1">WO</label>
                                </div>
                            </div>
                            <div class="col-2 text-center align-self-center">
                                <h5>VS</h5>
                            </div>
                            <div class="col-1">
                                <label for="#">Status</label>
                                <div>
                                    <input class="form-check-input" type="checkbox" id="team2" name="team2_wo"
                                        value="wo" {{ $matchData->team2_score == -1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="team2">WO</label>
                                </div>
                            </div>
                            <div class="col-1">
                                <label for="team2_score">Skor Tim 2</label>
                                <input type="text" class="form-control search-input-custom" name="team2_score"
                                    value="{{ $matchData->team2_score == -1 ? '0' : $matchData->team2_score }}" />
                            </div>
                            <div class="col-3">
                                <label for="team2">Team 2</label>
                                <input type="text" class="form-control search-input-custom" readonly name="team2"
                                    value="{{ $matchData->team2->name }}" />
                            </div>
                        </div>
                    </div>
                    @if ($haveDetail)
                        <div id="anggota">
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <h5>Data Tim 1</h5>
                                    </div>
                                    {{-- @for ($i = 1; $i < 6; $i++) --}}
                                    @foreach ($team1_member as $tm)
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Anggota {{ $loop->iteration }}
                                                    </label>
                                                    <select class="form-select bg-custom-2 text-white"
                                                        aria-label="Default select example" style="border:none" readonly
                                                        required name='team1_member[]'>
                                                        <option value="{{ $tm->player->id }}">{{ $tm->player->nickname }}
                                                        </option>
                                                        {{-- @foreach ($team1_member as $tm)
                                                            <option value="{{ $tm->player->id }}">
                                                                {{ $tm->player->nickname }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Kill
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_kill[]" value="{{ $tm->kill }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Death
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_death[]" value="{{ $tm->death }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Assist
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_assist[]" value="{{ $tm->assist }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        ACS
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_acs[]" value="{{ $tm->acs }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- @endfor --}}
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <h5>Data Tim 2</h5>
                                    </div>
                                    @foreach ($team2_member as $tm)
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Anggota {{ $loop->iteration }}
                                                    </label>
                                                    <select class="form-select bg-custom-2 text-white"
                                                        aria-label="Default select example" style="border:none" readonly
                                                        required name='team2_member[]'>
                                                        <option value="{{ $tm->player->id }}">{{ $tm->player->nickname }}
                                                        </option>
                                                        {{-- @foreach ($team1_member as $tm)
                                                            <option value="{{ $tm->player->id }}">
                                                                {{ $tm->player->nickname }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Kill
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_kill[]" value="{{ $tm->kill }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Death
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_death[]" value="{{ $tm->death }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Assist
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_assist[]" value="{{ $tm->assist }}" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        ACS
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_acs[]" value="{{ $tm->acs }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="anggota">
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <h5>Data Tim 1</h5>
                                    </div>
                                    @for ($i = 1; $i < 6; $i++)
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Anggota {{ $i }}
                                                    </label>
                                                    <select class="form-select bg-custom-2 text-white"
                                                        aria-label="Default select example" style="border:none" required
                                                        name='team1_member[]'>
                                                        <option value="">Pilih Anggota</option>
                                                        @foreach ($team1_member as $t1m)
                                                            @foreach ($t1m->user as $td)
                                                                <option value="{{ $td->id }}">{{ $td->nickname }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Kill
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_kill[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Death
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_death[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Assist
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_assist[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        ACS
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team1_acs[]" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <h5>Data Tim 2</h5>
                                    </div>
                                    @for ($i = 1; $i < 6; $i++)
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Anggota {{ $i }}
                                                    </label>
                                                    <select class="form-select bg-custom-2 text-white"
                                                        aria-label="Default select example" style="border:none" required
                                                        name='team2_member[]'>
                                                        <option value="">Pilih Anggota</option>
                                                        @foreach ($team2_member as $t2m)
                                                            @foreach ($t2m->user as $td)
                                                                <option value="{{ $td->id }}">{{ $td->nickname }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Kill
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_kill[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Death
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_death[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        Assist
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_assist[]" value="0" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="nama-organizer" class="form-label text-white-half">
                                                        ACS
                                                    </label>
                                                    <input type="text" class="form-control search-input-custom"
                                                        name="team2_acs[]" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-custom">Atur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
