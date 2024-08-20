<?php

namespace App\Http\Requests;

use App\Models\Mahasiswa;
use App\Models\MahasiswaWali;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        }
        
        return $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            // Validasi Mahasiswa
            'nama' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:m_mahasiswa,email',
            'nisn' => 'required|string|max:10|unique:m_mahasiswa,nisn',
            'jurusan' => 'required|integer|exists:m_jurusan,id',
            'program_studi' => 'required|integer|exists:m_program_studi,id',
            'registrasi_tanggal' => 'required|date',
            'status' => 'required|string|max:50',
            'semester_berjalan' => 'required|integer|min:1|max:14',
            'no_hp' => 'required|string|max:15',
            'alamat_domisili' => 'required|string|max:128',
            'nik' => 'required|string|max:16|unique:t_ktp,nik',
            'alamat_jalan' => 'required|string|max:128',
            'alamat_rt' => 'required|string|max:3',
            'alamat_rw' => 'required|string|max:3',
            'alamat_prov_code' => 'required|exists:indonesia_provinces,code',
            'alamat_kotakab_code' => 'required|exists:indonesia_cities,code',
            'alamat_kec_code' => 'required|exists:indonesia_districts,code',
            'alamat_kel_code' => 'required|exists:indonesia_villages,code',
            'lahir_tempat' => 'required|string|max:50',
            'lahir_tgl' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:10',
            'golongan_darah' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'kewarganegaraan' => 'required|string|max:50',

            // Validasi Wali 1
            'wali_nama_1' => 'required|string|max:50',
            'wali_no_hp_1' => 'required|string|max:15',
            'wali_alamat_domisili_1' => 'required|string|max:128',
            'wali_pekerjaan_1' => 'required|string|max:50',
            'wali_penghasilan_1' => 'required|string|max:50',
            'pendidikan_terakhir_1' => 'required|string|max:3|in:D1,D2,D3,D4,S1,S2,S3',
            'wali_nik_1' => 'required|string|max:16|unique:t_ktp,nik',
            'wali_alamat_jalan_1' => 'required|string|max:128',
            'wali_alamat_rt_1' => 'required|string|max:3',
            'wali_alamat_rw_1' => 'required|string|max:3',
            'wali_alamat_prov_code_1' => 'required|exists:indonesia_provinces,code',
            'wali_alamat_kotakab_code_1' => 'required|exists:indonesia_cities,code',
            'wali_alamat_kec_code_1' => 'required|exists:indonesia_districts,code',
            'wali_alamat_kel_code_1' => 'required|exists:indonesia_villages,code',
            'wali_lahir_tempat_1' => 'required|string|max:50',
            'wali_lahir_tgl_1' => 'required|date',
            'wali_jenis_kelamin_1' => 'required|in:L,P',
            'wali_agama_1' => 'required|string|max:10',
            'wali_golongan_darah_1' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'wali_kewarganegaraan_1' => 'required|string|max:50',

            // Validasi Wali 2
            'wali_nama_2' => 'required|string|max:50',
            'wali_no_hp_2' => 'required|string|max:15',
            'wali_alamat_domisili_2' => 'required|string|max:128',
            'wali_pekerjaan_2' => 'required|string|max:50',
            'wali_penghasilan_2' => 'required|string|max:50',
            'pendidikan_terakhir_2' => 'required|string|max:3|in:D1,D2,D3,D4,S1,S2,S3',
            'wali_nik_2' => 'required|string|max:16|unique:t_ktp,nik',
            'wali_alamat_jalan_2' => 'required|string|max:128',
            'wali_alamat_rt_2' => 'required|string|max:3',
            'wali_alamat_rw_2' => 'required|string|max:3',
            'wali_alamat_prov_code_2' => 'required|exists:indonesia_provinces,code',
            'wali_alamat_kotakab_code_2' => 'required|exists:indonesia_cities,code',
            'wali_alamat_kec_code_2' => 'required|exists:indonesia_districts,code',
            'wali_alamat_kel_code_2' => 'required|exists:indonesia_villages,code',
            'wali_lahir_tempat_2' => 'required|string|max:50',
            'wali_lahir_tgl_2' => 'required|date',
            'wali_jenis_kelamin_2' => 'required|in:L,P',
            'wali_agama_2' => 'required|string|max:10',
            'wali_golongan_darah_2' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'wali_kewarganegaraan_2' => 'required|string|max:50',

            // Validasi Kontak Darurat
            'kd_nama' => 'required|string|max:50',
            'kd_hubungan' => 'required|string|max:50',
            'kd_no_hp' => 'nullable|string|max:15',
        ];
    }

    private function updateRules(): array
    {
        $mahasiswa = Mahasiswa::find($this->route('mahasiswa'));
        $wali1 = MahasiswaWali::where('mahasiswa_id', $mahasiswa->id)->where('status_kewalian', 'AYAH')->first();
        $wali2 = MahasiswaWali::where('mahasiswa_id', $mahasiswa->id)->where('status_kewalian', 'IBU')->first();
        return [
            // Validasi Mahasiswa
            'nama' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:m_mahasiswa,email,' . $mahasiswa->id,
            'nisn' => 'required|string|max:10|unique:m_mahasiswa,nisn,' . $mahasiswa->id,
            'jurusan' => 'required|integer|exists:m_jurusan,id',
            'program_studi' => 'required|integer|exists:m_program_studi,id',
            'registrasi_tanggal' => 'required|date',
            'status' => 'required|string|max:50',
            'semester_berjalan' => 'required|integer|min:1|max:14',
            'no_hp' => 'required|string|max:15',
            'alamat_domisili' => 'required|string|max:128',
            'nik' => 'required|string|max:16|unique:t_ktp,nik,' . $mahasiswa->ktp_id,
            'alamat_jalan' => 'required|string|max:128',
            'alamat_rt' => 'required|string|max:3',
            'alamat_rw' => 'required|string|max:3',
            'alamat_prov_code' => 'required|exists:indonesia_provinces,code',
            'alamat_kotakab_code' => 'required|exists:indonesia_cities,code',
            'alamat_kec_code' => 'required|exists:indonesia_districts,code',
            'alamat_kel_code' => 'required|exists:indonesia_villages,code',
            'lahir_tempat' => 'required|string|max:50',
            'lahir_tgl' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:10',
            'golongan_darah' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'kewarganegaraan' => 'required|string|max:50',

            // Validasi Wali 1
            'wali_nama_1' => 'required|string|max:50',
            'wali_no_hp_1' => 'required|string|max:15',
            'wali_alamat_domisili_1' => 'required|string|max:128',
            'wali_pekerjaan_1' => 'required|string|max:50',
            'wali_penghasilan_1' => 'required|string|max:50',
            'pendidikan_terakhir_1' => 'required|string|max:3|in:D1,D2,D3,D4,S1,S2,S3',
            'wali_nik_1' => 'required|string|max:16|unique:t_ktp,nik,' . $wali1->ktp_id,
            'wali_alamat_jalan_1' => 'required|string|max:128',
            'wali_alamat_rt_1' => 'required|string|max:3',
            'wali_alamat_rw_1' => 'required|string|max:3',
            'wali_alamat_prov_code_1' => 'required|exists:indonesia_provinces,code',
            'wali_alamat_kotakab_code_1' => 'required|exists:indonesia_cities,code',
            'wali_alamat_kec_code_1' => 'required|exists:indonesia_districts,code',
            'wali_alamat_kel_code_1' => 'required|exists:indonesia_villages,code',
            'wali_lahir_tempat_1' => 'required|string|max:50',
            'wali_lahir_tgl_1' => 'required|date',
            'wali_jenis_kelamin_1' => 'required|in:L,P',
            'wali_agama_1' => 'required|string|max:10',
            'wali_golongan_darah_1' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'wali_kewarganegaraan_1' => 'required|string|max:50',

            // Validasi Wali 2
            'wali_nama_2' => 'required|string|max:50',
            'wali_no_hp_2' => 'required|string|max:15',
            'wali_alamat_domisili_2' => 'required|string|max:128',
            'wali_pekerjaan_2' => 'required|string|max:50',
            'wali_penghasilan_2' => 'required|string|max:50',
            'pendidikan_terakhir_2' => 'required|string|max:3|in:D1,D2,D3,D4,S1,S2,S3',
            'wali_nik_2' => 'required|string|max:16|unique:t_ktp,nik,' . $wali2->ktp_id,
            'wali_alamat_jalan_2' => 'required|string|max:128',
            'wali_alamat_rt_2' => 'required|string|max:3',
            'wali_alamat_rw_2' => 'required|string|max:3',
            'wali_alamat_prov_code_2' => 'required|exists:indonesia_provinces,code',
            'wali_alamat_kotakab_code_2' => 'required|exists:indonesia_cities,code',
            'wali_alamat_kec_code_2' => 'required|exists:indonesia_districts,code',
            'wali_alamat_kel_code_2' => 'required|exists:indonesia_villages,code',
            'wali_lahir_tempat_2' => 'required|string|max:50',
            'wali_lahir_tgl_2' => 'required|date',
            'wali_jenis_kelamin_2' => 'required|in:L,P',
            'wali_agama_2' => 'required|string|max:10',
            'wali_golongan_darah_2' => 'required|in:A,A+,A-,B,B+,B-,AB,AB+,AB-,O,O+,O-',
            'wali_kewarganegaraan_2' => 'required|string|max:50',

            // Validasi Kontak Darurat
            'kd_nama' => 'required|string|max:50',
            'kd_hubungan' => 'required|string|max:50',
            'kd_no_hp' => 'required|string|max:15',
        ];
    }
}
