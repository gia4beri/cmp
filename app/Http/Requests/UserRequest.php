<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'personal_number' => 'required|string|unique:users,personal_number',
            'birth_date' => 'required|date',
            'gender' => 'required|in:მამრობითი,მდედრობითი,სხვა',
            'citizenship' => 'string|nullable',
            'insurance' => 'string|nullable',
            'parent_first_name' => 'string|nullable',
            'parent_last_name' => 'string|nullable',
            'parent_personal_number' => 'string|nullable',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'email' => 'email|nullable',
            'referral_source' => 'required|in:პასუხის გარეშე,სოციალური მედია,საძიებო სისტემა,მეგობარი / ოჯახი,რეკლამიდან,ღონისძიებიდან'
        ];
    }
}
