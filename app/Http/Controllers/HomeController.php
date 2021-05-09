<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\UserSubscription;
use Auth;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subscription_plans = Subscriptions::get()->sortBy('price');
        return view('home')->with(compact('subscription_plans'));
    }
    
    public function goToDashboard(){
        $authUserId = Auth::user()->id;
        $userSubscription =  UserSubscription::where('user_id','=', $authUserId)->first()->no_checks_available;
        return view('dashboard')->with(compact('userSubscription'));
    }
}
