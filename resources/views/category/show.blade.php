@extends('layout.main')

@section('content')

<title>View Category | Your App Name</title>

<div div="col-12">
    <a href="/category/list"><img src="{{ asset('img/goback.png')}}" alt="Go Back" style="position:absolute; height: 20px; width: 20px;"></a>
</div>


<div id="group-button">
    <li><a href="#" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><img src="{{asset('img/edit.png')}}" alt="edit">Edit</a></li>
    <li><a href="#" data-id="{{ $category->category_id }}" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->category_id }}"><img src="{{asset('img/delete.png')}}" alt="delete">Delete</a></li>
</div>

<div class="container" id="show-container">
    <div class="row mt-3">
        <div class="col-lg-9 col-md-12">
            <div id="category-information">
                <form action="#" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="category_id" name="category_id" value="Category ID: {{ $category->category_id }}" readonly style="border: none; outline:none"> 
                            </div>
                            <div class="mb-3">
                                <textarea type="text" class="form-control" id="category_name" name="category_name" readonly style="border: none; outline:none; resize:none; ">Category Name: {{ $category->category_name }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('category.delete', ['category_id' => $category->category_id])
@include('category.edit')

@endsection
