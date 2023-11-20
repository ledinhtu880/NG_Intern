<?php

namespace App\Http\Requests\Station;

use Illuminate\Foundation\Http\FormRequest;

class StationUpdate extends FormRequest
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
            //
            'Name_Station' => [
                'required'
            ],
            'Ip_Address' => 'nullable|ip',
            'FK_Id_StationType' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'Name_Station.required' => 'Vui lòng nhập tên trạm',
            'Name_Station.unique' => 'Tên trạm đã tồn tại',
            'Ip_Address.ip' => 'Không đúng định dạng email',
            'FK_Id_StationType.required' => 'Vui lòng chọn loại trạm'
        ];
    }
}
