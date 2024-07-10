@extends('layout')

@section('content')
    <img src="{{ $organizerData->banner_img ? asset('storage/' . $organizerData->banner_img) : asset('/' . 'assets/img/banner.jpg') }}"
        class="img-fluid" alt="Responsive image" style="height: 350px; object-fit: cover">


    <div class="container-fluid bg-custom-primary-2 text-white">
        <div class="container">
            <div class="row my-4">
                <!-- Profile Pict-->
                <div class="col-md-6">
                    <div class="d-flex">
                        <div class="me-4">
                            <img src="{{ $organizerData->logo_img ? asset('storage/' . $organizerData->logo_img) : asset('/' . 'assets/img/organizer-profile.jpeg') }}"
                                alt="profile-pic" class="detail-organizer-profile" />
                        </div>
                        <div class="">
                            <span style="font-size: 24px" class="text-white">{{ $organizerData->name }}<br></span>
                            <p style="font-size: 18px; text-decoration: none" class="text-white-half">
                                {{ $organizerData->description }}
                            </p>
                        </div>
                    </div>
                </div>
                @if ($userRole === 'Leader')
                    <div class="col-md-6 mt-3 mt-md-0 d-flex">
                        <div class="ms-md-auto align-self-center mx-auto mx-md-0">
                            <a href="{{ route('organizer_dashboard', $organizerData->slug) }}"
                                class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Dashboard</a>
                            <a href="#" class="btn btn-custom mx-3 mt-2 mt-md-0 mx-md-0">Undang Anggota</a>
                        </div>
                    </div>
                @endif
            </div>

            <nav class="mt-5">
                <div class="nav nav-tabs justify-content-center" id="custom-tournament-top-tab" role="tablist">
                    <button class="nav-link active" id="nav-history-tournaments-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-history-tournaments" type="button" role="tab"
                        aria-controls="nav-history-tournaments" aria-selected="true">
                        Turnamen
                    </button>
                </div>
            </nav>
        </div>
    </div>
    <div class="container mt-3 mb-5">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-history-tournaments" role="tabpanel"
                aria-labelledby="nav-history-tournaments-tab" tabindex="0">
                <div class="row">
                    @if ($organizerData->tournaments->count() > 0)
                        @foreach ($organizerData->tournaments as $t)
                            <div class="col-md-3">
                                <a href="{{ route('tournament.show', $t->slug) }}">
                                    <div class="card mb-4 bg-custom-primary-2">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row text-white align-items-center">
                                                    <div class="col-4">
                                                        <img src="{{ asset('/' . 'assets/img/organizer-profile.jpeg') }}"
                                                            alt="logo_aog"
                                                            style="width: 100%; object-fit: cover; border-radius: 50%" />
                                                    </div>
                                                    <div class="col-8" style="line-height: 0">
                                                        <h5 class="fw-bold" style="font-size: 15px">
                                                            {{ $t->name }}
                                                        </h5>
                                                        <p class="fw-bold text-white-half my-3" style="font-size: 12px">
                                                            {{ $t->start_time }}
                                                        </p>
                                                        <p class="fw-bold text-white-half" style="font-size: 12px">
                                                            Organizer: {{ $organizerData->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <h5 class="text-white">Belum ada turnamen</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
