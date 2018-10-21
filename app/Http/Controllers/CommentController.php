<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Plan;
use App\User;
use Validator;
class CommentController extends Controller
{
    //
    public function view(){
        $plan = Plan::find(3);
        $user = User::find(1);
        $comments = $plan->comments->where('parent_comment_id', null);
    	return view('comment',['plan' => $plan, 'user' => $user, 'comments' => $comments]);
    }
    public function postComment(Request $request, $plan_id){
        $user = Auth::user();
        $files = $request->file('comment_images');
        $img = $request->snapShot;
        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->plan_id = $plan_id;

        $comment->content = $request->comment_text;
        $comment->location = $request->address;
        $parent_id = $request->parent_id;
        if(!is_null($parent_id))
            $comment->parent_comment_id = $parent_id;
        $comment->save();

        if($files != null){
           
           foreach($files as $file) {
                $this->saveImage($file, $comment);
            } 
        }

        if(!is_null($img)) {
            $image = new Image;
            $this->saveSnapShot($img, $image, $comment);
        }
        $images = $comment->images;
        $result = array($comment, $images, $user);
        return $result;
    	
    }
    public function saveImage($file, Comment $comment){
        $image = new Image;
        $fileName = 'photo' .rand() . time() .'.'.$file->getClientOriginalExtension();
        $image->path = 'images/comments/' . $fileName;
        $image->comment_id = $comment->id;
        $file->move('images/comments', $fileName);

        $image->save();
    }
    public function saveSnapShot($img,Image $image, Comment $comment){
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
       
        $fileData = base64_decode($img);
        //saving
        $fileName = 'images/comments/photo' . time() .'.png';
        file_put_contents($fileName, $fileData);
        //create Image
        $image->path = $fileName;
        $image->comment_id = $comment->id;
        $image->save();

    }
    public function testORM(){
        $plan = Plan::find(1);
        $comments = $plan->comments->where('parent_comment_id',null);
        foreach($comments as $comment){
            echo $comment->user->username;
            echo "----";
            echo $comment->content;
            echo "<br>";
            if($comment->images->isEmpty()){
                echo "empty<br>";
            }else{
                echo "no<br>";
                echo $comment->images->count();
                echo "<br>";
            }
            foreach($comment->images as $image){
                echo "--image" . $image->path;
                echo "<br>";
            }
            foreach($comment->children as $child){
                echo "---";
                echo $child->user->username;
                echo "<br>";
                echo "---content--" . $child->content;
                echo "<br>";
                foreach($child->images as $childImage){
                    echo "---childImage--" . $childImage->image;
                    echo "<br>";
                }
            }
           
            $count = $comment->images->count();
            $i = 0;
            for($i=0; $i < $count; $i++){
                echo "--------------<br>";
                echo $comment->images[$i];
                echo "<br>------------<br>";
            }
        }
    }
    public function testValidate(Request $request){
        $validator = Validator::make($request->all(),[
            'images.*' => 'image',
        ]);
        echo "validator<br>";
        if ($validator->fails()) {
            return "error";
        }
        $result = array("Hello", "AAA");
        return $result;
    }
}
