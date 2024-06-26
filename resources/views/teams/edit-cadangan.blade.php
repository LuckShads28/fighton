@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            {{-- Sidebar --}}
            @include('partials.teams-sidebar')

            {{-- Content --}}
            <div class="col-12 col-md-10">
                <h1 class="text-white">{{ $title }}</h1>
                <div class="card bg-dark-custom">
                    <div class="card-body">
                        <table class="table table-bordered text-white">
                            <thead>
                                <tr>
                                    <td>Nickname</td>
                                    <td>Role Game</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teamMember as $tm)
                                    <tr>
                                        @foreach ($tm->user as $m)
                                            <td>{{ $m->nickname }}</td>
                                            <td>
                                                <select class="form-select bg-custom-2 text-white"
                                                    aria-label="Default select example" style="border:none" name="role">
                                                    <option value="initiator" {{ $m->role == 'initiator' ?: 'selected' }}>
                                                        Inititator</option>
                                                    <option value="controller" {{ $m->role == 'controller' ?: 'selected' }}>
                                                        Controller</option>
                                                    <option value="duelist" {{ $m->role == 'duelist' ?: 'selected' }}>
                                                        Duelist</option>
                                                    <option value="sentinel" {{ $m->role == 'sentinel' ?: 'selected' }}>
                                                        Sentinel</option>
                                                    <option value="player_5" {{ $m->role == 'player_5' ?: 'selected' }}>
                                                        Fleksibel</option>
                                                    <option value="sub_1" {{ $m->role == 'sub_1' ?: 'selected' }}>Cadangan
                                                        1</option>
                                                    <option value="sub_2" {{ $m->role == 'sub_2' ?: 'selected' }}>
                                                        Cadangan 2</option>
                                                </select>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
