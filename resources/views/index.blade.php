@extends('layout.login')
@section('content')

<div class="container-fluid p-0 position-relative">
    <img src="img/loginBackground.png" alt="login background" id="login_background" class="img-fluid">
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card shadow-lg rounded p-4">
                    <img src="{{ asset('img/bluecat.png')}}" alt="Logo" class="d-inline-block align-text-top img-fluid">
                    <br>
                    <form action="/process/login" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter your username" name="username">
                            @error('username') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
                            @error('password') <p class="text-danger">{{$message}}</p>@enderror
                        </div>                    
                        <br>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#login_background {
    object-fit: cover;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: -1;
    top: 0;
    left: 0;
}

.card {
    z-index: 1001;
    background-color: rgba(255, 255, 255, 0);
    backdrop-filter: blur(10px);
}
</style>
@endsection
