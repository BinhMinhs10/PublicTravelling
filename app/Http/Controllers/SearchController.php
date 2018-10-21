<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;

class SearchController extends Controller
{
    public function search(Request $request){
        if($request->ajax()){
            $output="";
			$plans = Plan::where('title','LIKE','%'.$request->search."%")
            ->get();
            if($request->search == null)
            	return Response($output);
            if($plans){
                foreach ($plans as  $plan) {
                	$plan->countFollowJoinComment();
                	$plan->getStatus();
					$output.=
					'<div class="col-md-6">
						<a href="plans/'.$plan->id.'" class="custm-fix-link">
							<div class="card bod15 custm-fix-card">
						  		<img class="card-img-top bod15 img-card" src="images/plans/'. $plan->cover.'" alt="Card image cap">
						  		
						  		<div class="row card-body">
						  			<h5 class="card-title"> '.$plan->title.'</h5>
						  			<div class="col-md-12">
										<i class="fa fa-toggle-on"> '.$plan->start_at.'</i>
										<i class="fa fa-group marleft45"> '.($plan->num_join +1).'/'. $plan->member.'</i>
							    		<i class="fa fa-feed marleft15"> '.$plan->num_follow.'</i>
										<i class="fa fa-comments-o marleft15"> '.$plan->num_comment .'</i><br>
										<i class="fa fa-toggle-off"> '.$plan->end_at .'</i>';
										if ($plan->state===1)
											$output.='<i class="fa fa-ellipsis-h marleft45"> Planning</i>';
			                            else if ($plan->state===2)
			                            	$output.='<i class="fa fa-cogs marleft45"> Running</i>';
			                            else if ($plan->state===3)
			                            	$output.='<i class="fa fa-check-circle-o marleft45"> Ended</i>';
			                            else if ($plan->state===4)
			                            $output.='<i class="fa fa-warning marleft45"> Cancled</i>';
			                           $output.='
						  			</div>
						  		</div>
							</div>
						</a>
					</div>';
					
                }
                return Response($output);
            }
        }
    }
}
