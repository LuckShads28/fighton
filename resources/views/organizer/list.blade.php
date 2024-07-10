@extends('layout')

@section('content')
    <div class="container my-4 text-white">
        <div class="text-center">
            <h2>Organizer</h2>
            <h5 class="text-white-half" style="font-size: 16px">
                Pilih Organizer atau Buat Organizer untuk mulai mengatur turnamen
            </h5>
        </div>
        <div class="row my-4 justify-content-center">
            @if ($data->count() > 0)
                @foreach ($data as $d)
                    @foreach ($d->organizer as $o)
                        <div class="col-md-2">
                            <a href="{{ route('organizer.show', $o->slug) }}" style="text-decoration: none">
                                <div class="card d-flex flex-column align-items-center"
                                    style="background-color: rgba(255, 255, 255, 0)">
                                    <div id="user-team-profile">
                                        <img src="{{ $o->logo_img ? asset('storage/' . $o->logo_img) : asset('/' . 'assets/img/organizer-profile.jpeg') }}"
                                            alt="" />
                                    </div>
                                    <div class="mt-2 text-white" id="team-name">
                                        <h4 class="fw-bold">{{ $o->name }}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            @else
                <h5 class="text-center text-white-half">Tidak ada organizer</h5>
            @endif
        </div>
        <div id="create-organizer" class="d-flex justify-content-center">
            <a href="{{ route('organizer.create') }}" class="btn btn-custom">Buat Organizer</a>
        </div>
    </div>
@endsection
