<?php

namespace App\Http\Requests\DonNhapHang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'FK_Id_NCC' => [
                function ($attribute, $value, $fail) {
                    if ($value === 'default') {
                        $fail('This field must not be the default option.');
                    }
                },
            ],
            'TrangThai' => [
                function ($attribute, $value, $fail) {
                    if ($value === 'default') {
                        $fail('This field must not be the default option.');
                    }
                },
            ],
            'Ngay_DatHang' => [
                'required',
                'before:today',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Please make sure to fill in this field',
        ];
    }
}
