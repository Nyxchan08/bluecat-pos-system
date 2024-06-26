@extends('layout.main')

@section('content')

<div id="create-button">
    <a href="/product/create"><img src="{{ asset('img/user-add.png')}}" alt="Add Product">add product</a>
</div>
<div class="content-list">
    <div class="table-responsive">
        <table class="table table-sm ">
            <thead id="table-heading">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Status</th>
                </tr>
            </thead>
            @include('include.message')
            <tbody class="table-group-divider">
                @foreach ($products as $product)
                
                <tr onclick="window.location='/product/show/{{$product->product_id}}';" style="cursor:pointer;">
                    <td><img src="{{ $product->product_image ? asset('storage/img/product/' . $product->product_image) : 'https://i.vimeocdn.com/portrait/17883671_640x640'}}" alt="Product Image" style="height: 130px; width: 130px;"> </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $product->supplier->supplier_name ?? 'N/A' }}</td>                    
                    <td>
                        @if($product->status)
                            <img src="{{ asset('img/active.png/') }}" alt="Active"> Active
                        @else
                            <img src="{{ asset('img/inactive.png') }}" alt="Inactive"> Inactive
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection
