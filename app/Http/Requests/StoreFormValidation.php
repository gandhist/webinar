<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *g
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
            'permission_date' => 'nullable|date|required_without:is_fullday',
            'start_date' => 'nullable|date|required_with:is_fullday',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_with:is_fullday',
            'start_hour' => 'nullable|required_without:is_fullday',
            'end_hour' => 'nullable|required_without:is_fullday',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'karyawan_id.required' => 'Nama Karyawan wajib diisi!',
            'keterangan.required' => 'Keterangan ijin wajib diisi!',
            'end_date.after_or_equal' => 'Tanggal Akhir iji tidak boleh sebelum Tanggal Mulai Ijin!',
            'permission_date.required_without' => 'Tanggal Ijin wajib diisi, jika ijin beberapa jam!',
            'start_date.required_with' => 'Tanggal Mulai Ijin wajib diisi, jika ijin seharian!',
            'end_date.required_with' => 'Tanggal Akhir Ijin wajib diisi, jika ijin seharian!',
            'start_hour.required_without' => 'Jam Mulai wajib diisi, jika ijin beberapa jam!',
            'end_hour.required_without' => 'Jam Selesai wajib diisi, jika ijin beberapa jam!',
            'status.required' => 'Field status wajib diisi!'
        ];
    }
}
