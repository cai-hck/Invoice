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

Route::get('/', 'LoginController@index');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::get('/profile', 'CompanyController@profile');
Route::post('/updateprofile', 'CompanyController@updateprofile');

Route::get('/adduser', 'CompanyController@adduser');
Route::post('/newuser', 'CompanyController@newuser');
Route::get('/listuser', 'CompanyController@listuser');
Route::get('/edituser/{id}', 'CompanyController@edituser');
Route::post('/updateuser', 'CompanyController@updateuser');
Route::get('/deluser/{id}', 'CompanyController@deluser');

Route::get('/addsource', 'CompanyController@addsource');
Route::get('/listsource', 'CompanyController@listsource');
Route::post('/newsource', 'CompanyController@newsource');
Route::get('/editsource/{id}', 'CompanyController@editsource');
Route::post('/updatesource', 'CompanyController@updatesource');
Route::get('/delsource/{id}', 'CompanyController@delsource');

Route::get('/addairline', 'CompanyController@addairline');
Route::get('/listairline', 'CompanyController@listairline');
Route::post('/newairline', 'CompanyController@newairline');
Route::get('/editairline/{id}', 'CompanyController@editairline');
Route::post('/updateairline', 'CompanyController@updateairline');
Route::get('/delairline/{id}', 'CompanyController@delairline');

Route::get('/adducompany', 'CompanyController@adducompany');
Route::get('/listucompany', 'CompanyController@listucompany');
Route::post('/newucompany', 'CompanyController@newucompany');
Route::get('/editucompany/{id}', 'CompanyController@editucompany');
Route::post('/updateucompany', 'CompanyController@updateucompany');
Route::get('/delucompany/{id}', 'CompanyController@delucompany');



Route::get('/addinvoice', 'HomeController@addinvoice');
Route::get('/listinvoice', 'HomeController@listinvoice');
Route::post('/newinvoice', 'HomeController@newinvoice');
Route::get('/editinvoice/{id}', 'HomeController@editinvoice');
Route::post('/updateinvoice', 'HomeController@updateinvoice');
Route::get('/delinvoice/{id}', 'HomeController@delinvoice');


Route::get('/addinvoice1', 'HomeController@addinvoice1');
Route::get('/listinvoice1', 'HomeController@listinvoice1');
Route::post('/newinvoice1', 'HomeController@newinvoice1');
Route::get('/editinvoice1/{id}', 'HomeController@editinvoice1');
Route::post('/updateinvoice1', 'HomeController@updateinvoice1');
Route::get('/delinvoice1/{id}', 'HomeController@delinvoice1');

Route::get('/today', 'HomeController@today');

Route::get('/addcashier', 'HomeController@addcashier');
Route::post('/findinvoice', 'HomeController@findinvoice');
Route::post('/newcashier', 'HomeController@newcashier');

Route::get('/addexpense', 'HomeController@addexpense');
Route::post('/newexpense', 'HomeController@newexpense');
Route::get('/listexpense', 'HomeController@listexpense');
Route::get('/editexpense/{id}', 'HomeController@editexpense');
Route::post('/updateexpense', 'HomeController@updateexpense');
Route::get('/delexpense/{id}', 'HomeController@delexpense');




Route::get('/addpaid', 'HomeController@addpaid');
Route::post('/newpaid', 'HomeController@newpaid');
Route::get('/listpaid', 'HomeController@listpaid');
Route::get('/editpaid/{id}', 'HomeController@editpaid');
Route::post('/updatepaid', 'HomeController@updatepaid');
Route::get('/delpaid/{id}', 'HomeController@delpaid');

Route::get('/addpaying', 'HomeController@addpaying');
Route::post('/newpaying', 'HomeController@newpaying');
Route::get('/listpaying', 'HomeController@listpaying');
Route::get('/editpaying/{id}', 'HomeController@editpaying');
Route::post('/updatepaying', 'HomeController@updatepaying');
Route::get('/delpaying/{id}', 'HomeController@delpaying');

Route::get('/sourcereport', 'HomeController@sourcereport');
Route::get('/debt', 'HomeController@debt');
Route::get('/invoicereport', 'HomeController@invoicereport');
Route::get('/invoicereport1', 'HomeController@invoicereport1');
Route::get('/calledbox', 'HomeController@calledbox');
Route::post('/find', 'HomeController@find');
Route::post('/findexpense', 'HomeController@findexpense');
Route::get('/pay', 'HomeController@pay');
Route::post('/findpay', 'HomeController@findpay');

Route::get('/expensereport', 'HomeController@expensereport');
Route::get('/report', 'HomeController@report');
Route::post('/findreport', 'HomeController@findreport');

Route::post('/userlogin', 'LoginController@userlogin');
Route::post('/forgotemail', 'LoginController@forgotemail');
Route::get('/userlogout', 'HomeController@userlogout');
Route::get('/resetpassword/{token}', 'LoginController@resetpassword');
Route::post('/newpassword', 'LoginController@newpassword');



