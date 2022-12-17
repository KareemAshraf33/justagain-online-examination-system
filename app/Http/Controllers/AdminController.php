<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

class AdminController extends Controller
{
     public function list()
    {    //select all exams
        $exams=Exam::get();
        
        return view('admin.exams', [
            'exams'=>$exams
        ]);
    }
    
    public function show($id)
    {
        $exam=Exam::where('id','=',$id)->first();
        return view('admin.showexam',[
            'exam'=>$exam
        ]);
    }
    
     public function create()
    {
        return view('admin.create');
    }
    
     public function store(Request $request)
    {
         $unique_id = uniqid('exid');
         $validator = \Validator::make($request->all(), [ 'exam_name' => 'required|unique:exams|max:100|min:3']); 
         if($validator->fails())
         { 
             return redirect('exams/create') ->withErrors($validator) ->withInput();
         }
         
         $_name=$request->exam_name;
         $_date=$request->date;
         $_time=$request->time;
         //insert into db
         $exam=new Exam();
         $exam->exam_name=$_name;
         $exam->date=$_date;
         $exam->time=$_time;
         $exam->enterance_id=$unique_id;
         $exam->save();
         
        return redirect('exams/list');
    }
    
    //Question
    public function qnaDashboard()
    {
        $questions = Question::with('answers')->get();
        
        return view( 'admin.qnaDashboard',compact('questions') );
    }
    
    //add qnd
    public function addQna(Request $request){
        try{
            
            $questionId = Question::insertGetId([
                'question' =>$request->question
            ]);
            
            foreach($request->answers as $answer){
                
                    $is_correct = 0;
                
                   if($request->is_correct == $answer)
                     {
                        $is_correct = 1; 
                     }
                
               Answer::insert([
                 'questions_id' =>$questionId,
                 'answer' =>$answer,
                 'is_correct' =>$is_correct
              ]);
                
           }

          return response()->json(['success'=>true,'msg'=>'Question Added Successfuly']);
            
    }
        catch(\Exeption $e){
            
           return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }    
    public function studentsDashboard(){
          $students = User::where('is_admin',0)->get();
          return view('admin.studentsDashboard',compact('students'));
    }
    
    //get questions
    public function getQuestions(Request $request)
    {
          try{
              
              $questions = Question::get();
              if(count($questions) > 0){
                  
                  $data = [];
                  $counter = 0;
                  
                  foreach($questions as $question)
                  {
                    $qnaExam = QnaExam::where(['exam_id'=>$request->exam_id,'question_id'=>$question->id])->get();
                     if(count($qnaExam) ==0)
                     {
                         $data[$counter]['id'] = $question->id;
                         $data[$counter]['questions'] = $question->question;
                         $counter++;
                     } 
                  }
                  return response()->json(['success'=>true,'msg'=>'Question data','data'=>$data]);

               }
              else{
                  
               return response()->json(['success'=>false,'msg'=>'Question not Found']);
  
              }

          }catch(\Exeption $e){
            
           return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
    
    public function addQuestions(Request $request)
    {
        try{
            
            if(isset($request->questions_ids)){
                foreach($request->questions_ids as $qid){
                   QnaExam::insert([
                       'exam_id' =>$request->exam_id,
                       'question_id' =>$qid
                       
                   ]);  
                }
            }
           return response()->json(['success'=>true,'msg'=>'Questions added successfully!']);
             
        }catch(\Exeption $e){
            
           return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
    
}
