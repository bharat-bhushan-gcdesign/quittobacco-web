<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/home', 'HomeController@index')->name('home');



//tips 
Route::view('/privacy', 'privacypolicy');
Route::view('/terms', 'termsandcondition');

// Auth::routes();
// Route::get('/login', function () {
// 	if(!Auth::check())
// 	{
// 		Request::session()->put('url.intended',url()->previous());
//      	return view('login');
// 	}
//   	else
//   	{
//   	 	Request::session()->put('url.intended',url()->previous());
//   		return redirect('/');
//   	}
// })->name('login');

Route::any('/auth/secure', function () {
    if (Auth::user()->status!=1)
    {
    	Auth::logout();
        return 0;
    }
    else
        return 1;
});

Route::get('login', 'LoginController@login')->name('login');
Route::get('login/callback', 'LoginController@handleCallback');
Route::any('logout', 'LoginController@logout')->name('logout');
Route::any('/dashboard','DashboardController@dashboard');

Route::group(['middleware' => ['azure']], function () {
	Route::post('save-token','AdminloginController@saveToken')->name('save-token');
	Route::post('check-password','AdminloginController@checkPassword');

	Route::post('checklogin','AdminloginController@checklogin');
	Route::any('/forgotpassword','AdminloginController@ForgotPassword');
	Route::post('/forgotuserexist','AdminloginController@forgotuserexist');
	Route::any('/passwordconfrim','AdminloginController@passwordconfrim');
	Route::any('/updatepassword','AdminloginController@updatepassword');
	Route::any('/checktemplate','AdminloginController@checktemplate');
	Route::any('/home','DashboardController@home');

	Route::group(array('middleware' => 'auth','middleware' => 'prevent-back-history'), function() { //to check the authentication and allowing login  user only able  to other pages..
		// Route::any('/','DashboardController@dashboard')->name('dashboard');

		/* Admin Management */
		// Route::any('admin','AdminController@adminlist');
		// Route::get('admin/create','AdminController@addadmin');
		// Route::get('admin/edit/{id}','AdminController@editadmin');
		// Route::get('admin/view/{id}','AdminController@viewadmin');
		// Route::post('admin/saveadmin','AdminController@saveadmin');
		// Route::any('admin/deleteadmin/{id}','AdminController@deleteadmin');
		// Route::get('adminuserexist','AdminController@adminuserexist');
		// Route::post('admin/statusupdate','AdminController@statusupdate');

	/********************** Implemented by Jemima Starts ***************/ 

		/** Profession - what do you do*/ 

			Route::group(['prefix'=>'professions','as'=>'professions.'], function(){
		        Route::get('/', 'ProfessionController@index')->name('index');
				Route::get('create', 'ProfessionController@create')->name('create');
				Route::post('/', 'ProfessionController@store')->name('store');
				Route::post('check-exist', 'ProfessionController@checkExist')->name('exists');
				Route::post('update-status', 'ProfessionController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{profession}'], function(){
					Route::get('edit', 'ProfessionController@edit')->name('edit'); 
					Route::get('show', 'ProfessionController@show')->name('show'); 
					Route::post('update','ProfessionController@update')->name('update');
					Route::post('destroy', 'ProfessionController@destroy')->name('destroy');
		    	});
		    });


	    /** Carvings*/ 

			Route::group(['prefix'=>'carving-videos','as'=>'carving_videos.'], function(){
		        Route::get('/', 'CarvingVideoController@index')->name('index');
				Route::get('create', 'CarvingVideoController@create')->name('create');
				Route::post('/', 'CarvingVideoController@store')->name('store');
				Route::post('check-exist', 'CarvingVideoController@checkExist')->name('exists');
				Route::post('update-status', 'CarvingVideoController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{carving_video}'], function(){
					Route::get('edit', 'CarvingVideoController@edit')->name('edit'); 
					Route::get('show', 'CarvingVideoController@show')->name('show'); 
					Route::post('update','CarvingVideoController@update')->name('update');
					Route::post('destroy', 'CarvingVideoController@destroy')->name('destroy');
		    	});
		    });

	    /** Notification*/ 

		    Route::group(['prefix'=>'static-notifications','as'=>'static_notifications.'], function(){
				Route::get('/', 'StaticNotificationController@index')->name('index');
				Route::get('create', 'StaticNotificationController@create')->name('create');
		        Route::post('send', 'StaticNotificationController@send')->name('send');
		        Route::post('store', 'StaticNotificationController@store')->name('store');
		        Route::group(['prefix'=>'{static_notification}'], function(){
					Route::get('edit', 'StaticNotificationController@edit')->name('edit'); 
					Route::get('publish', 'StaticNotificationController@publish')->name('publish'); 
					Route::post('update','StaticNotificationController@update')->name('update');
					Route::post('destroy', 'StaticNotificationController@destroy')->name('destroy');
		    	});
		    });


	    Route::any('home/deleteimage/', 'CarvingVideoController@deleteimage');
	        
		/** Frequent Smoke - How often smoke*/ 

			Route::group(['prefix'=>'frequent-smokes','as'=>'frequent_smokes.'], function(){
		        Route::get('/', 'FrequentSmokeController@index')->name('index');
				Route::get('create', 'FrequentSmokeController@create')->name('create');
				Route::post('/', 'FrequentSmokeController@store')->name('store');
				Route::post('check-exist', 'FrequentSmokeController@checkExist')->name('exists');
				Route::post('update-status', 'FrequentSmokeController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{frequent_smoke}'], function(){
					Route::get('edit', 'FrequentSmokeController@edit')->name('edit'); 
					Route::get('show', 'FrequentSmokeController@show')->name('show'); 
					Route::post('update','FrequentSmokeController@update')->name('update');
					Route::post('destroy', 'FrequentSmokeController@destroy')->name('destroy');
		    	});
		    });

	    /** Content - CMS */ 

			Route::group(['prefix'=>'contents','as'=>'contents.'], function(){
			    Route::get('/', 'ContentController@index')->name('index');
				Route::get('create', 'ContentController@create')->name('create');
				Route::post('/', 'ContentController@store')->name('store');
				Route::post('check-exist', 'ContentController@checkExist')->name('exists');
				Route::post('check-null', 'ContentController@checkNull')->name('null');
				Route::post('update-status', 'ContentController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{content}'], function(){
					Route::get('edit', 'ContentController@edit')->name('edit'); 
					Route::get('show', 'ContentController@show')->name('show'); 
					Route::post('update','ContentController@update')->name('update');
					Route::post('destroy', 'ContentController@destroy')->name('destroy');
				});

			});

	    /** Cron Job - Cron For Notification */ 

			Route::group(['prefix'=>'cron-jobs','as'=>'cron_jobs.'], function(){
		        Route::get('/', 'CronJobController@index')->name('index');
				Route::get('create', 'CronJobController@create')->name('create');
				Route::post('/', 'CronJobController@store')->name('store');
				Route::post('check-exist', 'CronJobController@checkExist')->name('exists');
				Route::post('update-status', 'CronJobController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{cron_job}'], function(){
					Route::get('edit', 'CronJobController@edit')->name('edit'); 
					Route::get('show', 'CronJobController@show')->name('show'); 
					Route::post('update','CronJobController@update')->name('update');
					Route::post('destroy', 'CronJobController@destroy')->name('destroy');
		    	});

		    });

	    /** Currency */ 

			Route::group(['prefix'=>'currencies','as'=>'currencies.'], function(){
		        Route::get('/', 'CurrencyController@index')->name('index');
				Route::get('create', 'CurrencyController@create')->name('create');
				Route::post('/', 'CurrencyController@store')->name('store');
				Route::post('check-exist', 'CurrencyController@checkExist')->name('exists');
				Route::any('update-status', 'CurrencyController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{currency}'], function(){
					Route::get('edit', 'CurrencyController@edit')->name('edit'); 
					Route::get('show', 'CurrencyController@show')->name('show'); 
					Route::post('update','CurrencyController@update')->name('update');
					Route::post('destroy', 'CurrencyController@destroy')->name('destroy');
		    	});

		    });

	    /** Doing - What are you Doing */ 

			Route::group(['prefix'=>'doings','as'=>'doings.'], function(){
		        Route::get('/', 'DoingController@index')->name('index');
				Route::get('create', 'DoingController@create')->name('create');
				Route::post('/', 'DoingController@store')->name('store');
				Route::post('check-exist', 'DoingController@checkExist')->name('exists');
				Route::post('update-status', 'DoingController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{doing}'], function(){
					Route::get('edit', 'DoingController@edit')->name('edit'); 
					Route::get('show', 'DoingController@show')->name('show'); 
					Route::post('update','DoingController@update')->name('update');
					Route::post('destroy', 'DoingController@destroy')->name('destroy');
		    	});

		    });

	    /** Education  */ 

			Route::group(['prefix'=>'educations','as'=>'educations.'], function(){
		        Route::get('/', 'EducationController@index')->name('index');
				Route::get('create', 'EducationController@create')->name('create');
				Route::post('/', 'EducationController@store')->name('store');
				Route::post('check-exist', 'EducationController@checkExist')->name('exists');
				Route::post('update-status', 'EducationController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{education}'], function(){
					Route::get('edit', 'EducationController@edit')->name('edit'); 
					Route::get('show', 'EducationController@show')->name('show'); 
					Route::post('update','EducationController@update')->name('update');
					Route::post('destroy', 'EducationController@destroy')->name('destroy');
		    	});

		    });

	    /** Feedback */ 

			Route::group(['prefix'=>'feedback','as'=>'feedback.'], function(){
		        Route::get('/', 'FeedbackController@index')->name('index');
				// Route::get('create', 'FeedbackController@create')->name('create');
				// Route::post('/', 'FeedbackController@store')->name('store');
				// Route::post('check-exist', 'FeedbackController@checkExist')->name('exists');
				Route::post('update-status', 'FeedbackController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{feedback}'], function(){
					// Route::get('edit', 'FeedbackController@edit')->name('edit'); 
					Route::get('show', 'FeedbackController@show')->name('show'); 
					// Route::post('update','FeedbackController@update')->name('update');
					// Route::post('destroy', 'FeedbackController@destroy')->name('destroy');
		    	});

		    });

	    /** Feeling - How are you feeling */ 

			Route::group(['prefix'=>'feelings','as'=>'feelings.'], function(){
		        Route::get('/', 'FeelingController@index')->name('index');
				Route::get('create', 'FeelingController@create')->name('create');
				Route::post('/', 'FeelingController@store')->name('store');
				Route::post('check-exist', 'FeelingController@checkExist')->name('exists');
				Route::post('update-status', 'FeelingController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{feeling}'], function(){
					Route::get('edit', 'FeelingController@edit')->name('edit'); 
					Route::get('show', 'FeelingController@show')->name('show'); 
					Route::post('update','FeelingController@update')->name('update');
					Route::post('destroy', 'FeelingController@destroy')->name('destroy');
		    	});

		    });

	    /** First Smoke Timing - first smoke after wake up  */ 

			Route::group(['prefix'=>'first-smoke-timings','as'=>'first_smoke_timings.'], function(){
		        Route::get('/', 'FirstSmokeTimingController@index')->name('index');
				Route::get('create', 'FirstSmokeTimingController@create')->name('create');
				Route::post('/', 'FirstSmokeTimingController@store')->name('store');
				Route::post('check-exist', 'FirstSmokeTimingController@checkExist')->name('exists');
				Route::post('update-status', 'FirstSmokeTimingController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{first_smoke_timing}'], function(){
					Route::get('edit', 'FirstSmokeTimingController@edit')->name('edit'); 
					Route::get('show', 'FirstSmokeTimingController@show')->name('show'); 
					Route::post('update','FirstSmokeTimingController@update')->name('update');
					Route::post('destroy', 'FirstSmokeTimingController@destroy')->name('destroy');
		    	});

		    });

		    /** Quit Benefit -  Benefits of quit tobacco  */ 

			Route::group(['prefix'=>'quit-benefits','as'=>'quit_benefits.'], function(){
		        Route::get('/', 'QuitBenefitController@index')->name('index');
				Route::get('create', 'QuitBenefitController@create')->name('create');
				Route::post('/', 'QuitBenefitController@store')->name('store');
				Route::post('check-exist', 'QuitBenefitController@checkExist')->name('exists');
				Route::post('update-status', 'QuitBenefitController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{quit_benefit}'], function(){
					Route::get('edit', 'QuitBenefitController@edit')->name('edit'); 
					Route::get('show', 'QuitBenefitController@show')->name('show'); 
					Route::post('update','QuitBenefitController@update')->name('update');
					Route::post('destroy', 'QuitBenefitController@destroy')->name('destroy');
		    	});

		    });

	    /** Quit Reason -  Reason to quit tobacco  */ 

			Route::group(['prefix'=>'quit-reasons','as'=>'quit_reasons.'], function(){
		        Route::get('/', 'QuitReasonController@index')->name('index');
				Route::get('create', 'QuitReasonController@create')->name('create');
				Route::post('/', 'QuitReasonController@store')->name('store');
				Route::post('check-exist', 'QuitReasonController@checkExist')->name('exists');
				Route::post('update-status', 'QuitReasonController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{quit_reason}'], function(){
					Route::get('edit', 'QuitReasonController@edit')->name('edit'); 
					Route::get('show', 'QuitReasonController@show')->name('show'); 
					Route::post('update','QuitReasonController@update')->name('update');
					Route::post('destroy', 'QuitReasonController@destroy')->name('destroy');
		    	});

		    });

	 	/** Slider - App splash screen slider */ 

			Route::group(['prefix'=>'sliders','as'=>'sliders.'], function(){
		        Route::get('/', 'SliderController@index')->name('index');
				Route::get('create', 'SliderController@create')->name('create');
				Route::post('/', 'SliderController@store')->name('store');
				Route::post('check-exist', 'SliderController@checkExist')->name('exists');
				Route::post('update-status', 'SliderController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{slider}'], function(){
					Route::get('edit', 'SliderController@edit')->name('edit'); 
					Route::get('show', 'SliderController@show')->name('show'); 
					Route::post('update','SliderController@update')->name('update');
					Route::post('destroy', 'SliderController@destroy')->name('destroy');
		    	});

		    });

	    /** Subscription */ 
	    
			Route::group(['prefix'=>'subscriptions','as'=>'subscriptions.'], function(){
		        Route::get('/', 'SubscriptionController@index')->name('index');
				Route::get('create', 'SubscriptionController@create')->name('create');
				Route::post('/', 'SubscriptionController@store')->name('store');
				Route::post('check-exist', 'SubscriptionController@checkExist')->name('exists');
				Route::post('update-status', 'SubscriptionController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{subscription}'], function(){
					Route::get('edit', 'SubscriptionController@edit')->name('edit'); 
					Route::get('show', 'SubscriptionController@show')->name('show'); 
					Route::post('update','SubscriptionController@update')->name('update');
					Route::post('destroy', 'SubscriptionController@destroy')->name('destroy');
		    	});

		    });

		/** Tobacco  */ 

			Route::group(['prefix'=>'tobaccos','as'=>'tobaccos.'], function(){
		        Route::get('/', 'TobaccoController@index')->name('index');
				Route::get('create', 'TobaccoController@create')->name('create');
				Route::post('/', 'TobaccoController@store')->name('store');
				Route::post('check-exist', 'TobaccoController@checkExist')->name('exists');
				Route::post('update-status', 'TobaccoController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{tobacco}'], function(){
					Route::get('edit', 'TobaccoController@edit')->name('edit'); 
					Route::get('show', 'TobaccoController@show')->name('show'); 
					Route::post('update','TobaccoController@update')->name('update');
					Route::post('destroy', 'TobaccoController@destroy')->name('destroy');
		    	});

		    });

		/** Motivation  */ 

			Route::group(['prefix'=>'motivations','as'=>'motivations.'], function(){
		        Route::get('/', 'MotivationController@index')->name('index');
				Route::get('create', 'MotivationController@create')->name('create');
				Route::post('/', 'MotivationController@store')->name('store');
				Route::post('check-exist', 'MotivationController@checkExist')->name('exists');
				Route::post('update-status', 'MotivationController@updateStatus')->name('update-status');
				Route::post('publish-update-status', 'MotivationController@publishupdateStatus')->name('publish-update-status');
				Route::group(['prefix'=>'{motivation}'], function(){
					Route::get('edit', 'MotivationController@edit')->name('edit'); 
					Route::get('show', 'MotivationController@show')->name('show'); 
					Route::post('update','MotivationController@update')->name('update');
					Route::post('destroy', 'MotivationController@destroy')->name('destroy');
		    	});

		    });


		    	


	    /** Tobacco Product */ 

			Route::group(['prefix'=>'tobacco-products','as'=>'tobacco_products.'], function(){
		        Route::get('/', 'TobaccoProductController@index')->name('index');
				Route::get('create', 'TobaccoProductController@create')->name('create');
				Route::post('/', 'TobaccoProductController@store')->name('store');
				Route::post('check-exist', 'TobaccoProductController@checkExist')->name('exists');
				Route::post('update-status', 'TobaccoProductController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{tobacco_product}'], function(){
					Route::get('edit', 'TobaccoProductController@edit')->name('edit'); 
					Route::get('show', 'TobaccoProductController@show')->name('show'); 
					Route::post('update','TobaccoProductController@update')->name('update');
					Route::post('destroy', 'TobaccoProductController@destroy')->name('destroy');
		    	});

		    });

	    /** Use Reason - Why use tobacco  */ 

			Route::group(['prefix'=>'use-reasons','as'=>'use_reasons.'], function(){
		        Route::get('/', 'UseReasonController@index')->name('index');
				Route::get('create', 'UseReasonController@create')->name('create');
				Route::post('/', 'UseReasonController@store')->name('store');
				Route::post('check-exist', 'UseReasonController@checkExist')->name('exists');
				Route::post('update-status', 'UseReasonController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{use_reason}'], function(){
					Route::get('edit', 'UseReasonController@edit')->name('edit'); 
					Route::get('show', 'UseReasonController@show')->name('show'); 
					Route::post('update','UseReasonController@update')->name('update');
					Route::post('destroy', 'UseReasonController@destroy')->name('destroy');
		    	});

		    });

	   	/** User */ 

			Route::group(['prefix'=>'users','as'=>'users.'], function(){
		        Route::get('/', 'UserController@index')->name('index');
				Route::get('create', 'UserController@create')->name('create');
				Route::post('/', 'UserController@store')->name('store');
				Route::post('check-exist', 'UserController@checkExist')->name('exists');
				Route::post('update-status', 'UserController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{user}'], function(){
					Route::get('edit', 'UserController@edit')->name('edit'); 
					Route::get('show', 'UserController@show')->name('show'); 
					Route::post('update','UserController@update')->name('update');
					Route::post('destroy', 'UserController@destroy')->name('destroy');
		    	});

		    });

	    /** UserDetail */ 

			Route::group(['prefix'=>'user-details','as'=>'user_details.'], function(){
		        Route::get('/', 'UserController@index')->name('index');
				// Route::post('/', 'UserController@store')->name('store');
				// Route::post('check-exist', 'UserController@checkExist')->name('exists');
				Route::post('update-status', 'UserController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{user}'], function(){
					// Route::get('edit', 'UserController@edit')->name('edit'); 
					Route::get('show', 'UserController@show')->name('show'); 
					// Route::post('update','UserController@update')->name('update');
					Route::post('destroy', 'UserController@destroy')->name('destroy');
		    	});

		    });

	    /** With Whom - Whom you are with */ 

			Route::group(['prefix'=>'with-whoms','as'=>'with_whoms.'], function(){
		        Route::get('/', 'WithWhomController@index')->name('index');
				Route::get('create', 'WithWhomController@create')->name('create');
				Route::post('/', 'WithWhomController@store')->name('store');
				Route::post('check-exist', 'WithWhomController@checkExist')->name('exists');
				Route::post('update-status', 'WithWhomController@updateStatus')->name('update-status');
				Route::group(['prefix'=>'{with_whom}'], function(){
					Route::get('edit', 'WithWhomController@edit')->name('edit'); 
					Route::get('show', 'WithWhomController@show')->name('show'); 
					Route::post('update','WithWhomController@update')->name('update');
					Route::post('destroy', 'WithWhomController@destroy')->name('destroy');
		    	});
		    });

	/********************** Implemented by Jemima Ends ***************/ 

		/* 14/05-indhumathi*/
		Route::any('/newpassword','AdminloginController@passwordgeneration');

		Route::get('editprofile/{id}','DashboardController@editprofile');
		Route::post('saveprofile','DashboardController@saveprofile');
		Route::get('get-password','DashboardController@getPassword');
		Route::post('update-password','DashboardController@updatePassword');

});


	//cms
	// Route::get('cms', 'CmsController@list');
	// Route::get('cms/create', 'CmsController@create');
	// Route::post('cms/savecms', 'CmsController@savecms');
	// Route::any('cmsdestory/{id}','CmsController@cmsdestory');
	// Route::get('/cms/view/{id}', 'CmsController@view');
	// Route::get('/cms/edit/{id}', 'CmsController@edit');
	// Route::post('/cms/statusupdate', 'CmsController@statusupdate');

	//ReasonsToQuit
	// Route::get('reasonsToQuit', 'QuitReasonController@list');
	// Route::get('reasonsToQuit/create', 'QuitReasonController@create');
	// Route::post('reasonsToQuit/save', 'QuitReasonController@save');
	// Route::any('reasonsToQuitdestory/{id}','QuitReasonController@destory');
	// Route::get('/reasonsToQuit/view/{id}', 'QuitReasonController@view');
	// Route::get('/reasonsToQuit/edit/{id}', 'QuitReasonController@edit');
	// Route::post('/reasonsToQuit/statusupdate', 'QuitReasonController@statusupdate');
	// Route::post('/reasonsToQuit/check-Title', 'QuitReasonController@checktitle');


	//firstSmoke
	// Route::get('firstSmoke', 'MorningFirstSmokeController@list');
	// Route::get('firstSmoke/create', 'MorningFirstSmokeController@create');
	// Route::post('firstSmoke/save', 'MorningFirstSmokeController@save');
	// Route::any('firstSmokedestory/{id}','MorningFirstSmokeController@destory');
	// Route::get('/firstSmoke/view/{id}', 'MorningFirstSmokeController@view');
	// Route::get('/firstSmoke/edit/{id}', 'MorningFirstSmokeController@edit');
	// Route::post('/firstSmoke/statusupdate', 'MorningFirstSmokeController@statusupdate');
	// Route::post('/firstSmoke/check-Title', 'MorningFirstSmokeController@checktitle');

	//firstSmoke
	// Route::get('customMessage', 'CustomMessageController@list');
	// Route::get('customMessage/create', 'CustomMessageController@create');
	// Route::post('customMessage/save', 'CustomMessageController@save');
	// Route::any('customMessagedestory/{id}','CustomMessageController@destory');
	// Route::get('/customMessage/view/{id}', 'CustomMessageController@view');
	// Route::get('/customMessage/edit/{id}', 'CustomMessageController@edit');
	// Route::post('/customMessage/statusupdate', 'CustomMessageController@statusupdate');
	// Route::post('/customMessage/check-Title', 'CustomMessageController@checktitle');

	//user 
	// Route::get('users/create', 'UsersController@create');
	// Route::get('users', 'UsersController@user');
	// Route::post('/user/saveuser', 'UsersController@saveuser');
	// Route::any('savedestroy/{id}','UsersController@savedestroy');
	// Route::get('/user/edit/{id}', 'UsersController@edit');
	// Route::get('/user/view/{id}', 'UsersController@view');
	// Route::post('users/exportFile','UsersController@exportFile');
	// Route::post('users/exportexist','UsersController@exportexist');
	// Route::get('userexist','UsersController@userexist');
	// Route::post('users/statusupdate', 'UsersController@statusupdate');
	// Route::get('users/mobilecheck','UsersController@mobilecheck');
	// Route::get('users/phonecheck','UsersController@phonecheck');
	// Route::get('users/emailcheck','UsersController@emailcheck');
	// Route::get('/user/eventview/{id}', 'UsersController@eventview');
	
	//eventtype
	// Route::get('eventtype', 'EventtypeController@list');
	// Route::get('eventtype/create', 'EventtypeController@create');
	// Route::post('eventtype/saveretailtype','EventtypeController@saveretailtype');
	// Route::get('/eventtype/edit/{id}', 'EventtypeController@edit'); 
	// Route::get('/eventtype/view/{id}', 'EventtypeController@view');
	// Route::any('retaildestroy/{id}','EventtypeController@retaildestroy');
	// Route::post('eventtype/statusupdate','EventtypeController@statusupdate');
	// Route::post('/check-resttype', 'EventtypeController@checkresttype');

	//bankdetails
	// Route::get('bankdetails', 'bankdetailsController@list');
	// Route::get('/bankdetails/view/{id}', 'bankdetailsController@view');
	// Route::any('bankdetails/{id}','bankdetailsController@retaildestroy');
	
	//Events
	// Route::any('events', 'EventController@list');
	// Route::get('/events/view/{id}', 'EventController@view');
	// Route::any('/events/eventdata/{id}', 'EventController@eventreturnlist');
	// Route::any('/events/eventstatus/{id}', 'EventController@eventstatuslist');
	// Route::get('/events/donationlist/{id}', 'EventController@donationview');
	// Route::get('/events/donationview/{id}', 'EventController@donationviewlist');
	// Route::post('/events/statusupdate', 'EventController@statusupdate');
	// Route::get('/events/donwload', 'EventController@getDownload');
	// Route::any('eventdestroy/{id}','EventController@eventdestroy');

	//relationship 20.02.2020
	// Route::get('relationship', 'RelationshipController@list');
	// Route::get('relationship/create', 'RelationshipController@create');
	// Route::post('relationship/relationtype','RelationshipController@relationtype');
	// Route::get('/relationship/edit/{id}', 'RelationshipController@edit'); 
	// Route::get('/relationship/view/{id}', 'RelationshipController@view');
	// Route::post('/check-relation', 'RelationshipController@checkresttype');
	// Route::any('relationdestroy/{id}','RelationshipController@relationdestroy');
	// 	Route::post('relationship/statusupdate','RelationshipController@statusupdate');
	
	
	//faq
	// Route::get('faq', 'FaqController@list');
	// Route::get('faq/create', 'FaqController@create');
	// Route::post('faq/savefaq', 'FaqController@savefaq');
	// Route::any('faqdestory/{id}','FaqController@faqdestory');
	// Route::get('/faq/view/{id}', 'FaqController@view');
	// Route::get('/faq/edit/{id}', 'FaqController@edit');
	// Route::post('/faq/statusupdate', 'FaqController@statusupdate');

	//title
	// Route::get('title', 'TitleController@list');
	// Route::get('title/create', 'TitleController@create');
	// Route::post('title/savetitle','TitleController@savetitle');
	// Route::get('/title/edit/{id}', 'TitleController@edit'); 
	// Route::get('/title/view/{id}', 'TitleController@view');
	// Route::any('titledestroy/{id}','TitleController@titledestroy');
	// Route::post('title/statusupdate','TitleController@statusupdate');
	// Route::post('/check-Title', 'TitleController@checktitle');

	 //commission
	// Route::get('commission', 'CommissionController@list');
	// Route::get('commission/create', 'CommissionController@create');
	// Route::post('commission/saveeventpayment','CommissionController@saveeventpayment');
	// Route::get('/commission/edit/{id}', 'CommissionController@edit'); 
       
//        Route::get('/country', 'CountryController@index');
// Route::get('country/create', 'CountryController@create');
// Route::post('country/store', 'CountryController@store');
// Route::get('country/edit/{id}', 'CountryController@edit');
// Route::get('country/update/{id}', 'CountryController@update');
//  Route::post('countrydestroy/{id}','CountryController@destroy');
//  	Route::post('/country/statusupdate', 'CountryController@statusupdate');
//  	Route::post('/check_countryname', 'CountryController@checkname');

//  	Route::get('/state', 'StateController@index');
// Route::get('state/create', 'StateController@create');
// Route::post('state/store', 'StateController@store');
// Route::get('state/edit/{id}', 'StateController@edit');
// Route::get('state/update/{id}', 'StateController@update');
//  Route::post('statedestroy/{id}','StateController@destroy');
// 	Route::post('/state/statusupdate', 'StateController@statusupdate');
// Route::post('/check_statename', 'StateController@checkstatename');

// Route::get('/city', 'CityController@index');
// Route::get('city/create', 'CityController@create');
// Route::post('/', 'CityController@store')
//             ->name('city.store');
// Route::get('city/edit/{id}', 'CityController@edit');
// Route::get('city/update/{id}', 'CityController@update');
// Route::any('citydestroy/{id}','CityController@destroy');
// Route::get('city/statelist/{q?}', 'CityController@statelist');
// 	Route::post('/city/statusupdate', 'CityController@statusupdate');

// Route::any('check-cityname', 'CityController@cityname');



//Specialist
	// Route::get('/specialist', 'specialistController@list');
	// Route::get('specialist/create', 'specialistController@create');
	// Route::post('specialist/store', 'specialistController@store');
	// Route::get('specialist/edit/{id}', 'specialistController@edit'); 
	// Route::post('specialistdestroy/{id}','specialistController@destroy');
	// Route::post('specialist/statusupdate', 'specialistController@statusupdate');
	// Route::post('/check', 'specialistController@checkresttype');

	//genre
	// Route::get('/genre', 'GenreController@list');
	// Route::get('genre/create', 'GenreController@create');
	// Route::post('genre/store', 'GenreController@store');
	// Route::get('genre/edit/{id}', 'GenreController@edit'); 
	// Route::post('genredestroy/{id}','GenreController@destroy');
	// Route::post('genre/statusupdate', 'GenreController@statusupdate');
	// Route::post('/genrecheck', 'GenreController@checkresttype');

	//Education Vignesh 07-07-2020

	// Route::get('education', 'EducationController@list');
	// Route::get('education/create', 'EducationController@create');
	// Route::post('education/savetitle','EducationController@savetitle');
	// Route::get('/education/edit/{id}', 'EducationController@edit'); 
	// Route::get('/education/view/{id}', 'EducationController@view');
	// Route::any('education/destroy/{id}','EducationController@titledestroy');
	// Route::post('education/statusupdate','EducationController@statusupdate');
	// Route::post('/education/check-Title', 'EducationController@checktitle');

	//Tobacco Vignesh 07-07-2020

	// Route::get('tobacco', 'TobaccoController@list');
	// Route::get('tobacco/create', 'TobaccoController@create');
	// Route::post('tobacco/savetitle','TobaccoController@savetitle');
	// Route::get('/tobacco/edit/{id}', 'TobaccoController@edit'); 
	// Route::get('/tobacco/view/{id}', 'TobaccoController@view');
	// Route::any('tobacco/destroy/{id}','TobaccoController@titledestroy');
	// Route::post('tobacco/statusupdate','TobaccoController@statusupdate');
	Route::post('/tobacco/check-Title', 'TobaccoController@checktitle');

	//Tobacco Management Vignesh 07-07-2020

	// Route::get('tobacco_management', 'TobaccoManagementController@list');
	// Route::get('tobacco_management/create', 'TobaccoManagementController@create');
	// Route::post('tobacco_management/savetitle','TobaccoManagementController@savetitle');
	// Route::get('/tobacco_management/edit/{id}', 'TobaccoManagementController@edit'); 
	// Route::get('/tobacco_management/view/{id}', 'TobaccoManagementController@view');
	// Route::any('tobacco_management/destroy/{id}','TobaccoManagementController@titledestroy');
	// Route::post('tobacco_management/statusupdate','TobaccoManagementController@statusupdate');
	// Route::post('/check-Title', 'TobaccoManagementController@checktitle');

	//Static Page Vignesh 07-07-2020

	// Route::get('static_page', 'StaticPageController@list');
	// Route::get('static_page/create', 'StaticPageController@create');
	// Route::post('static_page/save', 'StaticPageController@save');
	// Route::any('static_page/destory/{id}','StaticPageController@destory');
	// Route::get('/static_page/view/{id}', 'StaticPageController@view');
	// Route::get('/static_page/edit/{id}', 'StaticPageController@edit');
	// Route::post('/static_page/statusupdate', 'StaticPageController@statusupdate');
	// Route::post('/static_page/check-Title', 'StaticPageController@checktitle');


	//Subscription Management Vignesh 25-07-2020

	// Route::get('subscription_mangement', 'SubscriptionController@list');
	// Route::get('subscription_mangement/create', 'SubscriptionController@create');
	// Route::post('subscription_mangement/save', 'SubscriptionController@save');
	// Route::any('subscription_mangement/destory/{id}','SubscriptionController@destory');
	// Route::get('/subscription_mangement/view/{id}', 'SubscriptionController@view');
	// Route::get('/subscription_mangement/edit/{id}', 'SubscriptionController@edit');
	// Route::post('/subscription_mangement/statusupdate', 'SubscriptionController@statusupdate'); 
	// Route::post('/subscription_mangement/check-Title', 'SubscriptionController@checktitle');

	//Subscription Management Vignesh 25-07-2020

	// Route::get('task_management', 'TaskController@list');
	// Route::get('task_management/create', 'TaskController@create');
	// Route::post('task_management/save', 'TaskController@save');
	// Route::any('task_management/destory/{id}','TaskController@destory');
	// Route::get('/task_management/view/{id}', 'TaskController@view');
	// Route::get('/task_management/edit/{id}', 'TaskController@edit');
	// Route::post('/task_management/statusupdate', 'TaskController@statusupdate');
	// Route::post('/task_management/check-Title', 'TaskController@checktitle');

	//Feedback Vignesh 25-07-2020

	// Route::get('feedback', 'FeedbackController@list');
	// Route::get('feedback/create', 'FeedbackController@create');
	// Route::post('feedback/save', 'FeedbackController@save');
	// Route::any('feedback/destory/{id}','FeedbackController@destory');
	// Route::get('/feedback/view/{id}', 'FeedbackController@view');
	// Route::get('/feedback/edit/{id}', 'FeedbackController@edit');
	// Route::post('/feedback/statusupdate', 'FeedbackController@statusupdate');
 

	// Route::get('qa', 'QAController@list');
	// Route::get('qa/create', 'QAController@create');  
	// Route::post('qa/save', 'QAController@save');
	// Route::any('qadestory/{id}','QAController@destory');
	// Route::get('/qa/view/{id}', 'QAController@view');
	// Route::get('/qa/edit/{id}', 'QAController@edit');
	// Route::post('/qa/statusupdate', 'QAController@statusupdate');

	//-----------Report------------------------//
	// Route::get('report', 'ReportController@list');
	// Route::post('get_report', 'ReportController@export_user');
	// Route::get('subscription', 'ReportController@subscription_list');
	// Route::post('get_export_subscription', 'ReportController@export_subscription');

	//Motivational Vignesh 21-07-2020

	// Route::get('motivational', 'MotivationalController@list');
	// Route::get('motivational/create', 'MotivationalController@create');
	// Route::post('motivational/save', 'MotivationalController@save');
	// Route::any('motivational/destory/{id}','MotivationalController@destory');
	// Route::get('motivational/view/{id}', 'MotivationalController@view');
	// Route::get('motivational/edit/{id}', 'MotivationalController@edit');
	// Route::post('motivational/statusupdate', 'MotivationalController@statusupdate');
	// Route::any('deleteVedio/', 'MotivationalController@deletevedio');
	// Route::post('/motivational/check-Title', 'MotivationalController@checktitle');

});



// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
