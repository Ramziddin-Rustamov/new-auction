<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id'=>['required','exists:users,id'],
            'name'=>['required'],
            'image'=>['required','mimes:png,jpg,jpeg'],
            'bidmargin'=>['required'],
            'description'=>['required'],
        ];
    }
}
