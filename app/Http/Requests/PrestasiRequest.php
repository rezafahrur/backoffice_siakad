<?php

namespace App\Http\Requests;

use App\Models\Mahasiswa;
use App\Models\MahasiswaWali;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PrestasiRequest extends FormRequest
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
            'mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'nama_prestasi' => 'required|string|max:50',
            'jenis_prestasi' => 'required|string|max:50',
            'tingkat_prestasi' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'penyelenggara' => 'required|string|max:50',
            'peringkat' => 'required|string|max:50',
            // 'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ];
    }

    private function updateRules(): array
    {
        return [
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'nama_prestasi' => 'required|string|max:50',
            'jenis_prestasi' => 'required|string|max:50',
            'tingkat_prestasi' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'penyelenggara' => 'required|string|max:50',
            'peringkat' => 'required|string|max:50',
            // 'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ];
    }
}
