<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // INDEX
    public function index(Request $request) {
        $searchTerm = $request->input('searchTerm');
    
        $categories = Category::query();
    
        if ($searchTerm) {
            $categories->where('category_name', 'like', '%' . $searchTerm . '%')
                       ->orWhere('category_id', 'like', '%' . $searchTerm . '%');
        }
    
        $categories->orderBy('category_name');
    
        $categories = $categories->paginate(9)->appends(['searchTerm' => $searchTerm]);
    
        return view('category.index', compact('categories', 'searchTerm'));
    }
    
    // SHOW
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('category.show', compact('category'));
    }
    
    // CREATE
    public function create() {
        return view('category.create');
    }    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => ['required'],
        ]);
    
        Category::create($validated);
    
        return redirect('/category/list')->with('message_success', 'Category successfully saved.');
    }

    // EDIT
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    // UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => ['required'],
        ]); 
    
        $categoryData = [
            'category_name' => $request->input('category_name'),
        ];
    
        // Update category
        $category->update($categoryData);
    
        return redirect('/category/list')->with('message_success', 'Category updated successfully');
    }
    
    
    // DELETE
    public function delete($id) {
        $category = Category::find($id); 
        return view('category.delete', compact('category'));
    }

    // DESTROY
    public function destroy(Request $request, Category $category) {
        $category->delete();
    
        return redirect('/category/list')->with('message_success', 'Category successfully deleted.');
    }
}
