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

/*Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

*/
//tips 

Auth::routes();
Route::get('/login', function () {
	if(!Auth::check())
	{
		Request::session()->put('url.intended',url()->previous());
     	return view('login');
	}
  	else
  	{
  	 	Request::session()->put('url.intended',url()->previous());
  		return redirect('/');
  	}
})->name('login');

Route::any('/auth/secure', function () {
    if (Auth::user()->status!=1)
    {
    	Auth::logout();
        return 0;
    }
    else
        return 1;
});

Route::post('checklogin','AdminloginController@checklogin');
Route::any('/forgotpassword','AdminloginController@ForgotPassword');
Route::post('/forgotuserexist','AdminloginController@forgotuserexist');
Route::any('/passwordconfrim','AdminloginController@passwordconfrim');
Route::any('/updatepassword','AdminloginController@updatepassword');
Route::any('/checktemplate','AdminloginController@checktemplate');

Route::group(array('middleware' => 'auth'), function() { //to check the authentication and allowing login  user only able  to other pages..
	Route::any('/','DashboardController@index');

	/* Admin Management */
	Route::any('admin','AdminController@adminlist');
	Route::get('admin/create','AdminController@addadmin');
	Route::get('admin/edit/{id}','AdminController@editadmin');
	Route::get('admin/view/{id}','AdminController@viewadmin');
	Route::post('admin/saveadmin','AdminController@saveadmin');
	Route::any('admin/deleteadmin/{id}','AdminController@deleteadmin');
	Route::get('adminuserexist','AdminController@adminuserexist');
	Route::post('admin/statusupdate','AdminController@statusupdate');

	Route::get('editprofile/{id}','DashboardController@editprofile');
	Route::post('saveprofile','DashboardController@saveprofile');
	Route::any('changepassword','DashboardController@updatepassword');

	/* Admin Management */
	Route::get('subadmin','SubadminController@subadminlist');
	Route::get('subadmin/create','SubadminController@addsubadmin');
	Route::get('subadmin/edit/{id}','SubadminController@editsubadmin');
	Route::get('subadmin/view/{id}','SubadminController@viewsubadmin');
	Route::post('subadmin/savesubadmin','SubadminController@savesubadmin');
	Route::any('subadmin/deleteadmin/{id}','SubadminController@deletesubadmin');
	Route::get('subadminuserexist','SubadminController@subadminuserexist');
	Route::post('subadmin/statusupdate','SubadminController@statusupdate');


	/* Service Type Management */
	Route::get('servicetype','ServicetypeController@servicetypelist');
	Route::get('servicetype/create','ServicetypeController@addservicetype');
	Route::get('servicetype/edit/{id}','ServicetypeController@editservicetype');
	Route::get('servicetype/view/{id}','ServicetypeController@viewservicetype');
	Route::post('servicetype/saveservicetype','ServicetypeController@saveservicetype');
	Route::any('servicetype/deleteservicetype/{id}','ServicetypeController@deleteservicetype');
	Route::get('servicetypeexist','ServicetypeController@servicetypeexist');
	Route::post('servicetype/statusupdate','ServicetypeController@statusupdate');

	/* Food Type Management */
	Route::get('foodtype','FoodtypeController@foodtypelist');
	Route::get('foodtype/create','FoodtypeController@addfoodtype');
	Route::get('foodtype/edit/{id}','FoodtypeController@editfoodtype');
	Route::get('foodtype/view/{id}','FoodtypeController@viewfoodtype');
	Route::post('foodtype/savefoodtype','FoodtypeController@savefoodtype');
	Route::any('foodtype/deletefoodtype/{id}','FoodtypeController@deletefoodtype');
	Route::get('foodtypeexist','FoodtypeController@foodtypeexist');
	Route::post('foodtype/statusupdate','FoodtypeController@statusupdate');

	/* Facilities Management */
	Route::get('facility','FacilityController@facilitylist');
	Route::get('facility/create','FacilityController@addfacility');
	Route::get('facility/edit/{id}','FacilityController@editfacility');
	Route::get('facility/view/{id}','FacilityController@viewfacility');
	Route::post('facility/savefacility','FacilityController@savefacility');
	Route::any('facility/deletefacility/{id}','FacilityController@deletefacility');
	Route::get('facilityexist','FacilityController@facilityexist');
	Route::post('facility/statusupdate','FacilityController@statusupdate');

	/* Terminal Management */
	Route::get('terminal','TerminalController@terminallist');
	Route::get('terminal/create','TerminalController@addterminal');
	Route::get('terminal/edit/{id}','TerminalController@editterminal');
	Route::get('terminal/view/{id}','TerminalController@viewterminal');
	Route::post('terminal/saveterminal','TerminalController@saveterminal');
	Route::any('terminal/deleteterminal/{id}','TerminalController@deleteterminal');
	Route::get('terminalexist','TerminalController@terminalexist');
	Route::post('terminal/statusupdate','TerminalController@statusupdate');



	/* Airport Management */
	Route::get('airport','AirportController@airportlist');
	Route::get('airport/create','AirportController@addairport');
	Route::get('airport/edit/{id}','AirportController@editairport');
	Route::get('airport/view/{id}','AirportController@viewairport');
	Route::post('airport/saveairport','AirportController@saveairport');
	Route::any('airport/deleteairport/{id}','AirportController@deleteairport');
	Route::get('airportexist','AirportController@airportexist');
	Route::get('get_state_list','AirportController@getStateList');
	Route::get('get_city_list','AirportController@getCityList');
	Route::get('airport/addfloormap/{id}','AirportController@addfloormap');
	Route::any('airport/savefloorplan','AirportController@savefloorplan');
	Route::post('airport/exportFile','AirportController@exportFile');
	Route::post('airport/exportexist','AirportController@exportexist');
	Route::post('airport/statusupdate','AirportController@statusupdate');

	Route::get('airport/aupload','AirportController@aupload');
	Route::post('airport/uploadcsv','AirportController@uploadcsv');
	Route::get('/download/{filename}', 'AirportController@download');

	/* Lounge Management */
	Route::get('lounge','LoungeController@loungelist');
	Route::get('lounge/create','LoungeController@addlounge');
	Route::get('lounge/edit/{id}','LoungeController@editlounge');
	Route::get('lounge/view/{id}','LoungeController@viewlounge');
	Route::post('lounge/savelounge','LoungeController@savelounge');
	Route::any('lounge/deletelounge/{id}','LoungeController@deletelounge');
	Route::post('lounge/loungeexist','LoungeController@loungeexist');
	Route::get('get_terminal','LoungeController@getTerminal');
	Route::any('lounge/deleteimage','LoungeController@deleteimage');
	Route::post('lounge/exportFile','LoungeController@exportFile');
	Route::post('lounge/exportexist','LoungeController@exportexist');
	Route::post('lounge/statusupdate','LoungeController@statusupdate');

	 	Route::get('lounge/lupload','LoungeController@lupload');
	 	Route::post('lounge/uploadcsv','LoungeController@uploadcsv');
	   
	//restaurants
Route::get('restaurants', 'RestaurantController@list');
Route::get('addrestaurants', 'RestaurantController@add_restaurant');
Route::any('getterminal/{q?}', 'RestaurantController@getterminal');

Route::post('/restaurant/add', 'RestaurantController@saverestaurant');
Route::get('/restaurants/edit/{id}', 'RestaurantController@edit');
Route::any('/deleteimage', 'RestaurantController@deleteimage');
Route::any('restaurant/deleteimage', 'RestaurantController@deleteimage');
Route::get('/restaurants/view/{id}', 'RestaurantController@view');
Route::any('restdestroy/{id}','RestaurantController@restdestroy');
Route::post('restaurant/exportFile','RestaurantController@exportFile');
Route::post('restaurant/exportexist','RestaurantController@exportexist');
Route::post('restaurant/statusupdate','RestaurantController@statusupdate');

//13.05.2019

	Route::get('restaurants/aupload','RestaurantController@aupload');
	Route::post('restaurants/uploadcsv','RestaurantController@uploadcsv');
	Route::get('/download/{filename}', 'RestaurantController@download');

//cms
Route::get('cms', 'CmsController@list');
Route::get('cms/create', 'CmsController@create');
Route::post('cms/savecms', 'CmsController@savecms');
Route::any('cmsdestory/{id}','CmsController@cmsdestory');
Route::get('/cms/view/{id}', 'CmsController@view');
Route::get('/cms/edit/{id}', 'CmsController@edit');
Route::post('/cms/statusupdate', 'CmsController@statusupdate');


//News
Route::get('news', 'NewsController@list');
Route::get('news/create', 'NewsController@create');
Route::post('news/savenews', 'NewsController@savenews');
Route::any('newsdestory/{id}','NewsController@newsdestroy');
Route::get('/news/view/{id}', 'NewsController@view');
Route::get('/news/edit/{id}', 'NewsController@edit');
Route::post('news/statusupdate', 'NewsController@statusupdate');

//advertisement
Route::get('advertisement', 'AdvertiseController@list');
Route::get('advertise/create', 'AdvertiseController@create');
Route::post('advertise/savead', 'AdvertiseController@savead');
Route::any('addestroy/{id}','AdvertiseController@addestroy');
Route::get('/advertise/view/{id}', 'AdvertiseController@view');
Route::get('/advertise/edit/{id}', 'AdvertiseController@edit');
Route::post('advertisement/statusupdate', 'AdvertiseController@statusupdate');

//offer
Route::get('offer', 'OfferController@list');
Route::get('offer/create', 'OfferController@create');
Route::post('offer/saveoffer', 'OfferController@saveoffer');
Route::get('/offer/edit/{id}', 'OfferController@edit');
Route::get('/offer/view/{id}', 'OfferController@view');
Route::any('offerdestroy/{id}','OfferController@offerdestroy');
Route::post('offer/statusupdate', 'OfferController@statusupdate');
/*Route::post('offer/exportFile','OfferController@exportFile');
Route::post('offer/exportexist','OfferController@exportexist');*/

//currency
Route::get('currency', 'CurrencyController@currency');
Route::get('currency/create', 'CurrencyController@create');
Route::post('/currency/save', 'CurrencyController@savecurrency');
Route::get('/currency/edit/{id}', 'CurrencyController@edit');
Route::get('/currency/view/{id}', 'CurrencyController@view');
Route::any('currencydestroy/{id}','CurrencyController@destroy');
Route::post('currency/statusupdate', 'CurrencyController@statusupdate');
	Route::get('currencyexist','CurrencyController@currencyexist');

Route::get('/country', 'CountryController@index');
Route::get('countrycreate', 'CountryController@create');
Route::post('/country/savecountry', 'CountryController@savecountry');
Route::get('/countryedit/{id}', 'CountryController@edit');
Route::get('countryview/{id}', 'CountryController@view');
Route::any('countrydestroy/{id}','CountryController@delete');
Route::any('country/listing/{q?}','CountryController@listing');
Route::post('country/statusupdate', 'CountryController@statusupdate');

	Route::get('countryexist','CountryController@countryexist');



//state management
Route::get('/state', 'StateController@index');
Route::get('statecreate', 'StateController@create');
Route::post('/state/savestate', 'StateController@savestate');
Route::get('/stateedit/{id}', 'StateController@edit');
Route::get('/stateview/{id}', 'StateController@view');
Route::any('statedestroy/{id}','StateController@delete');
Route::any('state/listing/{q?}','StateController@listing');
Route::post('state/statusupdate', 'StateController@statusupdate');

Route::any('stateexist','StateController@stateexist');


//city management
Route::get('/city', 'CityController@index');
Route::get('citycreate', 'CityController@create');
Route::post('/city/savecity', 'CityController@savecity');
Route::get('/cityedit/{id}', 'CityController@edit');
Route::get('/cityview/{id}', 'CityController@view');
Route::any('citydestroy/{id}','CityController@delete');
Route::any('city/listing/{q?}','CityController@listing');
Route::get('getstatelist/{q?}','CityController@getstatelist');
Route::post('city/statusupdate', 'CityController@statusupdate');

Route::any('cityexist','CityController@cityexist');


//offertype
Route::get('offertype', 'OffertypeController@list');
Route::get('offertype/create', 'OffertypeController@create');
Route::post('offertype/saveoffertype', 'OffertypeController@saveoffertype');
Route::get('/offertype/edit/{id}', 'OffertypeController@edit');
Route::get('/offertype/view/{id}', 'OffertypeController@view');
Route::any('offertypedestroy/{id}','OffertypeController@offertypedestroy');
Route::post('offertype/statusupdate', 'OffertypeController@statusupdate');



//user 
Route::get('users/create', 'UsersController@create');
Route::get('users', 'UsersController@user');
Route::post('/user/saveuser', 'UsersController@saveuser');
Route::any('savedestroy/{id}','UsersController@savedestroy');
Route::get('/user/edit/{id}', 'UsersController@edit');
Route::get('/user/view/{id}', 'UsersController@view');
Route::post('users/exportFile','UsersController@exportFile');
Route::post('users/exportexist','UsersController@exportexist');
Route::get('userexist','UsersController@userexist');
Route::post('users/statusupdate', 'UsersController@statusupdate');


//tips management

Route::get('tips', 'TipsController@list');
Route::get('tips/create', 'TipsController@create');
Route::post('/tips/savetips', 'TipsController@savetips');
Route::get('/tips/edit/{id}', 'TipsController@edit');
Route::get('/tips/view/{id}', 'TipsController@view');
Route::any('tipsdestory/{id}','TipsController@tipsdestory');
Route::post('tips/statusupdate', 'TipsController@statusupdate');


//Restaurant Menu category
Route::get('restaurantmenucategory','RestaurantmenucategoryController@restaurantmenucategorylist');
Route::get('restaurantmenucategory/create','RestaurantmenucategoryController@addrestaurantmenucategory');
Route::get('restaurantmenucategory/edit/{id}','RestaurantmenucategoryController@editrestaurantmenucategory');
Route::get('restaurantmenucategory/view/{id}','RestaurantmenucategoryController@viewrestaurantmenucategory');
Route::post('restaurantmenucategory/saverestaurantmenucategory','RestaurantmenucategoryController@saverestaurantmenucategory');
Route::any('restaurantmenucategory/deleterestaurantmenucategory/{id}','RestaurantmenucategoryController@deleterestaurantmenucategory');
Route::get('restaurantmenucategoryexist','RestaurantmenucategoryController@restaurantmenucategoryexist');
Route::post('restaurantmenucategory/statusupdate', 'RestaurantmenucategoryController@statusupdate');


//Restaurant Menu
Route::get('restaurantmenu','RestaurantmenuController@restaurantmenulist');
Route::get('restaurantmenu/create','RestaurantmenuController@addrestaurantmenu');
Route::get('restaurantmenu/create/{id}','RestaurantmenuController@addrestaurantmenu');
Route::get('restaurantmenu/edit/{id}','RestaurantmenuController@editrestaurantmenu');
Route::get('restaurantmenu/view/{id}','RestaurantmenuController@viewrestaurantmenu');
Route::post('restaurantmenu/saverestaurantmenu','RestaurantmenuController@saverestaurantmenu');
Route::any('restaurantmenu/deleterestaurantmenu/{id}','RestaurantmenuController@deleterestaurantmenu');
Route::post('restaurantmenu/restaurantmenuexist','RestaurantmenuController@restaurantmenuexist');
Route::any('restaurantmenu/deleteimage','RestaurantmenuController@deleteimage');
Route::post('restaurantmenu/statusupdate', 'RestaurantmenuController@statusupdate');

//18.5.2019

Route::any('getterminal/{q?}', 'RestaurantmenuController@getterminal');

//Retail Types 20.03.2019
Route::get('retailtype', 'RetailController@list');
Route::get('retailtype/create', 'RetailController@create');
Route::post('retailtype/saveretailtype','RetailController@saveretailtype');
Route::get('/retailtype/edit/{id}', 'RetailController@edit'); 
Route::get('/retailtype/view/{id}', 'RetailController@view');
Route::any('retaildestroy/{id}','RetailController@retaildestroy');
Route::post('retailtype/statusupdate','RetailController@statusupdate');

//Retail Types 08.05.2019

Route::post('/check_shoptype', 'RetailController@checkshoptype');

//Restaurant Types 07.05.2019
Route::get('restauranttype', 'RestauranttypeController@list');
Route::get('restauranttype/create', 'RestauranttypeController@create');
Route::post('restauranttype/saveretailtype','RestauranttypeController@saveretailtype');
Route::get('/restauranttype/edit/{id}', 'RestauranttypeController@edit'); 
Route::get('/restauranttype/view/{id}', 'RestauranttypeController@view');
Route::any('retaildestroy/{id}','RestauranttypeController@retaildestroy');
Route::post('restauranttype/statusupdate','RestauranttypeController@statusupdate');
Route::post('/check-resttype', 'RestauranttypeController@checkresttype');

//17.05.2019

	Route::get('retailshop/aupload','RetailshopController@aupload');
	Route::post('retailshop/uploadcsv','RetailshopController@uploadcsv');
	Route::get('/download/{filename}', 'RetailshopController@download');


//Retail shop 20.03.2019
Route::get('retailshop', 'RetailshopController@list');
Route::get('retailshop/create', 'RetailshopController@create');
Route::post('retailshop/saveretail','RetailshopController@saveretail');
Route::get('/retailshop/edit/{id}', 'RetailshopController@edit'); 
Route::get('/retailshop/view/{id}', 'RetailshopController@view');
Route::any('retailshopdestroy/{id}','RetailshopController@retaildestroy');
Route::post('retailshop/statusupdate','RetailshopController@statusupdate');

Route::any('terminalget/{q?}', 'RetailshopController@getterminal');

//Transporation Types 21.03.2019
Route::get('transport', 'TransportController@list');
Route::get('transport/create', 'TransportController@create');
Route::post('transport/savetransport','TransportController@savetransport');
Route::get('/transport/edit/{id}', 'TransportController@edit'); 
Route::get('/transport/view/{id}', 'TransportController@view');
Route::any('transportdestroy/{id}','TransportController@transportdestroy');
Route::post('transport/statusupdate','TransportController@statusupdate');

//vehicle 21.03.2019
Route::get('vehicle', 'VehicleController@list');
Route::get('vehicle/create', 'VehicleController@create');
Route::post('vehicle/savevehicle','VehicleController@savevehicle');
Route::get('/vehicle/edit/{id}', 'VehicleController@edit'); 
Route::get('/vehicle/view/{id}', 'VehicleController@view');
Route::any('vehicledestroy/{id}','VehicleController@vehicledestroy');
Route::post('vehicle/statusupdate','VehicleController@statusupdate');



//retailshop filter 25.3.2018
Route::get('retailshop/{id}','RetailshopController@filter_list')->where('id', '[0-9]+');
Route::get('restaurants/{id}','RestaurantController@filter_list')->where('id', '[0-9]+');
//Route::get('restaurantmenu/{id}','RestaurantmenuController@filter_list')->where('id', '[0-9]+');
Route::get('lounge/{id}','LoungeController@filter_list')->where('id', '[0-9]+');

Route::any('offer/type','OfferController@type');

Route::get('offertypeexist','OffertypeController@offertypeexist');

Route::get('servicelist','WebserviceController@servicelist');
	Route::get('createservice','WebserviceController@addservice');
	Route::get('viewservice/{id}','WebserviceController@viewservice');
	Route::get('editservice/{id}','WebserviceController@editservice');
	Route::post('service/saveservice','WebserviceController@saveservice');

	Route::get('/rest_menu/{q?}','RestaurantmenuController@rest_menu');
	Route::get('/menu_list/','RestaurantmenuController@menu_list');


	//commision
		Route::get('commisioncreate','CommisionController@create');


});


