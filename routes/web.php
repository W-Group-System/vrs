<?php
use Illuminate\Support\Facades\Route;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('home-vrs/{id}', 'VisitorController@index');
Route::post('/new_visitor/{id}', 'VisitorController@store')->name('store');
Auth::routes();
// vrs
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/dashboard', 'HomeController@index');
    Route::get('view_active/{id}', 'HomeController@view_active');
    Route::get('view_return/{id}', 'HomeController@view_return');
    Route::get('visitor/{visitor}', 'HomeController@show')->name('visitor.show');

    
    // change password
    Route::get('change_password','HomeController@changePassword')->name('change_password');
    Route::post('change_password','HomeController@updatePassword')->name('update_password');

    // user
    Route::get('/user', 'UserController@index');    
    Route::post('/new_user', 'UserController@store')->name('store');
    Route::post('update_user/{id}', 'UserController@update');
    Route::get('user/delete/{id}', 'UserController@delete')->name('user.delete');

    // building
    Route::get('/building', 'BuildingController@index');
    Route::post('/new_building', 'BuildingController@store')->name('store');
    Route::post('update_building/{id}', 'BuildingController@update');
    Route::get('building/delete/{id}', 'BuildingController@delete')->name('building.delete');

    // tenant
    Route::get('/tenant', 'TenantController@index');
    Route::post('/new_tenant', 'TenantController@store')->name('store');    
    Route::post('update_tenant/{id}', 'TenantController@update');
    Route::get('tenant/delete/{id}', 'TenantController@delete')->name('tenant.delete');

    // visitor id
    Route::get('/visitor_id', 'VisitorController@visitor_id');
    Route::post('new_id/{id}', 'VisitorController@new_id');
    Route::get('return_id/{id}', 'VisitorController@return_id');
    Route::get('view_id/{id}', 'VisitorController@view_id');

    // reports
    Route::get('/report', 'ReportController@index');
    Route::get('/filter', 'ReportController@filter')->name('visitors.filter');
    Route::get('/visitors/export/csv', 'VisitorController@exportCsv');
    Route::get('/visitors/export/pdf', 'VisitorController@exportPdf');
    Route::get('/visitors/export/excel', 'VisitorController@exportExcel');

    Route::get('/visitors/{type}/{id}', 'VisitorController@ShowImage');
});
