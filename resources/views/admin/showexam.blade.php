@extends('layout/admin-layout')

@section('title')
{{$exam->name}} | Exam
@endsection

@section('space-work')
<a href="{{url('exams/edit',$exam->id)}}">Edit</a>
<a href="{{url('exams/delete',$exam->id)}}">Delete</a>
<h1>{{$exam->name}}</h1>
@endsection
