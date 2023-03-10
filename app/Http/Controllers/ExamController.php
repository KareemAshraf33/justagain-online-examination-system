<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    
   public function loadExamDashboard($id)
   { 
       
       $qnaExam = Exam::get();
       
       if(count($qnaExam) > 0)
        { 
           if($qnaExam[0]['date'] == date('Y-m-d'))
           { 
                   if (count($qnaExam[0]['getQnaExam']) > 0)
                   { 
                       $qna = QnaExam::where('exam_id',$qnaExam[0]['id'])->with('question','answers')->inRandomOrder()->get();
                   return view('student.exam-dashboard', ['success' => true,'exam'=>$qnaExam,'qna'=>$qna]);
                   } 

                    else{
                        return view('student.exam-dashboard', ['success' =>false, 'msg' => 'This exam is not available ','exam'=>$qnaExam]);
                    }
               
           }

           else if($qnaExam[0]['date'] > date('Y-m-d'))
            {          
               return view('student.exam-dashboard', ['success' =>false, 'msg' => 'This exam will be start on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
            else{
                  
             return view('student.exam-dashboard', ['success' =>false, 'msg' => 'This exam has been expired on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
           }
          
        } else{
           return view('student.exam-dashboard');
       }
   }
    
    public function examSubmit(Request $request)
    {
        
       $attempt_id = ExamAttempt::insertGetId([
             'exam_id' => $request->exam_id,
             'user_id' => Auth::user()->id
            ]);
            $qcount = count($request->q);
            if($qcount > 0){
                for($i=0; $i < $qcount; $i++)
                {
                      ExamAnswer::insert([
                     'attempt_id' => $attempt_id,
                     'question_id' => $request->q[$i],
                     'answer_id' => request()->input('ans_'.($i+1))

                    ]); 
                }    

             } 
        
        $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
        return view('student.result',compact('attempts'));
//         return view('student.result');    
        
    }
    
    public function resultDashboard()
    {
        $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
        return view('student.result',compact('attempts'));
    }

}

