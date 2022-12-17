@extends('layout/student-layout')

@section('space-work')

<h2> Results</h2>
<table class="table">

    <thead>
       <tr>
          <th>#</th>
          <th>Exam</th>
          <th>Results</th>
          <th>Scores</th>
          <th>Exam Pass-Marks</th>  
       </tr>
    </thead>
    <tbody>
      @if(count($attempts) > 0)
        @php $x=1; @endphp
        @foreach($attempts as $attempt)
            <tr>
              <td>{{ $x++ }}</td>
              <td>{{ $attempt->exam->exam_name }}</td>
              <td>
                    @if($attempt->marks >= $attempt->exam->pass_marks)
                     <span style="color:green;">Passed</span>
                    @else
                      <span style="color:red;">Failed</span>
                    @endif

              </td>
              <td>
                {{$attempt->marks}}
              </td>
               <td>
                {{$attempt->exam->pass_marks}}
              </td>  
            </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4">You not attempt any exam ! </td>
        </tr>
      @endif    
    </tbody>

</table>
@endsection