@extends('layout/admin-layout')

@section('space-work')

<h2>Students</h2>

<table class="table">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>    
    </thead>
    <tbody>
      @if(count($students) > 0)
        @foreach ($students as $student )
         <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->name}}</td>
            <td>{{$student->email}}</td>
         </tr>   
        @endforeach
      @else
        <tr>
          <td colspan="3">Student not found</td>
        </tr>     
      @endif
    
    </tbody>
</table>

@endsection

