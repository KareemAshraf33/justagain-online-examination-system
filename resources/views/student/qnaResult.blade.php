@extends('layout/layout-common')

@section('space-work')

<h2> Results</h2>
<table class="table">

    <thead>
       <tr>
          <th>Exam</th>
          <th>Results</th>
          <th>Scores</th>
       </tr>
    </thead>
    <tbody>
            <tr>
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
            </tr>   
    </tbody>

</table>
@endsection