@extends('layout.main')

@section('content')

<div id="create-button">
    <a href="/category/create" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <img src="{{ asset('img/user-add.png')}}" alt="Add Category"> Add Category
    </a>
</div>
<div class="content-list">
    <div class="table-responsive">
        <table class="table table-sm ">
            <thead id="table-heading">
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                </tr>
            </thead>
            @include('include.message')
            <tbody class="table-group-divider">
                @foreach ($categories as $category)
                
                <tr onclick="window.location='/category/show/{{$category->category_id}}';" style="cursor:pointer;">
                    <td>{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $categories->links() }}
        </div>
    </div>
</div>

@include('category.create')

@endsection
