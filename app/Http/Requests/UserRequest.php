<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        switch (\Request::route()->getName()) {

        /** user password forgot */
            case 'api.users.otp.verify':
                return [
                    'id'=> 'required|exists:users,id',
                    'otp' => 'required|digits:4',
                    'password'=>'nullable',
                ];

        /** user password update */
            case 'api.users.password.update':
                return [
                    // 'current_password' => ['required', 
                    //     function ($attribute, $value, $fail) use($request) {
                    //     if (!\Hash::check($request->current_password,Auth::User()->password))return $fail(__('The current password is incorrect.'));
                    // }],
                    'security_question' => 'required', 
                    'new_password' => 'required|min:6|confirmed',
                    'id'=> 'required|exists:users,id',
                ];

        /** user password forgot */
            case 'api.users.password.forgot':
                return [
                    'mobile' => 'required|digits:10|exists:users,mobile',
                ];

        /** Resend otp */
            case 'api.users.otp.resend':
                return [
                    'mobile' => 'required|digits:10|exists:users,mobile',
                ];

        /** user register */
            case 'api.users.store':
                return [
                    // 'device_code'=> 'required|exists:devices,code',
                    'name' => 'required', 
                    'security_question' => 'required', 
                    'mobile' => 'required|digits:10|unique:users,mobile',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'required',                  
                    'fcm_token' => 'required',
                ];


        /** user profile update */
            case 'api.users.update':
                return [
                    'first_name' => 'nullable', 
                    'last_name' => 'nullable',  
                    'country_code' => 'nullable',   
                    'mobile' => 'nullable|digits:10',
                    'email' => 'nullable|string|email|max:255',
                    'fcm_token' => 'nullable',
                    'gender'=>'nullable',
                    'dob'=>'nullable',
                ];

        /** Location based service-provider index */
            case 'api.service-provider.by-location':
                return [
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

        /** Location based categories index */
            case 'api.service-provider.by-category':
                return [  
                    'category_id'=> 'required|exists:categories,id',
                    'latitude'=>'required',
                    'longitude'=>'required'
                ];
            /** Social media users */
            case 'api.auth.social_media_users':
                return [  
                    'social_media_id' => 'required',
                    // 'device_code'=> 'required|exists:devices,code',
                    'name' => 'required',   
                    'fcm_token' => 'required',   
                    'mobile' => 'nullable',
                    'email' => 'nullable',
                ];
               
        }
       
       
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
       $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'status'=>400,
            'errors'=>$errors
        ], 200));
    }
}