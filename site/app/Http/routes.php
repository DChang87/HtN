<?php
ini_set('default_socket_timeout',2);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => 'api'], function () {
    Route::resource('patients', 'PatientController'); 
    Route::resource('plans', 'PlanController'); 
    Route::resource('meds', 'MedController'); 
});
Route::get("/", function() {
    return view("index");
});
Route::get("/plans", function() {
    return view("plans");
});
Route::get("/meds", function() {
    return view("meds");
});
Route::get('/test', function () {   
    run()->getWaitHandle()->join();
});
