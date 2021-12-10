<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Resources\HealthImprovement as HealthImprovement;

use App\Http\Resources\CravingCollection;


use App\Http\Resources\QuitBenefitCollection;
use App\Http\Resources\Saving as SavingResource;

use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Mail;
use DB;
use URL;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Content;
use App\Models\Motivation;
use App\Models\Achievement;
use App\Models\UserMotivation;


use Session;
use Redirect;
use clause;
use App\Http\Resources\Content as ContentResource;
use App\Http\Resources\Motivation as MotivationResource;


use App\Services\Userdetails as Userdetails;
use App\Services\ManagementService as ManagementService;
use App\Services\QuestionnaireDetails as QuestionnaireDetails;
use App\Services\Settings as Settings;
use App\Http\Traits\UserTrait;
use App\User;
use DateTime;
use App\Models\QuitBenefit;

class ApiController extends Controller
{

    use UserTrait;

      private $request;
    private $Userdetails;


    public function __construct(Request $request)
    {   
        $this->request  = $request;
        $this->Userdetails = new Userdetails();        
        $this->ManagementService = new ManagementService();  
        $this->QuestionnaireDetails = new QuestionnaireDetails();
        $this->Settings = new Settings();      
       
    }

    /**
     * Dashboard.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        /** Get User by requested mobile number **/
        $user=User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  
        $datetime1 = new DateTime($user->user_information->quit_date);
        $datetime2 = new DateTime(Carbon::now());
        $interval = $datetime1->diff($datetime2);
        $admin_motivation_content =motivation::where('publish_status',1)->first();

        $admin_default_content = $admin_motivation_content != null ? $admin_motivation_content->message : "No Motivation Posted from Admin ";

        $motivation_content =UserMotivation::where('default_status',1)->where('user_id',$user->id)->first();

        $default_content = $motivation_content != null ? $motivation_content : "No Motivation Posted by User ";

        $cravings_resisted= $user->cravings !=null ? $user->cravings->where('carving_status',0)->count()  : 0;


        $life_regained = 0;
        $cravings_resisted_in_percent = 0;

        if($user->user_information->start_date != null && $user->user_information->quit_date != null ){

            $start_date = Carbon::createFromFormat('Y-m-d', $user->user_information ->start_date);
            $end_date = Carbon::createFromFormat('Y-m-d', $user->user_information->quit_date);
            $different_days = $start_date->diffInDays($end_date);

        $cravings_resisted_in_percent = $different_days !=0 ? ($cravings_resisted / $different_days) * 100 ."%" : 0; 

        $life_regained = $cravings_resisted * 1440;
        }


        $data=[
            'time_smoke_free'=>[
                'updated_at'=>($user->user_information != null) ? $user->user_information->updated_at->timestamp : "",
                'date'=>($user->user_information != null)?(new Carbon($user->user_information->quit_date_time))->timezone('UTC') : "",

                'date'=>($user->user_information != null)?(new Carbon($user->user_information->quit_date_time))->timestamp : "",
                'days'=>$interval->days +1,
                'quit_timestamp'=>($user->user_information->quit_timestamp != null) ? $user->user_information->quit_timestamp : 0,
            ],
            'benefits_of_quiting_tobacco'=>new QuitBenefitCollection(QuitBenefit::Status()->take(2)->get()),

            'money'=>$user->userSaving ? new SavingResource($user->userSaving) : "No data Available",

            'your_progress'=>[
                'not_used_days'=>$cravings_resisted,
                'life_regained'=>$life_regained,
                'cravings_resisted'=>round($cravings_resisted_in_percent).'%',
            ],
            'money'=> [
                'per_day'=>$user->user_information->country->currency_symbol . $user->user_information->money_spent,
                'per_week'=>$user->user_information->country->currency_symbol . $user->user_information->money_spent * 7,
                'per_month'=>$user->user_information->country->currency_symbol . $user->user_information->money_spent * 30,
                'per_year'=>$user->user_information->country->currency_symbol . $user->user_information->money_spent * 364,
                'total'=>$user->user_information->country->currency_symbol . Auth::user()->cravings->where('carving_status',0)->count()*Auth::user()->user_information->money_spent,
            ],

            'motivation'=>$default_content,
            // 'admin_motivation'=>$admin_default_content,

            'motivation_status'=>$user->motivation ? 1 : 0,

            'health_improvements'=> $user->healthImprovement ? new HealthImprovement($user->healthImprovement) : "No data Available",
            
            'cravings'=>[
                
              $user->cravings ? new CravingCollection ($user->cravings->where('carving_status','1')): ""

            ],

            'achievements'=>['quit_date'=>($user->user_information != null)?(new Carbon($user->user_information->quit_date))->format('d M Y h:i:s a') : "",
            'achievement'=>Achievement::whereIn('id',$user->user_achievements->pluck('achievement_id'))->take(2)->get()],
        ];

    /** Return with Otp sent and user's secret code */
        return response()->json([
            'status' => 200,
            'data'=>$data,
            'jwt_token'=>$token,
        ])->header('jwt_token', $token);
    }
     public function register()
    {
       return $this->Userdetails->register($this->request);
    }   

     public function login()
    {
       return $this->Userdetails->login($this->request);
    }
    
    public function changePassword()
    {
       return $this->Userdetails->changePassword($this->request);
    }  

    public function education()
    {
       return $this->ManagementService->education($this->request);
    }
    public function typeoftobacco()
    {
       return $this->ManagementService->typeoftobacco($this->request);
    }
    public function morningfirstsmoke()
    {
       return $this->ManagementService->morningfirstsmoke($this->request);
    }
    public function whydoUsetobacco()
    {
       return $this->ManagementService->whydoUsetobacco($this->request);
    }    
    public function motivationadd()
    {
       return $this->Userdetails->motivationadd($this->request);
    } 
    public function motivationlist()
    {
       return $this->Userdetails->motivationlist($this->request);
    } 
    public function missionadd()
    {
       return $this->Userdetails->missionadd($this->request);
    }
     public function missionlist()
    {
       return $this->Userdetails->missionlist($this->request);
    } 
    public function feedback()
    {
       return $this->Userdetails->feedback($this->request);
    } 
    public function diaryadd()
    {
       return $this->Userdetails->diaryadd($this->request);
    } 
    public function diarylist()
    {
       return $this->Userdetails->diarylist($this->request);
    }
    public function relationadd()
    {
       return $this->Userdetails->relationadd($this->request);
    }
     public function relationlist()
    {
       return $this->Userdetails->relationlist($this->request);
    } 
     public function relationedit()
    {
       return $this->Userdetails->relationedit($this->request);
    } 
    public function relationdelete()
    {
       return $this->Userdetails->relationdelete($this->request);
    }
   public function whistlistadd()
    {
       return $this->Userdetails->whistlistadd($this->request);
    }  
    public function whistlist()
    {
       return $this->Userdetails->whistlistlist($this->request);
    }  
      public function whistlistedit()
    {
       return $this->Userdetails->whistlistedit($this->request);
    }
    public function Questionnaireadd()
    {
       return $this->QuestionnaireDetails->Questionnaireadd($this->request);
    }
    public function staticPage()
    {
       return $this->ManagementService->staticPage($this->request);
    }
    public function Notifications()
    {
       return $this->Settings->Notifications($this->request);
    }
    public function ChangeQuitdate()
    {
       return $this->Settings->ChangeQuitdate($this->request);
    }
    public function ChangeQuittime()
    {
       return $this->Settings->ChangeQuittime($this->request);
    }
    public function changeCurrency()
    {
       return $this->Settings->changeCurrency($this->request);
    }
    public function changeSmokingcost()
    {
       return $this->Settings->changeSmokingcost($this->request);
    }
    public function changeQuantity()
    {
       return $this->Settings->changeQuantity($this->request);
    }
    public function changeSmokingtime()
    {
       return $this->Settings->changeSmokingtime($this->request);
    }
    public function reset()
    {
       return $this->Settings->reset($this->request);
    }
    public function logout()
    {
       return $this->Settings->logout($this->request);
    }
    public function quiteReason()
    {
       return $this->ManagementService->quiteReason($this->request);
    }
    


}
                 