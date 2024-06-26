@extends('layout.main')

@section('content')

<title>View User | Demo App</title>

<div div="col-12">
    <a href="/user/list" ><img src="{{ asset('img/goback.png')}}" alt="go back" style="position:absolute; height: 20px; width: 20px"></a>
</div>

<div id="group-button">
    <li><a href="/user/edit/{{$user->user_id}}"><img src="{{asset('img/edit.png')}}" alt="edit">Edit</a></li>
    <li><a href="#" data-id="{{ $user->user_id }}" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->user_id }}"><img src="{{asset('img/delete.png')}}" alt="delete">Delete</a></li>
</div>

<div class="container" id="show-container">
    <div class="row justify-content-center mt-3">
        <div class="col-lg-3 col-md-12">
            <div id="users_profile">
                <a href="{{ $user->user_image ? asset('storage/img/user/' . $user->user_image) : asset('img/defaultimg.avif')}}">
                    <img src="{{ $user->user_image ? asset('storage/img/user/' . $user->user_image) : asset('img/defaultimg.avif')}}" alt="User Profile">
                </a>
                <h6 style="margin-left: 26%; margin-top: 5%">User's Profile</h6>
                <p style="margin-left: 26%;">ID: {{ $user->user_id }}</p>
                <br>
            </div>
        </div>
        <div class="col-lg-9 col-md-12">
            <div id="user-information">
                <form action="#" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">First Name: {{ $user->first_name }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Middle Name: {{ $user->middle_name }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Last Name: {{ $user->last_name }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Suffix Name: {{ $user->suffix_name }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Birth Date: {{ $user->birth_date }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Gender: {{ $user->gender->gender }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none; resize:none;">Address: {{ $user->address }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Contact Number: {{ $user->contact_number }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Email Address: {{ $user->email_address }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="form-control" style="border: none; outline:none">Username: {{ $user->username }}</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.delete', ['user_id' => $user->user_id])

@endsection
