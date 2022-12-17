<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Hash;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\facades\Session;

use App\Models\PasswordReset;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\facades\URL;
//use Illuminate\Support\Carbon;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function loadRegister()
    {
         if(Auth::user() && Auth::user()->is_admin ==1){
            return redirect('/admin/dashboard');
        }elseif(Auth::user() && Auth::user()->is_admin ==0){
            return redirect('/dashboard');
        }
        return view('register');
    }
    
    public function studentRegister(Request $request)
    {
        $request->validate([
            'name'=>'string|required|min:2',
            'email'=>'string|email|required|max:100|unique:users',
            'password'=>'string|required|min:6|'
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->save();
        return back()->with('success','Your Registeration has been successfull.');
    }
    
    public function loadLogin()
    {
        if(Auth::user() && Auth::user()->is_admin ==1){
            return redirect('/admin/dashboard');
        }elseif(Auth::user() && Auth::user()->is_admin ==0){
            return redirect('/dashboard');
        }
        return view('login');
    }
    
    public function userLogin(Request $request)
    {
        
        $request->validate([
            'email'=>'string|required|email',
            'password'=>'string|required'
        ]);
        
        $userCredential = $request->only('email','password');
        
        if( Auth::attempt($userCredential) ){
            
            if(Auth::user()->is_admin == 1){
                return redirect('/admin/dashboard');
            }else{
                return redirect('/dashboard'); 
            }   
        }
        else{
          return back()->with('error','Email or Password is incorrect.');  
        }
        
        
    }
    
      public function loadDashboard()
    {
        $exams = Exam::get();  
        return view('student.dashboard',['exams'=>$exams]);
    }
    
     public function adminDashboard()
    {
        return view('admin.dashboard');
    }
    
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/login');
    }
    
    
    public function showForgotForm(){
        return view('forgot');
    }

    public function sendResetLink(Request $request){
         $request->validate([
             'email'=>'required|email|exists:users,email'
         ]);

             $token = \Str::random(64);
              PasswordReset::insert([
               'email'=>$request->email,
               'token'=>$token,
               'created_at'=>Carbon::now(),
         ]);
         
         $action_link = route('reset.password.form',['token'=>$token,'email'=>$request->email]);
         $body = "We are received a request to reset the password for <b>Your app Name </b> account associated with ".$request->email.". You can reset your password by clicking the link below";

        \Mail::send('email-forgot',['action_link'=>$action_link,'body'=>$body], function($message) use ($request){
              $message->from('noreply@example.com','Your App Name');
              $message->to($request->email,'Your name')
                      ->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetForm(Request $request, $token = null){
        return view('reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:5|confirmed',
            'password_confirmation'=>'required',
        ]);

        $check_token = PasswordReset::where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$check_token){
            return back()->withInput()->with('fail', 'Invalid token');
        }else{

            User::where('email', $request->email)->update([
                'password'=>\Hash::make($request->password)
            ]);

            PasswordReset::where([
                'email'=>$request->email
            ])->delete();

            return redirect()->url('/login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
        }
    }
    
    
    
    
    
    
    
    
    
//    public function forgetPasswordLoad()
//    {
//        return view('forget-password');
//    }
//    
//    public function forgetPassword(Request $request)
//    { 
//        
//        try{
//            
//          $user = User::where('email',$request->email)->get();
//          
//            if(count($user)>0)
//            {
//               
//                
//                $token = \Str::random(40);
//                PasswordReset::insert([
//                'email'=>$request->email,
//                 'token'=>$token,
//                 'created_at'=>Carbon::now(),
//                
//                ]);
////               
//                $action_link = route('resetPassword',[$token,'email'=>$request->email]);
//                $body="we are recived a request to reset your password".$request->email."You can reset your password by clicking the link below.";
//                
//                \Mail::send('forgetPasswordMail',['action_link'=>$action_link,'body'=>$body],function($message) use($request){
//                   $message->from('noreply@example.com','JustAgain');
//                   $message->to($request->email,'JustAgain')->subject('Reset Password');
//               });
//                return back()->with('success','Please check your mail to reset your password');
////                $domain = URL::to('');
////                $url = $domain.'/reset-password?token='.$token;
////                $data['url']=$url;
////                $data['email']=$request->email;
////                $data['title']='Password Reset';
////                $data['body']='Please click on below link to reset your password';
////                
////               Mail::send('forgetPasswordMail',['data'=>$data],function($message) use($data){
////                   $message->to($data['email'])->subject($data['title']);
////               }); 
////                
////                $dateTime = Carbon::now()->format('Y-m-d H:i:s');  
////                PasswordReset::updateOrCreate(
////                    ['email'=>$request->email],
////                    [
////                      'email'=>$request->email,
////                      'token'=>$token,
////                      'created_at'=>$dateTime
////                    ]      
////                 );  
////                
////              return back()->with('success','Please check your mail to reset your password');
//               
//            }
//            else
//            {
//                return back()->with('error','Email is not exsists!');
//            }
//            
//         }
//        catch(\Exception $e)
//        {
//            return back()->with('error',$e->getMessage());
//        }
//    }
//    
//    public function resetPasswordLoad(Request $request)
//    {
//        
//      $resetData = PasswordReset::where('token',$request->token)->get();
//      if(isset($request->token) && count($resetData) > 0)
//      {
//         
//          $user = User::where('email',$resetData[0]['email'])->get();
//          
//          return view('resetPassword',compact('user'));
// 
//      }
//     else
//        {
//         return view('404');
//        }
//   
//    }
    
}






