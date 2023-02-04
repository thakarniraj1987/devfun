<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
Use Redirect;
use Request as resAll;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\CreditReference;
use DB;
use App\setting;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
     protected $redirectTo = '/backpanel/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $user = \DB::table('users')->where('user_name', $request->input('user_name'))->first();

        $mntnc = setting::first();
        
        if (auth()->guard('web')->attempt(['user_name' => $request->input('user_name'), 'password' => $request->input('password')])) {
            if(auth()->user()->status == 'suspend'){
                return Redirect::back()->withErrors(['Contact Upline']);
            }
            if (auth()->user()->agent_level != 'COM')
            {
                if(!empty($mntnc->maintanence_msg))
                {
                    $msg = $mntnc->maintanence_msg;
                    return view('backpanel/maintanence',compact('msg'));
                }
            }

            if (auth()->user()->agent_level != 'COM')
            {
                if(!empty($mntnc->maintanence_msg))
                {
                    return Redirect::back()->withErrors(['Site Under Maintanence']);
                }
            }
            
            if (auth()->user()->agent_level != 'PL')
            {
                $adminUser = Auth::User();
                Session::put('adminUser', $adminUser);
                if(auth()->user()->first_login ==0){

                    return redirect()->route('change_pass_first')->with('message','Account login successfully '); 
                }
                else{
                    return redirect($this->redirectTo);
                }
            }else{
             Auth::logout();             
                return Redirect::back()->withErrors(['Only Admin & Agent can login here !']);
            }   
        }   
        return Redirect::back()->withErrors(['Your username and password wrong!!', 'Your username and password wrong!!']);
    }
    public function username()
    {
       return 'user_name';
    }
    protected function redirectTo()
    {
        if(auth()->user()->agent_level != 'COM' && auth()->user()->first_login==0){
            return '/change_pass_first';
        }else {          
            return '/backpanel/home';
        }
    }
    public function logout()
    {
        Session::forget('adminUser');
        Auth::logout();
        return redirect()->route('backpanel');
    }
}
