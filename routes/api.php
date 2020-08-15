<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/whoami', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['json.response'], 'namespace' => 'API'], function () {
    //Auth folder
    Route::group(['namespace' => 'Auth'], function () {

        Route::post('/login', 'AuthController@login')->name('user.login');
        Route::post('/register', 'AuthController@register')->name('user.register');
        //Requires Auth
        Route::group(['middleware' => 'auth:api'], function () {
            //Logout
            Route::post('/logout', 'AuthController@logout')->name('user.logout');
            //Security purposes get token if not same return error
            Route::get('/whoami', function (Request $request) {
                return $request->user();
            });
        });
    });

    Route::group(['middleware' => 'auth:api'], function () {
        //Profile
        Route::group(['namespace' => 'User'], function () {
            Route::get('/user/profile', 'UserProfileController@index')->name('user.profile');
            Route::post('/user/profile', 'UserProfileController@update')->name('user.update_profile');
            Route::post('/user/profile/avatar/upload', 'UserProfileController@uploadAvatar')->name('user.upload_avatar');
            Route::get('/user/profile/avatar', 'UserProfileController@getAvatar')->name('user.get_avatar');
        });
        
        
        //Customer
        Route::group(['namespace' => 'Customer'], function () {
            Route::get('/customer/list','CustomerController@index')->name('customer.list');
            // Route::get('/customer/list','CustomerController@index')->name('customer.list'); 
        });
    });

    
});


