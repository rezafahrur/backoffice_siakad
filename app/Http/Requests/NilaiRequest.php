<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class NilaiRequest extends FormRequest
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
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'kelas_id' => 'required|exists:m_kelas,id',
            'matakuliah_id' => 'required|exists:m_matakuliah,id',
            'details' => 'required|array',
            'details.*.mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'details.*.hasil_proyek' => 'nullable|numeric|min:0',
            'details.*.quiz' => 'nullable|numeric|min:0',
            'details.*.tugas' => 'nullable|numeric|min:0',
            'details.*.uts' => 'nullable|numeric|min:0',
            'details.*.uas' => 'nullable|numeric|min:0',
        ];
    }

    private function updateRules(): array
    {
        return [
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'kelas_id' => 'required|exists:m_kelas,id',
            'matakuliah_id' => 'required|exists:m_matakuliah,id',
            'details' => 'required|array',
            // 'details.*.mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'details.*.hasil_proyek' => 'nullable|numeric|min:0',
            'details.*.quiz' => 'nullable|numeric|min:0',
            'details.*.tugas' => 'nullable|numeric|min:0',
            'details.*.uts' => 'nullable|numeric|min:0',
            'details.*.uas' => 'nullable|numeric|min:0',
        ];
    }


}
