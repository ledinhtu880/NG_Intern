<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\ModeTransport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý người dùng');
        }
        $data = Customer::paginate(5);
        return view('customers.index', compact('data'));
    }

    public function create()
    {
        $data = ModeTransport::all();
        return view('customers.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        //
        $customer = Customer::create($request->validated());
        $customer->Time_Reception = Carbon::now();
        $customer->save();
        return redirect()->route('customers.show', compact('customer'))->with([
            'type' => 'success',
            'message' => 'Thêm người dùng thành công'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
        return view('customers.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
        $data = ModeTransport::all();
        return view('customers.edit', compact('data', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        //
        $customer->update($request->validated());
        return redirect()->route('customers.show', compact('customer'))->with([
            'type' => 'success',
            'message' => 'Sửa người dùng thành công'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
        $customer->delete();
        return redirect()->route('customers.index')->with([
            'message' => 'Xóa người dùng thành công',
            'type' => 'danger',
        ]);
    }
}
