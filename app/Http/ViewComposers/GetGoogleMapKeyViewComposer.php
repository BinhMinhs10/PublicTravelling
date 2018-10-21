<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class GetGoogleMapKeyViewComposer
{
    
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $APP_KEY2 = 'AIzaSyBv-UCpY1CgyIrWT8u_Zhmaf0jeLcdFlpI';
        $APP_KEY1 = 'AIzaSyBP-JN55aLbE2fiOC1SaA7tdP89ll8p7Tw';
        $APP_KEY3= 'AIzaSyDdtVaJjFLyHdn0kTk9pF8upC4nNiLlqgM';

        $view->with('APP_KEY', $APP_KEY3);
        
    }
}
?>