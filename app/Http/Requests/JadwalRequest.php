<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class JadwalRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function rules()
    {
        if($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            'paket_matakuliah_id' => 'required|exists:m_paket_matakuliah,id',
            'details' => 'required|array',
            'details.*.paket_matakuliah_detail_id' => 'required|exists:t_paket_matakuliah_detail,id',
            'details.*.hr_id' => 'required|exists:m_hr,id',
            'details.*.ruang_kelas_id' => 'required|exists:m_ruang_kelas,id',
            'details.*.jadwal_hari' => 'required',
            'details.*.jadwal_jam_mulai' => 'required|date_format:H:i',
            'details.*.jadwal_jam_akhir' => 'required|date_format:H:i|after:details.*.jadwal_jam_mulai',
        ];
    }

    private function updateRules(): array
    {
        return [
            'paket_matakuliah_id' => 'required|exists:m_paket_matakuliah,id',
        ];
    }
}
