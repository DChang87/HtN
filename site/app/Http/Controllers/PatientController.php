<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Patient;
use App\Plan;
use DB;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Patient::with('plans')->get();
    }

    public static function sync($arr){
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $relationships = $data['plans'];
        unset($data['plans']);
        $patient = new Patient($data);
        $patient->save();
        foreach($relationships as $id){
            $patient->plans()->save(Plan::find($id));
        }
        $patient = Patient::find($patient->id);
        $patient->plans;
        return $patient;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Patient::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        $data = $request->input();
        $relationships = $data['plans'];
        unset($data['plans']);
        $patient->fill($data);
        $patient->save();
        DB::table('patient_plan')->where('patient_id', $patient->id)->delete();
        foreach($relationships as $id){
            $patient->plans()->save(Plan::find($id));
        }
        $patient = Patient::find($patient->id);
        $patient->plans;
        return $patient;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Patient::destroy($id);
    }
}
