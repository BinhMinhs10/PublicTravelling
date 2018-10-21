<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Plan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->take(10)->get();
        $hotPlans=[];
        $newPlans=[];
        $soHot = DB::table('follows')->select(DB::raw('count(*) as num, plan_id'))->groupBy('plan_id')->orderBy('num','desc')->take(10)->get();
        foreach ($soHot as $row) {
            $plan = Plan::find($row->plan_id);
            $plan->countFollowJoinComment();
            $plan->getStatus();
            array_push($hotPlans, $plan);
        }
        $tempNewPlans = Plan::orderBy('created_at', 'desc')->take(10)->get();
        foreach ($tempNewPlans as $plan) {
            $plan->countFollowJoinComment();
            $plan->getStatus();
            array_push($newPlans, $plan);
        }
        return view('home')->with('users', $users)->with('newPlans', $newPlans)->with('hotPlans',$hotPlans);
    }

    public function plan(){
        return view('plans/create');
    }

    public function profile(){
        if(Auth::check()){
            $user = Auth::user();
            return view('profile')->with('user',$user);
        }
    }
    public function detailUser($id){
        $user = User::find($id);
        return view('users/detail')->with('user', $user);
    }

}
