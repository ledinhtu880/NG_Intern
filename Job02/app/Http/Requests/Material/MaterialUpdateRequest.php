<?php

namespace App\Http\Requests\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialUpdateRequest extends FormRequest
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
            'Name_RawMaterial' => [
                'required',
            ],
            'Unit' => [
                'required',
            ],
            'count' => [
                'required',
                'numeric',
            ],
            'FK_Id_RawMaterialType' => [
                'required',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'Name_RawMaterial.required' => 'Vui lòng nhập tên nguyên liệu thô',
            'Unit.required' => 'Vui lòng nhập đơn vị',
            'count.required' => 'Vui lòng nhập số lượng',
            'FK_Id_RawMaterialType.required' => 'Vui lòng chọn loại nguyên liệu',
        ];
    }
}
