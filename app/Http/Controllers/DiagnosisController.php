<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DiagnosisClient;
use App\Http\Controllers\TokenGenerator;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\UserSubscription;

class DiagnosisController
{
    private $config;
    private $diagnosisClient;
    
    function __construct()
    {
        $this->config = parse_ini_file("config.ini");
        return $this->_initDiagnosisClient();
    }
    
    private function checkRequiredParameters()
    {
        $pass = true;
        
        if (!isset($this->config['username']))
        {
            $pass = false;
            print "You didn't set username in config.ini" ;
        }
        if (!isset($this->config['password']))
        {
            $pass = false;
            print "You didn't set password in config.ini" ;
        }
        if (!isset($this->config['authServiceUrl']))
        {
            $pass = false;
            print "You didn't set authServiceUrl in config.ini" ;
        }
        if (!isset($this->config['healthServiceUrl']))
        {
            $pass = false;
            print "You didn't set healthserviceUrl in config.ini" ;
        }
        return $pass;
    }
    
    private function _initDiagnosisClient(){
        if (!$this->checkRequiredParameters()) return;
        
        $tokenGenerator = new TokenGenerator($this->config['username'],$this->config['password'],$this->config['authServiceUrl']);
        $token = $tokenGenerator->loadToken();
        
        if (!isset($token)) exit();

        $this->diagnosisClient = new DiagnosisClient($token, $this->config['healthServiceUrl'], 'en-gb');
        return $this->diagnosisClient;
    }
    
    public function symptomCheckView(){
        $symptoms = $this->diagnosisClient->loadSymptoms();
        return view('checks')->with(compact('symptoms'));
    }
    
    public function getDiagnostic(Request $request){
        $validated = $request->validate([ 'year' => 'required|digits:4|integer' ]);
        
        $authUserId = Auth::user()->id;
        $userSubscription =  UserSubscription::where('user_id','=', $authUserId)->first()->no_checks_available;
        $userSubscriptions =  UserSubscription::where('user_id','=', $authUserId)->first();
        
        $selectedSymptomIDS =  $request['symptomIDs'];
        $selectedSymptomNames = $request['symptomNames'];
        $year = $request ['year'];
        $gender = $request ['gender'];
        
        if(!isset($request['symptomIDs'])) exit();
        $diagnosis = $this->diagnosisClient->loadDiagnosis($selectedSymptomIDS, $gender, $year);
        $specialisations = $this->diagnosisClient->loadSpecialisations($selectedSymptomIDS, $gender , $year);
        
        $issuesInfoArray = array();
        reset($diagnosis);
        foreach($diagnosis as $key=>$val){
            $issuesInfoArray[]= $this->diagnosisClient->loadIssueInfo($val['Issue']['ID']);
        }
        
        $proposedSymptoms = $this->diagnosisClient->loadProposedSymptoms($selectedSymptomIDS, $gender , $year);
        
        $redFlagTexts = array();
        foreach($selectedSymptomIDS as $symptomID){
            
            $redFlagText = $this->diagnosisClient->loadRedFlag($symptomID);
             if (isset($redFlagText) && !empty($redFlagText)){
                 $redFlagTexts[$symptomID] = $redFlagText;
             }
        }
    
        if(!empty($diagnosis)){
            $authUserId = Auth::user()->id;
         $userSubscriptions->no_checks_available = $userSubscription - 1;
         $userSubscriptions->save();
        }

        return view('dashboard')->with(compact('selectedSymptomNames','userSubscription','diagnosis','specialisations','issuesInfoArray','proposedSymptoms','redFlagTexts'));
    }
}

?>