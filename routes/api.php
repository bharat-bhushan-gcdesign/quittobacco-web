<?php

use Illuminate\Http\Request;




// Route::post('login', 'ApiController@login');
// Route::post('register', 'ApiController@register');
// Route::post('changePassword', 'ApiController@changePassword');

Route::get('unauthorized', function() {
    return response()->json([
        'status' => 401,
        'message' => 'Unauthorized'
    ], 200);
})->name('jwt.unauthorized');

/** Auth */ 
    Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout')->middleware('auth:api');
         Route::post('social-media-users', 'AuthController@social_media_users')->name('social_media_users');
    });
    
/** Before Login **/

	Route::group(['prefix'=>'users','as'=>'users.'], function(){

    /** Users - store, update, profile */ /** Jemima */
        Route::post('store', 'UserController@store')->name('store');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::post('update', 'UserController@update')->name('update');
            Route::post('show', 'UserController@show')->name('show');
        });

    /** Otp */ 
        Route::group(['prefix'=>'otp','as'=>'otp.'], function(){
            Route::post('resend', 'UserController@resendOtp')->name('resend');
            Route::post('verify', 'UserController@verifyOtp')->name('verify');
        });

    /** Password */ 
        Route::group(['prefix'=>'password','as'=>'password.'], function(){
            Route::post('forgot', 'UserController@forgotPassword')->name('forgot');
            Route::post('update', 'UserController@updatePassword')->name('update');
        });
    });


  //   /** Social Media Register/Login */ 
		// Route::group(['prefix'=>'social-media-users'], function(){
  //           Route::post('/', 'SocialMediaController@login')->name('auth.social_media_users');
  //       });

    /** Content - CMS/Static page */ 
        Route::group(['prefix'=>'contents','as'=>'contents.'], function(){
            Route::post('about-us', 'ContentController@show')->name('about_us');
            Route::post('difficult-situations', 'ContentController@show')->name('difficult_situation');
            Route::post('nicotine-replacement', 'ContentController@show')->name('nicotine_replacement');
            Route::post('privacy-policy', 'ContentController@show')->name('privacy_policy');
            Route::post('terms-conditions', 'ContentController@show')->name('terms_conditions');
            Route::post('references', 'ContentController@show')->name('references');
            Route::post('welcome', 'ContentController@show')->name('welcome');
            Route::post('disclaimer', 'ContentController@show')->name('disclaimer');
            Route::post('your-progress', 'ContentController@show')->name('your_progress');

        });

    // /** Slider - Splash Screen slider */ 
        Route::group(['prefix'=>'sliders','as'=>'sliders.'], function(){
            Route::post('/', 'SliderController@index')->name('index');
        });
        Route::group(['prefix'=>'tobacco-infections','as'=>'tobacco-infections.'], function(){
            Route::post('/', 'SliderController@tobaccoinfections')->name('index');
        });

        Route::group(['prefix'=>'countries','as'=>'countries.'], function(){
            Route::post('/', 'CountryController@index')->name('index');
        });

    
/** After Login **/
 
	Route::group(['middleware' => ['auth:api']], function () {

    Route::post('dashboard', 'ApiController@dashboard')->name('dashboard');



 //    /** Category**/ 
        Route::group(['prefix'=>'categories','as'=>'categories.'], function(){
            Route::post('index', 'CategoryController@index')->name('index');
            Route::post('{category}/show', 'CategoryController@show')->name('show');
        });

        /** Redet setting api**/ 
        Route::group(['prefix'=>'settings','as'=>'settings.'], function(){
            Route::post('reset', 'SettingController@reset')->name('reset');
        });

    /** Craving */ 
        Route::group(['prefix'=>'cravings','as'=>'cravings.'], function(){
            Route::post('store', 'CravingController@store')->name('store');
            Route::post('graph', 'CravingController@trigger')->name('graph');
            Route::post('list', 'CravingController@index')->name('list');
            Route::post('trigger', 'CravingController@trigger')->name('trigger');
        });

    /** Currency */  
        Route::group(['prefix'=>'currencies','as'=>'currencies.'], function(){
            Route::post('/', 'CurrencyController@index')->name('index');
        });

	/** Diary */  
        Route::group(['prefix'=>'diaries','as'=>'diaries.'], function(){
            Route::post('index', 'DiaryController@index')->name('index');
            Route::post('store', 'DiaryController@store')->name('store');
            Route::post('show', 'DiaryController@show')->name('show');

            Route::group(['prefix'=>'{diary}'], function(){
                Route::post('destroy', 'DiaryController@destroy')->name('destroy');
            });
        });

        Route::group(['prefix'=>'user-motivations','as'=>'user-motivations.'], function(){
            Route::post('index', 'UserMotivationController@index')->name('index');
            Route::post('store', 'UserMotivationController@store')->name('store');
            Route::group(['prefix'=>'{user_motivation}'], function(){
            Route::post('update', 'UserMotivationController@update')->name('update');
            Route::post('destroy', 'UserMotivationController@destroy')->name('destroy');
            Route::post('default', 'UserMotivationController@default')->name('default');
        });
        });

    /** Doing */  
        Route::group(['prefix'=>'doings','as'=>'doings.'], function(){
            Route::post('/', 'DoingController@index')->name('index');
        });

    /** Education */  
        Route::group(['prefix'=>'educations','as'=>'educations.'], function(){
            Route::post('/', 'EducationController@index')->name('index');
        });

    /** Feedback */  
        Route::group(['prefix'=>'feedback','as'=>'feedback.'], function(){
            Route::post('/', 'FeedbackController@store')->name('store');
        });

    /** Feeling - what do you feel */  
        Route::group(['prefix'=>'feelings','as'=>'feelings.'], function(){
            Route::post('/', 'FeelingController@index')->name('index');
        });

    /** FirstSmokeTiming - when do you need your first smoke @ morning */  
        Route::group(['prefix'=>'first-smoke-timings','as'=>'first_smoke_timings.'], function(){
            Route::post('/', 'FirstSmokeTimingController@index')->name('index');
        });

    /** Frequent Smoke - how often you smoke */  
        Route::group(['prefix'=>'frequent-smokes','as'=>'frequent_smokes.'], function(){
            Route::post('/', 'FrequentSmokeController@index')->name('index');
        });

	/** Health Improvement */  
        Route::group(['prefix'=>'health-improvements','as'=>'health_improvements.'], function(){
            Route::post('/', 'HealthImprovementController@index')->name('index');
        });

 	/** Member */  
        Route::group(['prefix'=>'members','as'=>'members.'], function(){
            Route::post('index', 'MemberController@index')->name('index');
            Route::post('store', 'MemberController@store')->name('store');
            
        	Route::group(['prefix'=>'{member}'], function(){
                 Route::post('show', 'MemberController@show')->name('show');
            	Route::post('update', 'MemberController@update')->name('update');
            	Route::post('destroy', 'MemberController@destroy')->name('destroy');
        	});
        });

    /** Mission */  
        Route::group(['prefix'=>'missions','as'=>'missions.'], function(){
            Route::post('index', 'MissionController@index')->name('index');
            Route::post('store', 'MissionController@store')->name('store');
        });

    /** Motivation */  
        Route::group(['prefix'=>'motivations','as'=>'motivations.'], function(){
            Route::post('store', 'MotivationController@store')->name('store');
        	Route::group(['prefix'=>'{motivation}'], function(){
            	Route::post('update', 'MotivationController@update')->name('update');
        	});
        });

 //    /** Notification */  
        Route::group(['prefix'=>'notifications','as'=>'notifications.'], function(){
            Route::post('index', 'NotificationController@index')->name('index');
            Route::post('users', 'NotificationController@acheievement')->name('users');
            Route::post('general', 'NotificationController@general')->name('general');
            Route::post('diary', 'NotificationController@diary_remainder')->name('diary_remainder');
            Route::post('mission', 'NotificationController@mission_remainder')->name('mission_remainder');

            Route::post('store', 'NotificationController@store')->name('store');
            Route::post('update', 'NotificationController@update')->name('update');
            Route::post('show', 'NotificationController@show')->name('show');
            Route::post('/create', 'NotificationController@create')->name('create');
            Route::post('{user_notification}', 'NotificationController@seen_statusUpdate')->name('create');



        });

    /** Plan */  
        Route::group(['prefix'=>'plans','as'=>'plans.'], function(){
            Route::post('index', 'PlanController@index')->name('index');
            Route::post('store', 'PlanController@store')->name('store');
        });

    /** personal quit plan */  
        Route::group(['prefix'=>'user-quit-plan','as'=>'user_quit_plan.'], function(){
            Route::post('index', 'UserQuitPlanController@index')->name('index');
            Route::post('store', 'UserQuitPlanController@store')->name('store');
        });


	/** Profession - what do you do*/  
        Route::group(['prefix'=>'professions','as'=>'professions.'], function(){
            Route::post('/', 'ProfessionController@index')->name('index');
        });

    /** QuitBenefit - Benefits of quiting Tobacco */  
        Route::group(['prefix'=>'quit-benefits','as'=>'quit_benefits.'], function(){
            Route::post('/', 'QuitBenefitController@index')->name('index');
        });

    /** QuitReason - reason to quit */  
        Route::group(['prefix'=>'quit-reasons','as'=>'quit_reasons.'], function(){
            Route::post('/', 'QuitReasonController@index')->name('index');
        });

    /** Saving */ 
        Route::group(['prefix'=>'savings','as'=>'savings.'], function(){
            Route::post('/', 'SavingController@index')->name('index');
        });

    /** Tobacco - type of tobacco */  
        Route::group(['prefix'=>'tobaccos','as'=>'tobaccos.'], function(){
            Route::post('/', 'TobaccoController@index')->name('index');
        });

    // * Carvings-video - Carvings-cvideo
        Route::group(['prefix'=>'carving-videos','as'=>'carving_videos.'], function(){
             Route::post('/', 'CarvingVideoController@index')->name('index');
        });

    /** Tobacco - type of tobacco products*/  
        Route::group(['prefix'=>'tobacco-products','as'=>'tobacco-products.'], function(){
             Route::post('/', 'TobaccoProductController@index')->name('index');
        });

    // * Achieve
        Route::group(['prefix'=>'achievements','as'=>'achievements.'], function(){
             Route::post('/store', 'AchievementController@store')->name('store');
             Route::post('/show', 'AchievementController@show')->name('show');

        });
    
        
    //* User Information - Information about you  
        Route::group(['prefix'=>'user-informations','as'=>'user_informations.'], function(){
            Route::post('show', 'UserInformationController@show')->name('show');
            Route::post('store', 'UserInformationController@store')->name('store');
            Route::post('update', 'UserInformationController@update')->name('update');
        });

    // * UseReason - why do you use tobacco   
        Route::group(['prefix'=>'use-reasons','as'=>'use_reasons.'], function(){
            Route::post('/', 'UseReasonController@index')->name('index');
        });


    //* WithWhom - Whom you are with   
        Route::group(['prefix'=>'with-whom','as'=>'with_whom.'], function(){
            Route::post('/', 'WithWhomController@index')->name('index');
        });


    //* WishList   
        Route::group(['prefix'=>'wish-lists','as'=>'wish_lists.'], function(){
            Route::post('index', 'WishListController@index')->name('index');
            Route::post('store', 'WishListController@store')->name('store');

        	Route::group(['prefix'=>'{wish_list}'], function(){
                Route::post('show', 'WishListController@show')->name('show');
            	Route::post('update', 'WishListController@update')->name('update');
        	});
        });

    });

