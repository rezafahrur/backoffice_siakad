<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class KtpRequest extends FormRequest
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
            'nik' => 'required|string|max:16|unique:t_ktp,nik',
            'nama' => 'required|string|max:50',
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
        ];
    }

    private function updateRules(): array
    {
        return [
            'nik' => 'required|string|max:16|unique:t_ktp,nik,' . $this->ktp->id,
            'nama' => 'required|string|max:50',
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
        ];
    }
}
