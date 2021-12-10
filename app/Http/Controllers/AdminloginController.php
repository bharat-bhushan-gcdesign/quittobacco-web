<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Mail;
use Validator;
use Session;
use Redirect;
use clause;



class AdminloginController extends Controller
{

    /** 
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        $user=Auth::User();
        $user->fcm_token=$request->token;
        $user->save();
        return response()->json(['Settings Changed Successfully.']);
    }

    public function checkPassword(Request $request){

        $user=User::where('id',1)->first();
        return !\Hash::check($request->old_password,$user->password) ? 'false' : 'true';
    }

	public function checklogin(Request $request)
    {

        
        if ($request['g-recaptcha-response']==null) 
            return 4;

        $remember = $request->has('remember') ? true : false;
        $value = 0;
        if(Auth::attempt([  /*validate the user */  
            'email' => trim($request->username),
            'password' => $request->password,
            'role' => 1,
            'status' => 1
        ],$remember))

        if (Auth::user() != null)
        {
            if(Auth::user()->status==1){
                
                $value=1;
            }
            elseif(Auth::user()->status==0)
             {
              Auth::logout();
              $value=2;
             }
            else
             {
               Auth::logout();
               $value=3;
             }
        }
        return $value;
    }

    //-------------Forgot Password by JK on Jan 09 starts-------//

    /*
    * 
    * name: ForgotPassword
    * desc: 
    * @param: email
    * method: get
    * @return: Forgot password view page
    * Created by JK on 15.02.2019
    * 
    */ 
    public function ForgotPassword(Request $request)
    {
        if($request->has('email'))
        {
            $email = $request->post('email');
            $user = User::where('email','=',$email)->where('status','!=',2)->where('role',1)->first();
            if(is_object($user))
            {
                $user->forgetpassword_at = Carbon::now()->toDateTimeString();
                $user->save();

                $link = date("mYd").$user->id.date("His");
                $data = array('name'=>$user->Name,'link'=>encrypt(encrypt($link)));

                Mail::send('forgotpwdmail', $data, function($message) use ($user) {
                $message->to($user->email, $user->Name)->subject('AVI: Reset Password Confirmation');
                $message->from('avi@dci.in','AVI');
                });
                $type = 1;
                $message = '<h3 class="md_helo">Hello '.$user->Name.' Thanks!</h3><img src="'.url('/').'/img/rsuccess.png"><h3>Mail Sent Successfully</h3><p>Please check your registered email to reset your password</p>';
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This Email has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
            }

            return view('success',['type'=>$type,'message'=>$message]);
        }
        else
        return view('forgotpassword',['verified'=>0]);       
    }

    /*
    * 
    * name: forgotuserexist
    * desc: to check user is exist or not along with the activation status.
    * @param: email
    * method: POST
    * @return: success or failure message based on conditions
    * Created by JK on 15.02.2019
    * 
    */
	public function forgotuserexist(Request $request)
    {
		$email = $request->post('email');
        $checkexist=User::where("email",'=',trim($email))->where('status','!=',2)->first();
        
        if(is_object($checkexist))
        {
            if($checkexist->status ==3)
            {
                echo "inactive";
                 exit;
            }
            else
            {
                echo "failed";
                exit;
            }
        }
        else
        {
            echo "success";
            exit;
        }
    }

    //-------------Forgot Password by JK on Jan 09 ends-------//

    //-------------Reset Password by JK on Jan 09 ends-------//
    /*
    * 
    * name: passwordconfrim
    * desc: to reset the password.
    * @param: id
    * method: get
    * @return: the password reset page
    * Created by JK on 15.02.2019
    *
    */
    public function passwordconfrim(Request $request)
    {
        $id = $request->get('q');
        $code = decrypt(decrypt($id));
        $result = substr($code, 8, -6);
        $confirmstring = 0;
        if(is_numeric($result))
        {
            $usercheck = User::where('id',$result)->first();
            if(is_object($usercheck))
            {
                if($usercheck->forgetpassword_at != null)
                {
                    $to_time = strtotime(date("Y-m-d H:i:s"));
                    $from_time = strtotime($usercheck->forgetpassword_at);
                    $checkcondition = (($to_time - $from_time)/3600). " hours";
                    if($checkcondition <= 2)
                    $confirmstring = 1;
                    else
                    $confirmstring = 2;
                }
            }
        }

        if($confirmstring==0)
        {
            $type = 2;
            $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This Email has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
        }
        if($confirmstring==2)
        {
            $type = 2;
            $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This Link has been Expired</h3><p>please reset your link again.</p>';
        }

        if($confirmstring==1)                                            
        return view('passwordconfrim',['confirmstring'=>$confirmstring,'id'=>$result]);
        else
        return view('success',['type'=>$type,'message'=>$message]);
    }
    /*
    * 
    * name: updatepassword
    * desc: to save the new password.
    * @param: user_id, newpassword
    * method: POST
    * @return: sucess or failure page
    * Created by JK on 15.02.2019
    *
    */
    public function updatepassword(Request $request)
    {
        $id = $request->post('user_id');
        $pwd = $request->post('newpassword');

        if(is_numeric($id))
        {
            $usercheck = User::where('id',$id)->first();
            if(is_object($usercheck))
            {
                $usercheck->password = bcrypt($pwd);
                $usercheck->save();
                $type = 1;
                $message = '<h3 class="md_helo">Hello '.$usercheck->Name.' Thanks!</h3><img src="'.url('/').'/img/rsuccess.png"><h3>Your Password Reset Successfully</h3><p>Please <a href="login">login</a> to proceed further</p>';
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This User has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
            }
        } 
        else
        {
            $type = 2;
            $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This User has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
        }

        return view('success',['type'=>$type,'message'=>$message]);
    }

    //-------------Reset Password by JK on Feb 15 ends-------//

    //------------To generate random string by JK on Feb 11 starts----//

    public function generateRandomString($length=15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

	//------------To generate random string by JK on Feb 11 ends----//   

    public function checktemplate()
    {
        //return view('registrationmail',['email'=>"test@gmail.com",'password'=>"test"]);
        return view('forgotpwdmail',['name'=>"test@gmail.com",'link'=>"test"]);
    }

    /*14-05 */
    public function passwordgeneration()
    {
        
       // dd($result);
     $email='indhumathi.velmurugan@dci.in';
     // $emailtwo='indui2909@gmail.com';
     if($email){
         $alphabet  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pass  = strlen($alphabet );
        $alphaLength  = '';
        for ($i = 0; $i < 6; $i++) {
            $alphaLength  .= $alphabet [rand(0, $pass  - 1)];
        }
        $result= $alphaLength ;
         $checkexist=User::where('email','=',$email)->where('status','!=',2)->where('role',2)->first();
        //dd($checkexist);
              $opt['email']='indhumathi.velmurugan@dci.in';
                             $opt['Name']='indhu';
                             $data = [
     							 'v' =>$result,
   									 ];
                             // $pass=array();
                             // $pass[]=$result;
                      // print_r($pass); exit;
                               Mail::send('mails.mail',["data1"=>$data],function($message)use($opt) {
                                $message->to($opt['email'],$opt['Name'])
                                ->subject('newpassword');
      
                                });
                               $newdata=User::where('email','=',trim($email))->where('status','!=',2)->where('role',2)->first();
          $newdata->password=bcrypt($result);
           $newdata->save();

                
            }
            else
            {
               echo "false";
            }

             // return view('mails.mail', compact('result'));
     }

       // else{
       
       // }
          // $newdata=User::where('email','=',trim($email))->where('status','!=',2)->where('role',2)->first();
          // $newdata->password=$result;
          //  $newdata->save();

     //  $emailtwo='indui2909@gmail.com';
     // if(is_object($emailtwo)){
     //     $checkexist=User::where('email','=',trim($emailtwo))->where('status','!=',2)->where('role',2)->first();
     //    // dd($checkexist);
     //      $data['email']='indhumathi.velmurugan@dci.in';
     //                     $data['Name']='indhu';
     //                        Mail::send('mails.mail', $data,function($message)use($data) {
     //                        $message->to($data['email'], $data['Name'],$result)
     //                        ->subject('newpassword');
     //                        });
     // }



}