@extends('base')

@section('content')
<div class="container mt-5">
    @if(auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 rounded-lg shadow" style="background-color: #f6e6e6;">
                <div class="card-header bg-pink text-white rounded-top">
                    <h1 class="text-center">Dashboard</h1>
                </div>
                <div class="card-body">
                    <p class="text-center" style="font-size: 18px; color: #f188b4;">Hello, {{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-pink">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

