@extends('layouts.main') {{-- or your main layout --}}

@section('title', 'Access Denied')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">403</h1>
    <h2 class="mb-3">Access Denied</h2>
    <p>You don’t have permission to access this page.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
</div>
@endsection
