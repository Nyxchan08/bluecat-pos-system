<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
    
        // Retrieve all categories
        $categories = Category::all();
    
        // Query products
        $products = Product::query();
    
        // If there's a search term, filter products by name or category
        if ($searchTerm) {
            $products->where('product_name', 'like', '%' . $searchTerm . '%')
                     ->orWhereHas('category', function ($query) use ($searchTerm) {
                         $query->where('category_name', 'like', '%' . $searchTerm . '%');
                         $query->orWhere('product_id', 'like', '%' . $searchTerm . '%');
                     });
        }
    
        // Retrieve filtered or all products based on search
        $products = $products->get();
    
        return view('store.index', compact('categories', 'products', 'searchTerm'));
    }
}    