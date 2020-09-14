<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessage extends FormRequest
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
        $honeypot = \App::environment('local') ? ['my_name' => 'honeypot', 'my_time' => 'required|honeytime:5'] : [];

        return [
            'nom'        => 'required',
            'email'      => 'required|email',
            'remarque'   => 'required'
        ] + $honeypot;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nom.required'       => 'Votre nom est requis',
            'email.required'     => 'Votre e-mail est requis',
            'email.email'        => 'Votre e-mail n\'est pas valide',
            'phone.required'     => 'Votre numéro de téléphone est requis',
            'remarque.required'  => 'Un message est requis'
        ];
    }
}
