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
$route = env('PACKAGE_ROUTE', '');
Route::get('/', function () {
    return "heel";//view('welcome');
});
/*
  Accessing uploaded files
*/
Route::get($route.'/storage/profiles/{filename}', function ($filename)
{
    $path = storage_path('/app/profiles/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get($route.'/storage/logo/{filename}', function ($filename)
{
    $path = storage_path('/app/logos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'hey'.$exitCode;

    //
});

/* Authentication Router */
$route = env('PACKAGE_ROUTE', '').'/authenticate';
Route::resource($route, 'AuthenticateController', ['only' => ['index']]);
Route::post($route, 'AuthenticateController@authenticate');
Route::post($route.'/user', 'AuthenticateController@getAuthenticatedUser');
Route::post($route.'/refresh', 'AuthenticateController@refreshToken');
Route::post($route.'/invalidate', 'AuthenticateController@deauthenticate');


//Partners Controller
$route = env('PACKAGE_ROUTE', '').'/partners';
Route::post($route.'/retrieve', "PartnerController@retrieve");

//Templates
$route = env('PACKAGE_ROUTE', '').'/templates';
$controller = 'TemplateController@';
Route::post($route.'/create', $controller."create");
Route::post($route.'/retrieve',  $controller."retrieve");
Route::post($route.'/update',  $controller."update");
Route::post($route.'/delete',  $controller."delete");
Route::get($route.'/test',  $controller.'test');
Route::post($route.'/retrieve_templates_only',  $controller.'retriveTemplateOnly');
Route::post($route.'/retrieve_categories',  $controller.'retrieveCategories');


//Objects
$route = env('PACKAGE_ROUTE', '').'/objects';
Route::post($route.'/create', "ObjectController@create");
Route::post($route.'/retrieve', "ObjectController@retrieve");
Route::post($route.'/update', "ObjectController@update");
Route::post($route.'/delete', "ObjectController@delete");
Route::get($route.'/test', 'ObjectController@test');
Route::post($route.'/upload', 'ObjectController@upload');
Route::post($route.'/retrieve_dynamic_without_attributes', 'ObjectController@retrieveDynamicWithoutAttributes');

//Attributes
$route = env('PACKAGE_ROUTE', '').'/attributes';
Route::post($route.'/create', "AttributeController@create");
Route::post($route.'/retrieve', "AttributeController@retrieve");
Route::post($route.'/update', "AttributeController@update");
Route::post($route.'/update_on_table_view', "AttributeController@updateTableView");
Route::post($route.'/delete', "AttributeController@delete");
Route::get($route.'/test', 'AttributeController@test');

//Contents
$route = env('PACKAGE_ROUTE', '').'/contents';
Route::post($route.'/create', "ContentController@create");
Route::post($route.'/retrieve', "ContentController@retrieve");
Route::post($route.'/update', "ContentController@update");
Route::post($route.'/delete', "ContentController@delete");
Route::get($route.'/test', 'ContentController@test');

//Employees
$route = env('PACKAGE_ROUTE', '').'/employees';
Route::post($route.'/create', "EmployeeController@create");
Route::post($route.'/retrieve', "EmployeeController@retrieve");
Route::post($route.'/update', "EmployeeController@update");
Route::post($route.'/update_by_profile', "EmployeeController@updateByProfile");
Route::post($route.'/delete', "EmployeeController@delete");
Route::get($route.'/test', 'EmployeeController@test');
Route::post($route.'/upload', "EmployeeController@upload");
Route::post($route.'/retrieve_on_update', "EmployeeController@retrieveOnUpdate");
Route::post($route.'/retreve_table', "EmployeeController@getEmployeesForTable");

//Employee Columns
$route = env('PACKAGE_ROUTE', '').'/employee_columns';
Route::post($route.'/create', "EmployeeColumnController@create");
Route::post($route.'/retrieve', "EmployeeColumnController@retrieve");
Route::post($route.'/update', "EmployeeColumnController@update");
Route::post($route.'/delete', "EmployeeColumnController@delete");
Route::get($route.'/test', 'EmployeeColumnController@test');

//Marketplace
$route = env('PACKAGE_ROUTE', '').'/marketplace';
Route::post($route.'/create', "MarketplaceController@create");
Route::post($route.'/retrieve', "MarketplaceController@retrieve");
Route::post($route.'/update', "MarketplaceController@update");
Route::post($route.'/delete', "MarketplaceController@delete");
Route::get($route.'/test', 'MarketplaceController@test');

//Checkouts
$route = env('PACKAGE_ROUTE', '').'/custom_checkouts';
Route::post($route.'/create', "CheckoutController@create");
Route::post($route.'/retrieve', "CheckoutController@retrieve");
Route::post($route.'/retrieve_summary', "CheckoutController@retrieveSummary");
Route::post($route.'/update', "CheckoutController@update");
Route::post($route.'/update_merchant', "CheckoutController@updateMerchant");
Route::post($route.'/update_remove_merchant', "CheckoutController@updateRemoveMerchant");
Route::post($route.'/update_status', "CheckoutController@updateStatus");
Route::post($route.'/delete', "CheckoutController@delete");
Route::get($route.'/test', 'CheckoutController@test');


//Checkout Templates
$route = env('PACKAGE_ROUTE', '').'/checkout_templates';
Route::post($route.'/create', "CheckoutTemplateController@create");
Route::post($route.'/retrieve', "CheckoutTemplateController@retrieve");
Route::post($route.'/update', "CheckoutTemplateController@update");
Route::post($route.'/delete', "CheckoutTemplateController@delete");
Route::get($route.'/test', 'CheckoutTemplateController@test');

//Clients
$route = env('PACKAGE_ROUTE', '').'/clients';
Route::post($route.'/create', "ClientController@create");
Route::post($route.'/retrieve', "ClientController@retrieve");
Route::post($route.'/update', "ClientController@update");
Route::post($route.'/delete', "ClientController@delete");
Route::get($route.'/test', 'ClientController@test');

//Guides Controller
$route = env('PACKAGE_ROUTE', '').'/guides';
Route::post($route.'/create', "GuideController@create");
Route::post($route.'/retrieve', "GuideController@retrieve");
Route::post($route.'/update', "GuideController@update");
Route::post($route.'/delete', "GuideController@delete");
Route::get($route.'/test', 'GuideController@test');

//Emails Controller
$route = env('PACKAGE_ROUTE', '').'/emails';
Route::post($route.'/create', "EmailController@create");
Route::post($route.'/retrieve', "EmailController@retrieve");
Route::post($route.'/update', "EmailController@update");
Route::post($route.'/delete', "EmailController@delete");
Route::post($route.'/reset_password', 'EmailController@resetPassword');
Route::post($route.'/verification', 'EmailController@verification');
Route::post($route.'/changed_password', 'EmailController@changedPassword');
Route::post($route.'/referral', 'EmailController@referral');
Route::post($route.'/trial', 'EmailController@trial');

//Notification Settings Controller
$route = env('PACKAGE_ROUTE', '').'/notification_settings';
Route::post($route.'/create', "NotificationSettingController@create");
Route::post($route.'/retrieve', "NotificationSettingController@retrieve");
Route::post($route.'/update', "NotificationSettingController@update");
Route::post($route.'/delete', "NotificationSettingController@delete");
Route::get($route.'/test', 'NotificationSettingController@test');

//Profile Controller
$route = env('PACKAGE_ROUTE', '').'/profiles';
Route::post($route.'/create', "ProfileController@create");
Route::post($route.'/retrieve', "ProfileController@retrieve");
Route::post($route.'/update', "ProfileController@update");
Route::post($route.'/delete', "ProfileController@delete");
Route::get($route.'/test', 'ProfileController@test');

//Government Controller
$route = env('PACKAGE_ROUTE', '').'/profile_variables';
Route::post($route.'/create', "ProfileVariableController@create");
Route::post($route.'/retrieve', "ProfileVariableController@retrieve");
Route::post($route.'/update', "ProfileVariableController@update");
Route::post($route.'/delete', "ProfileVariableController@delete");
Route::get($route.'/test', 'ProfileVariableController@test');

// Google Spreadsheets
$route = env('PACKAGE_ROUTE', '').'/gsheets';
Route::get($route.'/create', 'GoogleSheetController@generate');
Route::post($route.'/auth', 'GoogleSheetController@getAuthUrl');
Route::post($route.'/create_file', 'GoogleSheetController@createNewGoogleSheet');
Route::post($route.'/read_file', 'GoogleSheetController@readGoogleSheet');
Route::post($route.'/save_token', 'GoogleSheetController@setAccessToken');
Route::get($route.'/sample', 'GoogleSheetController@sample');

//Account Google Sheet Controller
$route = env('PACKAGE_ROUTE', '').'/account_gsheets';
Route::post($route.'/create', "AccountGoogleSheetController@create");
Route::post($route.'/retrieve', "AccountGoogleSheetController@retrieve");
Route::post($route.'/update', "AccountGoogleSheetController@update");
Route::post($route.'/delete', "AccountGoogleSheetController@delete");
Route::get($route.'/test', 'AccountGoogleSheetController@test');

//Active Template Controller
$route = env('PACKAGE_ROUTE', '').'/active_templates';  
Route::post($route.'/create', "ActiveTemplateController@create");
Route::post($route.'/retrieve', "ActiveTemplateController@retrieve");
Route::post($route.'/update', "ActiveTemplateController@update");
Route::post($route.'/delete', "ActiveTemplateController@delete");
Route::get($route.'/test', 'ActiveTemplateController@test');

// Messenger Groups Custom
$route = env('PACKAGE_ROUTE', '').'/custom_messenger_groups/';
$controller = 'MessengerGroupController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");

// Account Login Status Controller
$route = env('PACKAGE_ROUTE', '').'/account_login_status/';  
$controller = 'AccountLoginStatusController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");

// Educations Controller
$route = env('PACKAGE_ROUTE', '').'/educations/';  
$controller = 'EducationController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");

// Works Controller
$route = env('PACKAGE_ROUTE', '').'/works/';  
$controller = 'WorkController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
