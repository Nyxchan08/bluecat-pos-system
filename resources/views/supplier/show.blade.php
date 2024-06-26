@extends('layout.main')

@section('content')

<title>View Supplier | Your App Name</title>

<div div="col-12">
    <a href="/supplier/list"><img src="{{ asset('img/goback.png')}}" alt="Go Back" style="position:absolute; height: 20px; width: 20px;"></a>
</div>


<div id="group-button">
    <li><a  href="/supplier/edit/{{$supplier->supplier_id}}"><img src="{{asset('img/edit.png')}}" alt="edit">Edit</a></li>
    <li><a href="#" data-id="{{ $supplier->supplier_id }}" data-bs-toggle="modal" data-bs-target="#deleteSupplierModal-{{ $supplier->supplier_id }}"><img src="{{asset('img/delete.png')}}" alt="delete">Delete</a></li>
</div>

<div class="container" id="show-container">
    <div class="col-lg-9 col-md-12">
        <div id="supplier-information">
            <form action="#" method="post">
                @csrf
                <div class="row  mt-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <p class="form-control" style="border: none; outline:none">Supplier Name: {{ $supplier->supplier_name }}</p> 
                        </div>
                        <div class="mb-3">
                            <p class="form-control" style="border: none; outline:none">Contact Person: {{ $supplier->contact_person }}</p> 
                        </div>
                        <div class="mb-3">
                            <p class="form-control" style="border: none; outline:none; resize:none;">Supplier Address: {{ $supplier->supplier_address }}</p> 
                        </div>
                        <div class="mb-3">
                            <p class="form-control" style="border: none; outline:none">Supplier Phone: {{ $supplier->supplier_phone }}</p> 
                        </div>
                        <div class="mb-3">
                            <p class="form-control" style="border: none; outline:none">Supplier Email: {{ $supplier->supplier_email }}</p> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  

@include('supplier.delete', ['supplier_id' => $supplier->supplier_id])

@endsection
