<?php


namespace App\Http\Controllers;


use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
// List
public function index()
{
$customers = Customer::orderBy('created_at', 'desc')->paginate(15);
return view('admin.customer.index', compact('customers'));
}


// Show create form
public function create()
{
return view('admin.customer.create');
}


// Store
public function store(StoreCustomerRequest $request)
{
Customer::create($request->validated());
return redirect()->route('customers.index')->with('success', 'Customer created.');
}


// Show single
public function show(Customer $customer)
{
return view('admin.customer.show', compact('customer'));
}


// Edit form
public function edit(Customer $customer)
{
return view('admin.customer.edit', compact('customer'));
}



public function import(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $file = fopen($path, 'r');

    $header = fgetcsv($file); // read first row as header

    $expectedHeaders = ['name', 'email', 'phone', 'address'];
    $header = array_map('strtolower', $header); // normalize case

    // Optional: validate CSV header matches expected columns
    if ($header !== $expectedHeaders) {
        return back()->with('error', 'Invalid CSV header. Expected: name,email,phone,address');
    }

    $dataToInsert = [];

    while (($row = fgetcsv($file)) !== false) {
        if (count($row) !== 4) continue;

        $dataToInsert[] = [
            'name'    => $row[0],
            'email'   => $row[1],
            'phone'   => $row[2],
            'address' => $row[3],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    fclose($file);

    if (count($dataToInsert)) {
        DB::table('customers')->insertOrIgnore($dataToInsert);
        return back()->with('success', 'Customers imported successfully!');
    }

    return back()->with('error', 'No valid rows found in CSV.');
}

// Update
public function update(StoreCustomerRequest $request, Customer $customer)
{
$customer->update($request->validated());
return redirect()->route('customers.index')->with('success', 'Customer updated.');
}


// Delete
public function destroy(Customer $customer)
{
$customer->delete();
return redirect()->route('customers.index')->with('success', 'Customer deleted.');
}
}