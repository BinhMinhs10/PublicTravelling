<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class IsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $requestParameters = $request->route()->parameters();
       
        
        if(isset($requestParameters['id'])){ 
            $plan = Plan::find($requestParameters['id']);
            $owner = $plan->owner->id;
            if ($owner !== Auth::id()) {
                // Authenticated user is the not owner
                abort(403);
            }
        }
        foreach ($requestParameters as $requestParameter) {
            // Loop through route parameters
            if (gettype($requestParameter) === "object") {
                
                // Route Model Binding is active for this parameter
                if (isset($requestParameter->user_id)) { //for betcontroller
                    // Model has an owner (column user_id is set)
                    $owner = $requestParameter->user_id;
                    if ($owner !== Auth::id()) {
                        // Authenticated user is the not owner
                        abort(403);
                    }
                }
            }
        }

        return $next($request);
    }
}
