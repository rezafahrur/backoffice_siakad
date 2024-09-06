<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
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
            // 'kode_semester' => 'unique:m_semester,kode_semester',
            'tahun_awal' => 'required|digits:4',
            'tahun_akhir' => 'required|digits:4',
            'semester' => 'required|in:1,2,3', // 1: Ganjil, 2: Genap, 3: Pendek
        ];
    }

    private function updateRules(): array
    {
        return [
            // 'kode_semester' => 'unique:m_semester,kode_semester,' . $this->route('semester'),
            'tahun_awal' => 'required|digits:4',
            'tahun_akhir' => 'required|digits:4',
            'semester' => 'required|in:1,2,3',
        ];
    }

}
