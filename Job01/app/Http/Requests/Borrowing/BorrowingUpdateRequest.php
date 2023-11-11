<?php

namespace App\Http\Requests\Borrowing;

use Illuminate\Foundation\Http\FormRequest;

class BorrowingUpdateRequest extends FormRequest
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
            'BookID' => [
                'required',
                function ($attribute, $value, $message) {
                    if ($value === 'default') {
                        $message('Please select a Book from the options provided.');
                    }
                },
            ],
            'MemberID' => [
                'required',
                'numeric'
            ],
            'BorrowDate' => [
                'required',
                'before:now'
            ],
            'DueDate' => [
                'required',
            ],
            'ReturnedDate' => [
                'required',
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
