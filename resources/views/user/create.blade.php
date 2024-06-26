@extends('layout.main')
@section('content')


<div class="container">
    <form action="/user/store" method="post" class="row g-3" style="margin: 8%" enctype="multipart/form-data">
        @csrf
        <div class="col-md-4">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
            @error('first_name') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-2">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" required>
            @error('middle_name') <p class="text-danger">{{$message}}</p>@enderror
            
        </div>
        <div class="col-md-4">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
            @error('last_name') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-2">
            <label for="suffix_name" class="form-label">Suffix Name</label>
            <input type="text" class="form-control" id="suffix_name" name="suffix_name">
        </div>
        <div class="col-md-6 col-lg-2">
            <label for="birth_date" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
            @error('birth_date') <p class="text-danger">{{$message}}</p>@enderror
        </div>
    <div class="col-md-6 col-lg-2">
            <label for="gender_id" class="form-label">Gender</label>
            <select class="form-select" id="gender_id" name="gender_id">
                @foreach($genders as $gender)
                    <option value="{{ $gender->gender_id }}">{{ $gender->gender }}</option>
                @endforeach
            </select>
        </div>  
    
        <div class="col-md-5">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
            @error('address') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-3">
            <label for="user_image" class="form-label">User Image</label>
            <input type="file" class="form-control" id="user_image" name="user_image">
            @error('user_image') <p class="text-danger">{{$message}}</p>@enderror
        </div>            
        <div class="col-md-6">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
            @error('contact_number') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="email_address" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email_address" name="email_address" required>
            @error('email_address') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
            @error('username') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-md-4">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            @error('role') <p class="text-danger">{{$message}}</p>@enderror
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-outline-success">Submit</button>
            <a href="/user/list" class="btn btn-outline-danger">Cancel</a>
        </div>
    </form>
</div>
 

@endsection
