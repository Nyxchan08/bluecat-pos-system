@extends('layout.main')

@section('content')

<title>Supplier Edit</title>

<div class="container">
    <form action="/supplier/update/{{ $supplier->supplier_id }}" method="post" class="row g-3">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label for="supplier_name" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="{{ $supplier->supplier_name }}" required>
            @error('supplier_name') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="contact_person" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ $supplier->contact_person }}" required>
            @error('contact_person') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_address" class="form-label">Supplier Address</label>
            <input type="text" class="form-control" id="supplier_address" name="supplier_address" value="{{ $supplier->supplier_address }}" required>
            @error('supplier_address') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_phone" class="form-label">Supplier Phone</label>
            <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" value="{{ $supplier->supplier_phone }}" required>
            @error('supplier_phone') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="supplier_email" class="form-label">Supplier Email</label>
            <input type="email" class="form-control" id="supplier_email" name="supplier_email" value="{{ $supplier->supplier_email }}" required>
            @error('supplier_email') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-outline-success">Submit</button>
            <a href="/supplier/list" class="btn btn-outline-danger">Cancel</a>
        </div>
    </form>
</div>

@endsection
