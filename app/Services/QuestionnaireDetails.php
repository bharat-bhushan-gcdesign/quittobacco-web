<?php 

  namespace App\Services; 
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\User;
  use App\Models\Questionnaire;
  use App;
  use JWTFactory;
  use JWTAuth;
  use Validator;
  use Response;
  use Mail;
  use Auth;
  use DB;
  use Carbon\Carbon;


  class QuestionnaireDetails {

  public function Questionnaireadd(Request $request)
    {
         $validator = Validator::make($request->all(), [                       
            'user_id'        => 'required',                             
        ]);
        if ($validator->fails()){              
            return response()->json(['status' => 500, 'message' => 'Parameter Missing'], 200);
        } 
        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if(!$user)
           return response()->json(['status' => 500, 'message' => 'Invalid Questionnaire'], 200);
        else{

          $user = JWTAuth::toUser();  
                  $token = JWTAuth::fromUser($user);
                  $Questionnaire = new Questionnaire();
                  $Questionnaire->gender =$request->gender;
                  $Questionnaire->dob =date("Y-m-d", strtotime($request->dob));
                  $Questionnaire->education =$request->education;
                  $Questionnaire->work=$request->work;
                  $Questionnaire->typeOfTobaccoConsume=$request->typeOfTobaccoConsume;
                  $Questionnaire->tobaccoProduct=$request->tobaccoProduct;
                  $Questionnaire->ageStart=$request->ageStart;
                  $Questionnaire->lastMonthUse=$request->lastMonthUse;
                  $Questionnaire->useageOfTobacco=$request->useageOfTobacco;
                  $Questionnaire->consumptionOfTobacco=$request->consumptionOfTobacco;
                  $Questionnaire->perDayUse=$request->perDayUse;
                  $Questionnaire->spentMoney=$request->spentMoney;
                  $Questionnaire->currency=$request->currency;
                  $Questionnaire->whenUseInDay=$request->whenUseInDay;
                  $Questionnaire->whyUse=$request->whyUse;
                  $Questionnaire->quitOption=$request->quitOption;
                  $Questionnaire->quitDate=date("Y-m-d", strtotime($request->quitDate));
                  $Questionnaire->reasonForQuit=$request->reasonForQuit;
                  $Questionnaire->user_id=$request->user_id;
                  $Questionnaire->status =1;
                  $Questionnaire->save();
            return response()->json(['status' => 200,'data'=>$Questionnaire,'jwt_token'=>$token])->header('jwt_token', $token);  
              
        } 
    }
  }