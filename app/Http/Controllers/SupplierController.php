<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // INDEX
    public function index(Request $request) {
        $searchTerm = $request->input('searchTerm');

        $suppliers = Supplier::query();

        if ($searchTerm) {
            $suppliers->where('supplier_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('supplier_id', 'like', '%' . $searchTerm . '%')
                      ->orWhere('contact_person', 'like', '%' . $searchTerm . '%')
                      ->orWhere('supplier_address', 'like', '%' . $searchTerm . '%')
                      ->orWhere('supplier_phone', 'like', '%' . $searchTerm . '%')
                      ->orWhere('supplier_email', 'like', '%' . $searchTerm . '%');
        }

        $suppliers->orderBy('supplier_name');

        $suppliers = $suppliers->paginate(9)->appends(['searchTerm' => $searchTerm]);

        return view('supplier.index', compact('suppliers', 'searchTerm'));
    }

    // SHOW
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }

    // CREATE
    public function create() {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => ['required'],
            'contact_person' => ['nullable'],
            'supplier_address' => ['nullable'],
            'supplier_phone' => ['nullable'],
            'supplier_email' => ['nullable', 'email'],
        ]);

        Supplier::create($validated);

        return redirect('/supplier/list')->with('message_success', 'Supplier successfully created.');
    }

    // EDIT
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    // UPDATE
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_name' => ['required'],
            'contact_person' => ['nullable'],
            'supplier_address' => ['nullable'],
            'supplier_phone' => ['nullable'],
            'supplier_email' => ['nullable', 'email'],
        ]);

        $supplier->update($validated);

        return redirect('/supplier/list')->with('message_success', 'Supplier successfully updated.');
    }

    // DELETE
    public function delete($id) {
        $supplier = Supplier::find($id);
        return view('supplier.delete', compact('supplier'));
    }

    // DESTROY
    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->delete();

        return redirect('/supplier/list')->with('message_success', 'Supplier successfully deleted.');
    }
}
