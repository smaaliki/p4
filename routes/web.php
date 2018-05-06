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

Route::get('/',  'PageController@index');



Route::get('/calculators/Sample_Size_Calc', 'CalculatorsController@Sample_Size_Calc');
Route::get('calculators/sampleSize', 'CalculatorsController@sampleSize');

Route::get('/calculators/System_Uptime_Calc', 'CalculatorsController@System_Uptime_Calc');
Route::get('/calculators/systemUptime', 'CalculatorsController@systemUptime');

Route::any('/calculators', 'CalculatorsController@index');

Route::get('/contact', 'ContactController@show');
Route::post('/contact',  'ContactController@mailToAdmin');

/* Contact centers */
Route::get('/ccs', 'ContactCentersController@index');
Route::get('/manageCCs', 'ContactCentersController@manageCCs');

/* CC - Create */
Route::get('/manageCCs/create', 'ContactCentersController@create');
Route::post('/manageCCs/store', 'ContactCentersController@store');

/* CC - Edit */
Route::get('/manageCCs/{id}/edit', 'ContactCentersController@edit');
Route::put('/manageCCs/{id}', 'ContactCentersController@update');

/* CC - Delete */
Route::get('/manageCCs/{id}/delete', 'ContactCentersController@remove');

/* Employees */
Route::get('/employees', 'EmployeeController@index');

/* Employees - Edit */
Route::get('/manageEmployees/{id}/edit', 'EmployeeController@edit');
Route::put('/manageEmployees/{id}', 'EmployeeController@update');

