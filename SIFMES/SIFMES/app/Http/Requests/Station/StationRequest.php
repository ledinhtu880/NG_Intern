<?php

namespace App\Http\Requests\Station;

use Illuminate\Foundation\Http\FormRequest;

class StationRequest extends FormRequest
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
            'Id_Station' => [
                'required',
                'numeric',
                'unique:Station,Id_Station'
            ],
            'Name_Station' => [
                'required',
                'unique:Station,Name_Station'
            ],
            'Ip_Address' => [
                'nullable',
                'ip',
                'unique:Station,Ip_Address'
            ],
            'FK_Id_StationType' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'Id_Station.required' => 'Vui lòng nhập ID',
            'Id_Station.numeric' => 'ID phải là số',
            'Id_Station.unique' => 'ID đã tồn tại',
            'Name_Station.required' => 'Vui lòng nhập tên trạm',
            'Name_Station.unique' => 'Tên trạm đã tồn tại',
            'Ip_Address.ip' => 'Không đúng định dạng ip',
            'Ip_Address.unique' => 'IP đã tồn tại',
            'FK_Id_StationType.required' => 'Vui lòng chọn loại trạm'
        ];
    }
}
