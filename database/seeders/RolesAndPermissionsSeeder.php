<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua role dan permission sebelum menambahkannya
        Permission::truncate();
        Role::truncate();

        // Daftar entitas untuk CRUD permissions
        $entities = [
            'jadwal',
            'mahasiswa',
            'jurusan',
            'program_studi',
            'ruang_kelas',
            'mata_kuliah',
            'semester',
            'tahun_ajaran',
            'position',
            'hr',
            'paket_mata_kuliah',
            'berita'
        ];

        // Membuat permissions untuk setiap entitas
        foreach ($entities as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                Permission::create(['name' => "{$action}_{$entity}", 'guard_name' => 'hr']);
            }
        }

        // Mengambil data roles dari tabel `m_position`
        $positions = DB::table('m_position')->select('id', 'posisi')->get();
        
        foreach ($positions as $position) {
            // Menggunakan nama role dari kolom position_name
            $roleName = $position->posisi;
            if ($roleName) {
                Role::create(['name' => $roleName, 'guard_name' => 'hr']);
            }
        }

        // Menetapkan permissions ke role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }

        // Contoh penetapan permissions untuk role lainnya
        $rolesPermissions = [
            'Ketua Jurusan' => [
                'create_jurusan',
                'update_jurusan',
                'read_jurusan',
                'delete_jurusan',
                'create_program_studi',
                'update_program_studi',
                'read_program_studi',
                'delete_program_studi',
                'read_jadwal',
            ],
            'Wakil Ketua Jurusan' => [
                'create_program_studi',
                'update_program_studi',
                'read_program_studi',
                'delete_program_studi',
                'read_jadwal',
                'create_berita',
                'read_berita',
                'update_berita',
                'delete_berita'
            ],
            'Ketua Program Studi' => [
                'create_ruang_kelas',
                'update_ruang_kelas',
                'read_ruang_kelas',
                'delete_ruang_kelas',
                'create_mata_kuliah',
                'update_mata_kuliah',
                'read_mata_kuliah',
                'delete_mata_kuliah',
                'read_jadwal'
            ],
            'Wakil Ketua Program Studi' => [
                'create_mata_kuliah',
                'update_mata_kuliah',
                'read_mata_kuliah',
                'delete_mata_kuliah',
                'read_jadwal',
                'create_semester',
                'update_semester',
                'read_semester',
                'delete_semester'
            ],
            'Dosen' => [
                'read_jadwal',
                'read_mata_kuliah'
            ]
        ];

        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo($permissions);
            }
        }
    }
}
