<?php 
namespace App\Services; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Airports;
use App\Models\wishlist;
use App\Models\Country;
use App\Models\Motivation;
use App\Models\Feedback;
use App\Models\Mission;
use App\Models\Diary;
use App\Models\Relation;
use App\Models\whistlist;
use AWS;
use App;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Mail;
use Auth;
use DB;
use Hash;
use Carbon\Carbon;


class Userdetails {

  public function register(Request $request){
        $validator = Validator::make($request->all(), [            
            'Name'           => 'required',            
            'email'                => 'required',
            'mobile'               => 'required',                    
            'password'             => 'required',                                       
            'fcm_key'      => 'required',                    
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'parameter missing'], 200);
        }  

        $EmailPhoneCheck = User::where('email',$request->input('email'))->orWhere('mobile',$request->input('mobile'))->count();
        if($EmailPhoneCheck != 0)
             return response()->json(['status' => 500, 'message' => 'email or mobile number already exists'], 200);
        
         //save data
          $user = new User();
         // $exclude_inputs = array('password','confirmpassword');
         // foreach($request->all() as $key=>$value){
         //  if($key != 'CountryUniqueCode'){
         //      if(!in_array($key,$exclude_inputs))
         //          $user->$key = $value;

         //      }
         //  }

         $user->Name =$request->Name;
         $user->email =$request->email;
         $user->mobile =$request->mobile;

         if($request->has('password'))
         { 
           $user->password = bcrypt($request->input('password'));
         } 
         $user->role    = 2 ;
         $user->status       = 1 ;

       
          $user->fcm_key = $request->fcm_key;
        
        
          //$user->Device_type = $request->Device_type;                  
        
        
        // if($request->CountryUniqueCode){
          
        //   $CountryUniqueCode = $request->CountryUniqueCode;    
          
        //   $cnty = country::where('sortname',$CountryUniqueCode)->first();
        //   if($cnty){
        //     $user->country    = $cnty->id;    
        //   }else{
        //     return response()->json(['status' => 500,'message' => 'Selected country does not allowed']);  
        //   }
        
        // }


         $user->save();
         //save data       
        $token = JWTAuth::fromUser($user);         
       
        return response()->json(['status' => 200,'message' => 'User logged in sucessfully.','data' =>$user,'jwt_token'=>$token])->header('Authorization', 'Bearer '.$token);
      
  }


  public function login(Request $request){
        $validator = Validator::make($request->all(), [            
            'email'         => 'required',
            'password'      => 'required',
           // 'fcmKey'          => 'required',                    
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'parameter missing'], 200);
        }  
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $credentials['email']             = trim($request->email);
            $credentials['password']          = $request->password;
        }
        else {
            $credentials['mobile']            = trim($request->email);
            $credentials['password']          = $request->password;
        }


        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 500, 'message' => 'Invalid credentials']);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['status' => 500, 'message' => 'could not create token']);
        }
         //dd($credentials);
        $currentUser = Auth::user();
        if(Auth::user()->status!=1)
           return response()->json(['status' => 500, 'message' => 'Your Account was Deleted or Inactive']);
        if($request->fcmKey){
          $currentUser->fcmKey = $request->fcmKey;
          $currentUser->save();                    
        }        
        return response()->json(['status' => 200,'message' => 'User logged in sucessfully.','data' => $currentUser->toArray(),'jwt_token'=>$token])->header('Authorization', 'Bearer '.$token);     
    }


     public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',       
            'password'       => 'required',                      
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['status' => 200, 'message' => 'Password changed successfully'], 200); 
        }      
    }

    public function motivationadd(Request $request)
    {
            $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
            'textdata'        => 'required',                             
            'motivation_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',                             
        ]);
        if ($validator->fails()){    
            return response()->json(['error_message'=>$validator->errors()], 400);

            // return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $motivation = new Motivation();
            $motivation->textdata=$request->textdata;
            $motivation->user_id=$request->user_id;
   $picture_single="";

                if($request->file('motivation_image')!=""){
            if($_FILES['motivation_image']['name']!='' )
            {
                $files_single = $request->file('motivation_image');
                $filename = $files_single->getClientOriginalName();
                $extension = $files_single->getClientOriginalExtension();
                $picture_single = date('His').$filename;
                $destinationPath = base_path() . '/public/uploads/motivation';
                $files_single->move($destinationPath, $picture_single);
            }
            }

                $motivation->motivation_image =$picture_single;
                $motivation->status =1;
                $motivation->save();


          
              return response()->json(['status' => 200,'data'=>$motivation,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 

    }

    public function motivationlist(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $motivation = Motivation::where('user_id',$request->user_id)->where('status',1)->get();
            if(count($motivation)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
                 return response()->json(['status' => 200,'data'=>$motivation,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    }

    public function missionadd(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $mission = new Mission();
            $mission->name=$request->name;
            $mission->date=date("Y-m-d", strtotime($request->date));
            $mission->user_id=$request->user_id;
            $mission->notes=$request->notes;
   $picture_single="";

                if($request->file('mission_image')!=""){
            if($_FILES['mission_image']['name']!='' )
            {
                $files_single = $request->file('mission_image');
                $filename = $files_single->getClientOriginalName();
                $extension = $files_single->getClientOriginalExtension();
                $picture_single = date('His').$filename;
                $destinationPath = base_path() . '/public/uploads/mission';
                $files_single->move($destinationPath, $picture_single);
            }
            }

                $mission->mission_image =$picture_single;
                $mission->status =1;
                $mission->save();


          
              return response()->json(['status' => 200,'data'=>$mission,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 
    }

    public function missionlist(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $Mission = Mission::where('user_id',$request->user_id)->where('status',1)->get();


            if(count($Mission)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
                 return response()->json(['status' => 200,'data'=>$Mission,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    }
    public function feedback(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);

                 

                  $feedback = new Feedback();
            $feedback->email=$request->email;
            $feedback->user_id=$request->user_id;
            $feedback->message=$request->message;
            $feedback->save();
          
                 return response()->json(['status' => 200,'data'=>$feedback,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    }

        public function diaryadd(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $diary = new Diary();
            $diary->last_entry =$request->last_entry;
            $diary->desire_use =$request->desire_use;
            $diary->craving =$request->craving;
            $diary->date=date("Y-m-d", strtotime($request->date));
            $diary->user_id=$request->user_id;
            $diary->notes=$request->notes;
                $diary->status =1;
                $diary->save();
              return response()->json(['status' => 200,'data'=>$diary,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 
    }

        public function diarylist(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $Diary = Diary::where('user_id',$request->user_id)->where('status',1)->get();


            if(count($Diary)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
                 return response()->json(['status' => 200,'data'=>$Diary,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    }

        public function relationadd(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $relation = new Relation();
            $relation->user_id=$request->user_id;
            $relation->relationship=$request->relationship;
            $relation->name=$request->name;
                $relation->status =1;
                $relation->save();
              return response()->json(['status' => 200,'data'=>$relation,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 
    }

        public function relationlist(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $relation = Relation::where('user_id',$request->user_id)->where('status',1)->get();


            if(count($relation)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
                 return response()->json(['status' => 200,'data'=>$relation,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    }  

      public function relationedit(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $relation = Relation::where('user_id',$request->user_id)->where('status',1)->first();


            if(count($relation)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
            {
              $relation = Relation::find($relation->id);
              $relation->user_id=$request->user_id;
            $relation->relationship=$request->relationship;
            $relation->name=$request->name;
                $relation->status =1;
                $relation->save();

               return response()->json(['status' => 200,'data'=>$relation,'jwt_token'=>$token])->header('jwt_token', $token);

            }
                
        }
    }
    
      public function relationdelete(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $relation = Relation::where('user_id',$request->user_id)->where('status',1)->first();


            if(count($relation)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
            {

              $relation = Relation::find($relation->id);
              $relation->user_id=$request->user_id;
        
                $relation->status =2;
                $relation->save();

               return response()->json(['status' => 200,'jwt_token'=>$token])->header('jwt_token', $token);

            }
                
        }
    } 

      public function whistlistadd(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $whistlist = new whistlist();
          $whistlist->name=$request->name;
          $whistlist->price=$request->price;
         
            $whistlist->user_id=$request->user_id;
            $whistlist->notes=$request->notes;
   $picture_single="";

                if($request->file('whistlist_image')!=""){
            if($_FILES['whistlist_image']['name']!='' )
            {
                $files_single = $request->file('whistlist_image');
                $filename = $files_single->getClientOriginalName();
                $extension = $files_single->getClientOriginalExtension();
                $picture_single = date('His').$filename;
                $destinationPath = base_path() . '/public/uploads/whistlist';
                $files_single->move($destinationPath, $picture_single);
            }
            }

                $whistlist->whistlist_image =$picture_single;
                $whistlist->status =1;
                $whistlist->save();
              return response()->json(['status' => 200,'data'=>$whistlist,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 
    }

           public function whistlistlist(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $whistlist = whistlist::where('user_id',$request->user_id)->where('status',1)->get();


            if(count($whistlist)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
                 return response()->json(['status' => 200,'data'=>$whistlist,'jwt_token'=>$token])->header('jwt_token', $token);
        }
    } 
       
    public function whistlistedit(Request $request)
    {
          $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            $whistlist = whistlist::where('user_id',$request->user_id)->where('status',1)->first();


            if(count($whistlist)<=0)
                 return response()->json(['status' => 500, 'message' => 'No data'], 200);
            else
            {

                    $whistlist =whistlist::find($whistlist->id);
                  $whistlist->name=$request->name;
          $whistlist->price=$request->price;
         
            $whistlist->user_id=$request->user_id;
            $whistlist->notes=$request->notes;
   $picture_single="";

                if($request->file('whistlist_image')!=""){
            if($_FILES['whistlist_image']['name']!='' )
            {
                $files_single = $request->file('whistlist_image');
                $filename = $files_single->getClientOriginalName();
                $extension = $files_single->getClientOriginalExtension();
                $picture_single = date('His').$filename;
                $destinationPath = base_path() . '/public/uploads/whistlist';
                $files_single->move($destinationPath, $picture_single);
            }
            }
            if($picture_single=="")
            {
              $picture_single= $whistlist->whistlist_image;
            }

                $whistlist->whistlist_image =$picture_single;
                $whistlist->status =1;
                $whistlist->save();
              return response()->json(['status' => 200,'data'=>$whistlist,'jwt_token'=>$token])->header('jwt_token', $token);
            }
                 
        }
    }  
}