<div class="col-12 col-md-2">
    <div class="position-sticky">
        <ul class="nav flex-column nav-pills text-center">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'team.edit' ? 'active' : '' }}" aria-current="page"
                    href="{{ Route::currentRouteName() !== 'team.edit' ? route('team.edit', $slug) : '#' }}">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'edit_anggota' ? 'active' : '' }}" aria-current="page"
                    href="{{ Route::currentRouteName() !== 'edit_anggota' ? route('edit_anggota', $slug) : '#' }}">Anggota</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'edit_cadangan' ? 'active' : '' }}"
                    aria-current="page"
                    href="{{ Route::currentRouteName() !== 'edit_cadangan' ? route('edit_cadangan', $slug) : '#' }}">Atur
                    Cadangan</a>
                <a href="{{ Route::currentRouteName() !== 'team_logs' ? route('team_logs', $slug) : '#' }}">Log
                    History</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('team.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="nav-link text-danger" type="submit">Hapus Tim</button>
                </form>
            </li>
        </ul>
    </div>
</div>
