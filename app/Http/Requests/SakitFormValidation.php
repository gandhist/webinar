<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SakitFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'karyawan_id' => 'required',
            'keterangan' => 'required',
            'date_start' => 'required',
            'date_end' => 'required|after_or_equal:date_start'
        ];
    }

    public function messages()
    {
        return [
            'karyawan_id.required' => 'Nama Karyawan wajib diisi!',
            'keterangan.required' => 'Keterangan sakit wajib diisi!',
            'date_start.required' => 'Tanggal Mulai wajib diisi!',
            'date_end.required' => 'Tanggal Akhir wajib diisi!',
            'date_end.after_or_equal' => 'Tanggal Akhir sakit tidak boleh sebelum Tanggal Mulai!'
        ];
    }
}
