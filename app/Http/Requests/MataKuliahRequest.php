<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataKuliahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public $validator;

    public function failedValidation($validator)
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
            'kode_matakuliah' => 'required|string|max:10|unique:m_matakuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:100',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'jenis_matakuliah' => 'nullable|string|max:1',
            'sks_tatap_muka' => 'required|numeric',
            'sks_praktek' => 'required|numeric',
            'sks_praktek_lapangan' => 'required|numeric',
            'sks_simulasi' => 'required|numeric',
            'metode_belajar' => 'nullable|string',
            'tgl_mulai_efektif' => 'nullable|date',
            'tgl_akhir_efektif' => 'nullable|date|after:tgl_mulai_efektif',
            'status' => 'nullable|in:0,1',
        ];
    }

    private function updateRules()
    {
        return [
            'kode_matakuliah' => 'required|string|max:10',
            'nama_matakuliah' => 'required|string|max:100',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'jenis_matakuliah' => 'nullable|string|max:1',
            'sks_tatap_muka' => 'required|numeric',
            'sks_praktek' => 'required|numeric',
            'sks_praktek_lapangan' => 'required|numeric',
            'sks_simulasi' => 'required|numeric',
            'metode_belajar' => 'nullable|string',
            'tgl_mulai_efektif' => 'nullable|date',
            'tgl_akhir_efektif' => 'nullable|date|after:tgl_mulai_efektif',
            'status' => 'nullable|in:0,1',
        ];
    }
}
