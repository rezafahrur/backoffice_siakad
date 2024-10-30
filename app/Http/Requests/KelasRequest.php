<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class KelasRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'semester_id' => 'required|exists:m_semester,id',
            'kurikulum_id' => 'required|exists:m_kurikulum,id',
            'nama_kelas' => 'required',
            'kapasitas' => 'required|numeric',
            'tanggal_mulai' => 'date|nullable',
            'tanggal_akhir' => 'date|after:tanggal_mulai|nullable',
            'details' => 'required|array',
            'details.*.kurikulum_detail_id' => 'required|exists:t_kurikulum_detail,id',
            'details.*.hr_id' => 'required|exists:m_hr,id',
            'details.*.tatap_muka' => 'required',
            'details.*.sks_ajar' => 'required',
            'details.*.jenis_evaluasi' => 'required',
            'details.*.desctiption' => 'nullable',
            'details.*.lingkup_kelas' => 'nullable',
            'details.*.mode_kelas' => 'nullable',
            'details.*.aktivitas_partisipatif' => 'nullable',
            'details.*.hasil_proyek' => 'nullable',
            'details.*.tugas' => 'nullable',
            'details.*.quiz' => 'nullable',
            'details.*.uts' => 'nullable',
            'details.*.uas' => 'nullable',
        ];
    }

    private function updateRules(): array
    {
        return [
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'semester_id' => 'required|exists:m_semester,id',
            'kurikulum_id' => 'required|exists:m_kurikulum,id',
            'nama_kelas' => 'required',
            'kapasitas' => 'required|numeric',
            'tanggal_mulai' => 'date|nullable',
            'tanggal_akhir' => 'date|after:tanggal_mulai|nullable',
            'details' => 'required|array',
            'details.*.kurikulum_detail_id' => 'required|exists:t_kurikulum_detail,id',
            'details.*.hr_id' => 'required|exists:m_hr,id',
            'details.*.tatap_muka' => 'required',
            'details.*.sks_ajar' => 'required',
            'details.*.jenis_evaluasi' => 'required',
            'details.*.desctiption' => 'nullable',
            'details.*.lingkup_kelas' => 'nullable',
            'details.*.mode_kelas' => 'nullable',
            'details.*.aktivitas_partisipatif' => 'nullable',
            'details.*.hasil_proyek' => 'nullable',
            'details.*.tugas' => 'nullable',
            'details.*.quiz' => 'nullable',
            'details.*.uts' => 'nullable',
            'details.*.uas' => 'nullable',
        ];
    }
}
