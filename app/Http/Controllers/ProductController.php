<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // INDEX
    public function index(Request $request) {
        $searchTerm = $request->input('searchTerm');
    
        $products = Product::query();
    
        if ($searchTerm) {
            $products->where('product_name', 'like', '%' . $searchTerm . '%')
                     ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                     ->orWhere('product_id', 'like', '%' . $searchTerm . '%')
                     ->orWhere('description', 'like', '%' . $searchTerm . '%');
        }
    
        $products->orderBy('product_name');
    
        $products = $products->paginate(9)->appends(['searchTerm' => $searchTerm]);
    
        return view('product.index', compact('products', 'searchTerm'));
    }
    
    // SHOW
    public function show($id)
    {
        $product = Product::with('category', 'supplier')->findOrFail($id);
        return view('product.show', compact('product'));
    }
    
    // CREATE
    public function create() {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('product.create', compact('categories', 'suppliers'));
    }    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'brand' => ['required'],
            'cost_price' => ['required', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'status' => ['required'],
            'product_image' => ['nullable', 'mimes:jpg,png,jpeg,biff,bmp'],
            'supplier_id' => ['nullable', 'integer'],
            'supplier_name' => ['nullable', 'required_with:supplier_email'],
            'contact_person' => ['nullable'],
            'supplier_address' => ['nullable'],
            'supplier_phone' => ['nullable'],
            'supplier_email' => ['nullable', 'email', 'required_with:supplier_name'],
        ]);
    
        if ($request->hasFile('product_image')) {
            $filenameWithExtension = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('product_image')->storeAs('public/img/product', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }
    
        $supplier_id = $request->supplier_id;
        if ($supplier_id) {
            $validated['supplier_id'] = $supplier_id;
        } else {
            if ($request->supplier_name && $request->supplier_email) {
                $supplier = Supplier::create([
                    'supplier_name' => $request->supplier_name,
                    'contact_person' => $request->contact_person,
                    'supplier_address' => $request->supplier_address,
                    'supplier_phone' => $request->supplier_phone,
                    'supplier_email' => $request->supplier_email,
                ]);
    
                $validated['supplier_id'] = $supplier->supplier_id;
            }
        }
    
        $product = Product::create($validated);
    
        return redirect('/product/list')->with('message_success', 'Product successfully saved.');
    }




        // EDIT
        public function edit($id)
        {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            $suppliers = Supplier::all();
            return view('product.edit', compact('product', 'categories', 'suppliers'));
        }
    
        public function update(Request $request, Product $product)
        {
            $validated = $request->validate([
                'product_name' => ['required'],
                'description' => ['nullable'],
                'price' => ['required', 'numeric'],
                'quantity' => ['required', 'integer'],
                'category_id' => ['required', 'integer'],
                'brand' => ['required'],
                'cost_price' => ['required', 'numeric'],
                'discount' => ['nullable', 'numeric'],
                'status' => ['required'],
                'product_image' => ['nullable', 'mimes:jpg,png,jpeg,bmp,gif'],
                'supplier_id' => ['nullable', 'integer'],
                'supplier_name' => ['nullable', 'required_with:supplier_email'],
                'contact_person' => ['nullable'],
                'supplier_address' => ['nullable'],
                'supplier_phone' => ['nullable'],
                'supplier_email' => ['nullable', 'email', 'required_with:supplier_name'],
            ]);
        
            if ($request->hasFile('product_image')) {
                $filenameWithExtension = $request->file('product_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                $extension = $request->file('product_image')->getClientOriginalExtension();
                $filenameToStore = $filename . '_' . time() . '.' . $extension;
                $request->file('product_image')->storeAs('public/img/product', $filenameToStore);
                $validated['product_image'] = $filenameToStore;
            }
        
            $product->update($validated);
        
            if ($request->supplier_id) {
                $supplier = Supplier::find($request->supplier_id);
                if ($supplier) {
                    $supplier->update([
                        'supplier_name' => $request->supplier_name ?? $supplier->supplier_name,
                        'contact_person' => $request->contact_person ?? $supplier->contact_person,
                        'supplier_address' => $request->supplier_address ?? $supplier->supplier_address,
                        'supplier_phone' => $request->supplier_phone ?? $supplier->supplier_phone,
                        'supplier_email' => $request->supplier_email ?? $supplier->supplier_email,
                    ]);
                }
            } elseif ($request->supplier_name) {
                $supplier = Supplier::create([
                    'supplier_name' => $request->supplier_name,
                    'contact_person' => $request->contact_person,
                    'supplier_address' => $request->supplier_address,
                    'supplier_phone' => $request->supplier_phone,
                    'supplier_email' => $request->supplier_email,
                ]);
                $product->update(['supplier_id' => $supplier->supplier_id]);
            }
        
            return redirect('/product/list')->with('message', 'Updated Successfully');
        }
        
        
    
    
    
    // DELETE
    public function delete($id) {
        $product = Product::find($id); 
        return view('product.delete', compact('product'));
    }

    // DESTROY
    public function destroy(Request $request, Product $product) {
        if ($product->product_image && Storage::exists('public/img/product/' . $product->product_image)) {
            Storage::delete('public/img/product/' . $product->product_image);
        }
        $product->delete();
    
        return redirect('/product/list')->with('message_success', 'Product successfully deleted.');
    }
}