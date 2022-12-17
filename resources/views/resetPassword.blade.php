@extends('layout/login-register-layout')

@section('title')
Reset Password
@endsection

@section('space-work')
<h1>Reset Password</h1>

@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red;">{{$error}}</p>
    @endforeach
@endif



<form action="{{url('/reset-password')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $user[0]['id'] }}">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
      <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <button type="submit" class="btn btn-primary">Reset Password</button>
</form>
<a href="{{url('/login')}}">Login</a>

@endsection