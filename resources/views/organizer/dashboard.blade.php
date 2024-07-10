@extends('organizer.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-custom-primary-2">
                <div class="inner">
                    <h3>{{ $activeTournament }}</h3>
                    <p>Total Turnamen Aktif</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-custom-primary-2">
                <div class="inner">
                    <h3>{{ $activeTournamentTeam }}</h3>
                    <p>Total Tim Mendaftar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
