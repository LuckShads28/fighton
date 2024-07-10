@extends('layout')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            <strong>Berhasil Daftar!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="px-4 py-5 img-fluid text-center text-white"
        style="background-image: url('/assets/img/hero-bg.png'); background-size: cover; height: 550px">
        <div class="h-100 d-flex justify-content-center align-items-center">
            <div class="col-lg-6 mx-auto">
                <h1 class="display-5 fw-bold">FIGHTON</h1>
                <p class="lead mb-4">CARI TURNAMENNYA DAN MENANGKAN BERSAMA TIMMU</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('tournament.index') }}" class="btn btn-custom">Cari Turnamen</a>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <!-- List Turnamen -->
        <div class="row mt-5">
            <div class="col-4">
                <div class="card bg-custom-primary-2">
                    <div class="mx-3 my-4 d-flex justify-content-center align-items-center flex-column">
                        <i class="fa-solid fa-trophy" style="font-size: 100px; color: white"></i>
                        <h5 class="text-white mt-4">TURNAMEN</h5>
                        <p class="text-center text-white">Cari turnamen Valorant terbaru dan bergabung bersama timmu</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-custom-primary-2">
                    <div class="mx-3 my-4 d-flex justify-content-center align-items-center flex-column">
                        <i class="fa-solid fa-people-group" style="font-size: 100px; color: white"></i>
                        <h5 class="text-white mt-4">TIM</h5>
                        <p class="text-center text-white">Buat timmu sendiri atau bergabung dengan tim lain untuk mengikuti
                            turnamen</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-custom-primary-2">
                    <div class="mx-3 my-4 d-flex justify-content-center align-items-center flex-column">
                        <i class="fa-solid fa-calendar-days" style="font-size: 100px; color: white"></i>
                        <h5 class="text-white mt-4">BUAT TURNAMEN</h5>
                        <p class="text-center text-white">Buat turnamenmu sendiri sebagai penyelenggara turnamen</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-white my-5">
            <h1 style="color: white; font-weight: bold">Turnamen Terbaru</h1>
            <div class="row mt-3">
                @if ($tournaments->count() > 0)
                    @foreach ($tournaments as $t)
                        <div class="col-md-4">
                            <div class="card mb-4 bg-custom-primary-2">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row text-white">
                                            <div class="col-4">
                                                <img src="{{ asset('/') }}assets/img/logo/logo_aov.png" alt="logo_aog"
                                                    style="width: 100%" />
                                            </div>
                                            <div class="col-8 pt-2">
                                                <h5 class="fw-bold text-white-half" style="font-size: 12px">
                                                    {{ $t->start_date . ' ' . $t->start_time }}
                                                </h5>
                                                <h5 class="fw-bold" style="font-size: 20px; margin-top: -5px">
                                                    {{ $t->name }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row text-white-half mt-3">
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Prize Pool</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-trophy" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span style="font-size: 11px">{{ $t->prizepool }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Kategori Tim</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-user" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span style="font-size: 11px">{{ $t->team_category }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <p><span style="font-size: 11px">Tim Terdaftar</span></p>
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <i class="fa-regular fa-people-group" style="font-size: 15px"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <span style="font-size: 11px">0/{{ $t->team_slot }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-custom-secondary">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-5">
                                                    <img src="{{ asset('storage/' . $t->organizer->logo_img) }}"
                                                        alt="profile-pic" class="organizer-profile" />
                                                </div>
                                                <div class="col-7 bg">
                                                    <span style="font-size: 12px" class="text-white-half">Organized
                                                        by<br></span>
                                                    <a href="{{ route('organizer.show', $t->organizer->slug) }}"
                                                        style="font-size: 12px; text-decoration: none"
                                                        class="text-white">{{ $t->organizer->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('tournament.show', $t->slug) }}"
                                                class="btn btn-custom w-100">Join</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 class="text-white-half text-center">Belum ada turnamen</h5>
                @endif
            </div>
            <div class="text-center">
                <a href="{{ route('tournament.index') }}" class="btn btn-custom">Cari Lainnya</a>
            </div>
        </div>
    </div>
@endsection
