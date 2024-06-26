@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-4">
                <div id="search-box">
                    <div class="row my-md-4">
                        <div class="col">
                            <form action="{{ route('team.index') }}">
                                <div class="input-group">
                                    <input type="search" class="form-control search-input-custom" placeholder="Cari Tim..."
                                        name="search" />
                                    <span class="input-group-text ms-0" style="background-color: #343434; border: none">
                                        <button class="btn search-btn-custom" type="submit">
                                            <i class="fas fa-search text-white"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dropdown my-md-4 my-2">
                    <button class="btn btn-dark-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        id="filter" style="width:250px">
                        Filter Role/Slot Kosong<span><i class="fa-solid fa-filter ms-1"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ route('team.index') }}?filter=initiator">Initiator</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('team.index') }}?filter=sentinel">Sentinel</a></li>
                        <li><a class="dropdown-item" href="{{ route('team.index') }}?filter=controller">Controller</a></li>
                        <li><a class="dropdown-item" href="{{ route('team.index') }}?filter=duelist">Duelist</a></li>
                        <li><a class="dropdown-item" href="{{ route('team.index') }}?filter=flex">Cadangan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($data as $t)
                <div class="col-md-4">
                    <div class="card mb-4 bg-custom-primary-2">
                        <div class="card-body">
                            <div class="container">
                                <div class="row text-white">
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $t->team->first()->logo_img) }}" alt="logo_aog"
                                            style="width: 100%; border-radius: 50%" />
                                    </div>
                                    <div class="col-8 pt-2 d-flex align-items-center">
                                        <h3 class="fw-bold text-white-half">
                                            {{ $t->team->first()->name }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="row text-white-half mt-3">
                                    <div class="col-12">
                                        <p><span style="font-size: 11px">Anggota Tim</span></p>
                                        <div class="row align-items-center">
                                            <div class="col-3">
                                                <i class="fa-regular fa-people-group" style="font-size: 15px"></i>
                                            </div>
                                            <div class="col-9">
                                                <span style="font-size: 11px">{{ $t->user->count() }}/7</span>
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
                                            @if ($t->user->first()->profile_img)
                                                <img src="{{ asset('storage/' . $t->user->first()->profile_img) }}"
                                                    alt="profile-pic" class="organizer-profile" />
                                            @else
                                                <img src="{{ asset('/') }}assets/img/organizer-profile.jpeg"
                                                    alt="profile-pic" class="organizer-profile" />
                                            @endif
                                        </div>
                                        <div class="col-7 bg">
                                            <span style="font-size: 12px" class="text-white-half">Team Leader:<br></span>
                                            <a href="#" style="font-size: 12px; text-decoration: none"
                                                class="text-white">{{ $t->user->first()->nickname }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('team.show', $t->team->first()->slug) }}"
                                        class="btn btn-custom w-100">Bergabung</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
