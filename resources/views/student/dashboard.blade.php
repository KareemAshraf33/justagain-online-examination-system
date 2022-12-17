@extends('layout/student-layout')

@section('space-work')

<h2 class="mb-4">Exams</h2>
<table class="table">
  <thead>
    <tr>
      <th>Exam ID</th>    
      <th>Exam Name</th>
      <th>Date</th>
      <th>Time</th>
      <th>Enroll</th>    
    </tr> 
  </thead>

  <tbody>
      @if(count($exams) > 0 )  
          @foreach($exams as $exam)
          <tr>
           <td>{{$exam->id}}</td>
           <td>{{$exam->exam_name}}</td>
           <td>{{$exam->date}}</td>
           <td>{{$exam->time}} Hrs</td>
           <td>
                <a href="{{url('/exam',$exam->id)}}"><button class=" btn btn-info">Enroll</button></a>
           </td>   
          </tr>
          @endforeach
      @endif
  </tbody>
</table>
@endsection