<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                </a>
            </li>

            @can('read_mahasiswa')
                <li class="menu-item {{ Route::is('mahasiswa.index') ? 'active' : '' }}">
                    <a href="{{ route('mahasiswa.index') }}" class='menu-link'>
                        <span><i class="bi bi-person-workspace"></i> Mahasiswa</span>
                    </a>
                </li>
            @endcan

            @can('read_jadwal')
                <li class="menu-item {{ Route::is('jadwal.index') ? 'active' : '' }}">
                    <a href="{{ route('jadwal.index') }}" class='menu-link'>
                        <span><i class="bi bi-calendar"></i> Jadwal</span>
                    </a>
                </li>
            @endcan

            <li
                class="menu-item has-sub {{ Route::is('jurusan.index') || Route::is('prodi.index') || Route::is('kelas.index') || Route::is('mata-kuliah.index') || Route::is('semester.index') || Route::is('tahun-ajaran.index') || Route::is('position.index') || Route::is('hr.index') || Route::is('paket-matakuliah.index') || Route::is('berita.index') ? 'active' : '' }}">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-grid-1x2-fill"></i> Master</span>
                </a>
                <div class="submenu">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            @can('read_jurusan')
                                <li class="submenu-item {{ Route::is('jurusan.index') ? 'active' : '' }}">
                                    <a href="{{ route('jurusan.index') }}" class='submenu-link'>Jurusan</a>
                                </li>
                            @endcan

                            @can('read_program_studi')
                                <li class="submenu-item {{ Route::is('prodi.index') ? 'active' : '' }}">
                                    <a href="{{ route('prodi.index') }}" class='submenu-link'>Program Studi</a>
                                </li>
                            @endcan

                            @can('read_ruang_kelas')
                                <li class="submenu-item {{ Route::is('kelas.index') ? 'active' : '' }}">
                                    <a href="{{ route('kelas.index') }}" class='submenu-link'>Ruang Kelas</a>
                                </li>
                            @endcan

                            @can('read_mata_kuliah')
                                <li class="submenu-item {{ Route::is('mata-kuliah.index') ? 'active' : '' }}">
                                    <a href="{{ route('mata-kuliah.index') }}" class='submenu-link'>Mata Kuliah</a>
                                </li>
                            @endcan

                            @can('read_semester')
                                <li class="submenu-item {{ Route::is('semester.index') ? 'active' : '' }}">
                                    <a href="{{ route('semester.index') }}" class='submenu-link'>Semester</a>
                                </li>
                            @endcan
                        </ul>
                        <ul class="submenu-group">
                            @can('read_tahun_ajaran')
                                <li class="submenu-item {{ Route::is('tahun-ajaran.index') ? 'active' : '' }}">
                                    <a href="{{ route('tahun-ajaran.index') }}" class='submenu-link'>Tahun Ajaran</a>
                                </li>
                            @endcan

                            @can('read_position')
                                <li class="submenu-item {{ Route::is('position.index') ? 'active' : '' }}">
                                    <a href="{{ route('position.index') }}" class='submenu-link'>Posisi</a>
                                </li>
                            @endcan

                            @can('read_hr')
                                <li class="submenu-item {{ Route::is('hr.index') ? 'active' : '' }}">
                                    <a href="{{ route('hr.index') }}" class='submenu-link'>HR</a>
                                </li>
                            @endcan

                            @can('read_paket_mata_kuliah')
                                <li class="submenu-item {{ Route::is('paket-matakuliah.index') ? 'active' : '' }}">
                                    <a href="{{ route('paket-matakuliah.index') }}" class='submenu-link'>Paket
                                        Matakuliah</a>
                                </li>
                            @endcan

                            @can('read_berita')
                                <li class="submenu-item {{ Route::is('berita.index') ? 'active' : '' }}">
                                    <a href="{{ route('berita.index') }}" class='submenu-link'>Berita</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
