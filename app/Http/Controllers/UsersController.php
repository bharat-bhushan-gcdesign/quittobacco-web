<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Userpermissions;
use App\Models\Cart;
use App\Models\Feedback;
use App\Models\Cocreator;
use App\Models\Event;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Mail;
use Validator;
use Session;
use Redirect;
use clause;


class UsersController extends Controller
{
    
	public function user()
	{
       $users=Users::where('status','!=',2)->where('role', '=', 2)->orderBy('id','DESC')->get();
       //dd($users);
        return view('users.list_users', compact('users'));
           
	}
   public function create()
    {
      $userid = Auth::user()->id;
        if($userid!="")
        {
            $userdetails = Users::where('id',$userid)->first(); 
            if(is_object($userdetails))
            {
            	   $pid="";     
                return view('users.add_user',compact('pid'));
            }
         else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>User Create failed</h3><p>This is not a valid data</p>';
                return view('success',['type'=>$type,'message'=>$message]);
            }
        }
        else
        return redirect('/login');
    }
    public function saveuser(Request $request)
    {
    	 $loginid = Auth::user()->id;
       
        if($loginid!="")
        {
        	$id=$request->pid;
        	if($id!="")
        	$user=Users::find($id);
            else
        	$user=new Users;
          
        //  if(isset($request->dob))
        //    $dob = date("Y-m-d", strtotime($request->dob));
       //   else
        //    $dob = null;

        	$user->Name=$request->first_name	;
        	// $user->lastName=$request->last_name;
        	$user->mobile=$request->ph_no;
        //	$user->phone=$request->alt_no;
        	//$user->gender=$request->gender;
        //	$user->dob=$dob;
        	$user->status=$request->status;
        	$user->email=$request->email;
        	//$user->personal_notes=$request->notes;
          $user->role=2;
        //  $user->user_type_id=2;
        	$user->created_by=Auth::user()->id;

                if($id =="")
                {
                   $password = $this->generateStrongPassword(8, false, 'luds');
                   $user->password=bcrypt($password);
               }
        	  if(is_object($user) && $user->profile_image!="")
                {
                    $picture_single =$user->profile_image;
                    
                }
                else 
                {
                    $picture_single = "";
                    
                } 

            if($_FILES['profile_img']['name']!='' )
              {

                $files_single = $request->file('profile_img');
                
                $filename = $files_single->getClientOriginalName();
                $extension = $files_single->getClientOriginalExtension();
                $picture_single = date('His').$filename;
                $destinationPath = base_path() . '/public/uploads/userimage';
                $files_single->move($destinationPath, $picture_single);
            }
            $user->profile_image=$picture_single;
             $user->save();
           //  if($user->firstName!="" && $user->email!="" &&  $user->password!="")
            // {
             //   if($id=="")
              //  {
                 //   $data['userid'] = $user->id;
                 //   $data['password'] = $password;
               //     $this->sentactivationlink($data);
             //   }
           //   }
              if($id=="")
                return redirect('/users')
                                 ->witherrors('Users Added successfully');
                  else
                return redirect('/users')
                                 ->witherrors('Users Updated successfully');
      }
      else
        return redirect('/login');

    }
    public function savedestroy($id)
    {
		
					//dd($id);
                	$user=Users::find($id);
						
                	$user->status=2;
                	$user->save();
                	return redirect('users')->with('message','Users Deleted successfully');
           

    }
    public function edit($id)
    {

      $userid = Auth::user()->id;
        if($userid!="")
        {
            $users=Users::find($id);
            $pid=$id;
            return view('users.add_user', compact('users','pid'));
        }
        else
        return redirect('/login');
    }
    public function view($id)
    {
    
      	$users=Users::find($id);
      	$rawvar=[];
      	$creators =Users::where('id',$id)->where('status',1)->get();
      	
      
		  if(count($creators)>0){
			
			foreach($creators as $key => $creator){
				
				   if($creator->user!="" && $creator->user!=null){
					   
			$rawvar[$key]['name']=@$creator->user->Name;
			$rawvar[$key]['id']=@$creator->user->id;
				
						//dd($rawvar);
				}
				
			
			  }
		
	}
       
         
      	 return view('users.view_user',compact('users','rawvar'));
      
    }

    /*public function generateRandomString($length=15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }*/

    public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function sentactivationlink($data)
    {
        if(isset($data['userid']) && is_numeric($data['userid']) )
        {
            $userid = $data['userid'];
            $user = Users::where('id',$userid)->first();
            $data = array('name'=>$user->Name,'password'=>$data['password'],'email'=>$user->email);

            Mail::send('registrationmail', $data, function($message) use ($user) {
            $message->to($user->email, $user->Name)->subject('AVI: Admin Registration');
            $message->from('avi@dci.in','AVI');
            });
        }
    }

    public function exportFile(Request $request){
      $type="xls";
      $userid = Auth::user()->id;
      $userdetails = Users::where('id',$userid)->first(); 

      $lounge = Users::where('status','!=',3);
      if($request->has('startdate') && $request->startdate!=null)
      {
        $startdate = date("Y-m-d",strtotime($request->startdate));
        $lounge->where('created_at','>=',$startdate);
      }
      if($request->has('enddate') && $request->enddate!=null)
      {
        $enddate = date("Y-m-d",strtotime($request->enddate. "+1 days"));
        $lounge->where('created_at','<=',$enddate);
      }
      if($request->has('status'))
      {
        $status = $request->status;
        $lounge->where('status','=',$status);
      }

      if($userdetails->user_type_id ==1)
          $products = $lounge->where('user_type_id',3)->get();
      if($userdetails->user_type_id ==2)
          $products = $lounge->where('created_by',$userid)->where('user_type_id',3)->get();     
      $i=0;

      if(count($products)>0)
      {
        foreach($products as $product)
        {
          if($product->gender ==1){
            $gend = 'Male';
          }
          elseif($product->gender ==2)  {
            $gend = 'Female';
          }
          else
          {
            $gend = 'Null';
          }
          $result[$i]['First Name'] = $product->Name;
          // $result[$i]['Last Name'] = $product->last_name;
          $result[$i]['Phone'] = $product->phone;
          $result[$i]['Email'] = $product->email;
          $result[$i]['Date Of Birth'] = $product->dob;
          $result[$i]['Gender'] = $gend;
          $result[$i]['Personal Notes'] = $product->personal_notes;
          $i++;
        }
      }
      else
      {
        $result[$i]['First Name'] = "";
        $result[$i]['Last Name'] = "";
        $result[$i]['Phone'] = "";
        $result[$i]['Email'] = "";
        $result[$i]['Date Of Birth'] = "";
        $result[$i]['Gender'] = "";
        $result[$i]['Personal Notes'] = "";
      }
      return \Excel::create('Userreport', function($excel) use ($result) {
      $excel->sheet('sheet name', function($sheet) use ($result)
      {
          $sheet->fromArray($result);
      });
      })->download($type);
    } 

  public function exportexist(Request $request){
      $userid = Auth::user()->id;
      $userdetails = Users::where('id',$userid)->first();

      $lounge = Users::where('status','!=',3);
      if($request->has('startdate') && $request->startdate!=null)
      {
        $startdate = date("Y-m-d",strtotime($request->startdate));
        $lounge->where('created_at','>=',$startdate);
      }
      if($request->has('enddate') && $request->enddate!=null)
      {
        $enddate = date("Y-m-d",strtotime($request->enddate. "+1 days"));
        $lounge->where('created_at','<=',$enddate);
      }
      if($request->has('status')) 
      {
        $status = $request->status;
        $lounge->where('status','=',$status);
      }
      if($userdetails->user_type_id ==1)
          $products = $lounge->where('user_type_id',3)->get();
      if($userdetails->user_type_id ==2)
          $products = $lounge->where('created_by',$userid)->where('user_type_id',3)->get();  

      $i=0;
      if(count($products)>0)
      return "1";
      else
      return "0";
  }

   /*
    * 
    * name: userexist
    * desc: to check whether the record is already exist or not.
    * @param: email,id
    * method: POST  
    * @return: return sucess or failure message
    * Created by JK on 11.02.2019
    * 
    */

    public function userexist(Request $request)
    {
        $userid = Auth::user()->id;
        $userdetails = Users::where('id',$userid)->first();
        $adminemail = $request->post('email');
        $id = ($request->post('id')!="") ? $request->post('id') : 0;

        $checkexist=Users::where('email','=',trim($adminemail))->where('status','!=',2)->whereNOTIn('id',[$id])->first();
        
        if($checkexist)
        {
            echo "false";
            exit;
        }
        else 
        {
            echo "true";
            exit;
        }
    }

     public function statusupdate(Request $request)
    {
        //dd("sf");
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = Users::where('id',$id)->first();
        if(is_object($check))
        {
            $check->status = $status;
            $check->save();
            return "success";
        }
        else
        return "failed";
    }    

    public function mobilecheck(Request $request) {
        $mobile = $request->get('ph_no');
        $id = $request->get('id');
        $mobile_exists = Users::where('mobile',$mobile)->where('status', '!=', 2)->where('id', '!=', $id)->count();
        if($mobile_exists>0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function phonecheck(Request $request) {
        $phone = $request->get('alt_no');
        $id = $request->get('id');
        $phone_exists = Users::where('phone',$phone)->where('status', '!=', 2)->where('id', '!=', $id)->count();
        if($phone_exists>0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function emailcheck(Request $request) {
        $email = $request->get('email');
        $id = $request->get('id');
        $email_exists = Users::where('email',$email)->where('status','!=', 2)->where('id', '!=', $id)->count();
        if($email_exists>0) {
            return "false";
        } else {
            return "true";
        }
    }

     /*created date 20.02.2020
     function for:  list event for particular user
     input fields:userid*/
     public function eventview($id){
      $user=Users::find($id);
      $event=Event::where('user_id',$id)->get();
     return view('users.eventlist',['event'=>$event,'user'=>$user]);
     }
}
