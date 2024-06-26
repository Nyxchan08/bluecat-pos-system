@extends('layout.main')

@section('content')

<title>View Product | Your App Name</title>

<div div="col-12">
    <a href="/product/list"><img src="{{ asset('img/goback.png')}}" alt="Go Back" style="position:absolute; height: 20px; width: 20px;"></a>
</div>


<div id="group-button">
    <li><a href="/product/edit/{{$product->product_id}}"><img src="{{asset('img/edit.png')}}" alt="edit">Edit</a></li>
    <li><a href="#" data-id="{{ $product->product_id }}" data-bs-toggle="modal" data-bs-target="#deleteProductModal-{{ $product->product_id }}"><img src="{{asset('img/delete.png')}}" alt="delete">Delete</a></li>
</div>

<div class="container-lg" id="show-container">
    <div class="row justify-content-center mt-3">
        <div class="col-lg-3 col-md-12">
            <div id="product_profile">
                <a href="{{ $product->product_image ? asset('storage/img/product/' . $product->product_image) : 'https://i.vimeocdn.com/portrait/17883671_640x640' }}">
                    <img src="{{ $product->product_image ? asset('storage/img/product/' . $product->product_image) : 'https://i.vimeocdn.com/portrait/17883671_640x640' }}" alt="Product Image">
                </a>
                <h6 style="margin-left: 26%; margin-top: 5%">Product Image</h6>
                <p style="margin-left: 26%;">ID: {{ $product->product_id }}</p>
                <br>
            </div>
        </div>
        <div class="col-lg-9 col-md-12">
            <div id="product-information">
                <form action="#" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="form-control" id="product_name" name="product_name" style="border: none; outline:none">Product Name: {{ $product->product_name }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="price" name="price" style="border: none; outline:none">Price: {{ $product->price }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="quantity" name="quantity" style="border: none; outline:none">Quantity: {{ $product->quantity }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="category" name="category" style="border: none; outline:none">Category: {{ $product->category->category_name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="brand" name="brand" style="border: none; outline:none">Brand: {{ $product->brand }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="cost_price" name="cost_price" style="border: none; outline:none">Cost Price: {{ $product->cost_price }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="sku" name="sku" style="border: none; outline:none">SKU: {{ $product->sku }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="form-control" id="discount" name="discount" style="border: none; outline:none">Discount: {{ $product->discount }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="status" name="status" style="border: none; outline:none">Status: {{ $product->status ? 'Active' : 'Inactive' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="supplier_name" name="supplier_name" style="border: none; outline:none">Supplier Name: {{ $product->supplier ? $product->supplier->supplier_name : 'No Supplier' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="contact_person" name="contact_person" style="border: none; outline:none">Contact Person: {{ $product->supplier ? $product->supplier->contact_person : 'No Contact Person' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="supplier_address" name="supplier_address" readonly style="border: none; outline:none; resize: none;">Supplier Address: {{ $product->supplier ? $product->supplier->supplier_address : 'No Supplier Address' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="supplier_phone" name="supplier_phone" style="border: none; outline:none">Supplier Phone: {{ $product->supplier ? $product->supplier->supplier_phone : 'No Supplier Phone' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" id="supplier_email" name="supplier_email" style="border: none; outline:none">Supplier Email: {{ $product->supplier ? $product->supplier->supplier_email : 'No Supplier Email' }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <p class="form-control" id="description" name="description" style="border: none; outline:none">Description: <br> {{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('product.delete', ['product_id' => $product->product_id])

@endsection
