<?php

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
    use Firebase\Firebase;
Route::group(['prefix' => 'api'], function () {
    Route::resource('patients', 'PatientController'); 
    Route::resource('plans', 'PlanController'); 
    Route::resource('meds', 'MedController'); 
});
Route::get('/test', function () {
    
    $fb = Firebase::initialize("https://radiant-torch-4965.firebaseio.com/", "9eIWuCjiQUrC98ZtbTPH3tUeYbGznRi0vMGOnSmV");
 
    //retrieve a node
    $nodeGetContent = $fb->get('/node/path');
    
    //set the content of a node
    $nodeSetContent = $fb->set('/node/path', array('data' => 'toset'));
    
    //update the content of a node
    $nodeUpdateContent = $fb->update('/node/path', array('data' => 'toupdate'));
    
    //delete a node
    $nodeDeleteContent = $fb->delete('/node/path');
    
    //push a new item to a node
    $nodePushContent = $fb->push('/node/path', array('name' => 'item on list'));
});
