<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\ModeTransport;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý khách hàng');
    }
    $data = Customer::paginate(5);
    return view('customers.index', compact('data'));
  }
  public function create()
  {
    $data = ModeTransport::all();
    $customerTypes = CustomerType::all();
    return view('customers.create', compact('data', 'customerTypes'));
  }
  public function store(CustomerRequest $request)
  {
    $idMax = Customer::getIdMax();
    $customer = new Customer();
    $customer->Id_Customer = $idMax;
    $customer->fill($request->all());
    $customer->save();
    return redirect()->route('customers.show', ['customer' => $idMax])->with([
      'type' => 'success',
      'message' => 'Thêm người dùng thành công'
    ]);
  }
  public function show(string $customer_id)
  {
    return view('customers.show', ['customer' => Customer::find($customer_id)]);
  }
  public function edit(Customer $customer)
  {
    $data = ModeTransport::all();
    $customerTypes = CustomerType::all();
    return view('customers.edit', compact('data', 'customer', 'customerTypes'));
  }
  public function update(CustomerUpdateRequest $request, string $id)
  {
    $validator = $request->validated();

    $customer = Customer::find($id);
    $customer->Name_Customer = $validator['Name_Customer'];
    $customer->Email = $validator['Email'];
    $customer->Phone = $validator['Phone'];
    $customer->Name_Contact = $validator['Name_Contact'];
    $customer->Address = $validator['Address'];
    $customer->Zipcode = $validator['Zipcode'];
    $customer->FK_Id_Mode_Transport = $validator['FK_Id_Mode_Transport'];
    $customer->Time_Reception = $validator['Time_Reception'];
    $customer->FK_Id_CustomerType = $validator['FK_Id_CustomerType'];
    $customer->save();

    if ($customer->wasChanged()) {
      return redirect()->route('customers.index')->with([
        'message' => 'Sửa thông tin khách hàng thành công',
        'type' => 'success'
      ]);
    } else {
      return redirect()->route('customers.index')->with([
        'message' => 'Không có thay đổi nào được thực hiện',
        'type' => 'info'
      ]);
    }
  }
  public function destroy(Customer $customer)
  {
    $customer->delete();
    return redirect()->route('customers.index')->with([
      'message' => 'Xóa người dùng thành công',
      'type' => 'success',
    ]);
  }
}