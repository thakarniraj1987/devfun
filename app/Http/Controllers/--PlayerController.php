<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\setting;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Request as resAll;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Match;
use App\MyBets;
use Carbon\Carbon;
use App\CreditReference;
use DB;
use Session;
use App\Sport;
use App\UserStake;
use App\ManageTv;
use App\SocialMedia;
use App\Banner;
class PlayerController extends Controller
{
  public function frontLogin(Request $request)
  {
   
	$credentials = $request->only('user_name', 'password');
    $username=$request->user_name;
    $password=$request->password;
    $mntnc = setting::first();
    $userData=User::where('user_name',$username)->first();     
    if (!empty($userData) && Hash::check($password, $userData->password)) {
      if ($userData->agent_level == 'PL')
      {
        $new_sessid   = \Session::getId();            
        $userData->token_val = $new_sessid;
        $userData->check_login = 1;
        $userData->update();
        session(['playerUser' => $userData]);
        if($userData->status == 'suspend')
        {
          $request->session()->forget(['playerUser']);
          return Redirect::back()->with('error', 'Contact to upline!');
        }
        if(!empty($mntnc->maintanence_msg))
        {
          $msg = $mntnc->maintanence_msg;
          return view('backpanel/maintanence',compact('msg'));
        }
        $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $sessionData = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

        if($sessionData->first_login ==0){
          return redirect()->route('change_pass_pl')->with('message','Account login successfully'); 
        }else{
          return redirect()->route('userLogin')->with('message','Account login successfully');
        }
      }else{  
        return Redirect::back()->with('error', 'Only player can login here!');
      }
    }
    return Redirect::back()->with('error', 'Oppes! You have entered invalid credentials!');
  }
  public function userLogin(Request $request)
  {
    $sports = Sport::all();
    $settings = setting::first();
    $restapi=new RestApi();
    $managetv = ManageTv::first();
    $socialdata = SocialMedia::first();
    $banner=Banner::get();
    return view('front.home',compact('sports','settings','managetv','socialdata','banner'));
  }
  public function matchDeclareRedirect(Request $request)
  {
    $match_data = Match::select('winner','status')->where('id',$request->match_id)->first();
    if(!empty($match_data->winner)){
      return response()->json(array('result'=> 'error'));
    } 
    if($match_data->status==0){
      return response()->json(array('result'=> 'error'));
    }    
    return response()->json(array('result'=> 'success'));
  }
  public function changePassLogoutuser(Request $request)
  {
    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $sessionData = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

    $checkstatus=User::where('id',$sessionData->id)->first();
    if($checkstatus->check_updpass!=$sessionData->check_updpass){
      $request->session()->forget(['playerUser']);
      return response()->json(array('result'=> 'error'));
    }
    return response()->json(array('result'=> 'success'));
  }
  public function changePassLogout(Request $request)
  {
    $sessionData = Session::get('adminUser');  
    $checkstatus=User::where('id',$sessionData->id)->first();    
    if($checkstatus->check_updpass!=$sessionData->check_updpass){
      Session::forget('adminUser');
      Auth::logout();
      return response()->json(array('result'=> 'error'));
    }
    return response()->json(array('result'=> 'success'));
  }
  public function maintenanceLogout(Request $request)
  {
    $mntnc = setting::first();
    $getuser = Auth::user();   
    if($getuser->agent_level != 'COM'){
      if(!empty($mntnc->maintanence_msg))
      {        
        
        Auth::logout();
        return response()->json(array('result'=> 'msgsuccess'));
      }
    }    
  }
	public function frontLogin_popup(Request $request)
  {
		$credentials = $request->only('user_name', 'password');
		$username=$request->user_name;
		$password=$request->password;
		$mntnc = setting::first();
    $userData=User::where('user_name',$username)->first();
    if (!empty($userData) && Hash::check($password, $userData->password)) {
      if ($userData->agent_level == 'PL')
      {
        $new_sessid   = \Session::getId();            
        $userData->token_val = $new_sessid;
        $userData->check_login = 1;
        $userData->update();
        session(['playerUser' => $userData]);

        $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $sessionData = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
        if(!empty($mntnc->maintanence_msg))
        {
          return Redirect::back()->with('error', 'Site under maintanence!');
        }
        if($sessionData->first_login ==0){
          return redirect()->route('change_pass_pl')->with('message','Account login successfully'); 
        }else{
          return 'Success';
        }
      }else{  
        return 'Only Player can login here !';     
      }
    }
    return 'Oppes! You have entered invalid credentials';
  }
  public function change_pass_pl()
  {      
    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getuser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
  	$id = $getuser->id;
  	$username = $getuser->user_name;
    return view('front/changePassPL',compact('id','username'));
  }
  public function updatePasswordPL(Request $request,$id)
  {
    $userData = User::find($id);
    $newpass = $request->newpwd;
    $yourpwd = $request->yourpwd;
    if (Hash::check($yourpwd, $userData->password)) { 
      $userData->first_login = 1;
      $userData->password = Hash::make($newpass);        
      $userData->update();        
    }else{
      return Redirect::back()->withErrors(['Your password do not match with current password', 'Password is not match !']);
    }
    return redirect()->route('front')->with('message','Password Change Successfully');
  }
  public function addPlayer(Request $request)
  {
    $getuser = Auth::user();
		$lid=User::create([
      'user_name' => $request->puser_name,
      'password' => Hash::make($request->ppassword),
      'agent_level' => 'PL',
      'first_name' => $request->pfname,
      'last_name' => $request->planame,
      'commission' => $request->pcommission,
      'time_zone' => $request->ptime,
      'parentid' => $getuser->id,
      'first_login' => 0,
      'ip_address' =>resAll::ip(),
    ]);
		$last_id=$lid->id;
		$cref=CreditReference::create([
      'player_id' => $last_id,
      'credit' => 0,
      'remain_bal' => 0,
      'available_balance_for_D_W' => 0,
    ]);
    $teamNameArr = array(100,200,300,400,500,600);
    $ustake = new UserStake();
    $ustake->user_id = $last_id;
    if(is_array($teamNameArr) && count($teamNameArr) > 0){
      $ustake->stake = json_encode($teamNameArr);
    }
    $ustake->save();
    return redirect()->route('home')->with('message','Player created successfully!'); 
  }
	public Static function getBlanceAmount($id = '')
	{
    if(empty($id))
		{
      $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $id = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

			$id=$id->id;
		}
		$depTot = CreditReference::where('player_id',$id)->first();
		$totBalance =$depTot['remain_bal'];
    return $totBalance;
  } 
	public static function getCalLaySession($teanName,$matchID,$userID,$run)
	{
    $myBetsModelLay = MyBets::where([
    	'bet_side'=>'lay',
      'bet_type'=>'SESSION',
      'team_name'=>$teanName,
      'match_id'=>$matchID,
      'user_id'=>$userID,
      'isDeleted'=>0,
			'result_declare'=>0
    ])->get();   
    $layAmount = 0;
    foreach($myBetsModelLay as $key=>$layVal)
		{
      if($run >= $layVal->bet_odds)
			{
        $amt = (($layVal->bet_oddsk*$layVal->bet_amount)/100);
        if($layAmount > 0)
				{
          $layAmount = $amt;
        }
				else
				{
          $layAmount = (0-(abs($layAmount)+$amt));
        }
      }
			else
			{
				if($layAmount > 0)
				{
					$layAmount = ($layAmount+$layVal->bet_amount);
				}
				else
				{
					if($layVal->bet_amount > abs($layAmount))
					{
						$layAmount = ($layVal->bet_amount-abs($layAmount));
					}
					else
					{
						$layAmount = ((abs($layAmount)-$layVal->bet_amount)*(-1));
					}
				}
      }
    }
    return $layAmount;
  }
	public static function getCalBackSession($teanName,$matchID,$userID,$run)
	{
    $myBetsModelBack = MyBets::where([
    	'bet_side'=>'back',
      'bet_type'=>'SESSION',
      'team_name'=>$teanName,
      'match_id'=>$matchID,
      'user_id'=>$userID,
      'isDeleted'=>0,
		  'result_declare'=>0
    ])->get();      
    $backAmount = 0;
    foreach($myBetsModelBack as $key=>$backVal){
      if($run >= $backVal->bet_odds){
        if($backAmount > 0){
          $backAmount = ($backAmount+(($backVal->bet_oddsk*$backVal->bet_amount)/100));
        }
				else
				{
          $backAmount = ((($backVal->bet_oddsk*$backVal->bet_amount)/100)-abs($backAmount));
        }
      }
			else
			{
        $backAmount += ($backVal->bet_amount*(-1));
      }
    }
    return $backAmount;
  }
	public static function getSessionValueByArr($match_id,$teamName,$userID,$winnerRun = NULL)
	{
    $myBetsModelLayMin = MyBets::where([
      'bet_side'=>'lay',
      'bet_type'=>'SESSION',
      'team_name'=>$teamName,
      'match_id'=>$match_id,
      'user_id'=>$userID,
      'isDeleted'=>0,
			'result_declare'=>0
    ])->min('bet_odds');
    $myBetsModelBackMax = MyBets::where([
      'bet_side'=>'back',
      'bet_type'=>'SESSION',
      'team_name'=>$teamName,
      'match_id'=>$match_id,
      'user_id'=>$userID,
      'isDeleted'=>0,
			'result_declare'=>0
    ])->max('bet_odds');
    if(!empty($myBetsModelLayMin) && !empty($myBetsModelBackMax)){
      $min = ($myBetsModelLayMin- 2);
      $max = ($myBetsModelBackMax+2);
    }elseif(!empty($myBetsModelLayMin)){
      $min = ($myBetsModelLayMin- 2);
      $max = ($myBetsModelLayMin+2);
    }elseif(!empty($myBetsModelBackMax)){
      $min = ($myBetsModelBackMax- 2);
      $max = ($myBetsModelBackMax+2);
    }
    if(!is_null($winnerRun)){
      if(!empty($winnerRun) || $winnerRun == 0 ){
        if($min > $winnerRun){
          $min = $winnerRun-2;
        }
        if($max < $winnerRun){
          $max = $winnerRun+2;
        }
      }
    }
    $i = $min;
    $ResultArr = array();
    while($max >= $i){
      $amtB = self::getCalBackSession($teamName,$match_id,$userID,$i);
      $ResultArr['back'][$i] = $amtB;
      $amtL = self::getCalLaySession($teamName,$match_id,$userID,$i);
      $ResultArr['lay'][$i] = $amtL;
      $i++;
    }
    $dataArr = array();
    if(isset($ResultArr['lay'])){
      foreach($ResultArr['lay'] as $run=>$val){
        $pL = 0;
        $profitB = isset($ResultArr['back'][$run]) ? $ResultArr['back'][$run] : 0;

        $profitL =  $val;
        if($profitB < 0 && $profitL < 0){
          $pL = (abs($profitB)+abs($profitL))*(-1);
        }else if($profitB >= 0 && $profitL >= 0){
          $pL = ($profitB+$profitL);
        }else if($profitB >= 0 && $profitL <= 0){
          $pL = ($profitB - abs($profitL));
        }else if($profitB <= 0 && $profitL >= 0){
          if($profitL >= abs($profitB)){
            $pL = ($profitL-abs($profitB));
          }else{
            $pL = ($profitL-abs($profitB));
          }
        }
        $dataArr[$run]['profitLay'] = $profitL;
        $dataArr[$run]['profitBack'] = $profitB;
        $dataArr[$run]['profit'] = $pL;
      }
    }elseIf(isset($ResultArr['back'])){
      foreach($ResultArr['back'] as $run=>$val){
        $pL = 0;
        $profitL = isset($ResultArr['lay'][$run]) ? $ResultArr['lay'][$run] : 0;
        $profitB =  $val;
        if($profitB < 0 && $profitL < 0){
          $pL = (abs($profitB)+abs($profitL))*(-1);
        }else if($profitB > 0 && $profitL > 0){
          $pL = ($profitB+$profitL);
        }else if($profitB > 0 && $profitL < 0){
          $pL = ($profitB - abs($profitL));
        }else if($profitB < 0 && $profitL > 0){
          if($profitL > abs($profitB)){
            $pL = ($profitL-abs($profitB));
          }else{
           $pL = ($profitL-abs($profitB));
          }
        }
        $dataArr[$run]['profitLay'] = $profitL;
        $dataArr[$run]['profitBack'] = $profitB;
        $dataArr[$run]['profit'] = $pL;
      }
    }
    return $dataArr;
  }
	public Static function getExAmountCricketAndTennis($sportID='',$matchid='',$userID='')
	{
		if(empty($userID)){

      $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $userID = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

			$userID = $userID->id;
    	}
		if(empty($sportID) && empty($matchid)){
      		$myBetsModel = MyBets::where(['user_id'=>$userID,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->get();
		}
		elseif(empty($matchid)){
      		$myBetsModel = MyBets::where(['sportID'=>$sportID,'user_id'=>$userID,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->get();
    	}
		elseif(empty($sportID)){
			$myBetsModel = MyBets::where(['match_id'=>$matchid,'user_id'=>$userID,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->get();
		}
		else{
      		$myBetsModel = MyBets::where(['sportID'=>$sportID,'match_id'=>$matchid,'user_id'=>$userID,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->get();
    	}
		$response = array();
    	$arr = array();
    	foreach($myBetsModel as $key=>$bet)
		{
      		$extra = json_decode($bet->extra,true);
      		switch($bet['bet_type'])
			{
        		case "ODDS":
				{
          			if($bet['bet_side'] == 'lay')
					{
            			$profitAmt = $bet['exposureAmt'];
						$profitAmt = ($profitAmt*(-1));
            			if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost']))
						{
             		 		$response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
            			}
						else
						{
              				$response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
            			}
            			if(isset($extra['teamname1']) && !empty($extra['teamname1']))
						{
              				if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet['bet_amount'];
              				}
            			}
						if(isset($extra['teamname2']) && !empty($extra['teamname2']))
						{
              				if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet['bet_amount'];
              				}
            			}
						if(isset($extra['teamname3']) && !empty($extra['teamname3']))
						{
              				if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet['bet_amount'];
              				}
            			}
            			if(isset($extra['teamname4']) && !empty($extra['teamname4']))
						{
							if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost']))
							{
								$response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet['bet_amount'];
							}
							else
							{
								$response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet['bet_amount'];
							}
            			}
          			}
					else
					{
            			$profitAmt = $bet['bet_profit']; ////nnn
						$bet_amt = ($bet['bet_amount']*(-1));
            			if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost']))
						{
              				$response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
            			}
						else
						{
              				$response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
            			}
						if(isset($extra['teamname1']) && !empty($extra['teamname1']))
						{
              				if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet_amt;
              				}
            			}
						if(isset($extra['teamname2']) && !empty($extra['teamname2']))
						{
              				if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet_amt;
              				}
            			}
						if(isset($extra['teamname3']) && !empty($extra['teamname3']))
						{
              				if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet_amt;
              				}
            			}
            			if(isset($extra['teamname4']) && !empty($extra['teamname4']))
						{
             	 			if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost']))
							{
                				$response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet_amt;
              				}
            			}  
          			}
          			break;
        		}
        		case 'BOOKMAKER':
				{
          			$profitAmt = $bet['bet_profit'];
          			if($bet['bet_side'] == 'lay')
					{
            			$profitAmt = ($profitAmt*(-1));
            			if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost']))
						{
              				$response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
            			}
						else
						{
              				$response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
            			}
            			if(isset($extra['teamname1']) && !empty($extra['teamname1']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
              				}
            			}
						if(isset($extra['teamname2']) && !empty($extra['teamname2']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
              				}
            			}
						if(isset($extra['teamname3']) && !empty($extra['teamname3']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
              				}
            			}
					}
					else
					{
            			$bet_amt = ($bet['bet_amount']*(-1));
            			if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost']))
						{
             				$response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
           		 		}
						else
						{
              				$response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
            			}
						if(isset($extra['teamname1']) && !empty($extra['teamname1']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet_amt;
              				}
            			}
						if(isset($extra['teamname2']) && !empty($extra['teamname2']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet_amt;
              				}	
            			}
						if(isset($extra['teamname3']) && !empty($extra['teamname3']))
						{
              				if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost']))
							{
                				$response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet_amt;
              				}
							else
							{
                				$response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet_amt;
              				}
            			}  
          			}
          			break;
        		}
        		case 'SESSION':
				{
          			$response['SESSION']['teamname'][$bet['team_name']] = $bet['team_name'];
          			$exArrData = self::getSessionValueByArr($bet['match_id'],$bet['team_name'],$bet['user_id']);
          			$finalExSes = 0;
          			foreach ($exArrData as $key=>$arr)
					{
            			if($finalExSes > $arr['profit'])
						{
              				$finalExSes = $arr['profit'];
            			}
          			}
          			$response['SESSION']['exposure'][$bet['team_name']]['SESSION_profitLost'] = $finalExSes;
					break;
        		}
      		}
    	}
		return $response;
  	}
	public Static function getExAmount($sportID='',$id = '')
	{
    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
		$id=$getUser->id;
		if(!empty($sportID)){
		  $sportsModel =  Match::where(["id" => $sportID])->first();
		}
		else{		
			//DB::enableQueryLog();
			$sportsModel = MyBets::select('my_bets.id','my_bets.sportID','my_bets.created_at','match.*')->join('match','match.event_id','=','my_bets.match_id')
			->where('my_bets.result_declare',0)
			->where('my_bets.user_id',$id)
			->where('my_bets.isDeleted',0)
			->whereNull('match.winner')
			->orderBy('my_bets.id','Desc')
			->groupby('my_bets.match_id') /// nnn 19-8-2021 put becuase exposer calculating twice as over here this query fetching all same match bets multiple times
			->get(); /// nnn 7-8-2021
			//dd(DB::getQueryLog());
    	}
    	$exAmtTot = 0;
    	foreach($sportsModel as $keyMatch=>$matchVal)
		{
			$gameModel = Sport::where(["sId" => $matchVal->sports_id])->first();
      		if(strtoupper($gameModel->sport_name) == 'CRICKET' ||  strtoupper($gameModel->sport_name) == 'TENNIS' || strtoupper($gameModel->sport_name) == 'CASINO' || strtoupper($gameModel->sport_name)=='SOCCER') 
			{
				if(strtoupper($gameModel->name) == 'CASINO')
				{
          			$exAmtArr = self::getExAmountCricketAndTennis($matchVal->id,'',$id);
        		}
				else
				{
					$matchid = $matchVal->event_id;
          			$exAmtArr = self::getExAmountCricketAndTennis('',$matchid,$id);
				}
				if(isset($exAmtArr['ODDS']))
				{
          			$arr = array();
          			foreach($exAmtArr['ODDS'] as $key=>$profitLos)
					{
            			if($profitLos['ODDS_profitLost'] < 0)
						{
              				$arr[abs($profitLos['ODDS_profitLost'])] = abs($profitLos['ODDS_profitLost']);
            			}
          			}
					if(is_array($arr) && count($arr) > 0)
					{
						$exAmtTot += max($arr);
          			}
        		}
				
        		if(isset($exAmtArr['BOOKMAKER']))
				{
          			$arrB = array();
          			foreach($exAmtArr['BOOKMAKER'] as $key=>$profitLos)
					{
						if($profitLos['BOOKMAKER_profitLost'] < 0)
						{
							$arrB[abs($profitLos['BOOKMAKER_profitLost'])] = abs($profitLos['BOOKMAKER_profitLost']);
						}
          			}
          			if(is_array($arrB) && count($arrB) > 0)
					{
            			$exAmtTot += max($arrB);
          			}
        		}
        		if(isset($exAmtArr['SESSION']))
				{
          			foreach($exAmtArr['SESSION']['exposure'] as $key=>$sesVal){
						$exAmtTot += abs($sesVal['SESSION_profitLost']);
          			}
        		}
      		}
			
    	}
		
		
		return round(abs($exAmtTot));
  	}
	public function getPlayerBalance()
	{
		$balance=SELF::getBlanceAmount();
		$exposer=SELF::getExAmount();
		return number_format(($balance-$exposer),2).'~~'.number_format($exposer,2);
	}
	public function SaveBalance($stack)
	{
    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

		$userId =$getUser->id;
		$creditref=CreditReference::where(['player_id'=>$userId])->first();
		
		$balance=SELF::getBlanceAmount();
		$exposer=SELF::getExAmount();
		
		$upd=CreditReference::find($creditref['id']);
		$upd->exposure = $exposer;
		$upd->available_balance_for_D_W =($balance-$exposer);
		$upd->update();
		return $exposer;
	}
	public Static function getExAmountSoccer($sportID='',$userID='')
	{
		if(empty($userID))
			{
				$getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
				$userId = $getUser->id;
		}
		$myBetsModel = MyBets::where(['sportID'=>$sportID,'user_id'=>$userID,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->get();
		$response = array();
		$arr = array();
		foreach($myBetsModel as $key=>$bet)
			{
			$extra = json_decode($bet->extra,true);
		  $betTypeArr = explode('-', $bet['bet_type']);
		  switch($betTypeArr[0])
				{
			case "ODDS":
					{
			  $profitAmt = $bet['bet_profit'];
			  if($bet['bet_side'] == 'lay')
						{
				$profitAmt = ($profitAmt*(-1));
				if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost']))
							{
				  $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
				}
							else
							{
				  $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
				}
				if(isset($extra['teamname1']) && !empty($extra['teamname1']))
							{
				  if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet['bet_amount'];
				  }
								else
								{
					$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet['bet_amount'];
				  }
				}
							if(isset($extra['teamname2']) && !empty($extra['teamname2']))
							{
				  if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet['bet_amount'];
				  }
								else
								{
					$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet['bet_amount'];
				  }
				}
							if(isset($extra['teamname3']) && !empty($extra['teamname3']))
							{
				  if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet['bet_amount'];
				  }
								else
								{
					$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet['bet_amount'];
				  }
				}
						}
						else
						{
				$bet_amt = ($bet['bet_amount']*(-1));
				if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost']))
							{
				  $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
				}
							else
							{
				  $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
				}
							if(isset($extra['teamname1']) && !empty($extra['teamname1']))
							{
				  if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet_amt;
				  }
								else
								{
					$response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet_amt;
				  }
				}
							if(isset($extra['teamname2']) && !empty($extra['teamname2']))
							{
				  if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet_amt;
				  }
								else
								{
					$response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet_amt;
				  }
				}
							if(isset($extra['teamname3']) && !empty($extra['teamname3']))
							{
				  if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost']))
								{
					$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet_amt;
				  }
								else
								{
					$response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet_amt;
				  }
				}  
			  }
			  break;
			}
			case 'SESSION':
					{
			  $profitAmt = $bet['bet_profit'];
			  if($bet['bet_side'] == 'lay')
						{
				$profitAmt = ($profitAmt*(-1));
				if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost']))
							{
				  $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
				}
							else{
				  $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
				}
				if(isset($extra['teamname1']) && !empty($extra['teamname1']))
							{
				  if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost']))
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] = $bet['bet_amount'];
				  }
								else
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] += $bet['bet_amount'];
				  }
				}
	
				if(isset($extra['teamname2']) && !empty($extra['teamname2']))
							{
				  if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost']))
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] = $bet['bet_amount'];
				  }
								else
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] += $bet['bet_amount'];
				  }
				}
			  }
						else
						{
				$bet_amt = ($bet['bet_amount']*(-1));
				if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost']))
							{
				  $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
				}
							else
							{
				  $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
				}
				if(isset($extra['teamname1']) && !empty($extra['teamname1']))
							{
				  if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost']))
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] = $bet_amt;
				  }
								else
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] += $bet_amt;
				  }
				}
							if(isset($extra['teamname2']) && !empty($extra['teamname2']))
							{
				  if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost']))
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] = $bet_amt;
				  }
								else
								{
					$response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] += $bet_amt;
				  }
				}
			  }
			  break;
			}
		  }  
		}
		return $response;
  	}
	public function getMainOdds($matchid,$betside)
	{
		$matchList = Match::where('event_id',$matchid)->where('status',1)->first(); 
		$matchId=$matchList['match_id'];
		$event_id=$matchList['event_id'];
		$matchtype=$matchList['sports_id'];
		$match_m=$matchList['suspend_m'];
		$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$event_id,$matchtype);
		$team1=$team2=$team3='';
		if($match_data!=0)
		{
			$html_chk='';
			if($match_m=='0')
			{
				if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
				{
					$team3='Suspend';
				}
				$team1='Suspend';
				$team2='Suspend';
			}
			else
			{
				if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
				{
					if($betside=='back')
						$team3=@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'];
					else
						$team3=@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'];
				}
				//check status
				if(@$match_data[0]['status']=='OPEN')
				{
					if(isset($match_data[0]['runners'][0]['ex']['availableToBack'][2]['price']))
					{
						if($betside=='back')
							$team1=@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'];
						else
							$team1=@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'];
					}
					else
					{
						if($betside=='back')
							$team1='';
						else
							$team1='';
					}
				}
				else
				{
					if($betside=='back')
						$team1='';
					else
						$team1='';
				}
				if(@$match_data[0]['status']=='OPEN')
				{
					if(isset($match_data[0]['runners'][1]['ex']['availableToBack'][2]['price']))
					{
						if($betside=='back')
							$team2=@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'];
						else
							$team2=@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'];
					}
					else
					{
						if($betside=='back')
							$team2='';
						else
							$team2='';
					}
				}
				else
				{
					if($betside=='back')
						$team2='';
					else
						$team2='';
				}
			}
		}
		return $team1.'~~'.$team2.'~~'.$team3;	
	}
	public function getMainBMOdds($matchid,$teamname,$position,$betside,$odds)
	{
		$matchList = Match::where('event_id',$matchid)->where('status',1)->first(); 
		$event_id=$matchList['event_id'];
		$matchtype=$matchList['sports_id'];
		$match_m=$matchList['suspend_b'];
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($matchid,$event_id,$matchtype);
		$team1=$team2=$team3='';
		if($match_data!=0)
		{
			$html_chk='';
			if($match_m=='1')
			{
				if(@$match_data['bm'][0]['status']!='ACTIVE' && strtolower(@$match_data['bm'][0]['nation'])==strtolower($teamname))
				{
					return 'Suspend';
				}
				else if(@$match_data['bm'][1]['status']!='ACTIVE' && strtolower(@$match_data['bm'][1]['nation'])==strtolower($teamname))
				{
					return 'Suspend';
				}
				else if(@$match_data['bm'][2]['status']!='ACTIVE' && strtolower(@$match_data['bm'][2]['nation'])==strtolower($teamname))
				{
					return 'Suspend';
				}
				else
				{
					if(@$match_data['bm'][0]['status']=='ACTIVE' && strtolower(@$match_data['bm'][0]['nation'])==strtolower($teamname))
					{
						if($betside=='lay')
						{
							if($position==0)
							{
								if(round($match_data['bm'][0]['l1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][0]['l2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][0]['l3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
						elseif($betside=='back')
						{
							if($position==0)
							{
								if(round($match_data['bm'][0]['b1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][0]['b2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][0]['b3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
					}
					else if(@$match_data['bm'][1]['status']=='ACTIVE' && strtolower(@$match_data['bm'][1]['nation'])==strtolower($teamname))
					{
						if($betside=='lay')
						{
							if($position==0)
							{
								if(round($match_data['bm'][1]['l1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][1]['l2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][1]['l3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
						elseif($betside=='back')
						{
							if($position==0)
							{
								if(round($match_data['bm'][1]['b1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][1]['b2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][1]['b3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
					}
					else if(@$match_data['bm'][2]['status']=='ACTIVE' && strtolower(@$match_data['bm'][2]['nation'])==strtolower($teamname))
					{
						if($betside=='lay')
						{
							if($position==0)
							{
								if(round($match_data['bm'][2]['l1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][2]['l2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][2]['l3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
						elseif($betside=='back')
						{
							if($position==0)
							{
								if(round($match_data['bm'][2]['b1'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==1)
							{
								if(round($match_data['bm'][2]['b2'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							else if($position==2)
							{
								if(round($match_data['bm'][2]['b3'])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
					}
				}
			}
			else
			return 'Suspend';
		}
	} 
	public function getMainFancyOdds($matchid,$teamname,$betside,$odds)
	{
		$matchList = Match::where('event_id',$matchid)->where('status',1)->first(); 
		$event_id=$matchList['event_id'];
		$matchtype=$matchList['sports_id'];
		$match_f=$matchList['suspend_f'];
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($matchid,$event_id,$matchtype);
		$team1=$team2=$team3='';
		$nat=array(); $gstatus=array(); $b=array(); $l=array(); $bs=array(); $ls=array(); $min=array(); $max=array(); $sid=array();
		if($match_data!=0)
		{
			if($match_f=='1')
			{
				foreach ($match_data['fancy'] as $key => $value) {
					$sid_val='';
					foreach($value as $key1 => $value1)
					{
						if($key1=='sid')
						{
							$sid_val=$value1;
							$sid[]=$value1;
						}
						if($key1=='nat')
							$nat[$sid_val]=$value1;
						if($key1=='gstatus')
						{
							$gstatus[$sid_val]=$value1;
						}
						if($key1=='b1')
							$b[$sid_val]=$value1;
						if($key1=='l1')
							$l[$sid_val]=$value1;
						if($key1=='bs1')
							$bs[$sid_val]=$value1;
						if($key1=='ls1')
							$ls[$sid_val]=$value1;
						if($key1=='min')
							$min[$sid_val]=$value1;
						if($key1=='max')
							$max[$sid_val]=$value1;
					}
				}
				sort($sid); $check_fancy=0;
				for($i=0;$i<sizeof($sid);$i++)
				{
					if($nat[$sid[$i]]==$teamname)
					{
						if($gstatus[$sid[$i]]!="")
						{
							return 'Suspend';
						}
						else
						{
							if($betside=='lay')
							{
								if(round($l[$sid[$i]])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
							if($betside=='back')
							{
								if(round($b[$sid[$i]])!=$odds)
								{
									return 'Odds Changed!';
								}
							}
						}
						$check_fancy=1;
					}
				}
				if($check_fancy==0)
				{
					return 'Suspend';
				}
			}
		}
	}
	public function CheckForOtherMatchBet($eventid)
	{
		$getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
		$userId = $getUser->id;
		$myBetsModel = MyBets::orWhere('match_id','!=',$eventid)->where(['user_id'=>$userId,'active'=>1,'isDeleted'=>0,'result_declare'=>0])->orderby('id','DESC')->count();
		return $myBetsModel;
	}
	public function  CheckForOtherMatchBetAmount($match_id)
	{
		$getUserCheck = Session::get('playerUser');
    if(!empty($getUserCheck)){
      $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
    }
		$id=$getUser->id;
		
		//DB::enableQueryLog();
		$sportsModel = MyBets::select('my_bets.id','my_bets.sportID','my_bets.created_at','match.*')->join('match','match.event_id','=','my_bets.match_id')
		->where('my_bets.result_declare',0)
		->where('my_bets.user_id',$id)
		->where('my_bets.isDeleted',0)
		->where('my_bets.match_id','!=',$match_id)
		->whereNull('match.winner')
		->orderBy('my_bets.id','Desc')
		->groupby('my_bets.match_id') /// nnn 19-8-2021 put becuase exposer calculating twice as over here this query fetching all same match bets multiple times
		->get(); /// nnn 7-8-2021
		//dd(DB::getQueryLog());
    	
    	$exAmtTot = 0;
    	foreach($sportsModel as $keyMatch=>$matchVal)
		{
			$gameModel = Sport::where(["sId" => $matchVal->sports_id])->first();
      		if(strtoupper($gameModel->sport_name) == 'CRICKET' ||  strtoupper($gameModel->sport_name) == 'TENNIS' || strtoupper($gameModel->sport_name) == 'CASINO' || strtoupper($gameModel->sport_name)=='SOCCER') 
			{
				$matchid = $matchVal->event_id;
          		$exAmtArr = self::getExAmountCricketAndTennis('',$matchid,$id);
				if(isset($exAmtArr['ODDS']))
				{
          			$arr = array();
          			foreach($exAmtArr['ODDS'] as $key=>$profitLos)
					{
            			if($profitLos['ODDS_profitLost'] < 0)
						{
              				$arr[abs($profitLos['ODDS_profitLost'])] = abs($profitLos['ODDS_profitLost']);
            			}
          			}
					if(is_array($arr) && count($arr) > 0)
					{
						$exAmtTot += max($arr);
          			}
        		}
				
        		if(isset($exAmtArr['BOOKMAKER']))
				{
          			$arrB = array();
          			foreach($exAmtArr['BOOKMAKER'] as $key=>$profitLos)
					{
						if($profitLos['BOOKMAKER_profitLost'] < 0)
						{
							$arrB[abs($profitLos['BOOKMAKER_profitLost'])] = abs($profitLos['BOOKMAKER_profitLost']);
						}
          			}
          			if(is_array($arrB) && count($arrB) > 0)
					{
            			$exAmtTot += max($arrB);
          			}
        		}
        		if(isset($exAmtArr['SESSION']))
				{
          			foreach($exAmtArr['SESSION']['exposure'] as $key=>$sesVal){
						$exAmtTot += abs($sesVal['SESSION_profitLost']);
          			}
        		}
      		}
			
    	}
		return round(abs($exAmtTot));
	}
	public function MyBetStore(Request $request)
	{
		$requestData = $request->all();
    	$requestData = $request->all();
		$main_odds=''; $team1_main_odds=''; $team2_main_odds=''; $team3_main_odds='';
		//odds check
		if($requestData['bet_type'] === 'ODDS' && $requestData['bet_side'] == 'back'){
			$main_odds=self::getMainOdds($requestData['match_id'],$requestData['bet_side']);
			if($main_odds!='')
			{
				$odd=explode("~~",$main_odds);
				$team1_main_odds=$odd[0];
				$team2_main_odds=$odd[1];
				$team3_main_odds=$odd[2];
			}
		}
		if($requestData['bet_type'] === 'ODDS' && $requestData['bet_side'] == 'lay'){
			$main_odds=self::getMainOdds($requestData['match_id'],$requestData['bet_side']);
			if($main_odds!='')
			{
				$odd=explode("~~",$main_odds);
				$team1_main_odds=$odd[0];
				$team2_main_odds=$odd[1];
				$team3_main_odds=$odd[2];
			}
		}
		// bm odds check
		if($requestData['bet_type'] === 'BOOKMAKER'){
			$main_odds=self::getMainBMOdds($requestData['match_id'],$requestData['team_name'],$requestData['bet_position'],$requestData['bet_side'],$requestData['bet_odds']);
			if($main_odds=='Suspend')
			{
				$responce['status']='false';
				$responce['msg']='Odds Changed!';
				return json_encode($responce);
				exit;
			}
			else if($main_odds=='Odds Changed!')
			{
				$responce['status']='false';
				$responce['msg']='Odds Changed!';
				return json_encode($responce);
				exit;
			}
		}
		// session odds check
		if($requestData['bet_type'] === 'SESSION'){
			$main_odds=self::getMainFancyOdds($requestData['match_id'],$requestData['team_name'],$requestData['bet_side'],$requestData['bet_odds']);
			if($main_odds=='Suspend')
			{
				$responce['status']='false';
				$responce['msg']='Odds Changed!';
				return json_encode($responce);
				exit;
			}
			else if($main_odds=='Odds Changed!')
			{
				$responce['status']='false';
				$responce['msg']='Odds Changed!';
				return json_encode($responce);
				exit;
			}
		}
		if(isset($requestData['team_name']) && !empty($requestData['team_name'])){
      		$requestData['team_name'] = urldecode($requestData['team_name']);
    	}
		if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
		  $requestData['teamname1'] = urldecode($requestData['teamname1']);
		}
		if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
		  $requestData['teamname2'] = urldecode($requestData['teamname2']);
		}
		if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
		  $requestData['teamname3'] = urldecode($requestData['teamname3']);
		}

		$getUserCheck = Session::get('playerUser');
		if(!empty($getUserCheck)){
		  $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
		}
		$userId = $getUser->id;
    	$user = User::find($userId);
		$stack=$requestData['stack'];
   	 	$sportsModel =  Match::where(['event_id'=>$requestData['match_id']])->first();
		$locked_user=json_decode($sportsModel->user_list);
		if(!empty($locked_user))
		{
			if(in_array($userId,$locked_user))
			{
				$responce['status']='false';
				$responce['msg']='Bet Locked By Admin!';
				return json_encode($responce);
				exit;
			}
		}
		//check if user placed bet on other match or not
		$other_bet_placed = SELF::CheckForOtherMatchBet($requestData['match_id']);
		$other_bet_placed_amount = SELF::CheckForOtherMatchBetAmount($requestData['match_id']);
		
		$min_bet_odds_limit=$sportsModel->min_bet_odds_limit;
		$max_bet_odds_limit =$sportsModel->max_bet_odds_limit;
		
		$min_bet_bm_limit=$sportsModel->min_bookmaker_limit;
		$max_bet_bm_limit =$sportsModel->max_bookmaker_limit;
		
		$min_bet_fancy_limit=$sportsModel->min_fancy_limit;
		$max_bet_fancy_limit =$sportsModel->max_fancy_limit;
		
		$max_odds_limit=$sportsModel->odds_limit;
		
		if($max_odds_limit < $requestData['bet_odds'] && $requestData['bet_type'] === 'ODDS'){
      		$responce['status']='false';
		  	$responce['msg']='Odds Limit Exceed!';
		  	return json_encode($responce);
			exit;
    	}
		$exArr = explode('-', $requestData['bet_type']);
		$betTypeOld = $requestData['bet_type'];
		$requestData['bet_type'] = $exArr[0];
		$headerUserBalance = SELF::getBlanceAmount();
		if($headerUserBalance <= 0){			
			$responce['status']='false';
			$responce['msg']='Insufficent Balance!';
			return json_encode($responce);
			exit;
		}
		
		$exposureAmt = SELF::getExAmount();
		$expAmt = $exposureAmt;
		$betamount = $requestData['bet_amount'];
		$headerUserBalance = SELF::getBlanceAmount();
		
		if($headerUserBalance <= 0)
		{
			$responce['status']='false';
			$responce['msg']='Insufficent Balance!';
			return json_encode($responce);
			exit;
		}
		$isExBalEq = false;
		if($headerUserBalance == $exposureAmt){
		  $isExBalEq = true;
		}

		$deduct_expo_amt=0;
		if($requestData['bet_type'] === 'ODDS')
		{
			if($requestData['bet_side'] == 'lay')
			{
				$betodds='';
				if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') 
				{
					if($requestData['bet_odds']>=$team1_main_odds)
							$betodds=$team1_main_odds;
					}
					else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
					{
						if($requestData['bet_odds']>=$team1_main_odds)
							$betodds=$team2_main_odds;
					}
					else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
					{
						if($requestData['bet_odds']>=$team1_main_odds)
							$betodds=$team2_main_odds;
					}
					else
					{  	 					
						$responce['status']='false';
						$responce['msg']='ODDS Changed!';
						return json_encode($responce);
						exit;
					}
					if($betodds!='')
						$deduct_expo_amt = ((($betodds-1)*$stack));
					else
						$deduct_expo_amt = ((($requestData['bet_odds']-1)*$stack));
				}
				else
				{
					$deduct_expo_amt = $stack; 
				}	
			}
			if($requestData['bet_type'] === 'BOOKMAKER')
			{
				if($requestData['bet_side'] == 'lay'){
					$deduct_expo_amt = ((($requestData['bet_odds'])*$stack));
				}
				else
				{
					$deduct_expo_amt = $stack;
				}	
			}
			if($requestData['bet_type'] === 'SESSION')
			{
				if($requestData['bet_side'] == 'lay'){
					$deduct_expo_amt = ((($requestData['odds_volume'])*$stack))/100;
				}
				else
				{
					$deduct_expo_amt = $stack;
				}	
			}
			if($headerUserBalance < ($exposureAmt+$deduct_expo_amt))
			{
				
				if($headerUserBalance < ($exposureAmt+$deduct_expo_amt) && $exposureAmt<=0)
				{  	
					$responce['status']='false';
					$responce['msg']='Insufficent Balance-aaaa!';
					return json_encode($responce);
					exit;
				}
			
				$fval = $stack;
				$team1_bet_count_new=0; $team2_bet_count_new=0; $finalValue=''; $team3_bet_count_new=0;
				if($requestData['bet_type'] === 'ODDS' && $requestData['bet_type'] != 'SESSION')
				{
					$betodds='';
					if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') 
					{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team1_main_odds)
								$betodds=$team1_main_odds;
							else
							{ 	 				
								$responce['status']='false';
								$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team1_main_odds)
								$betodds=$team1_main_odds;
							else
							{ 	 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
					}
					else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
					{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team2_main_odds)
								$betodds=$team2_main_odds;
							else
							{	
								$responce['status']='false';
								$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team2_main_odds)
								$betodds=$team2_main_odds;
							else
							{ 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
					}
					else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
					{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team3_main_odds)
								$betodds=$team3_main_odds;
							else
							{	 	
								$responce['status']='false';
							$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team3_main_odds)
								$betodds=$team3_main_odds;
							else
							{ 	 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed!';
								return json_encode($responce);
								exit;
							}
						}
					}
					if($betodds!='')
						$finalValue = ((($betodds-1)*$stack));
					else
						$finalValue = ((($requestData['bet_odds']-1)*$stack));
				}
				else if($requestData['bet_type'] === 'BOOKMAKER') 
				{
					$finalValue = (($requestData['bet_odds']) * $stack)/100;
				} 
				else if($requestData['bet_type'] === 'SESSION') 
				{
					$finalValue = (($requestData['odds_volume']) * $stack) / 100;
				} 
				$heighest_negative_odds='';
				if($requestData['bet_type'] === 'ODDS')
				{
					if($requestData['bet_side'] == 'back')
					{
						if ($requestData['team1'] == $requestData['team_name']) 
						{
							$old_value = $requestData['team1_total'];
							if ($old_value != '') 
							{
								 $finalValue = $old_value + $finalValue;
							}
							$team1_bet_count_new=round($finalValue,2);
							$fval_new = '';
						   
							$old_value_team2 = $requestData['team2_total'];
							if ($old_value_team2 != '') 
							{
								  $fval_new =$old_value_team2 - $fval;
							}
							$team2_bet_count_new=$fval_new;
						   
							$old_value_team3 = $requestData['team3_total'];
							if ($old_value_team3 != '') 
							{
								$fval_new =$old_value_team3 - $fval;
							}
							$team3_bet_count_new=$fval_new;
						}
						if ($requestData['team2'] == $requestData['team_name'])
						{
							$old_value = $requestData['team2_total'];
							  if ($old_value != '') {
								$finalValue = ($old_value + $finalValue);
							}
							$team2_bet_count_new=round($finalValue,2);
							$fval_new = '';
						   
							$old_value_team1 = $requestData['team1_total'];
							if ($old_value_team1 != '') {
								$fval_new =$old_value_team1 - $fval;
							}
							$team1_bet_count_new=$fval_new;
							
							$old_value_team3 = $requestData['team3_total'];
							if ($old_value_team3 != '') {
							$fval_new =$old_value_team3 - $fval;
							}
							$team3_bet_count_new=$fval_new;
						}
						if ($requestData['team3'] == $requestData['team_name'])
						{
							$old_value = $requestData['team3_total'];
							if ($old_value != '') {
								$finalValue = $old_value + $finalValue;
							}
							$team3_bet_count_new=round($finalValue,2);
							$fval_new = '';
						   
							$old_value_team1 = $requestData['team1_total'];
							if ($old_value_team1 != '') {
								$fval_new =$old_value_team1 - $fval;
							}
							$team1_bet_count_new=$fval_new;
							
							$old_value_team2 = $requestData['team2_total'];
							if ($old_value_team2 != '') {
								$fval_new =$old_value_team2 - $fval;
							}
							$team2_bet_count_new=$fval_new;
						}
					}
					if($requestData['bet_side'] == 'lay')
					{
					   if ($requestData['team1'] == $requestData['team_name']) 
					   {
						   $old_value = $requestData['team1_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team1_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team2 = $requestData['team2_total'];
						   if ($old_value_team2 != '') {
								$fval_new = $old_value_team2 + $fval;
						   }
						   $team2_bet_count_new=round($fval_new,2);
						   
						   $old_value_team3 = $requestData['team3_total'];
						   if ($old_value_team3 != '') {
								$fval_new =$old_value_team3 + $fval;
						   }
						   $team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team2'] == $requestData['team_name']) 
					   {
						   $old_value = $requestData['team2_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team2_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team1 = $requestData['team1_total'];
						   if($old_value_team1 != '') {
								$fval_new = $old_value_team1 + $fval;
						   }
						   $team1_bet_count_new=$fval_new;
						   
						   $old_value_team3 = $requestData['team3_total'];
						   if($old_value_team3 != '') {
								$fval_new = $old_value_team3 + $fval;
						   }
						   $team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team3'] == $requestData['team_name']) {
						   $old_value = $requestData['team3_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team3_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team1 = $requestData['team1_total'];
						   if($old_value_team1 != '') {
								$fval_new = $old_value_team1 + $fval;
						   }
						   $team1_bet_count_new=$fval_new;
						   
						   $old_value_team2 = $requestData['team2_total'];
						   if($old_value_team2 != '') {
								$fval_new = $old_value_team2 + $fval;
						   }
						   $team2_bet_count_new=$fval_new;
					   }
				   	}
			   
				   //calculate highest amount for exposure for odds 
				   if($team1_bet_count_new<0 || $team2_bet_count_new<0 || $team3_bet_count_new<0 )
				   {
					   $heighest_negative_odds=''; $heighest_negative_bm='';
					   if($team1_bet_count_new<0)
					   {
						   $check=0;
						   if($team2_bet_count_new<0)
						   { 
								if($team2_bet_count_new<0 && abs($team2_bet_count_new) > abs($team1_bet_count_new))
								{   /* ///nnn $team2_bet_count_new<0 && put this condition as it showing insuf. balance - 15-9-2021 where we have bet on other match */
									$check=1;
									$heighest_negative_odds=$team2_bet_count_new;
								}
								else{
									$check=1;
									$heighest_negative_odds=$team1_bet_count_new;
								}
						   }
						   if($team3_bet_count_new<0 && $requestData['team3']!='')
						   { 
								if(abs($team3_bet_count_new) > abs($team1_bet_count_new)){
									$check=1;
									$heighest_negative_odds=$team3_bet_count_new;
								}
								else{ 
									$check=1;
									$heighest_negative_odds=$team1_bet_count_new;
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_odds=$team1_bet_count_new;
						   }
					   }
					   if($team2_bet_count_new<0)
					   {
						   $check=0;
						   if($team2_bet_count_new<0)
						   { 
								if($team1_bet_count_new<0 && abs($team1_bet_count_new) > abs($team2_bet_count_new))
								{ /* ///nnn $team1_bet_count_new<0 && put this condition as it showing insuf. balance - 15-9-2021 where we have bet on other match */
									$check=1;
									$heighest_negative_odds=$team1_bet_count_new;
								}
								else{
									$check=1;
									$heighest_negative_odds=$team2_bet_count_new;
								}
						   }
						   if($team3_bet_count_new<0 && $requestData['team3']!='')
						   { 
								if(abs($team3_bet_count_new) > abs($team2_bet_count_new))
								{
									$check=1;
									$heighest_negative_odds=$team3_bet_count_new;
								}
								else
								{
									$check=1;
									$heighest_negative_odds=$team2_bet_count_new;
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_odds=$team2_bet_count_new;
						   }
					   }
					   if($team3_bet_count_new<0 && $requestData['team3']!='')
					   {
						   $check=0;
						   if($team2_bet_count_new<0)
						   { 
								if(abs($team2_bet_count_new) > abs($team3_bet_count_new))
								{
									$check=1;
									$heighest_negative_odds=$team2_bet_count_new;
								}
								else{
									$check=1;
									$heighest_negative_odds=$team3_bet_count_new;
								}
						   }
						   if($team1_bet_count_new<0)
						   { 
								if(abs($team1_bet_count_new) > abs($team3_bet_count_new))
								{
									$check=1;
									$heighest_negative_odds=$team1_bet_count_new;
								}
								else{
									$check=1;
									$heighest_negative_odds=$team3_bet_count_new;
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_odds=$team3_bet_count_new;
						   }
					   }
					   
					   //for bm highest
					   if($requestData['team1_BM_total']<0)
					   {
						   $check=0;
						   if($requestData['team2_BM_total']<0)
						   { 
								if(abs($requestData['team2_BM_total']) > abs($requestData['team1_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team2_BM_total'];
								}
								else{
									$check=1;
									$heighest_negative_bm=$requestData['team1_BM_total'];
								}
						   }
						   if($requestData['team3']!='' && $requestData['team3_BM_total']<0)
						   { 
								if(abs($requestData['team3_BM_total']) > abs($requestData['team1_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team3_BM_total'];
								}
								else{ 
									$check=1;
									$heighest_negative_bm=$requestData['team1_BM_total'];
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_bm=$requestData['team1_BM_total'];
						   }
					   }
					   if($requestData['team2_BM_total']<0)
					   {
						   $check=0;
						   if($requestData['team2_BM_total']<0)
						   { 
								if(abs($requestData['team1_BM_total']) > abs($requestData['team2_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team1_BM_total'];
								}
								else{
									$check=1;
									$heighest_negative_bm=$requestData['team2_BM_total'];
								}
						   }
						   if($requestData['team3_BM_total']<0 && $requestData['team3']!='')
						   { 
								if(abs($requestData['team3_BM_total']) > abs($requestData['team2_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team3_BM_total'];
								}
								else{
									$check=1;
									$heighest_negative_bm=$requestData['team2_BM_total'];
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_bm=$requestData['team2_BM_total'];
						   }
					   }
					   if($requestData['team3']!='' && $requestData['team3_BM_total']<0)
					   {
						   $check=0;
						   if($requestData['team2_BM_total']<0)
						   { 
								if(abs($requestData['team2_BM_total']) > abs($requestData['team3_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team2_BM_total'];
								}
								else{
									$check=1;
									$heighest_negative_bm=$requestData['team3_BM_total'];
								}
						   }
						   if($requestData['team1_BM_total']<0)
						   { 
								if(abs($requestData['team1_BM_total']) > abs($requestData['team3_BM_total'])){
									$check=1;
									$heighest_negative_bm=$requestData['team1_BM_total'];
								}
								else{
									$check=1;
									$heighest_negative_bm=$requestData['team3_BM_total'];
								}
						   }
						   if($check==0)
						   {
							  $heighest_negative_bm=$requestData['team3_BM_total'];
						   }
					   }
					   
					   $total_negative_number = '';
					   if($heighest_negative_odds!='' && $heighest_negative_odds<=0 &&  $heighest_negative_bm!='' && $heighest_negative_bm<=0)
					   {
						   $total_negative_number = abs($heighest_negative_odds)+abs($heighest_negative_bm);
					   }
					   else if($heighest_negative_odds!='' && $heighest_negative_odds<=0 && $heighest_negative_bm=='')
					   {
						   $total_negative_number =$heighest_negative_odds;
					   }
					   else if($heighest_negative_bm!='' && $heighest_negative_bm<=0 && $heighest_negative_odds=='')
					   {
						   $total_negative_number =$heighest_negative_bm;
					   }
					   
					   $fancy_exposer=0;
					   if($requestData['fancy_total']!=0)
					   {
						   $fancy_exposer=$requestData['fancy_total'];
						   $total_negative_number=abs($total_negative_number)+abs($fancy_exposer);
					   }
					   
					   if($headerUserBalance < abs($total_negative_number)) //team3 condition remaining
					   {
							$responce['status']='false';
							$responce['msg']='Insufficent Balance!';
							return json_encode($responce);
							exit;
					   }
					   /*echo 'highest negative odds--'.$heighest_negative_odds;
					   echo "<br>";
					   echo 'team 1 total-'.$team1_bet_count_new;
					   echo "<br>";
					   echo 'team 2 total-'.$team2_bet_count_new;
					   echo "<br>";
					   echo 'team 3 total-'.$team3_bet_count_new;
					   echo "<br>";
					   
					   echo $headerUserBalance;
					   echo "<br>";
					   echo 'other-'.$other_bet_placed;
					   echo "<br>";
					   echo 'total neg-'.$total_negative_number;
					   echo "<br>";
					   echo 'new-expo-'.$exposureAmt;
					   echo "<br>";
					   echo 'other bet amt-'.$other_bet_placed_amount;
					   echo "<br>";
					   echo $other_bet_placed_amount+abs($total_negative_number);
					   exit;*/
					   //if($headerUserBalance < ($other_bet_placed_amount+abs($total_negative_number))) //put this condition 21-8-2021
					   /*if($headerUserBalance < ($exposureAmt+$other_bet_placed_amount+abs($total_negative_number)))*/ //put this condition 27-8-2021 // put comment on 15-9-2021
					   if($headerUserBalance < ($other_bet_placed_amount+abs($total_negative_number))) //put this condition 27-8-2021
					   {
						   	$responce['status']='false';
							$responce['msg']='Insufficent Balance!';
							return json_encode($responce);
							exit;
					   }
					   /*if($other_bet_placed!='' && $other_bet_placed>0 && $headerUserBalance < (abs($total_negative_number)+$exposureAmt)) //put comment becuase its not calculating current exposure 21-8-2021
					   {	  
							$responce['status']='false';
							$responce['msg']='Insufficent Balance!';
							return json_encode($responce);
							exit;
					   }*/
					   //end for highest amount for odds exposure
				   }
				   
				  
		   		}
				//for BM
			    $heighest_negative_bm='';
			    if($requestData['bet_type'] === 'BOOKMAKER')
			    {
				   if($requestData['bet_side'] == 'back')
				   {
					   if ($requestData['team1'] == $requestData['team_name']) 
					   {
						   $old_value = $requestData['team1_BM_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value + $finalValue;
						   }
						   $team1_bet_count_new=round($finalValue,2);
						   $fval_new = '';
						   
						   $old_value_team2 = $requestData['team2_BM_total'];
						   if ($old_value_team2 != '') {
								$fval_new =$old_value_team2 - $fval;
						   }
						   $team2_bet_count_new=$fval_new;
						   
						   $old_value_team3 = $requestData['team3_BM_total'];
						   if ($old_value_team3 != '') {
								$fval_new =$old_value_team3 - $fval;
						   }
						   $team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team2'] == $requestData['team_name'])
					   {
							$old_value = $requestData['team2_BM_total'];
							if ($old_value != '') {
								$finalValue = ($old_value + $finalValue);
							}
							$team2_bet_count_new=round($finalValue,2);
							$fval_new = '';
						   
							$old_value_team1 = $requestData['team1_BM_total'];
							if ($old_value_team1 != '') {
								$fval_new =$old_value_team1 - $fval;
							}
							$team1_bet_count_new=$fval_new;
							
							$old_value_team3 = $requestData['team3_BM_total'];
							if ($old_value_team3 != '') {
								$fval_new =$old_value_team3 - $fval;
							}
							$team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team3'] == $requestData['team_name'])
					   {
							$old_value = $requestData['team3_BM_total'];
							if ($old_value != '') {
								$finalValue = $old_value + $finalValue;
							}
							$team3_bet_count_new=round($finalValue,2);
							$fval_new = '';
						   
							$old_value_team1 = $requestData['team1_BM_total'];
							if ($old_value_team1 != '') {
								$fval_new =$old_value_team1 - $fval;
							}
							$team1_bet_count_new=$fval_new;
							
							$old_value_team2 = $requestData['team2_BM_total'];
							if ($old_value_team2 != '') {
								$fval_new =$old_value_team2 - $fval;
							}
							$team2_bet_count_new=$fval_new;
					   }
				   }
				   if($requestData['bet_side'] == 'lay')
				   {
					   if ($requestData['team1'] == $requestData['team_name']) 
					   {
						   $old_value = $requestData['team1_BM_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team1_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team2 = $requestData['team2_BM_total'];
						   if ($old_value_team2 != '') {
								$fval_new = $old_value_team2 + $fval;
						   }
						   $team2_bet_count_new=round($fval_new,2);
						   
						   $old_value_team3 = $requestData['team3_BM_total'];
						   if ($old_value_team3 != '') {
								$fval_new =$old_value_team3 + $fval;
						   }
						   $team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team2'] == $requestData['team_name']) 
					   {
						   $old_value = $requestData['team2_BM_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team2_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team1 = $requestData['team1_BM_total'];
						   if($old_value_team1 != '') {
								$fval_new = $old_value_team1 + $fval;
						   }
						   $team1_bet_count_new=$fval_new;
						   
						   $old_value_team3 = $requestData['team3_BM_total'];
						   if($old_value_team3 != '') {
								$fval_new = $old_value_team3 + $fval;
						   }
						   $team3_bet_count_new=$fval_new;
					   }
					   if ($requestData['team3'] == $requestData['team_name']) {
						   $old_value = $requestData['team3_BM_total'];
						   if ($old_value != '') 
						   {
								$finalValue = $old_value - $finalValue;
						   }
						   $team3_bet_count_new=round($finalValue,2);
						   
						   $fval_new = '';
						   $old_value_team1 = $requestData['team1_BM_total'];
						   if($old_value_team1 != '') {
								$fval_new = $old_value_team1 + $fval;
						   }
						   $team1_bet_count_new=$fval_new;
						   
						   $old_value_team2 = $requestData['team2_BM_total'];
						   if($old_value_team2 != '') {
								$fval_new = $old_value_team2 + $fval;
						   }
						   $team2_bet_count_new=$fval_new;
					   }
				   }
			   
			   	   //calculate highest for odds
				   $heighest_negative_odds='';
				   if($requestData['team1_total']<0)
				   {
						$check=0;
						if($requestData['team2_total']<0)
						{ 
							if(abs($requestData['team2_total']) > abs($requestData['team1_total'])){
								$check=1;
								$heighest_negative_odds=$requestData['team2_total'];
							}
							else{
								$check=1;
								$heighest_negative_odds=$requestData['team1_total'];
							}
						}
						if($requestData['team3']!='' &&$team3_bet_count_new<0)
						{ 
							if(abs($requestData['team3_total']) > abs($requestData['team1_total'])){
								$check=1;
								$heighest_negative_odds=$requestData['team3_total'];
							}
							else{ 
								$check=1;
								$heighest_negative_odds=$requestData['team1_total'];
							}
						}
						if($check==0)
						{
							$heighest_negative_odds=$requestData['team1_total'];
						}
				   }
				   if($requestData['team2_total']<0)
				   {
						$check=0;
						if($requestData['team2_total']<0)
						{ 
							if(abs($requestData['team1_total']) > abs($requestData['team2_total'])){
								$check=1;
								$heighest_negative_odds=$requestData['team1_total'];
							}
							else{
								$check=1;
								$heighest_negative_odds=$requestData['team2_total'];
							}
						}
						if($requestData['team3_total']<0 && $requestData['team3']!='')
						{ 
							if(abs($requestData['team3_total']) > abs($requestData['team2_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
						else
						{
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
				   }
				   if($check==0)
				   {
						$heighest_negative_odds=$requestData['team2_total'];
				   }
				}
				if($requestData['team3_total']<0 && $requestData['team3']!='')
				{
					$check=0;
					if($requestData['team2_total']<0)
					{ 
						if(abs($requestData['team2_total']) > abs($requestData['team3_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
					}
					if($requestData['team1_total']<0)
					{ 
						if(abs($requestData['team1_total']) > abs($requestData['team3_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team1_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_odds=$requestData['team3_total'];
					}
				}
				//calculate highest for BM
				
				if($team1_bet_count_new<0)
				{  
				   $check=0;
				   if($team2_bet_count_new<0)
				   { 
						if($team2_bet_count_new <0 && abs($team2_bet_count_new) > abs($team1_bet_count_new)){ // put this condition on 15-9-2021 $team2_bet_count_new<0 
							$check=1;
							$heighest_negative_bm=$team2_bet_count_new;
						}
						else{
							$check=1;
							$heighest_negative_bm=$team1_bet_count_new;
						}
				   }
				   if($team3_bet_count_new<0 && $requestData['team3']!='')
				   { 
						if(abs($team3_bet_count_new) > abs($team1_bet_count_new)){
							$check=1;
							$heighest_negative_bm=$team3_bet_count_new;
						}
						else{ 
							$check=1;
							$heighest_negative_bm=$team1_bet_count_new;
						}
				   }
				   if($check==0)
				   {
					  $heighest_negative_bm=$team1_bet_count_new;
				   }
				}
				if($team2_bet_count_new<0)
				{
					$check=0;
					if($team2_bet_count_new<0)
					{ 
						if($team1_bet_count_new <0 && abs($team1_bet_count_new) > abs($team2_bet_count_new)){ //$team1_bet_count_new <0 put this condition on 15-9-201
							$check=1;
							$heighest_negative_bm=$team1_bet_count_new;
						}
						else{
							$check=1;
							$heighest_negative_bm=$team2_bet_count_new;
						}
					}
					if($team3_bet_count_new<0 && $requestData['team3']!='')
					{ 
						if(abs($team3_bet_count_new) > abs($team2_bet_count_new)){
							$check=1;
							$heighest_negative_bm=$team3_bet_count_new;
						}
						else{
							$check=1;
							$heighest_negative_bm=$team2_bet_count_new;
						}
					}
					if($check==0)
					{
						$heighest_negative_bm=$team2_bet_count_new;
					}
				}
				if($team3_bet_count_new<0 && $requestData['team3']!='')
				{
					$check=0;
  					if($team2_bet_count_new<0)
		   			{ 
						if($team2_bet_count_new<0 &&  abs($team2_bet_count_new) > abs($team3_bet_count_new)){ //put this condition on 15-9-2021 $team2_bet_count_new<0
							$check=1;
							$heighest_negative_bm=$team2_bet_count_new;
						}
						else{
							$check=1;
							$heighest_negative_bm=$team3_bet_count_new;
						}
		   			}
				   if($team1_bet_count_new<0)
				   { 
						if($team1_bet_count_new<0 && abs($team1_bet_count_new) > abs($team3_bet_count_new)){ //put this condition on 15-9-2021 $team1_bet_count_new<0
							$check=1;
							$heighest_negative_bm=$team1_bet_count_new;
						}
						else{
							$check=1;
							$heighest_negative_bm=$team3_bet_count_new;
						}
				   }
				   if($check==0)
				   {
					  $heighest_negative_bm=$team3_bet_count_new;
				   }
				}
				
				$total_negative_number = '';
				if($heighest_negative_odds!='' && $heighest_negative_odds<=0 &&  $heighest_negative_bm!='' && $heighest_negative_bm<=0)
				{
					$total_negative_number = abs($heighest_negative_odds)+abs($heighest_negative_bm);
				}
				else if($heighest_negative_odds!='' && $heighest_negative_odds<=0 && $heighest_negative_bm=='')
				{
					$total_negative_number =$heighest_negative_odds;
				}
				else if($heighest_negative_bm!='' && $heighest_negative_bm<=0 && $heighest_negative_odds=='')
				{
					$total_negative_number =$heighest_negative_bm;
				}
				
				$fancy_exposer=0;
				if($requestData['fancy_total']!=0)
				{
					$fancy_exposer=$requestData['fancy_total'];
					$total_negative_number=abs($total_negative_number)+abs($fancy_exposer);
				}
				if($headerUserBalance < abs($total_negative_number)) //team3 condition remaining
				{
					$responce['status']='false';
					$responce['msg']='Insufficent Balance!';
					return json_encode($responce);
					exit;
				}
				
				/*echo 'highest negative odds--'.$heighest_negative_odds;
					   echo "<br>";
					   echo 'team 1 total-'.$team1_bet_count_new;
					   echo "<br>";
					   echo 'team 2 total-'.$team2_bet_count_new;
					   echo "<br>";
					   echo 'team 3 total-'.$team3_bet_count_new;
					   echo "<br>";
					   
					   echo $headerUserBalance;
					   echo "<br>";
					   echo 'other-'.$other_bet_placed;
					   echo "<br>";
					   echo 'total neg-'.$total_negative_number;
					   echo "<br>";
					   echo 'new-expo-'.$exposureAmt;
					   echo "<br>";
					   echo $other_bet_placed_amount; echo "<br>";
					   echo abs($total_negative_number);*/
					  
				//if($headerUserBalance <= ($other_bet_placed_amount+abs($total_negative_number))) //put this condition 21-8-2021
				//if($headerUserBalance < ($exposureAmt+$other_bet_placed_amount+abs($total_negative_number))) //put this condition 26-8-2021 //REMOVED this condition on 16-9-2021
				if($headerUserBalance < ($other_bet_placed_amount+abs($total_negative_number))) 
				{
					$responce['status']='false';
					$responce['msg']='Insufficent Balance!';
					return json_encode($responce);
					exit;
				}
				
			} 
		   	
			//for fancy
			if($requestData['bet_type'] === 'SESSION')
			{
				//for highest negative odds
				$heighest_negative_odds='';
				if($requestData['team1_total']<0)
				{
					$check=0;
					if($requestData['team2_total']<0)
					{ 
						if(abs($requestData['team2_total']) > abs($requestData['team1_total']))
						{
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team1_total'];
						}
					}
					if($team3_bet_count_new<0 && $requestData['team3']!='')
					{ 
						if(abs($team3_bet_count_new) > abs($requestData['team1_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
						else
						{ 
							$check=1;
							$heighest_negative_odds=$requestData['team1_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_odds=$requestData['team1_total'];
					}
				}
				if($requestData['team2_total']<0)
				{
					$check=0;
					if($requestData['team2_total']<0)
					{ 
						if($requestData['team1_total']<0 && abs($requestData['team1_total']) > abs($requestData['team2_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team1_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
					}
					if($requestData['team3_total']<0 && $requestData['team3']!='')
					{ 
						if(abs($requestData['team3_total']) > abs($requestData['team2_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_odds=$requestData['team2_total'];
					}
				}
				if($requestData['team3_total']<0 && $requestData['team3']!='')
				{
					$check=0;
					if($requestData['team2_total']<0)
					{ 
						if(abs($requestData['team2_total']) > abs($requestData['team3_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team2_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
					}
					if($requestData['team1_total']<0)
					{ 
						if($requestData['team1_total']<0 &&  abs($requestData['team1_total']) > abs($requestData['team3_total'])){
							$check=1;
							$heighest_negative_odds=$requestData['team1_total'];
						}
						else{
							$check=1;
							$heighest_negative_odds=$requestData['team3_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_odds=$requestData['team3_total'];
					}
				}
			   	//for bm highest
			   	if($requestData['team1_BM_total']<0)
			   	{
					$check=0;
					if($requestData['team2_BM_total']<0)
					{ 
						if(abs($requestData['team2_BM_total']) > abs($requestData['team1_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team2_BM_total'];
						}
						else{
							$check=1;
							$heighest_negative_bm=$requestData['team1_BM_total'];
						}
					}
					if($team3_bet_count_new<0 && $requestData['team3']!='')
					{ 
						if(abs($requestData['team3_BM_total']) > abs($requestData['team1_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team3_BM_total'];
						}
						else
						{ 
							$check=1;
							$heighest_negative_bm=$requestData['team1_BM_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_bm=$requestData['team1_BM_total'];
					}
			   	}
			   	if($requestData['team2_BM_total']<0)
			   	{
					$check=0;
					if($requestData['team2_BM_total']<0)
					{ 
						if($requestData['team1_BM_total']<0 && abs($requestData['team1_BM_total']) > abs($requestData['team2_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team1_BM_total'];
						}
						else{
							$check=1;
							$heighest_negative_bm=$requestData['team2_BM_total'];
						}
					}
					if($requestData['team3_BM_total']<0 && $requestData['team3']!='')
					{ 
						if(abs($requestData['team3_BM_total']) > abs($requestData['team2_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team3_BM_total'];
						}
						else{
							$check=1;
							$heighest_negative_bm=$requestData['team2_BM_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_bm=$requestData['team2_BM_total'];
					}
			   	}
			   	if($requestData['team3_BM_total']<0 && $requestData['team3']!='')
			   	{
					$check=0;
				 	if($requestData['team2_BM_total']<0)
					{ 
						if(abs($requestData['team2_BM_total']) > abs($requestData['team3_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team2_BM_total'];
						}
						else{
							$check=1;
							$heighest_negative_bm=$requestData['team3_BM_total'];
						}
					}
					if($requestData['team1_BM_total']<0)
					{ 
						if(abs($requestData['team1_BM_total']) > abs($requestData['team3_BM_total'])){
							$check=1;
							$heighest_negative_bm=$requestData['team1_BM_total'];
						}
						else{
							$check=1;
							$heighest_negative_bm=$requestData['team3_BM_total'];
						}
					}
					if($check==0)
					{
						$heighest_negative_bm=$requestData['team3_BM_total'];
					}
			   	}
				   
				$total_negative_number = '';
				if($heighest_negative_odds!='' && $heighest_negative_odds<=0 &&  $heighest_negative_bm!='' && $heighest_negative_bm<=0)
				{
					$total_negative_number = abs($heighest_negative_odds)+abs($heighest_negative_bm);
				}
				else if($heighest_negative_odds!='' && $heighest_negative_odds<=0 && $heighest_negative_bm=='')
				{
					$total_negative_number =$heighest_negative_odds;
				}
				else if($heighest_negative_bm!='' && $heighest_negative_bm<=0 && $heighest_negative_odds=='')
				{
					$total_negative_number =$heighest_negative_bm;
				}
				   
				$fancy_exposer=0;
				if($requestData['fancy_total']!=0)
				{
					$fancy_exposer=$requestData['fancy_total'];
					$total_negative_number=abs($total_negative_number)+abs($fancy_exposer);
				}
				if($headerUserBalance < abs($total_negative_number)) //team3 condition remaining
				{
					$responce['status']='false';
					$responce['msg']='Insufficent Balance2222!';
					return json_encode($responce);
					exit;
				}
					
				//if($headerUserBalance < ($other_bet_placed_amount+abs($total_negative_number))) //put this condition 21-8-2021
				//if($headerUserBalance < ($exposureAmt+$other_bet_placed_amount+abs($total_negative_number))) //put this condition 27-8-2021 //removed this condition on 16-9-2021
				if($headerUserBalance < ($other_bet_placed_amount+abs($total_negative_number)))
				{
					$responce['status']='false';
					$responce['msg']='Insufficent Balance1111!';
					return json_encode($responce);
					exit;
				}
			}
		}
		else
		{
			$exAmtArr = self::getExAmountCricketAndTennis($requestData['match_id'],$userId);
			if(isset($exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"]))
			{
				$exArrs = array();
				$betprofit = $exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"];
				$exArrs[] = $betprofit;
				if($requestData['bet_type'] == 'BOOKMAKER'){
					$betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
				}
				else
				{
					if($requestData['bet_type'] === 'ODDS')
					{
						$betodds='';
						if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') 
						{
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team1_main_odds)
									$betodds=$team1_main_odds;
								else
								{ 	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team1_main_odds)
									$betodds=$team1_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
						{
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team2_main_odds)
									$betodds=$team2_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team2_main_odds)
									$betodds=$team2_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
						{
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team3_main_odds)
									$betodds=$team3_main_odds;
								else
								{	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team3_main_odds)
									$betodds=$team3_main_odds;
								else
								{   	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						if($betodds!='')
							$betamount = (($betodds*$requestData['bet_amount'])-$requestData['bet_amount']);
						else
							$betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
					}
					else
						$betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
				}
				$betprofit1 = $betprofit2 = $betprofit3 = '';
				if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"])){
					$betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
					$exArrs[] = $betprofit1;
				}
				if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"])){
					$betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
					$exArrs[] = $betprofit2;
				}
				if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"])){
					$betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
					$exArrs[] = $betprofit3;
				}
				$teamMaxEx = min($exArrs);
				if($requestData['bet_side'] == 'lay')
				{
					$newExArr = array();
					if($betprofit > 0)
					{
						$amt = abs($betprofit)-abs($betamount);
						if($amt > 0)
						{
							$amt = 0;
						}
						$newExArr['betTeam'] = $amt;
						if($betprofit1 < 0)
						{
							if($requestData['bet_amount'] < abs($betprofit1))
							{
								$newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
							}
							else
							{
								$newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
							}
						}
						if($betprofit2 < 0)
						{
							if($requestData['bet_amount'] < abs($betprofit2))
							{
								$newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
							}
							else
							{
								$newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
							}
						}
						if($betprofit3 < 0)
						{
							if($requestData['bet_amount'] < abs($betprofit3))
							{
								$newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
							}
							else
							{
								$newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
							}
						}
					}
					else
					{
						$amt = abs($betamount)+abs($betprofit);
						$amt = ($exposureAmt+$betamount);
						if($headerUserBalance < (abs($amt)))
						{
							$responce['status']='false';
							$responce['msg']='Insufficent Balance!';
							return json_encode($responce);
							exit;
						}
				  	}
				  	if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"]))
					{
						$betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
					  	if($betprofit1 >= 0)
						{
							$betamount = $requestData['bet_amount'];
						  	$amt = $betprofit1 - abs($betamount);
						  	$amt = 0;
						  	if($headerUserBalance < ($exposureAmt+abs($amt)))
							{
								$responce['status']='false';
								$responce['msg']='Insufficent Balance!';
								return json_encode($responce);
								exit;
						  	}
					  	}
				  	}
				  	if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"]))
					{
						$betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
						if($betprofit2 >= 0)
						{
							$betamount = $requestData['bet_amount'];
							$amt = $betprofit2 - abs($betamount);
							$amt = 0;
							if($amt < 0)
							{
								if($headerUserBalance < ($exposureAmt+abs($amt)))
								{
									$responce['status']='false';
									$responce['msg']='Insufficent Balance!';
							  		return json_encode($responce);
							  		exit;
								}
					  		}
						}
			  		}
					if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"]))
					{
						$betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
					  	if($betprofit3 >= 0)
						{
							$betamount = $requestData['bet_amount'];
						  	$amt = $betprofit3 - abs($betamount);
						  	$amt = 0;
						  	if($headerUserBalance < ($exposureAmt+abs($amt)))
							{
								$responce['status']='false';
								$responce['msg']='Insufficent Balance!';
								return json_encode($responce);
								exit;
								}
							}
						}
					}
					else
					{
						$newExArr = array();
						if($betprofit < 0)
						{
							$amt = abs($betamount)-abs($betprofit);
							if($amt > 0)
							{
								$amt = 0;
							}
							$newExArr['betTeam'] = $amt;
							if($betprofit1 < 0){
								$newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
							}
							if($betprofit2 < 0){
								$newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];
								
							}
							if($betprofit3 < 0)
										{
								$newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
							}
				 		}
						else
						{
							$newExArr = array();
							$amt = abs($betamount)+abs($betprofit);
							if($amt > 0){
								$amt = 0;
							}
							$newExArr['betTeam'] = $amt;
							if($betprofit1 < 0){
								$newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
							}
							if($betprofit2 < 0){
								$newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];
								
							}
							if($betprofit3 < 0){
								$newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
							}
					  	}
				  	}
			  	}
				else
				{
					if($requestData['bet_side'] == 'lay')
					{
						if($requestData['bet_type'] == 'BOOKMAKER'){
							$betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
						}else if($requestData['bet_type'] == 'SESSION'){
							$betamount = (($requestData['odds_volume']*$requestData['bet_amount'])/100);
						}
						else
						{
							$betodds='';
							if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') {
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team1_main_odds)
									$betodds=$team1_main_odds;
								else
								{   	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team1_main_odds)
									$betodds=$team1_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
						{
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team2_main_odds)
									$betodds=$team2_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team2_main_odds)
									$betodds=$team2_main_odds;
								else
								{   	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
						{
							if($requestData['bet_side'] == 'lay')
							{
								if($requestData['bet_odds']>=$team3_main_odds)
									$betodds=$team3_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
							else
							{
								if($requestData['bet_odds']<=$team3_main_odds)
									$betodds=$team3_main_odds;
								else
								{  	 	
									$responce['status']='false';
									$responce['msg']='ODDS Changed!';
									return json_encode($responce);
									exit;
								}
							}
						}
						if($betodds!='')
							$betamount = (($betodds*$requestData['bet_amount'])-$requestData['bet_amount']);
						else
							$betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
					}
				}
				else
				{
				}
			}
		}
		if($requestData['bet_type'] === 'ODDS')
		{
			if($requestData['bet_amount'] < $min_bet_odds_limit)
			{
				$responce['status']='false';
				$responce['msg']='Minimum bet limit is '.$min_bet_odds_limit.'!';
				return json_encode($responce);
				exit;
			}
			if($requestData['bet_amount'] > $max_bet_odds_limit)
			{
				$responce['status']='false';
				$responce['msg']='Maximum bet limit is  '.$max_bet_odds_limit.'!';
				return json_encode($responce);
				exit;
			}
		}
		if($requestData['bet_type'] === 'BOOKMAKER')
		{
			if($requestData['bet_amount'] < $min_bet_bm_limit)
			{	
				$responce['status']='false';
				$responce['msg']='Minimum bet limit is '.$min_bet_bm_limit.'!';
				return json_encode($responce);
				exit;
			}
			if($requestData['bet_amount'] > $max_bet_bm_limit)
			{
				$responce['status']='false';
				$responce['msg']='Maximum bet limit is '.$max_bet_bm_limit.'!';
				return json_encode($responce);
				exit;
			}
		}
		if($requestData['bet_type'] == 'SESSION')
		{
			if($requestData['bet_amount'] < $min_bet_fancy_limit)
			{
				$responce['status']='false';
				$responce['msg']='Minimum bet limit is '.$min_bet_fancy_limit.'!';
				return json_encode($responce);
				exit;
			}
			if($requestData['bet_amount'] > $max_bet_fancy_limit)
			{
				$responce['status']='false';
				$responce['msg']='Maximum bet limit is '.$min_bet_fancy_limit.'!';
				return json_encode($responce);
				exit;
			}
		}
		$exposureAmt = SELF::getExAmount();
		$deduct_expo_amt=0;
		if($requestData['bet_type'] == 'SESSION')
		{
			if($requestData['bet_side'] == 'lay'){
				$betamount = $requestData['bet_amount'];
				$bet_oddsK  = $requestData['odds_volume'];
				$deduct_expo_amt = (($betamount*$bet_oddsK)/100);
			}
			else
			{
				$betamount = $requestData['bet_amount'];
				$deduct_expo_amt =$betamount;
			}
			
			if($headerUserBalance < ($exposureAmt+$deduct_expo_amt))
			{
				$responce['status']='false';
				$responce['msg']='Insufficent Balance!';
				return json_encode($responce);
				exit;
			}
			
		}
		if($requestData['bet_type'] === 'BOOKMAKER')
		{
			if($requestData['bet_side'] === 'lay'){
				$deduct_expo_amt = (($requestData['bet_odds']*$stack)/100);
			}
			else
			{
				$betamount = $stack;
				$deduct_expo_amt = $stack; 
			}
		}
		if($requestData['bet_type'] === 'ODDS')
		{
			if($requestData['bet_side'] === 'lay')
			{
				$betodds='';
				if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend')
				{
					if($requestData['bet_odds']>=$team1_main_odds)
						$betodds=$team1_main_odds;
					else
					{ 			 		
						$responce['status']='false';
						$responce['msg']='ODDS Changed!';
						return json_encode($responce);
						exit;
					}
				}
				else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
				{
					if($requestData['bet_odds']>=$team2_main_odds)
						$betodds=$team2_main_odds;
					else
					{  	 	
						$responce['status']='false';
						$responce['msg']='ODDS Changed!';
						return json_encode($responce);
						exit;
					}
				}
				else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
				{
					if($requestData['bet_odds']>=$team3_main_odds)
						$betodds=$team3_main_odds;
					else
					{   	 	
						$responce['status']='false';
						$responce['msg']='ODDS Changed!';
						return json_encode($responce);
						exit;
					}
				}
				if($betodds!='')
					$deduct_expo_amt = ((($betodds-1)*$stack));
				else
					$deduct_expo_amt = ((($requestData['bet_odds']-1)*$stack));
			}
			else
			{
				$betamount = $stack;
				$deduct_expo_amt = $stack; 
			}
		}
		$isExBalEq = false;
		if($headerUserBalance == $exposureAmt){
			$isExBalEq = true;
		}
		if($headerUserBalance < ($requestData['bet_odds']))
		{
			$responce['status']='false';
			$responce['msg']='Insufficent Balance!';
			return json_encode($responce);
			exit;	 
		}
	 	else
		{
			$getUserCheck = Session::get('playerUser');
			if(!empty($getUserCheck)){
				$getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
			}
			$getUser= $getUser->id;
				  
			$exposureAmt=$exposureAmt+$deduct_expo_amt;
			$betModel = new MyBets();
			$betModel->sportID = $requestData['sportID'];
			$betModel->user_id = $getUser;
			$betModel->match_id = $requestData['match_id'];
			$betModel->bet_type = $requestData['bet_type'];
			$betModel->bet_side = $requestData['bet_side'];
			  
		  	if($betModel->bet_type=='ODDS')
	  	  	{
				$betodds='';
				if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') 
				{
					if($requestData['bet_side'] == 'lay')
					{
						if($requestData['bet_odds']>=$team1_main_odds)
							$betodds=$team1_main_odds;
						else
						{	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
					else
					{
						if($requestData['bet_odds']<=$team1_main_odds)
							$betodds=$team1_main_odds;
						else
						{ 	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
				}
				else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
				{
					if($requestData['bet_side'] == 'lay')
					{
						if($requestData['bet_odds']>=$team2_main_odds)
							$betodds=$team2_main_odds;
						else
						{   	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
					else
					{
						if($requestData['bet_odds']<=$team2_main_odds)
							$betodds=$team2_main_odds;
						else
						{   	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
				}
				else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
				{
					if($requestData['bet_side'] == 'lay')
					{
						if($requestData['bet_odds']>=$team3_main_odds)
							$betodds=$team3_main_odds;
						else
						{   	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
					else
					{
						if($requestData['bet_odds']<=$team3_main_odds)
							$betodds=$team3_main_odds;
						else
						{   	 	
							$responce['status']='false';
							$responce['msg']='ODDS Changed!';
							return json_encode($responce);
							exit;
						}
					}
				}
				if($betodds!='')
					$betModel->bet_odds = $betodds;
				else
					$betModel->bet_odds = $requestData['bet_odds'];
			  
				$betModel->bet_amount = $stack;
				if($betModel->bet_type=='ODDS')
				{
					if($betodds!='')
					{
						if($requestData['bet_side'] === 'lay')
						{
							$deduct_expo_amt = ((($betodds-1)*$stack));
							$betModel->bet_profit = $stack;
						}
						else
						{
							$deduct_expo_amt =($requestData['bet_cal_amt']*($betodds-1))/($requestData['bet_odds']-1);
							$betModel->bet_profit = $deduct_expo_amt;
							$deduct_expo_amt = $stack;
						}
					}
					else
					{
						$deduct_expo_amt = $requestData['bet_cal_amt'];
						$betModel->bet_profit = $requestData['bet_cal_amt'];
					}
				}
				else
					$betModel->bet_profit = $requestData['bet_cal_amt'];
			  
				$betModel->team_name = $requestData['team_name'];
				$teamNameArr = array();
				if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
					$teamNameArr['teamname1'] = $requestData['teamname1'];
				}
				if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
					$teamNameArr['teamname2'] = $requestData['teamname2'];
				}
				if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
					$teamNameArr['teamname3'] = $requestData['teamname3'];
				}
					 
				if(is_array($teamNameArr) && count($teamNameArr) > 0){
					$betModel->extra = json_encode($teamNameArr);
				}
			  
				$betModel->exposureAmt = $deduct_expo_amt;
				$betModel->ip_address = resAll::ip();
				$betModel->browser_details = $_SERVER['HTTP_USER_AGENT'];
						
				$timezone=Carbon::now()->format('Y-m-d H:i:s');
				$betModel->created_at = $timezone;
				$betModel->updated_at = $timezone;
				if($betModel->save()){
					$save_exposer_balance= SELF::SaveBalance($deduct_expo_amt); 
					$responce['status']='true';
					$responce['msg']='Bet Added Succesfully';
					return json_encode($responce);
					exit;
				}
		  	}
		  	else
		  	{
				$betodds='';
			  	if($betModel->bet_type=='ODDS')
		  	  	{
			  		if ($requestData['team1'] == $requestData['team_name'] && $team1_main_odds!='' && $team1_main_odds!='Suspend') 
				  	{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team1_main_odds)
								$betodds=$team1_main_odds;
							else
							{
								$responce['status']='false';
								$responce['msg']='ODDS Changed';
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team1_main_odds)
								$betodds=$team1_main_odds;
							else
							{
								$responce['status']='false';
								$responce['msg']='ODDS Changed';
								return json_encode($responce);
								exit;
							}
						}
					}
					else if ($requestData['team2'] == $requestData['team_name'] && $team2_main_odds!='' && $team2_main_odds!='Suspend') 
					{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team2_main_odds)
								$betodds=$team2_main_odds;
							else
							{
								$responce['status']='false';
								$responce['msg']='ODDS Changed';  	 	
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team2_main_odds)
								$betodds=$team2_main_odds;
							else
							{   	 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed';
								return json_encode($responce);
								exit;
							}
						}
					}
					else if ($requestData['team3'] == $requestData['team_name'] && $team3_main_odds!='' && $team3_main_odds!='Suspend') 
					{
						if($requestData['bet_side'] == 'lay')
						{
							if($requestData['bet_odds']>=$team3_main_odds)
								$betodds=$team3_main_odds;
							else
							{  	 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed';
								return json_encode($responce);
								exit;
							}
						}
						else
						{
							if($requestData['bet_odds']<=$team3_main_odds)
								$betodds=$team3_main_odds;
							else
							{   	 	
								$responce['status']='false';
								$responce['msg']='ODDS Changed';
								return json_encode($responce);
								exit;
							}
						}
					}
				  	if($betodds!='')
				  		$betModel->bet_odds = $betodds;
				  	else
						$betModel->bet_odds = $requestData['bet_odds'];
				}
				else
					$betModel->bet_odds = $requestData['bet_odds'];
				
				$betModel->bet_amount = $stack;
				
				if($betModel->bet_type=='ODDS')
		  	{
					if($betodds!='')
					{
						if($requestData['bet_side'] === 'lay')
						{
							$deduct_expo_amt = ((($betodds-1)*$stack));
							$betModel->bet_profit = $stack;
						}
						else
						{
							$deduct_expo_amt =($requestData['bet_cal_amt']*($betodds-1))/($requestData['bet_odds']-1);
							$betModel->bet_profit = $deduct_expo_amt;
							$deduct_expo_amt = $stack;
						}
					}
					else{
						$deduct_expo_amt = $requestData['bet_cal_amt'];
						$betModel->bet_profit = $deduct_expo_amt;
					}
					
				}
				else if($requestData['bet_type'] == 'SESSION')
				{
					if($requestData['bet_side'] === 'lay'){
						$betModel->bet_profit = $stack;
					}
					else{
						$betModel->bet_profit = round(($requestData['odds_volume']*$stack)/100,2);
					}
				}
				else
				{
					$betModel->bet_profit = $requestData['bet_cal_amt'];
				}
				$betModel->team_name = $requestData['team_name'];
			  
			  if($betModel->bet_type=='SESSION')
					$betModel->bet_oddsk = $requestData['odds_volume'];
			 
			  	$teamNameArr = array();
				if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
					$teamNameArr['teamname1'] = $requestData['teamname1'];
				}
			  	if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
					$teamNameArr['teamname2'] = $requestData['teamname2'];
			  	}
			  	if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
					$teamNameArr['teamname3'] = $requestData['teamname3'];
			  	}
			 	if(is_array($teamNameArr) && count($teamNameArr) > 0){
					$betModel->extra = json_encode($teamNameArr);
			  	}
			  	if($betModel->bet_type=='BOOKMAKER')
			  	{
					$betModel->exposureAmt = $deduct_expo_amt;
			  	}
				else if($betModel->bet_type=='SESSION')
				{
					if($requestData['bet_side'] === 'lay')
					{
						$betModel->exposureAmt = $deduct_expo_amt;
					}
					else
					{
						$betModel->exposureAmt = $stack;
					}
				}
			  	else
			  	{
					if($betModel->bet_type=='ODDS')
					{
						if($betodds!='')
						{
							if($requestData['bet_side'] === 'lay')
							{
							}
						}
						else
							$deduct_expo_amt= $requestData['bet_cal_amt'];
						
						$betModel->exposureAmt = $deduct_expo_amt;
					}
					else
						$betModel->exposureAmt = $requestData['bet_cal_amt'];
				}
			  	$betModel->ip_address = resAll::ip();
			  	$betModel->browser_details = $_SERVER['HTTP_USER_AGENT'];
				$timezone=Carbon::now()->format('Y-m-d H:i:s');
				$betModel->created_at = $timezone;
				$betModel->updated_at = $timezone;
			  	if($betModel->save())
			  	{
					$save_exposer_balance= SELF::SaveBalance($deduct_expo_amt); 
					$responce['status']='true';
					$responce['msg']='Bet Added Succesfully.';
					return json_encode($responce);
					exit;
			  	}
		  	}
	  	}
    return json_encode($responce);
	}
	public function GetOtherMatchBet(Request $request)
	{
		$val=explode("~~",$request->match_id);
		$matchid=@$val[0];
		$bet_type=@$val[1];

    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }
		$userId=$getUser->id;
		$html='';
		if($bet_type!='All'){
		$my_placed_bets = MyBets::where('user_id',$userId)->where('bet_type',$bet_type)->where('match_id',$matchid)->where('isDeleted',0)->where('result_declare',0)->orderby('id','DESC')->get();
		}
		else
		{
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$matchid)
			->where('isDeleted',0)
			->where('result_declare',0)->orderby('id','DESC')->get();
		}
		if(sizeof($my_placed_bets)>0)
		{
			$j=0; $k=0;
			foreach($my_placed_bets as $bet)
      {
				if($bet->bet_side=='back')
        {	
					if($j==0)
				  {
						$html.='<ul class="betslip_head">
                        <li class="col-bet">Back (Bet For)</li>
                        <li class="col-odd">Odds</li>
                        <li class="col-stake">Stake</li>
                        <li class="col-profit">Profit</li>
                    </ul>';
					}
					$bet_type_check="";
					if($bet->bet_type=='ODDS')
						$bet_type_check='BACK';
					if($bet->bet_type=='SESSION')
						$bet_type_check='YES';
					$bet_profit="";
					if($bet->bet_type=='ODDS' || $bet->bet_type=='BOOKMAKER' )
						$bet_profit=$bet->bet_profit;
					if($bet->bet_type=='SESSION')
						$bet_profit=$bet->bet_profit;
					$html.='<div class="betslip_box light-blue-bg-1" id="backbet">
              <div class="betn">
                  <span class="slip_type lightblue-bg2">'.$bet_type_check.'</span>
                  <span class="shortamount">'.$bet->team_name.'</span>
                  <span>'.$bet->bet_type.'</span>
              </div>
              <div class="col-odd text-color-blue-2 text-center">';
                if(!empty($bet->bet_oddsk)){
                    $html.=''.$bet->bet_odds.'<br><span>('.$bet->bet_oddsk.')</span>';
                  }
                  else{
                    $html.=''.$bet->bet_odds.'';
                  }
              $html.='</div>
              <div class="col-stake text-color-blue-2 text-center">'.$bet->bet_amount.'</div>
              <div class="col-profit">'.number_format($bet_profit,2).'</div>
          </div>';
					$j++;
				}
			}
			foreach($my_placed_bets as $bet)
      {
			 	if($bet->bet_side=='lay')
        { 
					if($k==0)
          {
						$html.='<ul class="betslip_head">
                      <li class="col-bet">Lay (Bet Against)</li>
                      <li class="col-odd">Odds</li>
                      <li class="col-stake">Stake</li>
                      <li class="col-profit">Liability</li>
                  </ul>';
					}
					$bet_profit="";
					if($bet->bet_type=='ODDS' || $bet->bet_type=='BOOKMAKER')
						$bet_profit=$bet->exposureAmt;
					if($bet->bet_type=='SESSION')
						$bet_profit=$bet->bet_profit;
						
					$bet_type_check="";
					if($bet->bet_type=='ODDS')
						$bet_type_check='LAY';
					if($bet->bet_type=='SESSION')
						$bet_type_check='NO';	
					$html.='<div class="betslip_box lightpink-bg2" id="laybet">
                <div class="betn">
                    <span class="slip_type lightpink-bg1">'.$bet_type_check.'</span>
                    <span class="shortamount">'.$bet->team_name.'</span>
                    <span>'.$bet->bet_type.'</span>
                </div>
                <div class="col-odd text-color-blue-2 text-center">';
                  if(!empty($bet->bet_oddsk)){
                    $html.=''.$bet->bet_odds.'<br><span>('.$bet->bet_oddsk.')</span>';
                  }
                  else{
                    $html.=''.$bet->bet_odds.'';
                  }
                $html.='</div>
                <div class="col-stake text-color-blue-2 text-center">'.$bet->bet_amount.'</div>
                <div class="col-profit">'.number_format($bet_profit,2).'</div>
            </div>';
         $k++; 
				}
			}
			echo $html;
		}
		else
		echo 'No bet found for this match';
	}
  public function frontAutoLogout(Request $request)
  {
    $sessionData = Session::get('playerUser');
    $mntnc = setting::first();
     
    if($sessionData)
    {
      $checkstatus=User::where('id',$sessionData->id)->first();
      if($checkstatus->status == 'suspend'){
        $request->session()->forget(['playerUser']);
        return response()->json(array('result'=> 'suspendsuccess'));
      }

      if(!empty($mntnc->maintanence_msg))
      {
        $request->session()->forget(['playerUser']);
        return response()->json(array('result'=> 'msgsuccess'));
      }
    }
  }
  public function stakechange(Request $request)
  {
    $pos = $request->id;
    $s_data = $request->data;
    $getUserCheck = Session::get('playerUser');
      if(!empty($getUserCheck)){
        $getuser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
      }

    $s_result = UserStake::where('user_id',$getuser->id)->first();
    $ans = json_decode($s_result->stake);
    foreach ($ans as $key => $value) {
      if($key == $pos){
        $replacements = array($key => $s_data);
        $pack = array_replace($ans, $replacements);
        UserStake::where('user_id',$getuser->id)->update(['stake' => $pack]);
      }
    }
  }
  /*public function getAllBetsForMobile(Request $request)
  {
	  $getUser = Session::get('playerUser');
	  $userId=$getUser->id;
	  $event_id=$request->event_id;
	  $my_placed_bets_all = MyBets::where('user_id',$userId)->where('match_id',$event_id)->where('isDeleted',0)
	  ->where('bet_side','back')
	  ->where('result_declare',0)->orderby('id','DESC')->get();
	  $return_data='';
	  foreach($my_placed_bets_all as $data)
	  {
			if($data->result_declare == 0)
			{
				$sports = Sport::where('sId', $data->sportID)->first();
				$matchdata = Match::where('event_id', $data->match_id)->first();
				
				$return_data.='<tr class="white-bg">
                                                <td width="9%"><img src="'.asset('asset/front/img/plus-icon.png').'"> <a class="text-color-blue-light">'.$data->id.'</a></td>
                                                <td width="9%">'.$getUser->user_name.'</td>
                                                <td>'.$sports->sport_name.'<i class="fas fa-caret-right text-color-grey"></i> 
												<strong>'.$matchdata->match_name.'</strong> <i class="fas fa-caret-right text-color-grey"></i>
												'.$data->bet_type.'</td>
                                                <td width="12%" class="text-right">'.$data->team_name.'</td>';
                                                if($data->bet_side == 'lay')
                                                $return_data.='<td width="4%" class="text-right" style="color: #e33a5e !important;">'.$data->bet_side.'</td>';
                                                else
                                                $return_data.='<td width="4%" class="text-right" style="color: #1f72ac !important;">'.$data->bet_side.'</td>';
                                                
                                                $return_data.='<td width="8%" class="text-right">'.$data->created_at.'</td>
                                                <td width="8%" class="text-right">'.$data->bet_amount.'</td>
                                                <td width="8%" class="text-right">'.$data->bet_odds.'</td>
                                            </tr>';
			}
	  }
	  return $return_data;
  }*/
}
