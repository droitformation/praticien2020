<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivateRequest extends FormRequest
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
            'code' => [
                'required', Rule::exists('codes')->where(function ($query) {$query->whereNull('user_id')->where('valid_at','>=',date('Y-m-d'));}),
            ],
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'Une facture existe déjà pour cette édition'
        ];
    }
}
