<?php

namespace App\Http\Requests\EduProgram;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EduProgramUpdateRequest extends FormRequest
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
            'Sym_Sub' => [
                'required',
                'regex:/^[a-zA-Z0-9,-]+$/',
                Rule::unique('Subjects', 'Sym_Sub')->ignore($this->Id_Sub, 'Id_Sub')
            ],
            'Name_Sub' => [
                'required',
                'regex:/^[\w\W\s\d,-]*$/',
                Rule::unique('Subjects', 'Name_Sub')->ignore($this->Id_Sub, 'Id_Sub')
            ],
            'Theory' => [
                'required',
                'integer',
                'min:0',
            ],
            'Exercise' => [
                'required',
                'integer',
                'min:0',
            ],
            'Practice' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'Sym_Sub.unique' => 'Ký hiệu môn học đã tồn tại',
            'Sym_Sub.required' => 'Vui lòng nhập ký hiệu môn học',
            'Sym_Sub.regex' => 'Ký hiệu môn học chỉ được nhập ký tự chữ và số',
            'Name_Sub.unique' => 'Tên môn học đã tồn tại',
            'Name_Sub.required' => 'Vui lòng nhập tên môn học',
            'Name_Sub.regex' => 'Tên môn học chỉ được nhập ký tự chữ và số',
            'Theory.required' => 'Vui lòng nhập số tiết lý thuyết',
            'Exercise.required' => 'Vui lòng nhập số tiết bài tập',
            'Practice.required' => 'Vui lòng nhập số tiết thực hành',
            'Theory.integer' => 'Số tiết lý thuyết phải là số nguyên dương',
            'Exercise.integer' => 'Số tiết bài tập phải là số nguyên dương',
            'Practice.integer' => 'Số tiết thực hành phải là số nguyên dương',
        ];
    }
}
