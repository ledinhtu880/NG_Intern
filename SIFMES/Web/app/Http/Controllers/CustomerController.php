<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\ModeTransport;
use App\Models\Order;
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
    $customer->Time_Reception = \Carbon\Carbon::now();
    $customer->save();

    return redirect()->route('customers.index')->with([
      'type' => 'success',
      'message' => 'Thêm người dùng thành công'
    ]);
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
    $customer->fill($validator);
    $customer->save();

    if ($customer->wasChanged()) {
      return redirect()->route('customers.index')->with([
        'message' => 'Sửa khách hàng thành công',
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
    if (Order::where('FK_Id_Customer', $customer->Id_Customer)->exists()) {
      return redirect()->route('customers.index')->with([
        'message' => 'Khách hàng đang có đơn hàng, không thể xóa.',
        'type' => 'warning'
      ]);
    } else {
      $customer->delete();
      return redirect()->route('customers.index')->with([
        'message' => 'Xóa khách hàng thành công',
        'type' => 'success'
      ]);
    }
  }
}
