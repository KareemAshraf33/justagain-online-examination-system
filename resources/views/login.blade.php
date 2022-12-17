@extends('layout/login-register-layout')

@section('title')
Login
@endsection

@section('space-work')
<h1>Login</h1>

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif

@if(Session::has('error'))
<p style="color:red;">{{Session::get('error')}}</p>
@endif

<form action="{{url('login/userLogin')}}" method="post">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
<a href="{{url('/password/forgot')}}">Forget Password</a>


@endsection