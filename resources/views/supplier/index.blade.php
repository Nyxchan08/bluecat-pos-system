@extends('layout.main')

@section('content')

<div id="create-button">
    <a href="/supplier/create" data-bs-toggle="modal" data-bs-target="#supplierModal"><img src="{{ asset('img/user-add.png')}}" alt="Add Supplier">add supplier</a>
</div>
<div class="content-list">
    <div class="table-responsive">
        <table class="table table-sm table-hover ">
            <thead id="table-heading">
                <tr>
                    <th>Supplier Name</th>
                    <th>Contact Person</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            @include('include.message')
            <tbody class="table-group-divider">
                @foreach ($suppliers as $supplier)
                
                <tr onclick="window.location='/supplier/show/{{$supplier->supplier_id}}';" style="cursor:pointer;">
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->supplier_phone }}</td>
                    <td>{{ $supplier->supplier_email }}</td>
                    <td>{{ $supplier->supplier_address }}</td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>

@include('supplier.create')

@endsection
