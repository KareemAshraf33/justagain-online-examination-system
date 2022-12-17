@extends('layout/admin-layout')


@section('space-work')
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif
<form action="{{url('exams/store')}}" method="post" enctype="multipart/form-data">
    @csrf
  <div class="mb-3 col-4">
    <label for="exampleInputEmail1" class="form-label">Exam Name</label>
    <input type="text" name="exam_name" class="form-control" id="exampleInputEmail1" style="border:gray; border-width:1px; border-style:solid;" aria-describedby="emailHelp">
  </div>
  <div class="mb-3 col-4">
    <label for="exampleInputPassword1" class="form-label">Date</label>
    <input type="date" name="date" class="form-control" style="border:gray; border-width:1px; border-style:solid;" required min="@php echo date('Y-m-d'); @endphp" id="exampleInputPassword1">
  </div>
    <div class="mb-3 col-4">
    <label for="exampleInputPassword1" class="form-label">Time</label>
    <input type="time" name="time" class="form-control" style="border:gray; border-width:1px; border-style:solid;" required min="@php echo date('Y-m-d'); @endphp" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Add Exam</button>
</form>

@endsection

