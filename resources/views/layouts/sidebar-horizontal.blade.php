<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('mahasiswa.index') ? 'active' : '' }}">
                <a href="{{ route('mahasiswa.index') }}" class='menu-link'>
                    <span><i class="bi bi-person-workspace"></i> Mahasiswa</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('jadwal.index') ? 'active' : '' }}">
                <a href="{{ route('jadwal.index') }}" class='menu-link'>
                    <span><i class="bi bi-calendar"></i> Jadwal</span>
                </a>
            </li>
            <li class="menu-item has-sub">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-grid-1x2-fill"></i> Master</span>
                </a>
                <div class="submenu">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item {{ Route::is('jurusan.index') ? 'active' : '' }}">
                                <a href="{{ route('jurusan.index') }}" class='submenu-link'>Jurusan</a>
                            </li>
                            <li class="submenu-item {{ Route::is('prodi.index') ? 'active' : '' }}">
                                <a href="{{ route('prodi.index') }}" class='submenu-link'>Program Studi</a>
                            </li>
                            <li class="submenu-item {{ Route::is('kelas.index') ? 'active' : '' }}">
                                <a href="{{ route('kelas.index') }}" class='submenu-link'>Ruang Kelas</a>
                            </li>
                            <li class="submenu-item {{ Route::is('mata-kuliah.index') ? 'active' : '' }}">
                                <a href="{{ route('mata-kuliah.index') }}" class='submenu-link'>Mata Kuliah</a>
                            </li>
                            {{-- <li class="submenu-item {{ Route::is('mahasiswa.index') ? 'active' : '' }}">
                                <a href="{{ route('mahasiswa.index') }}" class='submenu-link'>Mahasiswa</a>
                            </li> --}}
                            <li class="submenu-item {{ Route::is('semester.index') ? 'active' : '' }}">
                                <a href="{{ route('semester.index') }}" class='submenu-link'>Semester</a>
                            </li>
                        </ul>
                        <ul class="submenu-group">
                            <li class="submenu-item {{ Route::is('tahun-ajaran.index') ? 'active' : '' }}">
                                <a href="{{ route('tahun-ajaran.index') }}" class='submenu-link'>Tahun Ajaran</a>
                            </li>
                            <li class="submenu-item {{ Route::is('position.index') ? 'active' : '' }}">
                                <a href="{{ route('position.index') }}" class='submenu-link'>Posisi</a>
                            </li>
                            <li class="submenu-item {{ Route::is('hr.index') ? 'active' : '' }}">
                                <a href="{{ route('hr.index') }}" class='submenu-link'>HR</a>
                            </li>
                            <li class="submenu-item {{ Route::is('paket-matakuliah.index') ? 'active' : '' }}">
                                <a href="{{ route('paket-matakuliah.index') }}" class='submenu-link'>
                                    Paket Matakuliah</a>
                            </li>
                            {{-- <li class="submenu-item {{ Route::is('jadwal.index') ? 'active' : '' }}">
                                <a href="{{ route('jadwal.index') }}" class='submenu-link'>Jadwal</a>
                            </li> --}}
                            <li class="submenu-item {{ Route::is('berita.index') ? 'active' : '' }}">
                                <a href="{{ route('berita.index') }}" class='submenu-link'>Berita</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submenuItems = document.querySelectorAll('.submenu-item.active');

        submenuItems.forEach(function(item) {
            const parentMenuItem = item.closest('.has-sub');
            if (parentMenuItem) {
                parentMenuItem.classList.add('active');
            }
        });
    });
</script>
