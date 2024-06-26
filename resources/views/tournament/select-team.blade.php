@extends('layout')

@section('content')
    <div class="container my-4 text-white">
        <div class="text-center">
            <h2>Pilih Tim</h2>
            <h5 class="text-white-half" style="font-size: 16px">
                Pilih Tim atau buat tim untuk mengikuti turnamen
            </h5>
        </div>
        <div class="row justify-content-center mt-4">
            @foreach ($teams as $ts)
                <div class="col-md-3">
                    @foreach ($ts->team as $t)
                        <form action="{{ route('join_tournament', $slug) }}" method="post">
                            @csrf
                            <input type="hidden" name="teamId" value="{{ $t->id }}">
                            <div class="card card-sm bg-dark-custom" style="background-color: rgba(0,0,0,0);">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                    <button type="submit" class="w-100 h-100 btn btn-none text-white">
                                        <img src="{{ asset('storage/' . $t->logo_img) }}" alt="profile" width="50%"
                                            style="border-radius: 50%" />
                                        <div class="mt-3">
                                            <h5 id="team-name">{{ $t->name }}</h5>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- <a href="#" class="text-decoration-none">
                        </a> --}}
                    @endforeach
                </div>
            @endforeach
        </div>
        <div id="create-organizer" class="d-flex mt-5 justify-content-center">
            <a href="{{ route('team.create') }}" class="btn btn-custom d-none d-md-block">Buat Tim</a>
            <a href="{{ route('team.create') }}" class="btn btn-custom w-100 d-block d-md-none">Buat Tim</a>
        </div>
    </div>
@endsection
