<?php 

  namespace App\Services; 
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\User;
  use App\Models\Notifications;
  use App\Models\changeQuitdate;
  use App\Models\changeQuittime;
  use App\Models\changeCurrency;
  use App\Models\changeSmokingcost;
  use App\Models\changeQuantity;
  use App\Models\changeSmokingtime;
  use App;
  use JWTFactory;
  use JWTAuth;
  use Validator;
  use Response;
  use Mail;
  use Auth;
  use DB;
  use Carbon\Carbon;


  class Settings {
       
     
    public function Notifications(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid notificationchangetimer'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $notificationchangetimer = new Notifications();
                    $notificationchangetimer->dairyremainder =$request->dairyremainder;
                    $notificationchangetimer->dairyremaindertime =$request->dairyremaindertime;
                    $notificationchangetimer->missionremainder =$request->missionremainder;
                    $notificationchangetimer->missionremaindertime =$request->missionremaindertime;
                    $notificationchangetimer->badgenotification =$request->badgenotification;
                    $notificationchangetimer->generalalertnotification =$request->generalalertnotification;
                    $notificationchangetimer->user_id=$request->user_id;
                    $notificationchangetimer->status =1;
                    $notificationchangetimer->save();
              return response()->json(['status' => 200,'data'=>$notificationchangetimer,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function ChangeQuitdate(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeQuitdate'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $changeQuitdate = new changeQuitdate();
                    $changeQuitdate->date =date("Y-m-d", strtotime($request->date));
                    $changeQuitdate->time =$request->time;
                    $changeQuitdate->user_id=$request->user_id;
                    $changeQuitdate->status =1;
                    $changeQuitdate->save();
              return response()->json(['status' => 200,'data'=>$changeQuitdate,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function ChangeQuittime(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeQuitdate'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $ChangeQuittime = new ChangeQuittime();
                    $ChangeQuittime->time =$request->time;
                    $ChangeQuittime->user_id=$request->user_id;
                    $ChangeQuittime->status =1;
                    $ChangeQuittime->save();
              return response()->json(['status' => 200,'data'=>$ChangeQuittime,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function changeCurrency(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeCurrency'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $changeCurrency = new changeCurrency();
                    $changeCurrency->name =$request->name;
                    $changeCurrency->user_id=$request->user_id;
                    $changeCurrency->status =1;
                    $changeCurrency->save();
              return response()->json(['status' => 200,'data'=>$changeCurrency,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function changeSmokingcost(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeSmokingcost'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $changeSmokingcost = new changeSmokingcost();
                    $changeSmokingcost->price =$request->price;
                    $changeSmokingcost->user_id=$request->user_id;
                    $changeSmokingcost->status =1;
                    $changeSmokingcost->save();
              return response()->json(['status' => 200,'data'=>$changeSmokingcost,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function changeQuantity(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeSmokingcost'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $changeQuantity = new changeQuantity();
                    $changeQuantity->quantity =$request->quantity;
                    $changeQuantity->user_id=$request->user_id;
                    $changeQuantity->status =1;
                    $changeQuantity->save();
              return response()->json(['status' => 200,'data'=>$changeQuantity,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function changeSmokingtime(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
              'user_id'        => 'required',                             
          ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          if(!$user)
             return response()->json(['status' => 500, 'message' => 'Invalid changeSmokingcost'], 200);
          else{

            $user = JWTAuth::toUser();  
                    $token = JWTAuth::fromUser($user);
                    $changeSmokingtime = new changeSmokingtime();
                    $changeSmokingtime->time =$request->time;
                    $changeSmokingtime->user_id=$request->user_id;
                    $changeSmokingtime->status =1;
                    $changeSmokingtime->save();
              return response()->json(['status' => 200,'data'=>$changeSmokingtime,'jwt_token'=>$token])->header('jwt_token', $token);  
                
          } 
    }
    public function logout(Request $request)
    {
      $validator = Validator::make($request->all(), [                               
            'user_id'        => 'required',                                                     
         ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        }
          $user = User::where('id',$request->user_id)->where('status', 1)->first();
          $userdata=$user;
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid User'], 200);
        else{
          $user->fcm_key="";
          $user->save();  
          return response()->json(['status' => 200,'data' => $user,'message' => 'logout sucessfully']);
        }
    }
    public function reset(Request $request)
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

              $changeQuitdate = changeQuitdate::where('user_id',$request->user_id)->where('user_id',$request->user_id)->first();

              $changeQuitdate = changeQuitdate::find($changeQuitdate->id);
              $changeQuitdate->user_id=$request->user_id;
        
              $changeQuitdate->status =2;
              $changeQuitdate->save();

              $Notifications = Notifications::where('user_id',$request->user_id)->where('user_id',$request->user_id)->first();

              $Notifications = Notifications::find($Notifications->id);
              $Notifications->user_id=$request->user_id;
        
              $Notifications->status =2;
              $Notifications->save();

              return response()->json(['status' => 200,'jwt_token'=>$token])->header('jwt_token', $token);
 
        }
    }
}