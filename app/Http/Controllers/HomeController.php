<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\setting;
use App\CreditReference;
use Hash;
use Redirect;
use Auth;
use Session;
use App\Match;
use App\Banner;
class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $getuser = Auth::user(); 
    if($getuser->agent_level=='SL' && $getuser->list_client=='1'){
      $agent = User::where('parentid','1')->whereNotIn('agent_level',['PL','SL'])->orderBy('user_name')->get();
      $player = User::where('parentid','1')->where('agent_level','PL')->orderBy('user_name')->get();
    }else{
    $agent = User::where('parentid',$getuser->id)->whereNotIn('agent_level',['PL','SL'])->orderBy('user_name')->get();
    $player = User::where('parentid',$getuser->id)->where('agent_level','PL')->orderBy('user_name')->get();
    }
    $banner=Banner::get();
    return view('backpanel/index',compact('agent','player','banner'));
  }   
  public function changepasspage()
  {      
    return view('backpanel/change-password');
  }
  public function changePass($id)
  {      
    $user = User::find($id);
    if($user->agent_level != 'COM'){
      $userdata = CreditReference::where('player_id',$id)->first();
    }
    else{
      $userdata = setting::first();
    }
    return view('backpanel/changePass',compact('id','user','userdata'));
  }
  public function change_pass_first()
  {      
    $getuser = Auth::user();
    $id = $getuser->id;
    $username = $getuser->user_name;
    return view('backpanel/changePassFirst',compact('id','username'));
  }
  public function updatePassword(Request $request,$id)
  {      
    $userData = User::find($id);
    $newpass = $request->newpwd;
    $yourpwd = $request->yourpwd;
    $userpass = Auth::user()->password;
      
    if (Hash::check($yourpwd, $userpass)) { 
      $userData->first_login = 1;
      $userData->password = Hash::make($newpass);        
      $userData->update();        
    }else{
      return Redirect::back()->withErrors(['Your password do not match with current password', 'Password is not match !']);
    }
    return redirect()->route('home')->with('message','Password Change Successfully');
  }
  public function updatePasswordadmin(Request $request,$id)
  {      

    $adminpass= Auth::user();
    $userData = User::find($id);
    $newpass = $request->newpwd;
    $yourpwd = $request->yourpwd;

    $check_updpass = $userData->check_updpass;
    if (Hash::check($yourpwd, $adminpass->password)) {           
      $userData->password = Hash::make($newpass);   
      $userData->check_updpass = $check_updpass+1;     
      $userData->update();        
    }else{   
      return Redirect::back()->with('error', 'Your password do not match with current password!');  
    }   
    return redirect()->route('home')->with('message','Password Change Successfully');
  }
  public function storeReference(Request $request)
  {      
    $userPass = Auth::user()->password;
    $routename = $request->route_name;
    $credit = CreditReference::where('player_id',$request->player_id)->first();
    $count = CreditReference::where('player_id',$request->player_id)->count();
    if (Hash::check($request['current_pass'], $userPass)) { 
      if($count != 0){
        $balance=$credit->credit;
        $balance=$request->credit;
        $credit->credit = $balance;
        $credit->update();
      }else{
        $data = $request->all();
        CreditReference::create($data);
      }
    }else{
      return Redirect::back()->with('error', 'Incorrect password!'); 
    } 
    return redirect()->route($routename)->with('message','Data created successfully.'); 
  }
}
