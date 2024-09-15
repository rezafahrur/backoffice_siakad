<div class="horizontal-menu">
    <nav class="navbar top-navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="#" class="navbar-brand">
                    POLIBA<span>TU</span>
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img class="wd-30 ht-30 rounded-circle"
                                src="{{ Session::get('photo_profile') && Storage::exists('public/' . Session::get('photo_profile'))
                                    ? asset('storage/' . Session::get('photo_profile'))
                                    : asset('assets/images/others/default-avatar.jpg') }}"
                                alt="profile">
                        </a>
                        <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                            <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                <div class="mb-3">
                                    <img class="wd-80 ht-80 rounded-circle"
                                        src="{{ Session::get('photo_profile') && Storage::exists('public/' . Session::get('photo_profile'))
                                            ? asset('storage/' . Session::get('photo_profile'))
                                            : asset('assets/images/others/default-avatar.jpg') }}"
                                        alt="profile">
                                </div>
                                <div class="text-center">
                                    <p class="tx-16 fw-bolder">{{ Session::get('nama') }}</p>
                                    <p class="tx-12 text-muted">{{ Session::get('posisi') }}</p>
                                </div>
                            </div>
                            <ul class="list-unstyled p-1">
                                <li class="dropdown-item py-2">
                                    <a href="pages/general/profile.html" class="text-body ms-0">
                                        <i class="me-2 icon-md" data-feather="user"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li class="dropdown-item py-2">
                                    <a href="{{ route('logout') }}" class="text-body ms-0">
                                        <i class="me-2 icon-md" data-feather="log-out"></i>
                                        <span>Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="horizontal-menu-toggle">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('/') }}">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                @can('read_mahasiswa')
                    <li class="nav-item {{ Route::is('mahasiswa.index') ? 'active' : '' }}">
                        <a href="{{ route('mahasiswa.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="inbox"></i>
                            <span class="menu-title">Mahasiswa</span>
                        </a>
                    </li>
                @endcan

                @can('read_jadwal')
                    <li class="nav-item {{ Route::is('jadwal.index') ? 'active' : '' }}">
                        <a href="{{ route('jadwal.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="calendar"></i>
                            <span class="menu-title">Jadwal</span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="grid"></i>
                        <span class="menu-title">Master</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="submenu-item">
                                    @can('read_jurusan')
                                        <li class="nav-item {{ Route::is('jurusan.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('jurusan.index') }}">Jurusan</a>
                                        </li>
                                    @endcan

                                    @can('read_program_studi')
                                        <li class="nav-item {{ Route::is('prodi.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('prodi.index') }}">Program Studi</a>
                                        </li>
                                    @endcan

                                    @can('read_ruang_kelas')
                                        <li class="nav-item {{ Route::is('kelas.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('kelas.index') }}">Ruang Kelas</a>
                                        </li>
                                    @endcan

                                    @can('read_mata_kuliah')
                                        <li class="nav-item {{ Route::is('mata-kuliah.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="submenu-item">
                                    @can('read_semester')
                                        <li class="nav-item {{ Route::is('semester.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('semester.index') }}">Semester</a>
                                        </li>
                                    @endcan

                                    {{-- @can('read_tahun_ajaran')
                                        <li class="nav-item {{ Route::is('tahun-ajaran.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a>
                                        </li>
                                    @endcan --}}

                                    @can('read_position')
                                        <li class="nav-item {{ Route::is('position.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('position.index') }}">Posisi</a>
                                        </li>
                                    @endcan

                                    @can('read_hr')
                                        <li class="nav-item {{ Route::is('hr.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('hr.index') }}">HR</a>
                                        </li>
                                    @endcan

                                    {{-- Kurikulum --}}
                                    {{-- @can('read_kurikulum') --}}
                                    <li class="nav-item {{ Route::is('kurikulum.index') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('kurikulum.index') }}">Kurikulum</a>
                                    </li>
                                    {{-- @endcan --}}

                                    {{-- @can('read_paket_mata_kuliah')
                                        <li class="nav-item {{ Route::is('paket-matakuliah.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('paket-matakuliah.index') }}">Paket
                                                Matakuliah</a>
                                        </li>
                                    @endcan --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="archive"></i>
                        <span class="menu-title">Feature</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_berita')
                                <li class="nav-item {{ Route::is('berita.index') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('berita.index') }}">Berita</a>
                                </li>
                            @endcan
                            <li class="nav-item {{ Route::is('config.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('config.index') }}">Config</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
