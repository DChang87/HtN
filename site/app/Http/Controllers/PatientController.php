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
        $DEFAULT_PATH = '/users';
        
        $firebase = new \Firebase\FirebaseLib($DEFAULT_URL, $DEFAULT_TOKEN);
        $output  = [];
        foreach(Patient::whereIn('id', $arr)->with('plans')->get() as $patient){
            foreach($patient->plans as $plan){
                $data = array('id'=> $patient->uid,'time'=>'2015-09-20T10:01:10.229Z', 
                    'layout' => array(
                        'type' => 'calendarPin',
                        'title' => $plan->med->name . " Medication",
                        'body' => 'Take your medication for ' . $plan -> name
                    )
                );
                $data_json = json_encode($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://timeline-api.getpebble.com/v1/shared/pins/".$patient->uid);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json), 'X-Pin-Topics:john-doe', 'X-API-KEY:SB54cgbvj7nwtakkyobwbrz3c9bnv8im'));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
if($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}
                curl_close($ch);
            }
            $firebase->set($DEFAULT_PATH . '/'.$patient->uid, $patient->toArray());
        }
        
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
        PatientController::sync([$patient->id]);
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
    public function uid($id)
    {
        return Patient::where('uid', $id)->with('plans')->first();
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
        PatientController::sync([$patient->id]);
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
        PatientController::sync([$id]);
    }
}
