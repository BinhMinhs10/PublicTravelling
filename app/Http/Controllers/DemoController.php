<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemoController extends Controller
{
    public function googleMaps(){
    	return view('demo.googlemap');
    }
    public function try(){
    	return view('demo.try');
    }
    public function jsPicker()
    {
    	return view('demo.textSearch');
    }
    public function test()
    {
    	return view('demo.test');
    }
    public function loading(){
        return view('demo.loading');
    }
    public function index(){
        return view('search.search');
    }
    public function search(Request $request){
        if($request->ajax()){
            $output="";
            $plans=DB::table('plans')->where('title','LIKE','%'.$request->search."%")->get();
            if($plans){
                foreach ($plans as $key => $plan) {
                    $output.='<tr>'.
                     
                    '<td>'.$plan->id.'</td>'.
                     
                    '<td>'.$plan->title.'</td>'.
                     
                    '<td>'.$plan->description.'</td>'.
                     
                    '</tr>';
                }
                return Response($output);
            }
        }
    }
}