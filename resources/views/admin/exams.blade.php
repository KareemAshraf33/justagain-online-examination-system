@extends('layout/admin-layout')

@section('space-work')
<h2>Exams</h2>
<table class="table">
  <thead>
    <tr>
      <th>Exam ID</th>    
      <th>Exam Name</th>
      <th>Date</th>
      <th>Time</th> 
      <th>Add Questions</th> 
    </tr> 
  </thead>

  <tbody>
      @foreach($exams as $exam)
      <tr>
       <td>{{$exam->id}}</td>
       <td>{{$exam->exam_name}}</td>
       <td>{{$exam->date}}</td>
       <td>{{$exam->time}} Hrs</td>
       <td>
           <a href="#" class="addQuestion" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#addQnaModal">Add Question</a>
       </td>
      </tr>
      @endforeach
  </tbody>
</table>
<!-- Add Answer Modal -->
<div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
     <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
<!--         <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>-->
           <button type="button" class="close"  data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
         </button>
    </div>
    <form id="addQna">
        @csrf
       <div class="modal-body">
          <input type="hidden" name="exam_id" id="addExamId">
        <table class="table" >
           <thead>
              <th>Select</th>
              <th>Question</th>    
                
           </thead>
           <tbody class="addBody">
               
           </tbody>    
        </table>
       </div>    
       <div class="modal-footer">  
           <span class="error" style="color:red;"></span>
           <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-primary">Add Q&A</button>
       </div>
    </form>    
   </div> 
  </div>
</div>
<script>
  $(document).ready(function(){
    //add questions
      $('.addQuestion').click(function(){
          var id = $(this).attr('data-id');
          $('#addExamId').val(id);
          
           $.ajax({
                url:"{{ url('/get-questions') }}",
                type:"GET",
                data:{exam_id:id},
                success:function(data){
                if(data.success == true)
                    {
                      var questions = data.data;
                      var html = '';
                      if(questions.length>0)
                        {
                            for(let i=0; i<questions.length;i++){
                              html +=`
                                <tr>
                                    <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"></td>
                                    <td>`+questions[i]['questions']+`</td>
                                </tr>
                              `;  
                            }
                           
                        }
                        else{
                          html+=`
                           <tr>
                             <td colspan="2">Questions not available</td> 
                          </tr> `;
                           }
                        
                        $('.addBody').html(html);
                    } 
                else
                   {
                      alert(data.msg); 
                   }
                }
           });
      })
        
      //submit
      
            $('#addQna').submit(function(e){
          e.preventDefault();
            var formData = $(this).serialize();    
          
           $.ajax({
                url:"{{ url('/add-questions') }}",
                type:"POST",
                data:formData,
                success:function(data){
                if(data.success == true)
                    {
                      location.reload();  
                      
                    }else
                   {
                      alert(data.msg); 
                   }
                }
           });
      })
  });

</script>
@endsection

