<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RuangKelasRequest extends FormRequest
{
    public $validator;
    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function rules():array
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    private function createRules():array
    {
        return [
            'kode_ruang_kelas' => 'required|string|max:10|unique:m_ruang_kelas,kode_ruang_kelas',
            'nama_ruang_kelas' => 'required|string|max:50',
            'kapasitas' => 'required|integer',
        ];
    }

    private function updateRules():array
    {
        return [
            'kode_ruang_kelas' => 'required|string|max:10',
            'nama_ruang_kelas' => 'required|string|max:50',
            'kapasitas' => 'required|integer',
        ];
    }
}
