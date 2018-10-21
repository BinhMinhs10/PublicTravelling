<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\User;
use Illuminate\Support\Facades\Auth;

class GetUserViewComposer
{
    
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        if(Auth::user()){
            $user = Auth::user();
            $current_user = [
                'username' => $user->username,
                'id' => $user->id,
                'avatar' => $user->avatar
            ];

            $view->with('current_user', $current_user);
        }
    }
}
?>