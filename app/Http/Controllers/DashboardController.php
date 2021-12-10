<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Airports;
use App\Models\Foodtype;
use App\Models\Userpermissions;
use App\Models\Retail_Shop;
use App\Models\Retail_type;
use App\Models\Facility;
use App\Models\Orders;
use App\Models\OAG;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Models\File;

use Mail;
use Validator;
use Session;
use Redirect;
use clause;

use Azure;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function index()
    {       
        $users['total']=User::where('status','!=',2)->where('role',2)->count();      
        $users['active']=User::where('status',1)->where('role',2)->count();      
        $users['inactive']=User::where('status',0)->where('role',2)->count(); 
        $users['inactive']=User::where('status',0)->where('role',2)->count();      

        $labels[]  = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        
        return view('dashboard',compact('users'));
    }


    public function dashboard(Request $request)
    {       
        if(isset($request->code)){
            try {
                $token = Azure::getAccessToken('authorization_code', [
                    'code' => $request->code,
                    'resource' => 'https://graph.windows.net',
                ]);
                // \Log::info(var_dump($token));
                // \Log::info('------------------------------Asshiii');


                $resourceOwner = Azure::getResourceOwner($token);
                // echo 'Hello, '.$resourceOwner->getEmail().'!';
                $user=User::where('email',$resourceOwner->getEmail())->first();
                \Log::info($user);
                if($user==null)
                    abort(403);

                $user->update([
                    'name'=> $resourceOwner->getFirstName() .' '.$resourceOwner->getLastName(),
                    'azure_id'=>$token
                ]);
                Auth::loginUsingId($user->id, true);
                // return $token;
                return redirect('/home');
            } catch (\Exception $e) {
                abort(403);
            }
        }
        abort(403);
    }

    public function home(Request $request)
    {       

        $user_data=User::where('role','!=',1)->get();
        $users['total']=$user_data->count();
        $users['active']=$user_data->where('status',1)->count();
        $users['inactive']=$user_data->where('status',0)->count();
        $users['social_media_users']=$user_data->where('social_media_id','!=','')->count();
        $users['free']=Subscription::where('status','!=',2)->where('title',"Free")->first(); 
        $users['gold']=Subscription::where('status','!=',2)->where('title',"Gold")->first();
        $users['platinum']=Subscription::where('status','!=',2)->where('title',"Platinum")->first();
        
       
        // $subscription=Subscription::all();
        $labels[]  = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        return view('dashboard',compact('users'));
    }
    

    public function editprofile(Request $request,$code)
    {
              
        $adminuserdetail = User::where('code',$code)->where('status','!=',2)->where('role',1)->first();
// return $adminuserdetail->name;
        return view('editprofile',['id'=>$adminuserdetail->id,'code'=>$code,'adminuserdetail'=>$adminuserdetail]);
               
    }

    
    public function saveprofile(Request $request)
    {
            $code=$request->code;

        $validator = Validator::make($request->all(), [
            'profile_image' => 'file|mimes:jpg,bmp,png'
        ]);
        if ($validator->fails()) 
            return redirect('/editprofile/'.$code)->with('errors',$validator->errors());

            $adminuser = User::where('code',$code)->where('status','!=',2)->first();
                $adminuser->updated_at = Carbon::now()->toDateTimeString();
                
                $message = "Profile Updated Successfully";
          
                $adminuser->name=trim($request->name);
      
                $file = $request->file('profile_image');
                $name="";
                      
                if($request->file('profile_image')!="")
                {
                  $name = date('His').$file->getClientOriginalName();
                   $file->move(base_path() . '/public/uploads/files', $name);
                }
                if($adminuser->profile!=null)
                    $adminuser->profile->update([
                          'name' =>$name == ""  ? $adminuser->profile->name : $name, 
                    ]);
                else
                    File::create([
                        'fileable_id'=>$adminuser->id,
                        'fileable_type'=>'users',
                        'name' =>$name, 
                    ]);
                $adminuser->save();
                return redirect('/editprofile/'.$code)->with('message',$message);
    }


    public function getPassword(Request $request)
    {
        
        return view('changepassword');
    }

    public function updatePassword(Request $request)
    {

        $loginid = Auth::user()->id;
        $pwd = $request->post('newpassword');
        $pass = 0;
        if(is_numeric($loginid))
        {
            if($request->has('newpassword'))
            {
                $usercheck = User::where('id',$loginid)->first();
                if(is_object($usercheck))
                {
                    $usercheck->password = bcrypt($pwd);
                    $usercheck->save();
                    $pass =1;
                    $message = 'Password Reset Successfully';
                }
                else
                {
                    $type = 2;
                    $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This User has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
                }
            }
        } 
        else
        {
            $type = 2;
            $message = '<h3 class="md_helo">Oops !</h3><img src="'.url('/').'/img/cross.png"><h3>This User has not been registered with us</h3><p>Kindly <a href="register" style="color: #3993F4;font-weight: bold;">Register</a></p>';
        }
        if($pass ==0)
        return view('changepassword');
        else
        return view('changepassword')->witherrors($message);;
    }

    public function generateRandomString($length=4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
















