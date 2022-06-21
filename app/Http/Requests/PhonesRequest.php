<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhonesRequest extends FormRequest
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
            'model' => 'required|string',
            'price' => 'required|double|min:0',
            'quantity' => 'required|int|min:0'
        ];
    }
}
