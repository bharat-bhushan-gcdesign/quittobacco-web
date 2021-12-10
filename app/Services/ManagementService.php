<?php 

  namespace App\Services; 
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\User;
  use App\Models\Education;
  use App\Models\Tobacco;
  use App\Models\MorningFirstSmoke;
  use App\Models\TobaccoManagement;
  use App\Models\StaticPage;
  use App\Models\QuitReason;
  use App;
  use JWTFactory;
  use JWTAuth;
  use Validator;
  use Response;
  use Mail;
  use Auth;
  use DB;
  use Carbon\Carbon;


  class ManagementService {
       
     
    public function education(Request $request){   
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
            $Education = Education::where('status','1')->get();

            if(count($Education) > 0)
              return response()->json(['status' => 200,'message' => 'Education List.','data'=>$Education,'jwt_token'=>$token])->header('jwt_token', $token);  
              else
                return response()->json(['status' => 500,'message' => 'No results found.']);; 
        } 
    } 
    public function typeoftobacco(Request $request){   
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
            $Tobacco = Tobacco::where('status','1')->get();

            if(count($Tobacco) > 0)
              return response()->json(['status' => 200,'message' => 'Education List.','data'=>$Tobacco,'jwt_token'=>$token])->header('jwt_token', $token);  
              else
                return response()->json(['status' => 500,'message' => 'No results found.']);; 
        } 
    }

    public function morningfirstsmoke(Request $request){   
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
            $MorningFirstSmoke = MorningFirstSmoke::where('status','1')->get();

            if(count($MorningFirstSmoke) > 0)
              return response()->json(['status' => 200,'message' => 'Education List.','data'=>$MorningFirstSmoke,'jwt_token'=>$token])->header('jwt_token', $token);  
              else
                return response()->json(['status' => 500,'message' => 'No results found.']);; 
        } 
    }
    public function whydoUsetobacco(Request $request){   
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
            $whydoUsetobacco = TobaccoManagement::where('status','1')->get();

            if(count($whydoUsetobacco) > 0)
              return response()->json(['status' => 200,'message' => 'Education List.','data'=>$whydoUsetobacco,'jwt_token'=>$token])->header('jwt_token', $token);  
              else
                return response()->json(['status' => 500,'message' => 'No results found.']);; 
        } 
    } 
    public function staticPage(Request $request){   
      $validator = Validator::make($request->all(), [                       
            'title'        => 'required',                             
        ]);
          if ($validator->fails()){              
              return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
          } 

          $user = JWTAuth::toUser();  
                 $token = JWTAuth::fromUser($user);
            //$staticPage = StaticPage::where('status','1')->get();

            if($request->title=='Privacy Policy')
            {
              $staticPage=StaticPage::where('id',1)->first();
              $staticPage->description=base64_decode($staticPage->description);
            }
            elseif ($request->title=='Dealing with difficult situations') {
              $staticPage=StaticPage::where('id',2)->first();
                 $staticPage->description=base64_decode($staticPage->description);
            }
            elseif ($request->title=='Nicotine Replacement Therapy') {
              $staticPage=StaticPage::where('id',4)->first();
                 $staticPage->description=base64_decode($staticPage->description);
            }
            elseif ($request->title=='References') {
              $staticPage=StaticPage::where('id',5)->first();
                 $staticPage->description=base64_decode($staticPage->description);
            }
            elseif ($request->title=='Terms and Condition') {
              $staticPage=StaticPage::where('id',6)->first();
                 $staticPage->description=base64_decode($staticPage->description);
            } 
            else
            {
              return response()->json(['status' => 500, 'message' => 'No Users'], 200);
            }
          return response()->json(['status' => 200,'data' => $staticPage]);
      }
    public function quiteReason(Request $request){   
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
            $QuitReason = QuitReason::where('status','1')->get();

            if(count($QuitReason) > 0)
              return response()->json(['status' => 200,'message' => 'QuitReason List.','data'=>$QuitReason,'jwt_token'=>$token])->header('jwt_token', $token);  
              else
                return response()->json(['status' => 500,'message' => 'No results found.']);; 
        } 
    }
  }