<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\User;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlanRequest;
use DateTime;
use App\Notifications\MessagesDeny;
class PlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('owner')->only(['edit','update', 'destroy','cancel','start']);
        $this->middleware('auth')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();
        return view('home',['plans'=>$plans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    { 
        $user_id = Auth::id();

        //  Validate the data
        $valid = $request->validated();

        //  Prepare image file
        if($request->hasFile('cover')){
            $file = $request->cover;
            $filename = $user_id.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/images/plans'), $filename);
        }else{
            $filename = 'cover_default.png';
        }      
    
        
        $plan = new Plan;

        $plan->title = $request->title;
        $plan->start_at = $request->start_at;
        $plan->end_at = $request->end_at;
        $plan->cover = $filename;
        $plan->member = $request->member;
        $plan->description = $request->description;
        $plan->user_id = $user_id;

        $plan->save();

        $routes = json_decode($request->routesPlan);
        foreach ($routes as $route) {
            $route->plan_id = $plan->id;
            Route::create((array)$route);
        }
        
        return redirect()->back()->with('status', 'Create plan successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        $routes = Route::where('plan_id', $plan->id)->orderBy("no")->get();
    //    $user = Auth::user();
        $comments = $plan->comments->where('parent_comment_id', null);
        $plan->countFollowJoinComment();
        $plan->getStatus();
        return view('plans.show',['plan'=>$plan, 'routes'=>$routes, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $routes = Route::where('plan_id', $plan->id)->get();
        return view('plans.edit',['plan'=>$plan, 'routes'=>$routes,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PlanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        if($plan->status === 1){
            $user_id = Auth::id();
            
            //  Validate the data
            $valid = $request->validated();

            //  Prepare image file
            if($request->hasFile('cover')){
                $file = $request->cover;
                $filename = $user_id.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/images/plans'), $filename);
                $plan->cover = $filename;
            }      

            $plan->title = $request->title;
            $plan->start_at = $request->start_at;
            $plan->end_at = $request->end_at;
            $plan->member = $request->member;
            $plan->description = $request->description;

            $plan->save();

            $routes = json_decode($request->routesPlan);
            $count = Route::where('plan_id',$plan->id)->count();
            $new_count = count($routes);
            for($i = 0; $i< $new_count;$i++) {
                $routes[$i]->plan_id = $plan->id;
                $route = Route::where('plan_id',$plan->id)->where('no',$i)->update((array)$routes[$i]);  
            }
            if($new_count<$count){
                for($i=$new_count; $i<$count; $i++){
                    $route = Route::where('plan_id',$plan->id)->where('no',$i)->delete();
                }
            }
            if($new_count>$count){
                for($i=$count; $i<$new_count;$i++){
                    $routes[$i]->plan_id= $plan->id;
                    Route::create((array)$routes[$i]);
                }
            }

            return redirect()->back()->with('status', 'Update plan successfully!');
        }else{
            return redirect()->back()->withErrors(['edt'=>'You can not edit a plan which have started!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        
    }
    public function cancel($id){
        $plan = Plan::find($id);
        $plan->status = 4;
        $plan->save();
        foreach ($plan->joiners as $user) {
            $user = User::find($user->id);
            $user->notify(new MessagesDeny($plan));    
        }
        return redirect()->back();
    }
    public function start($id){
        $plan = Plan::find($id);
        $plan->status = 2;
        $plan->save();
        return redirect()->back();
    }
}
