@extends('layout.main')

@section('content')

<title>BLUE CAT EDIT</title>

<div class="container">
    <form action="/product/update/{{ $product->product_id }}" method="post" class="row g-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-4">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
            @error('product_name') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ $product->brand }}" required>
            @error('brand') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $product->price }}" required>
            @error('price') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="cost_price" class="form-label">Cost Price</label>
            <input type="number" class="form-control" id="cost_price" name="cost_price" step="0.01" value="{{ $product->cost_price }}" required>
            @error('cost_price') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
            @error('quantity') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" class="form-control" id="discount" name="discount" step="0.01" value="{{ $product->discount }}">
            @error('discount') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ $category->category_id == $product->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-danger">{{$message}}</p>@enderror
        </div>

        <div class="col-md-4">
            <label for="product_image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="product_image" name="product_image">
            @error('product_image') <p class="text-danger">{{$message}}</p>@enderror
        </div>

        <div class="col-md-6">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-select" id="supplier_id" name="supplier_id">
                <option value="">Select a Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}" {{ $product->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                @endforeach
            </select>
            @error('supplier_id') <p class="text-danger">{{$message}}</p>@enderror
        </div>

        <div class="col-md-6">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
            @error('description') <p class="text-danger">{{$message}}</p>@enderror
        </div>

        <hr>

        <div class="col-md-6">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-select" id="supplier_id" name="supplier_id">
                <option value="">Select a Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}" {{ $product->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                @endforeach
            </select>
            @error('supplier_id') <p class="text-danger">{{$message}}</p>@enderror
        </div>

        <div class="col-md-6">
            <label for="supplier_name" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="{{ optional($product->supplier)->supplier_name }}">
            @error('supplier_name') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="contact_person" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ optional($product->supplier)->contact_person }}">
            @error('contact_person') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_address" class="form-label">Supplier Address</label>
            <input type="text" class="form-control" id="supplier_address" name="supplier_address" value="{{ optional($product->supplier)->supplier_address }}">
            @error('supplier_address') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_phone" class="form-label">Supplier Phone</label>
            <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" value="{{ optional($product->supplier)->supplier_phone }}">
            @error('supplier_phone') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_email" class="form-label">Supplier Email</label>
            <input type="email" class="form-control" id="supplier_email" name="supplier_email" value="{{ optional($product->supplier)->supplier_email }}">
            @error('supplier_email') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-outline-success">Submit</button>
            <a href="/product/list" class="btn btn-outline-danger">Cancel</a>
        </div>
    </form>
</div>

@endsection
