<?php

namespace App\Http\Requests\Material;

use App\Models\RawMaterial;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $rawMaterial = $this->rawMaterial;

        return [
            'Name_RawMaterial' => [
                'required',
                Rule::unique(RawMaterial::class)->ignore($rawMaterial, 'Id_RawMaterial')
                    ->where(function ($query) use ($rawMaterial) {
                        $query->where('Id_RawMaterial', '!=', $rawMaterial);
                    }),
                'regex:/^[\pL\s]+$/u',
            ],
            'Unit' => 'required',
            'Count' => ['required', 'integer', 'min:1'],
            'FK_Id_RawMaterialType' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'Name_RawMaterial.unique' => 'Tên nguyên liệu thô đã tồn tại',
            'Name_RawMaterial.required' => 'Vui lòng nhập tên nguyên liệu thô',
            'Name_RawMaterial.regex' => 'Tên nguyên liệu thô chỉ được chứa các ký tự chữ cái',
            'Unit.required' => 'Vui lòng nhập đơn vị',
            'Count.required' => 'Vui lòng nhập số lượng',
            'Count.integer' => 'Số lượng nguyên liệu phải là số nguyên',
            'Count.min' => 'Số lượng nguyên liệu phải lớn hơn hoặc bằng 1',
            'FK_Id_RawMaterialType.required' => 'Vui lòng chọn loại nguyên liệu',
        ];
    }
}
