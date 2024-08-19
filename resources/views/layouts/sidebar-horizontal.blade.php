<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item {{ Route::is('home') ? 'active' : '' }} ">
                <a href="{{ url('/') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('mahasiswa.index') ? 'active' : '' }} ">
                <a href="{{ route('mahasiswa.index') }}" class='menu-link'>
                    <span><i class="bi bi-person-workspace"></i> Mahasiswa</span>
                </a>
            </li>
            <li class="menu-item active has-sub">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-grid-1x2-fill"></i>Master</span>
                </a>
                <div class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item {{ Route::is('prodi.index') ? 'active' : '' }} ">
                                <a href="{{ route('prodi.index') }}" class='submenu-link'>Program Studi</a>
                            </li>
                            <li class="submenu-item {{ Route::is('kelas.index') ? 'active' : '' }}">
                                <a href="{{ route('kelas.index') }}" class='submenu-link'>Ruang Kelas</a>
                            </li>
                            <li class="submenu-item {{ Route::is('mata-kuliah.index') ? 'active' : '' }}">
                                <a href="{{ route('mata-kuliah.index') }}" class='submenu-link'>Mata Kuliah</a>
                            </li>
                            <li class="submenu-item {{ Route::is('mahasiswa.index') ? 'active' : '' }}">
                                <a href="{{ route('mahasiswa.index') }}" class='submenu-link'>Mahasiswa</a>
                            </li>
                            <li class="submenu-item {{ Route::is('semester.index') ? 'active' : '' }}">
                                <a href="{{ route('semester.index') }}" class='submenu-link'>Semester</a>
                            </li>
                            <li class="submenu-item {{ Route::is('tahun-ajaran.index') ? 'active' : '' }}">
                                <a href="{{ route('tahun-ajaran.index') }}" class='submenu-link'>Tahun Ajaran</a>

                            <li class="submenu-item {{ Route::is('position.index') ? 'active' : '' }}">
                                <a href="{{ route('position.index') }}" class='submenu-link'>Posisi</a>
                            </li>
                            <li class="submenu-item {{ Route::is('hr.index') ? 'active' : '' }}">
                                <a href="{{ route('hr.index') }}" class='submenu-link'>HR</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
