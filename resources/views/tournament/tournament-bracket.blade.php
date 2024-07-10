@extends('layout')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/bracket/jquery.bracket.min.css">
    @endpush
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Edit Turnamen</h4>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-dark-custom dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Basic
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ Route::current()->url }}?page=basic">Basic</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=team">Tim</a></li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=match">Pertandingan</a></li>
                        <li><a class="dropdown-item" href="{{ route('bracket', $data->slug) }}">Bracket</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="p-3 bg-custom-primary rounded text-white" style="height: 400px">
            <h1>Atur Bracket</h1>
            <div id="bracket"></div>
            <form action="{{ route('generate_round', $data->id) }}" method="post" id="bracketPost">
                @csrf
                <button class="btn btn-primary" type="submit">Generate Next Round</button>
            </form>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('/') }}assets/vendor/bracket/jquery.bracket.min.js"></script>
        <script>
            var id = {{ $data->id }}

            function saveFn(data, userData) {
                var team = Object.entries(data.teams)
                var score = Object.entries(data.results)
                document.getElementById('bracketPost').querySelectorAll('#teams').forEach(e => e.remove())
                // if (document.getElementById('teams')) {
                //     document.getElementById('teams').remove()
                // }
                // if (document.getElementById('scores')) {
                //     document.getElementById('scores').remove()
                // }
                for (let i = 0; i < team.length; i++) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'teams[]',
                        value: team[i][1],
                        id: 'teams'
                    }).appendTo('form');
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'score[]',
                        value: score[i],
                        id: 'scores'
                    }).appendTo('form');
                }
            }

            $(function() {
                $.get("http://127.0.0.1:8000/bracket/get/" + id, function(data) {
                    var container = $('div#bracket')
                    // for (let i = 0; i < data.teams.length; i++) {
                    //     $('<input>').attr({
                    //         type: 'hidden',
                    //         name: 'teams[]',
                    //         value: data.teams[i][0]
                    //     }).appendTo('form');
                    //     $('<input>').attr({
                    //         type: 'hidden',
                    //         name: 'teams[]',
                    //         value: data.teams[i][1]
                    //     }).appendTo('form');
                    //     $('<input>').attr({
                    //         type: 'hidden',
                    //         name: 'score[]',
                    //         value: data.results[i][0]
                    //     }).appendTo('form');
                    //     $('<input>').attr({
                    //         type: 'hidden',
                    //         name: 'score[]',
                    //         value: data.results[i][1]
                    //     }).appendTo('form');
                    // }
                    container.bracket({
                        skipConsolationRound: true,
                        init: data,
                        save: saveFn,
                        userData: data,
                        disableToolbar: true,
                        disableTeamEdit: true,
                    })
                    var data = container.bracket('data')
                });
            })
        </script>
    @endpush
@endsection
