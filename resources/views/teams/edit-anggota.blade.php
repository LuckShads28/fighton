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
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>Role Game</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teamMember as $tm)
                                    <tr>
                                        @php
                                            $status = $tm->status;
                                            $teamRole = $tm->role;
                                        @endphp
                                        @if ($status < 2)
                                            <td>{{ $loop->iteration }}</td>
                                            @foreach ($tm->user as $m)
                                                <td>{{ $m->nickname }}</td>
                                                <td>{{ $m->role }}</td>
                                                <td>
                                                    @if ($status === 0)
                                                        Menunggu Persetujuan
                                                    @endif
                                                    @if ($status === 1)
                                                        {{ $tm->role }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($status === 0)
                                                        <form action="{{ route('member_action', $slug) }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="userId" value="{{ $m->id }}">
                                                            <input type="hidden" name="teamId"
                                                                value="{{ $data->id }}">
                                                            <input type="hidden" name="status" value="1">
                                                            <button type="submit" class="btn btn-success">Terima</button>
                                                        </form>
                                                        <form action="{{ route('member_action', $slug) }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="userId"
                                                                value="{{ $m->id }}">
                                                            <input type="hidden" name="teamId"
                                                                value="{{ $data->id }}">
                                                            <input type="hidden" name="status" value="2">
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </form>
                                                    @endif
                                                    @if ($status === 1 && $tm->role !== 'Leader')
                                                        <form action="{{ route('member_action', $slug) }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="userId"
                                                                value="{{ $m->id }}">
                                                            <input type="hidden" name="teamId"
                                                                value="{{ $data->id }}">
                                                            <input type="hidden" name="status" value="3">
                                                            <button type="submit" class="btn btn-danger">Keluarkan
                                                                Anggota</button>
                                                        </form>
                                                    @endif
                                                    @if ($status === 1 && $tm->role === 'Leader')
                                                        <a href="#" class="btn btn-danger disabled">Keluarkan
                                                            Anggota</a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endif
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
