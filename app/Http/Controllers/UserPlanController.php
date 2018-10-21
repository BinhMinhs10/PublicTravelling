<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;
use App\User;
use App\Notifications\MessagesPublish;
use App\Notifications\MessagesDeny;
class UserPlanController extends Controller
{
    public function follow($id){
    	if(Auth::check()){
    		$follow = DB::table('follows')
		    ->where('user_id', '=', Auth::user()->id)
    		->where('plan_id', '=', $id)
    		->first();
			if (is_null($follow)) {
			    Auth::user()->follows()->attach($id);
			    $message = 'Success, you are following this plan';
    			return back()->with('success', $message);
			} else {
			    $message = 'Fail, you have followed this plan';
			    return back()->with('fail', $message);
			}
    		
    	}else{
    		return redirect('login');
    	}
    	
    }
    public function join($id){
    	if(Auth::check()){
    		$follow = DB::table('follows')
		    ->where('user_id', '=', Auth::user()->id)
    		->where('plan_id', '=', $id)
    		->first();
            $plan = Plan::find($id);
            $owner = $plan->owner->id;
            if ($owner == Auth::id()){
                abort(403);
            }
            if($plan->status != 1  ){
                $message = 'Fail join because this plan started run';
                return back()->with('fail', $message);
            }
			if (is_null($follow)) {
			    // chưa có tên trong yêu cầu request
                Auth::user()->follows()->attach($id,['isRequest' => '1']);
			    $message = 'Success, you are request join this plan';
    			return back()->with('success', $message);
			} else if( $follow->isRequest == 0){
                // đã request và bị từ chối
                Auth::user()->follows()->detach($id);
                Auth::user()->follows()->attach($id,['isRequest' => '1']);
                $message = 'Success, you are request join this plan';
                return back()->with('success', $message);
            }else{
			    $message = 'Fail, you have joined this plan';
			    return back()->with('fail', $message);
			}
    		
    	}else{
    		return redirect('login');
    	}
    	
    }
    
    public function joiners($plan_id){
        $plan = Plan::find($plan_id);
        return view('users.joiners',['plan'=>$plan, ]);
    }


    public function deny(Request $request)
    {
        if(Auth::check()){
            DB::table('follows')->where('user_id', '=', $request->input('user_id'))
            ->where('plan_id', '=', $request->input('plan_id'))->update(['isRequest' => 0]);
            $user = User::find($request->input('user_id'));
            $plan = Plan::find($request->input('plan_id'));
            $plan->joiners()->detach($request->input('user_id'));
            $user->notify(new MessagesDeny($plan));
            return "Success, you denied user ";
            
        }else{
            abort(403);
        }
        
    }



    public function accept(Request $request)
    {
        if(Auth::check()){
            $follow = DB::table('follows')
            ->where('user_id', '=', $request->input('user_id'))
            ->where('plan_id', '=', $request->input('plan_id'))
            ->first();
            if (! is_null($follow)) {
                $user = User::find($request->input('user_id'));
                $plan = Plan::find($request->input('plan_id'));
                if($plan->member > $plan->joiners->count() + 1 ){
                    DB::table('follows')->where('user_id', '=', $request->input('user_id'))
                    ->where('plan_id', '=', $request->input('plan_id'))->update(['isRequest' => 2]);
                    $user->joins()->attach($request->input('plan_id'));
                    $user->notify(new MessagesPublish($plan));
                    return 1;
                }else{
                    // that bai do so nguoi da đủ
                    return 0;
                }
                
            }
        }else{
            abort(403);
        }
        
    }
}
