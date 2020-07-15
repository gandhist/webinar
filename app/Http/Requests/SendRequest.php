<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
        'nik' => 'required|max=50',
        ];
        if (request()->idMethod('post')){
            $rules['name'] = 'required|max 100|leave_date';
        }    
        if (request()->idMethod('post')){
            $rules['name'] = 'required|max 100|leave_quota_id';
        }
        if(request()->isMethod('delete')){
            $rules['id'] = 'required|int';
        }
        return $rules;
    }
}
