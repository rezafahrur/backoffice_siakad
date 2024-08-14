<?php

namespace App\Http\Requests;

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

    public function createRules(): array
    {
        return [
            'ktp_id' => 'required|exists:t_ktp,id',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'nim' => 'required|string|max:20|unique:m_mahasiswa,nim',
            'nama' => 'required|string|max:50',
            'registrasi_tanggal' => 'required|date',
            'status' => 'required|in:Aktif,Nonaktif',
        ];
    }

    public function updateRules(): array
    {
        return [
            'ktp_id' => 'required|exists:t_ktp,id',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'nim' => 'required|string|max:20|unique:m_mahasiswa,nim,' . $this->mahasiswa->id,
            'nama' => 'required|string|max:50',
            'registrasi_tanggal' => 'required|date',
            'status' => 'required|in:Aktif,Nonaktif',
        ];
    }   
}
