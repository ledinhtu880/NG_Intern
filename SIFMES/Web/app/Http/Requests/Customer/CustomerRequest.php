<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
      'Name_Customer' => [
        'required',
        'max:255',
        'regex:/^[\pL\s]+$/u'
      ],
      'Email' => [
        'required',
        'email',
        'regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'unique:customer,Email'
      ],
      'Phone' => [
        'required',
        'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})\b/',
        'unique:customer,phone'
      ],
      'Name_Contact' => [
        'required'
      ],
      'Address' => [
        'required'
      ],
      'Zipcode' => [
        'required',
        'numeric'
      ],
      'FK_Id_Mode_Transport' => [
        'required'
      ],
      'FK_Id_CustomerType' => [
        'required'
      ]
    ];
  }

  public function messages(): array
  {
    return [
      'Name_Customer.required' => 'Vui lòng nhập tên bạn',
      'Name_Customer.regex' => 'Tên bạn không được chứa số và ký tự đặc biệt',
      'Email.required' => 'Vui lòng nhập email',
      'Email.regex' => 'Không đúng định dạng email',
      'Email.email' => 'Không đúng định dạng email',
      'Email.unique' => 'Email đã tồn tại',
      'Phone.required' => 'Vui lòng nhập số điện thoại',
      'Phone.regex' => 'Không đúng định dạng',
      'Phone.unique' => 'Số điện thoại đã tồn tại',
      'Name_Contact.required' => 'Vui lòng nhập tên liên hệ',
      'Address.required' => 'Vui lòng nhập địa chỉ',
      'Zipcode.required' => 'Vui lòng nhập zipcode',
      'Zipcode.numeric' => 'Zipcode phải là số',
      'FK_Id_Mode_Transport.required' => 'Vui lòng chọn phương thức vận chuyển',
      'FK_Id_CustomerType.required' => 'Vui lòng chọn kiểu khách hàng'
    ];
  }
}
