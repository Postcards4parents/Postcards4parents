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
use Illuminate\Support\Carbon;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/pass', function () {

 $message="You have exceeded the rate limit of the Organization this Space belongs to by making too many API requests within a short timespan. Please wait a moment before trying the request again. (View: /home/postcards/www/www/resources/views/site/layout/home.blade.php)";
 
 $match="You have exceeded the rate limit of the Organization this Space belongs to by making too many API requests within a short timespan. Please wait a moment before trying the request again";
 
 if(strstr($message,$match))
 {
     echo "match";
 }

 //echo Hash::make("POstCArD%");
     
 });
Auth::routes(['verify' => true]);
//Route::group(['middleware' => ['auth']], function() {
        //Route::get('/payment/{id}','PaymentController@index');
		//Route::get('/UserSet','SignUpController@showRegistrationFormRegister');
		Route::get('/payment/flows','PaymentController@index');
        Route::get('/payment/createproduct','PaymentController@create_product');
        Route::get('/addplans','PaymentController@create_plan');
        Route::get('/listplan','PaymentController@list_plan');
        Route::get('/payment/goforpayment','PaymentController@listPlan');
        Route::post('/storepayment','PaymentController@store');
        Route::post('/payment/couponcheck','PaymentController@couponcheck');
//});
Route::get('/clear-cache', function() {
    //-- Artisan::call('cache:clear');
     //Artisan::call('route:cache');
     //Artisan::call('route:clear');
   //--  Artisan::call('view:clear');
     //Artisan::call('postcard:midmailer');
   // Artisan::call('config:cache');
     Artisan::call('postcard:mailer');
     return "Cache is cleared";
});
Route::get('/error', 'HomeContentController@errorHandeler');
Route::get('/page', function () {  
    return view('admin.admin');
});
Route::get('/', 'HomeContentController@index');
Route::get('video', 'HomeContentController@video');
Route::get('kindergarten', 'HomeContentController@kindergarten');
Route::get('grades-1-3', 'HomeContentController@grade_1_3');
Route::get('grades-4-5', 'HomeContentController@grade_4_5');
Route::get('toolkit', 'HomeContentController@toolkit');
Route::get('about', 'HomeContentController@about');

Route::get('details/{id}/{name?}', 'HomeContentController@details');

Route::get('toolkitDetails/{id}/{name?}', 'HomeContentController@toolkitDetails');
Route::get('gradelist/{id}/{name?}', 'HomeContentController@gradelist');
Route::get('catlist2/{url}/{id}', 'HomeContentController@catlist2');
Route::get('cattag/{url}/{id}', 'HomeContentController@cattag');
Route::get('catlist/{id}/{name?}', 'HomeContentController@catlist');
Route::get('thank-you', 'HomeContentController@thank_you');

Route::get('combination', 'LoginController@combination');


// Route::get('/', function () {
//     return view('site.layout.home');
// });

// Route::get('about', function () {
//     return view('site.layout.about');
// });

// Route::get('pre-k', function () {
//     return view('site.other_pages.pre_k');
// });


Route::get('/page', function () {
    return view('admin.admin');
});


Route::get('/menu', function () {
    return view('menu.create');
});

Route::get('disclaimer', 'HomeContentController@disclaimer');
Route::get('terms-of-use', 'HomeContentController@termsOfUse');
Route::get('privacy-policy', 'HomeContentController@privacyPolicy');

Route::get('userlogin', 'Auth\LoginController@showLoginForm');
Route::post('userlogin', 'Auth\LoginController@post_login_admin');
Route::post('userSignup', 'LoginController@userSignup');
Route::post('userUpdate', 'LoginController@userUpdate');
Route::post('DetailPaging', 'HomeContentController@DetailPaging');

Route::get('userDash', 'LoginController@userDash');
Route::post('userDeactive', 'UserController@userDeactive');
Route::post('userActive', 'UserController@userActive');
Route::post('getInTouch', 'LoginController@getInTouch');
Route::post('SearchModule', 'HomeContentController@SearchModule');
Route::get('MoreSearchModule/{keyword}', 'HomeContentController@MoreSearchModule');
Route::get('postcards', 'HomeContentController@second_grade');
Route::get('quiz', 'HomeContentController@quizQuestion');
Route::post('quizView', 'QuizController@index');
Route::post('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');
Route::get('midweek','HomeContentController@MidWeekEmail');
//

Route::resource('category', 'CategoryController');
Route::resource('subcategory', 'SubcategoryController');
Route::post('subcategoryByCat', 'SubcategoryController@subcategoryByCat');

Route::resource('user', 'UserController');
Route::resource('mtemp', 'ManagetempController');


Route::get('mailtest', 'HomeController@mail_test');
Route::get('userlist', 'UserController@userDatatable');
Route::get('catlist', 'CategoryController@categoryDatatable');
Route::get('subcatlist', 'SubcategoryController@subcategoryDatatable');
Route::get('mtemplist', 'ManagetempController@mtempDatatable');
Route::get('welcomeKit', 'LoginController@welcomeKit')->name('welcomeKit' );
Route::get('postcards-office-hours', 'LoginController@yourPostcards')->name('postcards-office-hours' );
Route::get('story-circle', 'LoginController@storyCircle')->name('story-circle' );
Route::get('userDashboard', 'LoginController@userDashboard')->name('userDashboard' );

Route::post('forget_password', 'LoginController@forget_password');
Route::post('update_password', 'LoginController@update_password');
Route::get('reset_status', 'LoginController@reset_status')->name('reset_status');
Route::get('password_reset/{email}/{token}', 'LoginController@password_reset');


//Route::group(['middleware' => 'is-admin'], function () {
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@post_login_admin');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('test_mail', 'LoginController@test_mail');

Route::get('newTestCron', 'HomeContentController@newTestmailerCron');

Route::get('NewMailerCron', 'HomeContentController@NewMailerCron');

//Auth::routes();
// Registration Routes...
// $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// $this->post('register', 'Auth\RegisterController@register');

//Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');


//});
Route::get('/home', 'LoginController@loginForm')->name('home');

//contentfull
Route::get('content', 'ContentfullController@index');
Route::get('content1', 'ContentfullController@index1');
Route::get('content2', 'ContentfullController@index2');
Route::get('content3', 'ContentfullController@index3');
Route::get('content4', 'ContentfullController@index4');
Route::get('content5', 'ContentfullController@index5');

Route::get('mailerCron', 'HomeContentController@mailerCron');
Route::get('testCron', 'HomeContentController@testmailerCron');

Route::get('updateGrade', 'HomeContentController@updateGrade');
Route::get('updateBirthYear', 'HomeContentController@updateBirthYear');

Route::get('email-test', function(){
  
    $details['email'] = 'ajay.kumar@sourcesoftsolutions.com';
    
      dispatch((new App\Jobs\NewslatterJob($details))->delay(Carbon::now()->addSeconds(3)));
  
    dd('done');


});

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    

    Route::group(['prefix' => 'user_log'],function(){
    // Authentication Routes...
   // Route::get('login', 'LoginController@loginForm');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Password Reset Routes...
    // Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    // Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
    // Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('callback/facebook', 'Auth\LoginController@handleFacebookCallback');

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('callback/google', 'Auth\LoginController@handleGoogleCallback');



//auth super user
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@post_login_admin');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//
//user login
