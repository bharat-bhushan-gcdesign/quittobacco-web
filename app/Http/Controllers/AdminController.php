<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Userpermissions; 

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


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $userdetails= Auth::user();
            $allowed =0;

            if($userdetails->user_type_id ==1)
            $allowed = 1;
        
            if($allowed == 1)
            return $next($request);
            else
            return redirect('/');
        });
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
    * 
    * name: adminlist
    * desc: to list the Admin users
    * @param: none
    * method: none  
    * @return: return the admin users list with neccessary actions or redirect to falilue page based on condition.
    * Created by JK on 11.02.2019
    * 
    */
    public function adminlist()
    {
       $userid = Auth::user()->id;
        if($userid!="")
        {
            $userdetails = User::where('id',$userid)->first();

            if(is_object($userdetails) && $userdetails->user_type_id ==1)
            {
                if($userdetails->user_type_id ==1)
                $adminuserslist = User::where('status','!=',2)->where('user_type_id',1)->where('id','!=',$userid)->orderby('id','DESC')->get();

                if($userdetails->user_type_id ==2)
                $adminuserslist = User::where('status','!=',2)->where('user_type_id',1)->where('id','!=',$userid)->where('created_by',$userid)->orderby('id','DESC')->get();
                return view('adminlist',['adminuserslist'=>$adminuserslist,'userid'=>$userid]);
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Admin Users List failed</h3><p>This is not a valid data</p>';
                return view('site.success',['type'=>$type,'message'=>$message]);
            }
        }
        else
        return redirect('/login');
    } 
    /*
    * 
    * name: addadmin
    * desc: to add the Admin users
    * @param: none
    * method: none  
    * @return: return the admin user create form or redirect to falilue page based on condition.
    * Created by JK on 07.02.2019
    * 
    */
    public function addadmin()
    {
        $userid = Auth::user()->id;
        if($userid!="")
        {
            $userdetails = User::where('id',$userid)->first();
            if(is_object($userdetails))
            {
                return view('addadminuser',['id'=>"0"]);
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Complaincetype Create failed</h3><p>This is not a valid data</p>';
                return view('success',['type'=>$type,'message'=>$message]);
            }
        }
        else
        return redirect('/login');
    }
    /*
    * 
    * name: editadmin
    * desc: to edit the Admin User Records
    * @param: $id
    * method: GET  
    * @return: return the admin user edit form or or redirect to falilue page based on condition.
    * ReCreated by JK on 11.02.2019
    * 
    */
    public function editadmin(Request $request,$id)
    {
        $userid = Auth::user()->id;
        if($userid!="")
        {
            $userdetails = User::where('id',$userid)->first();
            if(is_object($userdetails))
            {
                $adminuserdetail = User::where('id',$id)->where('status','!=',2)->first();
                if(is_object($adminuserdetail))
                {
                    if(($userdetails->user_type_id ==1 || $adminuserdetail->created_by == $userid) && $id!=$userid)
                    {
                        return view('addadminuser',['id'=>$id,'adminuserdetail'=>$adminuserdetail]);
                    }
                    else
                    {
                      $type = 2;
                      $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Update Admin User failed</h3><p>You dont have credentials to update this user.</p>';
                        return view('success',['type'=>$type,'message'=>$message]);
                    }
                }
                else
                {
                    $type = 2;
                    $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Admin user Update failed</h3><p>This is not a valid data</p>';
                    return view('success',['type'=>$type,'message'=>$message]);
                }
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Admin Create failed</h3><p>This is not a valid data</p>';
                return view('success',['type'=>$type,'message'=>$message]);
            }
        }
        else
        return redirect('/login');
    }

    /*
    * 
    * name: saveadmin
    * desc: to save the Admin user Records
    * @param: firstname,email,phone,dob,status
    * method: POST  
    * @return: return to the listing page with necessary popup message.
    * ReCreated by JK on 18.01.2019
    * 
    */
    public function saveadmin(Request $request)
    {
        //dd($request->all());
        $loginid = Auth::user()->id;
        if($loginid!="")
        {
            $check = 0;
            $userdetails = User::where('id',$loginid)->first();
            $id=$request->id;
            if($id==0 || $id==null)
            {
                $password = $this->generateStrongPassword(8, false, 'luds');
                $adminusers = new Users;
                $adminusers->created_at = Carbon::now()->toDateTimeString();
                $adminusers->password=bcrypt($password);
                $adminusers->created_by=$loginid;
                $check = 1;
                $message = "Admin User Created Successfully";
            }
            else
            {
                $adminusers = User::where('id',$id)->where('status','!=',2)->first();
                if(is_object($adminusers))
                {
                    $adminusers->updated_at = Carbon::now()->toDateTimeString();
                    $check = 1;
                    $message = "Admin User Updated Successfully";
                }
            }
            if($check==1)
            {

                $adminusers->first_name=trim($request->first_name);
                $adminusers->phone=trim($request->phone);
                $adminusers->dob=date("Y-m-d",strtotime($request->dob));
                if($request->has('email'))
                $adminusers->email=trim($request->email);
                $adminusers->status=$request->status;
                $adminusers->user_type_id=1;
                $adminusers->user_type=1;
                $adminusers->is_admin=1;
                $adminusers->save(); 

                if($id==0)
                {
                    $data['userid'] = $adminusers->id;
                    $data['password'] = $password;
                    $this->sentactivationlink($data);
                }
                return redirect('/admin')->witherrors($message);
            }
            else
            {
                $type = 2;
                $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Admin User Update failed</h3><p>You dont have credentials to update this user.</p>';
                return view('success',['type'=>$type,'message'=>$message]);
            } 

        }
        else
        return redirect('/login');
    }

    /*
    * 
    * name: viewadmin
    * desc: to view the admin user Records
    * @param: $id
    * method: GET  
    * @return: return the view page of particual record or redirect to failure page with respective message.
    * ReCreated by JK on 11.02.2019
    * 
    */

    public function viewadmin(Request $request,$id)
    {
        $loginid = Auth::user()->id;
          if($loginid!="")
          {
            $userdetails = User::where('id',$loginid)->first();
            $adminuserdetails = User::where('status','!=',2)->where('id',$id)->first();
            if(is_object($adminuserdetails) && $userdetails->user_type_id ==1)
            {
                if(($userdetails->user_type_id ==1 || $adminuserdetails->created_by == $loginid) && $id!=$loginid)
                {
                    $id=$id;
                    return view('viewadmin',['adminuserdetails'=>$adminuserdetails,'id'=>$id]);

                }
                else
                {
                    $type = 2;
                    $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>View Admin User failed</h3><p>You dont have credentials to view this user.</p>';
                    return view('success',['type'=>$type,'message'=>$message]);
                }
            }
            else
            {
              $type = 2;
              $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>View Admin users failed</h3><p>This is not a valid data</p>';
              return view('success',['type'=>$type,'message'=>$message]);
            }
        }
        else
         return redirect('/login');
    }

    /*
    * 
    * name: deletecompliancetype
    * desc: to delete the Compliance Type Records
    * @param: $id
    * method: GET  
    * @return: return to listing page with respective message or redirect to failure page with respective message.
    * ReCreated by JK on 18.01.2019
    * 
    */

    public function deleteadmin(Request $request,$id)
    {
        $id =  $request->id;
        $loginid = Auth::user()->id;
        if($loginid!="")
        {
            $userdetails = User::where('id',$loginid)->first();
            $adminuserdetails = User::where('status','!=',2)->where('id',$id)->first();
            if(is_object($adminuserdetails))
            {
                if(($userdetails->user_type_id ==1 || $adminuserdetails->created_by == $loginid) && $id!=$loginid)
                {
                    $adminuserdetails->status = 2;
                    $adminuserdetails->save();
                    return redirect('/admin')->with('message','Admin User Deleted successfully');
                }
                else
                {
                    $type = 2;
                    $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Delete Admin User failed</h3><p>You dont have credentials to view this admin user.</p>';
                    return view('success',['type'=>$type,'message'=>$message]);
                }
            }
            else
            {
              $type = 2;
              $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>Delete Admin User failed</h3><p>This is not a valid data</p>';
              return view('success',['type'=>$type,'message'=>$message]);
            }
        }
        else
        return redirect('/login');
    }

    /*
    * 
    * name: adminuserexist
    * desc: to check whether the record is already exist or not.
    * @param: email,id
    * method: POST  
    * @return: return sucess or failure message
    * Created by JK on 11.02.2019
    * 
    */

    public function adminuserexist(Request $request)
    {
        $userid = Auth::user()->id;
        $userdetails = User::where('id',$userid)->first();
        $adminemail = $request->post('email');
        $id = ($request->has('id')) ? $request->post('id') : 0;
       
        $checkexist=User::where('email','=',trim($adminemail))->where('status','!=',2)->whereNOTIn('id',[$id])->first();
        
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

//------------To generate random string by JK on Feb 11 starts----//

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


//------------To generate random string by JK on Feb 11 ends----//   

    /*
    * 
    * name: sentactivationlink
    * desc: to send mail to the respective mail.
    * @param: data
    * method: none
    * @return: 
    * Created by JK on 02.01.2019
    * 
    */ 
    public function sentactivationlink($data)
    {
        if(isset($data['userid']) && is_numeric($data['userid']) )
        {

            $userid = $data['userid'];
            $user = User::where('id',$userid)->first();
            ///dd($user);
            $data = array('name'=>$user->first_name,'password'=>$data['password'],'email'=>$user->email);
            Mail::send('registrationmail', $data, function($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('AVI: Admin Registration');
            $message->from('avi@dci.in','AVI');
            });
        }
    }

    public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $airportcheck = User::where('id',$id)->first();
        if(is_object($airportcheck))
        {
            $airportcheck->status = $status;
            $airportcheck->save();
            return "success";
        }
        else
        return "failed"; 
    }
}
