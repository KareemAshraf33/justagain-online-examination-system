@extends('layout/login-register-layout')

@section('title')
Forget Password
@endsection

@section('space-work')
<h1>Forget Password</h1>

@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red;">{{$error}}</p>
    @endforeach
@endif

@if(Session::has('error'))
    <p style="color:red;">{{ Session::get('error') }}</p>
@endif

@if(Session::has('success'))
<p style="color:green;">{{Session::get('success')}}</p>
@endif

<form action="{{url('/forget-password')}}" method="post">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>

  <button type="submit" class="btn btn-primary">Forget Password</button>
</form>
<a href="{{url('/login')}}">Login</a>

@endsection