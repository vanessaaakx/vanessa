@extends('base')

@section('content')
<div class="container col-md-6 offset-md-3 mt-5">
    <div class="card p-4 rounded-lg shadow" style="background-color: #f8e7e7;">
        <h1 class="text-center mb-4" style="color: #ff66b2;">Welcome</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label" style="color: #ff66b2;">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" style="border-color: #ff66b2;">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="color: #ff66b2;">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" style="border-color: #ff66b2;">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label" style="color: #ff66b2;">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" style="border-color: #ff66b2;">
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label" style="color: #ff66b2;">Confirm Password</label>
                <input type="password" name="password_confirmation" id="confirm_password" class="form-control" style="border-color: #ff66b2;">
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('login') }}" style="color: #ff66b2;">Log in to your account</a>
                </div>
                <button type="submit" class="btn btn-pink" style="background-color: #ff66b2;">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection
