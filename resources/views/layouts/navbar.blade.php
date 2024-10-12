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
                                    <a href="{{ route('profile') }}" class="text-body ms-0">
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

                {{-- @can('read_mahasiswa')
                    <li class="nav-item {{ Request::is('mahasiswa*') ? 'active' : '' }}">
                        <a href="{{ route('mahasiswa.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="inbox"></i>
                            <span class="menu-title">Mahasiswa</span>
                        </a>
                    </li>
                @endcan --}}

                {{-- mahasiswa dan ktm validasi --}}
                <li class="nav-item {{ Request::is('mhs*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="inbox"></i>
                        <span class="menu-title">Mahasiswa</span>
                        <i class="link-arrow
                            "></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_mahasiswa')
                                <li class="nav-item {{ Request::is('mhs/mahasiswa*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
                                </li>
                            @endcan

                            @can('read_ktm_validasi')
                                <li class="nav-item {{ Request::is('mhs/ktm-validasi*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('ktm-validasi.index') }}">Validasi KTM</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('master*') ? 'active' : '' }}">
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
                                        <li class="nav-item {{ Request::is('master/jurusan*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('jurusan.index') }}">Jurusan</a>
                                        </li>
                                    @endcan

                                    @can('read_program_studi')
                                        <li class="nav-item {{ Request::is('master/prodi*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('prodi.index') }}">Program Studi</a>
                                        </li>
                                    @endcan

                                    @can('read_ruang_kelas')
                                        <li class="nav-item {{ Request::is('master/ruang-kelas*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('ruang-kelas.index') }}">Ruang Kelas</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="submenu-item">
                                    @can('read_semester')
                                        <li class="nav-item {{ Request::is('master/semester*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('semester.index') }}">Semester</a>
                                        </li>
                                    @endcan

                                    @can('read_position')
                                        <li class="nav-item {{ Request::is('master/position*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('position.index') }}">Posisi</a>
                                        </li>
                                    @endcan

                                    @can('read_mata_kuliah')
                                        <li class="nav-item {{ Request::is('master/mata-kuliah*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('kurikulum*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="book"></i>
                        <span class="menu-title">Kurikulum</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_kurikulum')
                                <li class="nav-item {{ Request::is('kurikulum/matkul*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('kurikulum.index') }}">Kurikulum</a>
                                </li>
                            @endcan

                            @can('read_rencana_evaluasi')
                                <li class="nav-item {{ Request::is('kurikulum/rencana-evaluasi*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('evaluasi_plan.index') }}">Rencana Evaluasi</a>
                                </li>
                            @endcan

                            @can('read_rencana_pembelajaran')
                                <li class="nav-item {{ Request::is('kurikulum/rencana-pembelajaran*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('pembelajaran_plans.index') }}">Rencana
                                        Pembelajaran</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>


                {{-- Perkuliahan --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="book-open"></i>
                        <span class="menu-title">Perkuliahan</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_kelas')
                                <li class="nav-item {{ Request::is('kelas*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('kelas.index') }}">Kelas</a>
                                </li>
                            @endcan

                            {{-- jadwal --}}
                            @can('read_jadwal')
                                <li class="nav-item {{ Request::is('jadwal*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('jadwal.index') }}">Jadwal</a>
                                </li>
                            @endcan

                            {{-- @can('read_absensi') --}}
                            <li class="nav-item">
                                <a class="nav-link" href="">Absensi</a>
                            </li>
                            {{-- @endcan --}}

                            {{-- @can('read_nilai') --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('nilai.index') }}">Nilai</a>
                            </li>
                            {{-- @endcan --}}

                            @can('read_skala_nilai')
                                <li class="nav-item {{ Request::is('skala-nilai*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('skala-nilai.index') }}">Skala Nilai</a>
                                </li>
                            @endcan

                            @can('read_periode_perkuliahan')
                                <li class="nav-item {{ Request::is('periode-perkuliahan*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('periode-perkuliahan.index') }}">Periode
                                        Perkuliahan</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                {{-- Aktivitas Mahasiswa --}}
                <li class="nav-item {{ Request::is('akm*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="activity"></i>
                        <span class="menu-title">Aktivitas Mahasiswa</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_akm')
                                <li class="nav-item {{ Request::is('akm/aktivitas-mahasiswa*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('aktivitas.index') }}">Aktivitas Mahasiswa</a>
                                </li>
                            @endcan

                            @can('read_akm_peserta')
                                <li class="nav-item {{ Request::is('akm/aktivitas-peserta*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('aktivitas-peserta.index') }}">Aktivitas Mahasiswa
                                        Peserta</a>
                                </li>
                            @endcan

                            @can('read_akm_bimbing_uji')
                                <li class="nav-item {{ Request::is('akm/aktivitas-bimbing-uji*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('bimbingUji.index') }}">Aktivitas Mahasiswa
                                        Bimbing Uji</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('feature*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="archive"></i>
                        <span class="menu-title">Feature</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @can('read_berita')
                                <li class="nav-item {{ Request::is('feature/berita*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('berita.index') }}">Berita</a>
                                </li>
                            @endcan
                            @can('read_config')
                                <li class="nav-item {{ Request::is('feature/config*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('config.index') }}">Config</a>
                                </li>
                            @endcan
                            @can('read_feature')
                                <li class="nav-item {{ Request::is('feature/fitur-hak-akses*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('feature.index') }}">Feature</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
