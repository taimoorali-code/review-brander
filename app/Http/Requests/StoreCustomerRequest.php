<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class StoreCustomerRequest extends FormRequest
{
public function authorize()
{
return true;
}


public function rules()
{
$customerId = $this->route('customer') ? $this->route('customer')->id : null;


return [
'name' => 'required|string',
'email' => 'required|email|unique:customers,email,' . $customerId,
'phone' => 'nullable|string',
'address' => 'nullable|string',
];
}
}