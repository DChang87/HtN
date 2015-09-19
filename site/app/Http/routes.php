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
async function hello(): Awaitable<void> {
  $DEFAULT_URL = 'https://radiant-torch-4965.firebaseio.com/';
  $DEFAULT_TOKEN = '9eIWuCjiQUrC98ZtbTPH3tUeYbGznRi0vMGOnSmV';
  $DEFAULT_PATH = '/test';
  
  $firebase = new \Firebase\FirebaseLib($DEFAULT_URL, $DEFAULT_TOKEN);
  
  // --- storing an array ---
  $test = array(
      "foo" => "bar",
      "i_love" => "lamp",
      "id" => 42
  );
  $dateTime = new DateTime();
  $firebase->set($DEFAULT_PATH . '/' . $dateTime->format('c'), $test);
  
  // --- storing a string ---
  $firebase->set($DEFAULT_PATH . '/name/contact001', "John Doe");
  
  // --- reading the stored string ---
  $name = $firebase->get($DEFAULT_PATH . '/name/contact001');
}
async function run(): Awaitable<void> {
  await hello();
}
Route::group(['prefix' => 'api'], function () {
    Route::resource('patients', 'PatientController'); 
    Route::resource('plans', 'PlanController'); 
    Route::resource('meds', 'MedController'); 
});
Route::get('/test', function () {   
    run()->getWaitHandle()->join();
});
