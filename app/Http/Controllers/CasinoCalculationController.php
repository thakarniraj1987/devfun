<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\CasinoBet;
use Redirect;
use Session;

class CasinoCalculationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function casino_bet(Request $request)
  {

    $getUserCheck = Session::get('playerUser');
    if(!empty($getUserCheck)){
      $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
    }
    $data = $request->all();
    $roundid =  explode('Round ID: ',$request->roundid);   
    //$last_result=app('App\Http\Controllers\RestApi')->getteen20LastResult("teen20"); 
    $i=1;
    /*foreach ($last_result as $value) {           
      if($last_result[$i]['round_id'] == $roundid[1]){
        echo $last_result[$i]['round_id'];
        echo "---".$roundid[1];
      }
      $i++;
    }*/
    $stake_value =  $request->stake_value;    
    $odds_value =  $request->odds_value;   
    $team_name =  $request->team_name;
    if($team_name == 'PAIR PLUS A' || $team_name == 'PAIR PLUS B'){
      $profit = $stake_value;  
    }else{
      $profit = ($odds_value-1)*($stake_value);  
    }
    $data['odds_value']=$odds_value;  
    $data['casino_profit']=$profit;
    $data['casino_name']='teen20';
    $data['user_id']=$getUser->id;
    $data['roundid']=$roundid[1];
    CasinoBet::create($data);
    return response()->json(array('result'=> 'success','team_name'=>$team_name));
    
  }   
  
}
