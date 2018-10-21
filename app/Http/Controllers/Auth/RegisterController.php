<?php

namespace App\Http\Controllers\Auth;

use App\User;
use File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use DateTime;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'birthday' => 'required|date|before:now',
            'avatar' => 'image',
            'gender' => 'required|in:0,1',
        ]);
        
        $user = new User;
        $user->username = $request->input('username');
        $user->fullname = $request->input('fullname');
        $user->email = $request->input('email');
        $user->birthday = $request->input('birthday');
        $user->gender = $request->input('gender');
        $user->password = Hash::make($request->input('password'));
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $file->move('images/users', $user->username.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension());
            $user->avatar = 'images/users/'.$user->username.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension();
        }else{
            $user->avatar = 'images/avatars/default_avatar.png';
        }
        
        $user->save();
        
        return redirect('login');    
        
        
    }
    public function modify(Request $request){
        $this->validate($request,[
            'fullname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'avatar' => 'image|max:5120',
            'gender' => 'required|in:0,1',
            'email' => 'bail|required|email',
        ]);
        
        $user = User::find($request->input('id') );
        if($request->email != $user->email){
             $this->validate($request,[
                'email' => 'unique:users',
            ]);
        }
        $user->fullname = $request->input('fullname');
        $user->birthday = $request->input('birthday');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        if($request->hasFile('avatar')){
            File::delete($request->input('oldAvatar'));
            $file = $request->avatar;
            $file->move('images/users', $user->username.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension());
            $user->avatar = 'images/users/'.  $user->username.'_'.((new DateTime)->getTimestamp()).'.'.$file->getClientOriginalExtension();
        }
        
        $user->save();
        
        return redirect('profile');
    }
}
