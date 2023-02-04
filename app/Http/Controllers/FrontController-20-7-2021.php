<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sport;
use App\setting;
use App\Match;
use App\Casino;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\MyBets;
use Auth;
use DB;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{

	public function index()
	{     
		$sports = Sport::all();
  		$settings = setting::first();
		$restapi=new RestApi();
		//$match_data=app('App\Http\Controllers\RestApi')->GetMatchOdds('1.181914545');
		return view('front.home',compact('sports','settings'));
	}
 	public function myaccount(Request $request)
    {
        return view('front/myaccount');
    }
  	public function frontLogout()
 	{
		//Auth::Logout();
    	Session::forget('playerUser');
		return redirect()->route('front');
 	}
	public function casinoDetail($id)
 	{
 		$casino = Casino::find($id);
		return view('front.'.$casino->casino_name,compact('casino'));
 	}
 	public function getCasinoteen20()
 	{
 		$casino_data=app('App\Http\Controllers\RestApi')->GetTeen20Data();
		return view('front.'.$casino->casino_name,compact('casino'));
 	}
  	public function matchDetail($id)
  	{
		$match = Match::find($id);
		$inplay='';
		$match_data='';
		$sport = Sport::where('sId',$match->sports_id)->first();
		if($sport->id==1)
		{
			$matchId=$match->match_id;
			$matchname=$match->matchname;
			$eventId=$match->event_id;
			
			$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$eventId,$sport->id);
			
			//$match_data=app('App\Http\Controllers\RestApi')->DetailCall($eventId,$matchId,$match->sports_id);
			$inplay='';
			if(isset($match_data[0]['inplay'])!='')
			{
				$inplay=$match_data[0]['inplay'];
				if($inplay==1)
					$inplay='True';
				else
					$inplay='false';
				//	$inplay='True';
			}
		}
		else
		{
			$matchId=$match->match_id;
			$matchname=$match->matchname;
			$eventId=$match->event_id;
			
			$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$eventId,$sport->id);
			$inplay='';
			if(isset($match_data[0]['inplay'])!='')
			{
				$inplay=$match_data[0]['inplay'];
				if($inplay==1)
					$inplay='True';
				else
					$inplay='false';
				//	$inplay='True';
			}
		}
		$my_placed_bets=array(); $total_todays_bet=0; $match_name_bet=array();
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId=$getUser->id;
			//$my_placed_bets = MyBets::where('user_id',$userId)->whereDate('created_at', Carbon::today())->get();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$match->event_id)->get();
			
			
			$match_name_bet=array();
			$i=0; $event_array=array(); $bet_type=array();
			foreach($my_placed_bets as $bet)
			{
				$match_id=$bet->match_id;
				//DB::enableQueryLog();
				$sport_get = Match::where('event_id',$match_id)->where('winner', NULL)->where('status',1)->first();
				if(!$sport_get)
					return redirect()->route('front');
				//echo $sport_get; exit;
				//dd(DB::getQueryLog());
				$ev=$sport_get['event_id'].'_'.$bet->bet_type;
				if($i>0)
				{
					if(!in_array($ev,$event_array))
					{
						$event_array[]=$sport_get['event_id'].'_'.$bet->bet_type;
						$match_name_bet[$i]['event_id']=$sport_get['event_id'];
						$match_name_bet[$i]['match_name']=$sport_get['match_name'];
						$match_name_bet[$i]['bet_for']=$bet->bet_type;
						$i++;
					}
				}
				else
				{
					$event_array[]=$sport_get['event_id'].'_'.$bet->bet_type;
					$match_name_bet[$i]['event_id']=$sport_get['event_id'];
					$match_name_bet[$i]['match_name']=$sport_get['match_name'];
					$match_name_bet[$i]['bet_for']=$bet->bet_type;
					$i++;
				}
			}
			$total_todays_bet=count($my_placed_bets);
		}
	
		//odds data
		$matchtype=$match->sports_id;
		$match_id=$match->id;
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 
		$match_m=$matchList->suspend_m;
		$matchtype=$sport->id;
		$matchId= $match->match_id;
		$matchname=$match->match_name;
		$event_id=$match->event_id;
		$team=explode(" v ",strtolower($matchname));
		$sport_id=$matchList->sports_id;
		
		$min_bet_odds_limit=$matchList->min_bet_odds_limit;
		$max_bet_odds_limit =$matchList->max_bet_odds_limit;
		
		$team1_bet_total='';
		$team1_bet_class='';
		
		$team2_bet_total='';
		$team2_bet_class='';
		
		$team_draw_bet_total='';
		$team_draw_bet_class='';
		
		$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$event_id,$matchtype);
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$event_id)->where('bet_type','ODDS')->where('isDeleted',0)->get();
			//dd(DB::getQueryLog());
			$team2_bet_total=0;
			$team1_bet_total=0;
			$team_draw_bet_total=0;
			/*if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
									
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{	
									//$team_draw_bet_total=$team_draw_bet_total-($bet->bet_odds/($bet->bet_amount-1));
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								//$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								//$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								//$team2_bet_total=$team2_bet_total+$bet->bet_amount;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}*/
			if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
								
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									//$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit; ///nnn
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								
								if(count($abc)>=2)
								{	
									//$team_draw_bet_total=$team_draw_bet_total-($bet->bet_odds/($bet->bet_amount-1));
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit; ///nnn 16-7-2021
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								//$team2_bet_total=$team2_bet_total+$bet->bet_amount;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		}
		//echo $match_data;
		if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
		{
		  $cricketSec = '3';
		}else{
			$cricketSec = '2';
		}
		$section='';
		if($sport_id=='1'){
			$section='3';
		}elseif($sport_id=='2'){
			$section='2';
		}elseif($sport_id=='4'){
			$section=$cricketSec;
		}
		$html='';
		$html.= '<table class="table custom-table inplay-table w1-table">
			<tr class="betstr">
				<td class="text-color-grey">'.$section.' Selections</td>
				<td colspan="2">101.7%</td>
				<td>
					<a class="backall">
						<img src="'.asset('asset/front/img/bluebg1.png').'">
						<span>Back all</span>
					</a>
				</td>
				<td>
					<a class="layall">
						<img src="'.asset('asset/front/img/pinkbg1.png').'">
						<span>Lay all</span>
					</a>
				</td>
				<td colspan="2">97.9%</td>
				</tr>'; 
				//data-toggle="modal" data-target="#myLoginModal"
				$login_check='';
				$sessionData = Session::get('playerUser');
				if(!empty($sessionData))
				{
					if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
						$login_check='onclick="opnForm(this);"';
				}
				else
				{
					$login_check='data-toggle="modal" data-target="#myLoginModal"';
				}
				
				if($match_data!=0)
				{
					$html_chk='';
					if($match_m=='0')
					{
						if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
						{
							$html.='
							<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
							</tr>
							<tr class="white-bg tr_team3">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">THE DRAW</b> 
									<div>
										<span class="lose " id="team1_bet_count_old"></span>
										<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack td_team3_back_2" >
									<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
								</td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team3_back_1" data-team="team1">
									<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
								</td>
								<td class="cyan-bg spark ODDSBack td_team3_back_0" >
									<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
								<td class="pink-bg sparkLay ODDSLay td_team3_lay_0" >
									<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
								</td>
								<td class="light-pink-bg-2 sparkLay ODDSLay td_team3_lay_1" >
									<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
								<td class="light-pink-bg-3 sparkLay ODDSLay td_team3_lay_2" >
									<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
							</tr>';
						}
						$html_chk.='
						<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg tr_team1">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
								<div>
									<span class="lose " id="team1_bet_count_old"></span>
									<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
								</div>
							</td>
							<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" >
								<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1">
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
							</td>
							<td class="cyan-bg spark ODDSBack td_team1_back_0" >
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" >
								<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_lay_2" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
						</tr>
						<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg tr_team2">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
								<div>
									<span class="lose " id="team1_bet_count_old"></span>
									<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
								</div>
							</td>
							<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" >
								<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team1">
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
							</td>
							<td class="cyan-bg spark ODDSBack td_team2_back_0" >
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" >
								<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
						</tr>';
					 }
					 else
					 {				 
						if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
						{	
							$display=''; $cls='';
							if($team_draw_bet_total=='' && $team1_bet_total && $team2_bet_total=="")
							{
								$display='style="display:none"';
							}
							else
							{
								if($team_draw_bet_total=="")
									$team_draw_bet_total=0.00;
							}
							if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
							{
								$cls='text-color-red';
							}
							
						
						$html_chk.='<tr class="white-bg tr_team3">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team3"> The Draw </b> 
								<div>
									<span class="lose '.$cls.'" '.$display.' id="draw_bet_count_old">(<span id="draw_total">'.round($team_draw_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="draw_bet_count_new">0.00</span>
								</div>
							</td>
							<td class="light-blue-bg-2  spark ODDSBack td_team3_back_2" data-team="team3">
								<a '.$login_check.' data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black">
									<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['size'].'</span>
								</a>
							</td>
							<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team3_back_1" data-team="team3">
								<a '.$login_check.'  data-cls="cyan-bg" data-val="'. @$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].'" class="text-color-black back1btn"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['size'].'</span>
								</a>
							</td>
							<td class="cyan-bg spark ODDSBack td_team3_back_0" data-team="team3">
								<a '.$login_check.' data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['size'].'</span>
								</a>
							</td>
							<td class="pink-bg sparkLay ODDSLay td_team3_lay_0" data-team="team3">
								<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['size'].'</span>
								</a>
							</td>
							<td class="light-pink-bg-2 sparkLay ODDSLay td_team3_lay_1" data-team="team3">
								<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['size'].'</span>
								</a>
							</td>
							<td class="light-pink-bg-3 sparkLay ODDSLay td_team3_lay_2" data-team="team3">
								<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['size'].'</span>
								</a>
							</td>
						</tr>';
					 }
					//check status
					if(@$match_data[0]['status']=='OPEN')
					{
						if(isset($match_data[0]['runners'][0]['ex']['availableToBack'][2]['price']))
						{
							
							$display=''; $cls='';
								if($team_draw_bet_total=='' && $team1_bet_total && $team2_bet_total=="")
									$display='style="display:none"';
								else{
									if($team1_bet_total=="")
										$team1_bet_total=0.00;
								}
								if($team1_bet_total!='' && $team1_bet_total>=0)
								{
									$cls='text-color-green';
								}
								else if($team1_bet_total!='' && $team1_bet_total<0)
								{
									$cls='text-color-red';
								}
								
								if($team1_bet_total!='' || $team2_bet_total!='' || $team_draw_bet_total!='')
								{
									if($team1_bet_total=='')
										$team1_bet_total=0;
									if($team2_bet_total=='')
										$team2_bet_total=0;
									if($team_draw_bet_total=='')
										$team_draw_bet_total=0;
								}
								
								$html.='<tr class="white-bg tr_team1">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
											<div>
												<span class="lose '.$cls.'" '.$display.' id="team1_bet_count_old">(<span id="team1_total">'.round($team1_bet_total,2).'</span>)</span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" data-team="team1">
											<a '.$login_check.'  data-val="'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['size'].'</span></a>
										</td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1">
											<a '.$login_check.'  data-cls="cyan-bg" data-val="'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'<br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['size'].'</span></a>
										</td>
										<td class="cyan-bg spark ODDSBack td_team1_back_0" data-team="team1">
											<a '.$login_check.'  data-val="'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
												@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['size'].'</span></a>
										</td>
										<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" data-team="team1">
											<a '.$login_check.'  data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['size'].'</span></a>
										</td>
										<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" data-team="team1">
											<a '.$login_check.' href="javascript:void(0)" data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['size'].'</span></a>
										</td>
										<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_lay_2" data-team="team1">
											<a '.$login_check.'  data-val="'.
												@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
												@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['size'].'</span></a>
										</td>
								</tr>';
							
						}
						else
						{
							$html.='<tr class="white-bg tr_team1">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> </td>
								<td class="light-blue-bg-2 td_team1_back_2"><a class="back1btn">
									<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
								<td class="link(target, link)ght-blue-bg-3 td_team1_back_1"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
								<td class="cyan-bg td_team1_back_0"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
								<td class="pink-bg td_team1_lay_0"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
								<td class="light-pink-bg-2 td_team1_lay_1"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
								<td class="light-pink-bg-3 td_team1_lay_2"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
							</tr>';
						}
					 }
					 else
					 {
						 $html_chk.='
								<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
	
								</tr>
								<tr class="white-bg tr_team1">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
											<div>
												<span class="lose " id="team1_bet_count_old"></span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" ><a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1"><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
										<td class="cyan-bg spark ODDSBack td_team1_back_0" ><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
										<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
										<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" ><a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
										<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_back_2" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								</tr>';
					 }
					 //end for status
					if(@$match_data[0]['status']=='OPEN')
					{
						if(isset($match_data[0]['runners'][1]['ex']['availableToBack'][2]['price']))
						{
							$display=''; $cls='';
							if($team_draw_bet_total=='' && $team1_bet_total && $team2_bet_total=="")
								$display='style="display:none"';
							else
							{
								if($team2_bet_total=="")
									$team2_bet_total=0.00;
							}
							if($team2_bet_total!='' && $team2_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team2_bet_total!='' && $team2_bet_total<0)
							{
								$cls='text-color-red';
							}
							
							$html.='<tr class="white-bg tr_team2">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> 
									<div>
										<span class="lose '.$cls.'" '.$display.' id="team2_bet_count_old">(<span id="team2_total">'.round($team2_bet_total,2).'</span>)</span>
										<span class="towin text-color-green" style="display:none" id="team2_bet_count_new">0.00</span>					
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" data-team="team2"><a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].'" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['size'].'</span></a></td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['size'].'</span>
									</a>
								</td>
								<td class="cyan-bg spark ODDSBack td_team2_back_0" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['size'].'</span>
									</a>
								</td>
								<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['size'].'</span>
									</a>
								</td>
								<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['size'].'</span>
									</a>
								</td>
								<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['size'].'</span></a>
								</td>
							</tr>';
						}
						else
						{
							$html.='<tr class="white-bg tr_team2">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> </td>
										<td class="light-blue-bg-2 td_team2_back_2"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
										<td class="link(target, link)ght-blue-bg-3 td_team2_back_1"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">
										--</a></td>
										<td class="cyan-bg td_team2_back_0"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
										<td class="pink-bg td_team2_lay_0"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
										<td class="light-pink-bg-2 td_team2_lay_1"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
										<td class="light-pink-bg-3 td_team2_lay_2"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
									</tr>';
						}
					}
					else
					{
						$html_chk.='
								<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
								</tr>
								<tr class="white-bg tr_team2">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
											<div>
												<span class="lose " id="team1_bet_count_old"></span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" ><a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team1"><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
										<td class="cyan-bg spark ODDSBack td_team2_back_0" ><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
										<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
										<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" ><a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
										<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								</tr>';
					}
				} // end suspended if
					$html.=$html_chk;
					$html.='</table>';
				}
				else
				{
					$html='No data found.';
				}
	
		//for bm
		
		$matchtype=$match->sports_id;
		$match_id=$match->id;			
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 

		$min_bet_odds_limit=$matchList->min_bookmaker_limit;
		$max_bet_odds_limit =$matchList->max_bookmaker_limit;
		
		$min_bet_fancy_limit=$matchList->min_fancy_limit;
		$max_bet_fancy_limit =$matchList->max_fancy_limit;

		$matchtype=$sport->id;
		$eventId=$matchList->event_id;
		$matchname=$matchList->match_name;
		$match_b=$matchList->suspend_b;
        $match_f=$matchList->suspend_f;
		$html_bm=''; $html_bm_team="";
		
		@$team_name=explode(" v ",strtolower($matchname));
		$team1_name=@$team_name[0];
		if(@$team_name[1])
			@$team2_name=$team_name[1];
		else
			$team2_name='';
		
		
		$match_detail = Match::where('event_id',$matchList->event_id)->where('status',1)->first();
		
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($eventId,$match_id,$matchtype);
		
		$team2_bet_total=0;
		$team1_bet_total=0;
		$team_draw_bet_total=0;
		
	
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets_bm = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('bet_type','BOOKMAKER')->get();
			//dd(DB::getQueryLog());
			
			if(sizeof($my_placed_bets_bm)>0)
			{
				foreach($my_placed_bets_bm as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{	
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		} 
		
		$html_two=''; $html_two_team="";
		
		$login_check='';
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
			 $login_check='onclick="opnForm(this);"';
		}
		else
		{
			$login_check='data-toggle="modal" data-target="#myLoginModal"';
		}
		
		if(!empty($match_data) && $match_data!=0)
		{
			
			//for bookmaker			
			$html_bm_team.='
			<tr>
                <td class="text-color-grey fancybet-block" colspan="7">
                    <div class="dark-blue-bg-1 text-color-white">
                        <a> <img src="'.asset('asset/front/img/pin-bg.png').'"> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                        Bookmaker Market <span class="zeroopa">| Zero Commission</span>
                        <a class="btn_fancy_info d-lg-none" id="fancyinfo"><img src="'.asset('asset/front/img/fancy-info.svg').'" alt=""></a>
                        <div class="fancyinfo_popup white-bg" id="fancypopupinfo">
                            <div class="fancypopup_content d-flex align-items-start">
                                <div>
                                    <dt class="text-color-grey">Min / Max</dt>
                                    <dd class="text-color-black1"> 1 / 500</dd>
                                </div>
                                    <a id="fancyinfo_close"><img src="'.asset('asset/front/img/close-icon.svg').'" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="fancy_info text-color-white d-none d-lg-block">
                        <span class="light-grey-bg-5 text-color-blue-1">Min</span> <span id="div_min_bet_bm_limit">'.$match_detail['min_bookmaker_limit'].'</span>
                        <span class="light-grey-bg-5 text-color-blue-1">Max</span> <span id="div_max_bet_bm_limit">'.$match_detail['max_bookmaker_limit'].'</span>
                    </div>
                </td>
            </tr>

			<tr class="bets-fancy white-bg d-none d-lg-table-row">
				<td colspan="3" style="width:170px"></td>
				<td>
					<a class="backall">
						<img src="'.asset('asset/front/img/bluebg1.png').'">
						<span>Back all</span>
					</a>
				</td>
				<td>
					<a class="layall">
						<img src="'.asset('asset/front/img/pinkbg1.png').'">
						<span>Lay all</span>
					</a>
				</td>
				<td colspan="2"></td>
			</tr>
            
            <tr class="bets-fancy white-bg d-lg-none">
				<td style="width:170px"></td>
				<td>
					<a class="backall">
						<img src="'.asset('asset/front/img/bluebg1.png').'">
						<span>Back all</span>
					</a>
				</td>
				<td>
					<a class="layall">
						<img src="'.asset('asset/front/img/pinkbg1.png').'">
						<span>Lay all</span>
					</a>
				</td>
				<td colspan="2"></td>
			</tr>';
			//print_r($match_data['bm']);
			
			$team_name_array=array();
			$team_name_array[]=@$match_data['bm'][0]['nation'];
			$team_name_array[]=@$match_data['bm'][1]['nation'];
			$team_name_array[]=@$match_data['bm'][2]['nation'];
			
			
			$team1_name= $arry_position=array_search(ucwords($team1_name),$team_name_array);
			$team2_name= $arry_position=array_search(ucwords($team2_name),$team_name_array);
			$team3_name=0;
			if($team1_name==0 && $team2_name==1)
				$team3_name=2;
			else if($team1_name==1 && $team2_name==0)
				$team3_name=2;
			else if($team1_name==2 && $team2_name==1)
				$team3_name=0;
			else if($team1_name==1 && $team2_name==2)
				$team3_name=0;
			else if($team1_name==0 && $team2_name==2)
				$team3_name=1;
			else if($team1_name==2 && $team2_name==0)
				$team3_name=1;
			
			if($team1_name!='' || $team2_name!='')
			{
				if($match_b=='0')
				{
					$html_bm.='<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
                    <tr class="white-bg tr_bm_team1">
								<td class="padding3">'.ucfirst(@$match_data['bm'][$team1_name]['nation']).'<br>
								<div>
									<span class="lose" id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">0.00</span>
								</div>
								</td>
								<td class="spark td_team1_bm_back_2">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3']).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team1_bm_back_1">
									<div class="back-gradient text-color-black">										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team1_bm_back_0">
									<div class="back-gradient text-color-black">
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay td_team1_bm_lay_0">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
									</div>
								</td>
                                <td class="sparkLay td_team1_bm_lay_1">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="sparkLay td_team1_bm_lay_2">
									<div class="lay-gradient text-color-black		
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>
							
							<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
							</tr>
							
							<tr class="white-bg tr_bm_team2">
								<td class="padding3">'.ucfirst(@$match_data['bm'][$team2_name]['nation']).'<br>
								<div>
									<span class="lose" id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="spark td_team2_bm_back_2">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team2_bm_back_1">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="spark td_team2_bm_back_0">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay td_team2_bm_lay_0">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>
								</td>
                                <td class="sparkLay td_team2_bm_lay_1">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="sparkLay td_team2_bm_lay_2">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
				}
				else
				{
					
					if(isset($match_data['bm'][$team1_name]['status']) && $match_data['bm'][$team1_name]['status']!='SUSPENDED')
					{
						$display=''; $cls='';
						if($team1_bet_total=='')
							$display='style="display:none"';
						if($team1_bet_total!='' && $team1_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team1_bet_total!='' && $team1_bet_total<0)
						{
							$cls='text-color-red';
						}					
						$html_bm.='

						<tr class="white-bg tr_bm_team1">
								<td class="padding3">'.ucfirst(@$match_data['bm'][$team1_name]['nation']).'<br>
								<div>
									<span class="lose '.$cls.'" '.$display.' id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="spark td_team1_bm_back_2">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="spark td_team1_bm_back_1">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team1_bm_back_0">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay td_team1_bm_lay_0">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>
								</td>
                                <td class="sparkLay td_team1_bm_lay_1">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="sparkLay td_team1_bm_lay_2">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
					}
					else
					{
						$display=''; $cls='';
						if($team1_bet_total=='')
							$display='style="display:none"';
						if($team1_bet_total!='' && $team1_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team1_bet_total!='' && $team1_bet_total<0)
						{
							$cls='text-color-red';
						}
						$html_bm.='
					
						<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg tr_bm_team1">
							<td class="padding3">'.ucfirst(@$match_data['bm'][$team1_name]['nation']).'<br>
								<div>
									<span class="lose '.$cls.'" '.$display.' id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
							</td>
							<td class="td_team1_bm_back_2">
								<div class="back-gradient text-color-black">
									<div id="back_3" class="light-blue-bg-2">
										<a>  </a>
									</div>
								</div>
							</td>
							<td class="td_team1_bm_back_1">
								<div class="back-gradient text-color-black">
									
									<div id="back_2" class="light-blue-bg-3">
										<a>  </a>
									</div>
								</div>
							</td>
							<td class="td_team1_bm_back_0">
								<div class="back-gradient text-color-black">
									
									<div id="back_1"><a class="cyan-bg">  </a></div>
								</div>
							</td>
							
							<td class="td_team1_bm_lay_0">
								<div class="lay-gradient text-color-black">
									<div id="lay_1"><a class="pink-bg">  </a></div>
									
								</div>
							</td>
							<td class="td_team1_bm_lay_1">
								<div class="lay-gradient text-color-black">
									
									<div id="lay_2" class="light-pink-bg-2">
										<a>  </a>
									</div>
								</div>
							</td>
							<td class="td_team1_bm_lay_2">
								<div class="lay-gradient text-color-black">
									
									<div id="lay_3" class="light-pink-bg-3">
										<a>  </a>
									</div>
								</div>
							</td>
						</tr>
						';
							
					}
					if(isset($match_data['bm'][$team2_name]['status']) && @$match_data['bm'][$team2_name]['status']!='SUSPENDED')
					{
						$display=''; $cls='';
						if($team2_bet_total=='')
							$display='style="display:none"';
						if($team2_bet_total!='' && $team2_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team2_bet_total!='' && $team2_bet_total<0)
						{
							$cls='text-color-red';
						}
						$html_bm.='<tr class="white-bg tr_bm_team2">
								<td class="padding3">'.ucfirst(@$match_data['bm'][$team2_name]['nation']).'<br>
									<div>
										<span class="lose '.$cls.'" '.$display.' id="team2_betBM_count_old">(<span id="team2_BM_total">'.round($team2_bet_total,2).'</span>)</span>
										<span class="tolose text-color-red" style="display:none" id="team2_betBM_count_new">(6.7)</span>
									</div>
								</td>
								<td class="spark td_team2_bm_back_2">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b3'],2).'">'.round(@$match_data['bm'][$team2_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team2_bm_back_1">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b2'],2).'">'.round(@$match_data['bm'][$team2_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark td_team2_bm_back_0">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b1'],2).'">'.round(@$match_data['bm'][$team2_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay td_team2_bm_lay_0">
									<div class="lay-gradient text-color-black">
										<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l1'],2).'">'.round(@$match_data['bm'][$team2_name]['l1'],2).'</a></div>
									</div>
								</td>
                                <td class="sparkLay td_team2_bm_lay_1">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l2'],2).'">'.round(@$match_data['bm'][$team2_name]['l2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="sparkLay td_team2_bm_lay_2">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l3'],2).'">'.round(@$match_data['bm'][$team2_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
					}
					else
					{
						$display=''; $cls='';
						if($team2_bet_total=='')
							$display='style="display:none"';
						if($team2_bet_total!='' && $team2_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team2_bet_total!='' && $team2_bet_total<0)
						{
							$cls='text-color-red';
						}
						$html_bm.='<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg tr_bm_team2">
							<td class="padding3">'.ucfirst(@$match_data['bm'][$team2_name]['nation']).'<br>
								<div>
									<span class="lose '.$cls.'" '.$display.' id="team2_betBM_count_old">(<span id="team2_BM_total">'.round($team2_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team2_betBM_count_new">(6.7)</span>
								</div>
							</td>
							<td class="td_team2_bm_back_2">
								<div class="back-gradient text-color-black">
									<div id="back_3" class="light-blue-bg-2">
										<a> </a>
	
									</div>
								</div>
							</td>
							<td class="td_team2_bm_back_1">
								<div class="back-gradient text-color-black">
									
									<div id="back_2" class="light-blue-bg-3">
										<a> </a>
									</div>
								</div>
							</td>
							<td class="td_team2_bm_back_0">
								<div class="back-gradient text-color-black">
									
									<div id="back_1"><a class="cyan-bg"> </a></div>
								</div>
							</td>
							
							
							<td class="td_team2_bm_lay_0">
								<div class="lay-gradient text-color-black">
									<div id="lay_1"><a class="pink-bg"> </a></div>
									
								</div>
							</td>
							<td class="td_team2_bm_lay_1">
								<div class="lay-gradient text-color-black">
									<div id="lay_2" class="light-pink-bg-2">
											<a> </a>
									</div>
								</div>
							</td>
							<td class="td_team2_bm_lay_2">
								<div class="lay-gradient text-color-black">
									
									<div id="lay_3" class="light-pink-bg-3">
											<a> </a>
									</div>
								</div>
							</td>
						</tr>
						';
							
					}
					if(isset($match_data['bm'][2]['status']))
					{
						if(@$match_data['bm'][2]['status']!='SUSPENDED')
						{
							$display=''; $cls='';
							if($team_draw_bet_total=='')
							{
								$display='style="display:none"';
							}
							if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
							{
								$cls='text-color-red';
							}
						
							$html_bm.='<tr class="white-bg tr_bm_team3">
										<td class="padding3">'.ucfirst(@$match_data['bm'][$team3_name]['nation']).'<br>
											<div>
												<span class="lose '.$cls.'" '.$display.' id="draw_betBM_count_old">(<span id="draw_BM_total">'.round($team_draw_bet_total,2).'</span>)</span>
												<span class="tolose text-color-red" style="display:none" id="draw_betBM_count_new">(6.7)</span>
											</div>
										</td>
										<td class="spark td_team3_bm_back_2">
											<div class="back-gradient text-color-black">
												<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b3'],2).'">'.round(@$match_data['bm'][$team3_name]['b3'],2).'</a>
												</div>
											</div>
										</td>
										<td class="spark td_team3_bm_back_1">
											<div class="back-gradient text-color-black">
												
												<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b2'],2).'">'.round(@$match_data['bm'][$team3_name]['b2'],2).'</a>
												</div>
												
											</div>
										</td>
										<td class="spark td_team3_bm_back_0">
											<div class="back-gradient text-color-black">
												
												<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b1'],2).'">'.round(@$match_data['bm'][$team3_name]['b1'],2).'</a>
												</div>
											</div>
										</td>
										
										
										<td class="sparkLay td_team3_bm_lay_0">
											<div class="lay-gradient text-color-black">
												<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l1'],2).'">'.round(@$match_data['bm'][$team3_name]['l1'],2).'</a>
												</div>
											</div>
										</td>
										<td class="sparkLay td_team3_bm_lay_1">
											<div class="lay-gradient text-color-black">
												
												<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l2'],2).'">'.round(@$match_data['bm'][$team3_name]['l2'],2).'</a>
												</div>
											</div>
										</td>
										<td class="sparkLay td_team3_bm_lay_2">
											<div class="lay-gradient text-color-black">
												
												<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
													<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l3'],2).'">'.round(@$match_data['bm'][$team3_name]['l3'],2).'</a>
												</div>
											</div>
										</td>
									</tr>';
						}
						else
						{
							$display=''; $cls='';
							if($team_draw_bet_total=='')
							{
								$display='style="display:none"';
							}
							if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
							{
								$cls='text-color-red';
							}
							$html_bm.='<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data['bm'][$team3_name]['status'].'</span></div>
								</td>
							</tr>
							<tr class="white-bg tr_bm_team3">
								<td class="padding3">'.ucfirst(@$match_data['bm'][$team3_name]['nation']).'<br>
								<div>
									<span class="lose '.$cls.'" '.$display.' id="draw_betBM_count_old">(<span id="draw_BM_total">'.round($team_draw_bet_total).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="draw_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="td_team3_bm_back_2">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="light-blue-bg-2">
											<a>  </a>
										</div>
									</div>
								</td>
								<td class="td_team3_bm_back_1">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="light-blue-bg-3">
											<a>  </a>
										</div>
									</div>
								</td>
								<td class="td_team3_bm_back_0">
									<div class="back-gradient text-color-black">
										
										<div id="back_1"><a class="cyan-bg">  </a></div>
									</div>
								</td>
								
								
								<td class="td_team3_bm_lay_0">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"><a class="pink-bg">  </a></div>
									</div>
								</td>
								<td class="td_team3_bm_lay_1">
									<div class="lay-gradient text-color-black">
										<div id="lay_2" class="light-pink-bg-2">
											<a>  </a>
										</div>
									</div>
								</td>
								<td class="td_team3_bm_lay_2">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="light-pink-bg-3">
											<a>  </a>
										</div>
									</div>
								</td>
							</tr>
							';
								
						}
					}
				} // end suspended if
			}
		}
		if($html_bm!='')
			$html_bm=$html_bm_team.$html_bm;
			
		
		//for fancy 
		$html_two='';
		$login_check='';
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			if($min_bet_fancy_limit>0 && $min_bet_fancy_limit!="" && $max_bet_fancy_limit>0 && $max_bet_fancy_limit!="")
			$login_check='onclick="opnForm(this);"';
		}
		else
		{
			$login_check='data-toggle="modal" data-target="#myLoginModal"';
		}
		$html_two_team.='
			<tr>
            	<td class="text-color-grey fancybet-block" colspan="7">
                	<div class="dark-blue-bg-1 text-color-white">
                    	<a> <img src="'.asset('asset/front/img/pin-bg.png').' "> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                        Fancy Bet <span id="div_min_bet_fancy_limit" style="display:none">'.$min_bet_fancy_limit.'</span> <span id="div_max_bet_fancy_limit" style="display:none">'.$max_bet_fancy_limit.'</span>
                   	</div>
               	</td>
           	</tr>
			<tr class="bets-fancy white-bg">
            	<td colspan="3">
				
				</td>
                <td>No</td>
                <td>Yes</td>
                <td colspan="1"></td>
            </tr>
			';
			$nat=array(); $gstatus=array(); $b=array(); $l=array(); $bs=array(); $ls=array(); $min=array(); $max=array(); $sid=array();
			if(@$match_data['fancy'])
			{
				//echo 'hello';
				//print_r($match_data['fancy']);
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
				
				sort($sid);
				//print_r($sid);
				for($i=0;$i<sizeof($sid);$i++)
				{
					$max_val=0;
					if($max[$sid[$i]]>999)
					{
						$input = number_format($max[$sid[$i]]);
						$input_count = substr_count($input, ',');
						$arr = array(1=>'K','M','B','T');
						if(isset($arr[(int)$input_count]))      
						   $max_val= substr($input,0,(-1*$input_count)*4).$arr[(int)$input_count];
						else
							$max_val= $input;
					}
					
					if($match_f=='0')
					{
						
						$sessionData = Session::get('playerUser');
						if(!empty($sessionData))
						{
								//$userId = Auth::user()->id;
								/*$getUser = Session::get('playerUser');
								$userId =$getUser->id;
								//DB::enableQueryLog();
								$my_placed_bets_session = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
								//dd(DB::getQueryLog());
								$abc=sizeof($my_placed_bets_session);
								if(sizeof($my_placed_bets_session)>0)
								{
									$run_arr=array();
									foreach($my_placed_bets_session as $bet)
									{
										$down_position=$bet->bet_odds-1;
										if(!in_array($down_position,$run_arr))
										{
											$run_arr[]=$down_position;
										}
										$level_position=$bet->bet_odds;
										if(!in_array($level_position,$run_arr))
										{
											$run_arr[]=$level_position;
										}
										$up_position=$bet->bet_odds+1;
										if(!in_array($up_position,$run_arr))
										{
											$run_arr[]=$up_position;
										}
									}
									array_unique($run_arr);
									sort($run_arr);
									$bet_chk=''; 
									for($kk=0;$kk<sizeof($run_arr);$kk++)
									{
										$bet_deduct_amt=0; $placed_bet_type='';
										foreach($my_placed_bets as $bet)
										{
											if($bet->bet_side=='back')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
												}
											}
											else if($bet->bet_side=='lay')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
												}
											}
										}
										if($final_exposer=="")
											$final_exposer=$bet_deduct_amt;
										else
										{
											if($final_exposer>$bet_deduct_amt)
												$final_exposer=$bet_deduct_amt;
										}
										
										if($bet_deduct_amt>0) {
											$position.='<tr> 
											<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
											<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
											</tr>';
										}
										else
										{
											$position.='<tr> 
											<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
											<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
											</tr>';
										}
									}
									if($position!='')
									{
										$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
											<div class="modal-dialog">
												<div class="modal-content light-grey-bg-1">
													<div class="modal-header">
														<h4 class="modal-title text-color-blue-1">Run Position</h4>
														<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
													</div>
													<div class="modal-body white-bg p-3">
														<table class="table table-bordered w-100 fonts-1 mb-0">
															<thead>
																<tr>
																	<th width="50%" class="text-center">Run</th>
																	<th width="50%" class="text-right">Amount</th>
																</tr>
															</thead>
															<tbody> '.$position.'</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>';
									}
								}*/
								$getUser = Session::get('playerUser');
								$userId =$getUser->id;
								//DB::enableQueryLog();
								$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
							
								//dd(DB::getQueryLog());
								//exit;
								$abc=sizeof($my_placed_bets);
								if(sizeof($my_placed_bets)>0)
								{
									$run_arr=array();
									foreach($my_placed_bets as $bet)
									{
										$down_position=$bet->bet_odds-1;
										if(!in_array($down_position,$run_arr))
										{
											$run_arr[]=$down_position;
										}
										$level_position=$bet->bet_odds;
										if(!in_array($level_position,$run_arr))
										{
											$run_arr[]=$level_position;
										}
										$up_position=$bet->bet_odds+1;
										if(!in_array($up_position,$run_arr))
										{
											$run_arr[]=$up_position;
										}
									}
									array_unique($run_arr);
									sort($run_arr);
									$bet_chk=''; 
									for($kk=0;$kk<sizeof($run_arr);$kk++)
									{
										$bet_deduct_amt=0; $placed_bet_type='';
										foreach($my_placed_bets as $bet)
										{
											if($bet->bet_side=='back')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt.'~>';	
													//$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
													
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt.'~>';
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
													//$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
													//$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
											}
											else if($bet->bet_side=='lay')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
												}
											}
										}
										if($final_exposer=="")
											$final_exposer=$bet_deduct_amt;
										else
										{
											if($final_exposer>$bet_deduct_amt)
												$final_exposer=$bet_deduct_amt;
										}
										
										if($bet_deduct_amt>0) {
											$position.='<tr> 
											<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
											<td class="text-right cyan-bg">'.$bet_deduct_amt.'--'.$bet_chk.'</td>
											</tr>';
										}
										else
										{
											$position.='<tr> 
											<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
											<td class="text-right pink-bg">'.$bet_deduct_amt.'--'.$bet_chk.'</td>
											</tr>';
										}
									}
									if($position!='')
									{
										$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
											<div class="modal-dialog">
												<div class="modal-content light-grey-bg-1">
													<div class="modal-header">
														<h4 class="modal-title text-color-blue-1">Run Position</h4>
														<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
													</div>
													<div class="modal-body white-bg p-3">
														<table class="table table-bordered w-100 fonts-1 mb-0">
															<thead>
																<tr>
																	<th width="50%" class="text-center">Run</th>
																	<th width="50%" class="text-right">Amount</th>
																</tr>
															</thead>
															<tbody> '.$position.'</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>';
									}
								}
							}
							
							$display=''; $cls='';
							if($bet_model=='')
							{
								$display='style="display:block"';
							}
							if($bet_model!='')
							{
								$cls='text-color-red';
							}
							//end for bet calculation
						
							$html_two.='
							<tr class="fancy-suspend-tr">
							<td colspan="3"></td>
							<td class="fancy-suspend-td" colspan="2">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
							</tr>
							<tr class="white-bg tr_fancy_'.$i.'">
									<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
										<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
									</td>
									<td class="pink-bg back1btn text-center FancyLay td_fancy_lay_'.$i.'" >
										<a><br> <span>--</span></a></td>
									<td class="lay1btn cyan-bg text-center FancyBack td_fancy_back_'.$i.'">
										<a>--<br> <span>--</span></a>
									</td>
									<td class="zeroopa1" colspan="1"> <span></span> <br></td>
								</tr>';
					}
					else{
						$placed_bet=''; $position=''; $bet_model=''; $abc=''; $final_exposer='';
						if($gstatus[$sid[$i]]!='Ball Running' &&  $gstatus[$sid[$i]]!='Suspended' && $l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0)
						{
							if($l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0 && $l[$sid[$i]]!='' && $b[$sid[$i]]!='' )
							{
								//bet calculation
								
								$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									/*$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets_session = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets_session);
									if(sizeof($my_placed_bets_session)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets_session as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}*/
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
								
									//dd(DB::getQueryLog());
									//exit;
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt.'=>';	
														//$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt.'=>';
														//$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														//$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'--'.$bet_chk.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'--'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								
								$html_two.='<tr class="white-bg tr_fancy_'.$i.'">
									<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
										<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
										
									</td>
									<td class="pink-bg back1btn text-center FancyLay td_fancy_lay_'.$i.'" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="pink-bg" data-volume="'.round($ls[$sid[$i]]).'" data-val="'.round($l[$sid[$i]]).'">'.round($l[$sid[$i]]).'<br> <span>'.round($ls[$sid[$i]]).'</span></a></td>
									<td class="lay1btn cyan-bg text-center FancyBack td_fancy_back_'.$i.'" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="cyan-bg" data-volume="'.round($bs[$sid[$i]]).'" data-val="'.round($b[$sid[$i]]).'">'.round($b[$sid[$i]]).'<br> <span>'.round($bs[$sid[$i]]).'</span></a>
									</td>
									<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].'</td>
								</tr>';
							}
							else
							{
								//for bet calculation
								$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								$html_two.='<tr class="fancy-suspend-tr-1">
								<td colspan="3"></td>
								<td class="fancy-suspend-td-1" colspan="2">
									<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
								</tr>
								<tr class="white-bg tr_fancy_'.$i.'">
									<td colspan="3"><b>'.$nat[$sid[$i]].' </b></td>
									<td class="pink-bg  back1btn text-center1111 td_fancy_lay_'.$i.'"><a> <br> <span> </span></a></td>
									<td class="cyan-bg lay1btn  text-center td_fancy_back_'.$i.'"><a> <br> <span> </span></a></td>
									<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].' </td>
								</tr>
								';
							}
						}
						else
						{
							//for bet calculation
							$sessionData = Session::get('playerUser');
							if(!empty($sessionData))
							{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets_session = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets_session);
									if(sizeof($my_placed_bets_session)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets_session as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets_session as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
							}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
							$html_two.='<tr class="fancy-suspend-tr-1">
								<td colspan="3"></td>
								<td class="fancy-suspend-td-1" colspan="2">
									<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>'.$gstatus[$sid[$i]].'</span></div>
								</td>
							</tr>
							<tr class="white-bg tr_fancy_'.$i.'">
								<td colspan="3"><b>'.$nat[$sid[$i]].' </b>
									<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
								</td>
								<td class="pink-bg  back1btn text-center td_fancy_lay_'.$i.'"><a> <br> <span> </span></a></td>
								<td class="cyan-bg lay1btn  text-center td_fancy_lay_'.$i.'"><a> <br> <span> </span></a></td>
								<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$matchList['min_fancy_limit'].' / '.$matchList['max_fancy_limit'].' </td>
							</tr>
							';
						}
					} // end suspended if
				}
				if($html_two!='')
					$html_two=$html_two_team.$html_two.'<input type="hidden" name="hid_fancy" id="hid_fancy" value="'.$i.'">';
			}
		return view('front.matchDetail',compact('match','match_data','inplay','my_placed_bets','total_todays_bet','match_name_bet','html','html_bm','html_two'));
		
  	}
	public function matchCallOdds($eventId, Request $request)
	{
		$matchtype=$request->matchtype;
	
		$match_id=$request->match_id;
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 
		if(!$matchList)
		{
			return 'inactive';
		}
		$match_m=$matchList->suspend_m;
		$matchtype=$sport->id;
		$matchId=$request->matchid;
		$matchname=$request->matchname;
		$event_id=$request->event_id;
		$team=explode(" v ",strtolower($matchname));
		$sport_id=$matchList->sports_id;
		
		$min_bet_odds_limit=$matchList->min_bet_odds_limit;
		$max_bet_odds_limit =$matchList->max_bet_odds_limit;
		
		$team1_bet_total='';
		$team1_bet_class='';
		
		$team2_bet_total='';
		$team2_bet_class='';
		
		$team_draw_bet_total='';
		$team_draw_bet_class='';
		
		$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$event_id,$matchtype);
		$sessionData = Session::get('playerUser');
		
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$event_id)->where('bet_type','ODDS')->where('isDeleted',0)->get();
			//dd(DB::getQueryLog());
			$team2_bet_total=0;
			$team1_bet_total=0;
			$team_draw_bet_total=0;
			if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
								
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									//$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								
								if(count($abc)>=2)
								{	
									//$team_draw_bet_total=$team_draw_bet_total-($bet->bet_odds/($bet->bet_amount-1));
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit; ///nnn 16-7-2021
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								//$team2_bet_total=$team2_bet_total+$bet->bet_amount;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		}
	//echo $match_data;
	$section='3';
	if($sport_id=='1'){
		$section='2';
	}
	$html='';
  	$html.= '<table class="table custom-table inplay-table w1-table">
		<tr class="betstr">
        	<td class="text-color-grey">'.$section.' Selections</td>
            <td colspan="2">101.7%</td>
            <td>
            	<a class="backall">
                	<img src="'.asset('asset/front/img/bluebg1.png').'">
                    <span>Back all</span>
               	</a>
           	</td>
            <td>
            	<a class="layall">
                	<img src="'.asset('asset/front/img/pinkbg1.png').'">
                    <span>Lay all</span>
              	</a>
           	</td>
          	<td colspan="2">97.9%</td>
            </tr>'; 
			//data-toggle="modal" data-target="#myLoginModal"
			$login_check='';
			$sessionData = Session::get('playerUser');
			if(!empty($sessionData))
			{
				if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
					$login_check='onclick="opnForm(this);"';
			}
			else
			{
				$login_check='data-toggle="modal" data-target="#myLoginModal"';
			}
			
            if($match_data!=0)
			{
				$html_chk='';
				if($match_m=='0')
				{
					if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
					{
				 		$html.='
				 		<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
				 		<tr class="white-bg tr_team3">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">The Draw</b> 
								<div>
									<span class="lose " id="team1_bet_count_old"></span>
									<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
								</div>
							</td>
							<td class="light-blue-bg-2 spark opnForm ODDSBack td_team3_back_2" >
								<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team3_back_1" data-team="team1">
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
							</td>
							<td class="cyan-bg spark ODDSBack td_team3_back_0" >
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="pink-bg sparkLay ODDSLay td_team3_lay_0" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
							</td>
							<td class="light-pink-bg-2 sparkLay ODDSLay td_team3_lay_1" >
								<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
							<td class="light-pink-bg-3 sparkLay ODDSLay td_team3_lay_2" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
							</td>
						</tr>';
					}
					$html_chk.='
					<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
					<tr class="white-bg tr_team1">
						<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
							<div>
								<span class="lose " id="team1_bet_count_old"></span>
								<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
							</div>
						</td>
						<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" >
							<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
						</td>
						<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1">
							<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
						</td>
						<td class="cyan-bg spark ODDSBack td_team1_back_0" >
							<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
						<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" >
							<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
						</td>
						<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" >
							<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
						<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_lay_2" >
							<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
					</tr>
					<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
					<tr class="white-bg tr_team2">
						<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
							<div>
								<span class="lose " id="team1_bet_count_old"></span>
								<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
							</div>
						</td>
						<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" >
							<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
						</td>
						<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team1">
							<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
						</td>
						<td class="cyan-bg spark ODDSBack td_team2_back_0" >
							<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
						<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" >
							<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
						</td>
						<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" >
							<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
						<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" >
							<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
						</td>
					</tr>';
				 }
				 else
				 {				 
					if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
					{	
						$display=''; $cls='';
						if($team_draw_bet_total=='' && $team1_bet_total=="" && $team2_bet_total=="")
						{
							$display='style="display:none"';
						}
						else
						{
							if($team_draw_bet_total=="")
								$team_draw_bet_total=0.00;
						}
						if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
						{
							$cls='text-color-red';
						}
					
					$html_chk.='<tr class="white-bg tr_team3">
						<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team3"> The Draw </b> 
							<div>
								<span class="lose '.$cls.'" '.$display.' id="draw_bet_count_old">(<span id="draw_total">'.round($team_draw_bet_total,2).'</span>)</span>
								<span class="tolose text-color-red" style="display:none" id="draw_bet_count_new">0.00</span>
							</div>
						</td>
						<td class="light-blue-bg-2  spark ODDSBack td_team3_back_2" data-team="team3">
							<a '.$login_check.' data-val="'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black">
								<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['size'].'</span>
							</a>
						</td>
						<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team3_back_1" data-team="team3">
							<a '.$login_check.'  data-cls="cyan-bg" data-val="'. @$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].'" class="text-color-black back1btn"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['size'].'</span>
							</a>
						</td>
						<td class="cyan-bg spark ODDSBack td_team3_back_0" data-team="team3">
							<a '.$login_check.' data-val="'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['size'].'</span>
							</a>
						</td>
						<td class="pink-bg sparkLay ODDSLay td_team3_lay_0" data-team="team3">
							<a '.$login_check.'  data-val="'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['size'].'</span>
							</a>
						</td>
						<td class="light-pink-bg-2 sparkLay ODDSLay td_team3_lay_1" data-team="team3">
							<a '.$login_check.'  data-val="'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['size'].'</span>
							</a>
						</td>
						<td class="light-pink-bg-3 sparkLay ODDSLay td_team3_lay_2" data-team="team3">
							<a '.$login_check.'  data-val="'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].' <br><span>'.
								@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['size'].'</span>
							</a>
						</td>
					</tr>';
				 }
				//check status
				if(@$match_data[0]['status']=='OPEN')
				{
					if(isset($match_data[0]['runners'][0]['ex']['availableToBack'][2]['price']))
					{
						
						$display=''; $cls='';
							if($team_draw_bet_total=='' && $team1_bet_total=="" && $team2_bet_total=="")
								$display='style="display:none"';
							else
							{
								if($team1_bet_total=='')
									$team1_bet_total=0.00;
							}
							if($team1_bet_total!='' && $team1_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team1_bet_total!='' && $team1_bet_total<0)
							{
								$cls='text-color-red';
							}
							$html.='<tr class="white-bg tr_team1">
									<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
										<div>
											<span class="lose '.$cls.'" '.$display.' id="team1_bet_count_old">(<span id="team1_total">'.round($team1_bet_total,2).'</span>)</span>
											<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
										</div>
									</td>
									<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" data-team="team1">
										<a '.$login_check.'  data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['size'].'</span></a>
									</td>
									<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1">
										<a '.$login_check.'  data-cls="cyan-bg" data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'<br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['size'].'</span></a>
									</td>
									<td class="cyan-bg spark ODDSBack td_team1_back_0" data-team="team1">
										<a '.$login_check.'  data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['size'].'</span></a>
									</td>
									<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" data-team="team1">
										<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['size'].'</span></a>
									</td>
									<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" data-team="team1">
										<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['size'].'</span></a>
									</td>
									<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_lay_2" data-team="team1">
										<a '.$login_check.'  data-val="'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['size'].'</span></a>
									</td>
							</tr>';
						
					}
					else
					{
						$html.='<tr class="white-bg tr_team1">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> </td>
							<td class="light-blue-bg-2 td_team1_back_2"><a class="back1btn">
								<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
							<td class="link(target, link)ght-blue-bg-3 td_team1_back_1"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
							<td class="cyan-bg td_team1_back_0"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
							<td class="pink-bg td_team1_lay_0"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
							<td class="light-pink-bg-2 td_team1_lay_1"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
							<td class="light-pink-bg-3 td_team1_lay_2"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</td>
						</tr>';
					}
				 }
				 else
				 {
					 $html_chk.='
							<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
								</td>

							</tr>
							<tr class="white-bg tr_team1">
									<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
										<div>
											<span class="lose " id="team1_bet_count_old"></span>
											<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
										</div>
									</td>
									<td class="light-blue-bg-2 spark opnForm ODDSBack td_team1_back_2" ><a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
									<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team1_back_1" data-team="team1"><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
									<td class="cyan-bg spark ODDSBack td_team1_back_0" ><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
									<td class="pink-bg sparkLay ODDSLay td_team1_lay_0" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
									<td class="light-pink-bg-2 sparkLay ODDSLay td_team1_lay_1" ><a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
									<td class="light-pink-bg-3 sparkLay ODDSLay td_team1_back_2" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
							</tr>';
				 }
				 //end for status
				if(@$match_data[0]['status']=='OPEN')
				{
					if(isset($match_data[0]['runners'][1]['ex']['availableToBack'][2]['price']))
					{
						$display=''; $cls='';
						if($team_draw_bet_total=='' && $team1_bet_total=="" && $team2_bet_total=="")
							$display='style="display:none"';
						else
						{
							if($team2_bet_total=="")
								$team2_bet_total=0.00;
						}
						if($team2_bet_total!='' && $team2_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team2_bet_total!='' && $team2_bet_total<0)
						{
							$cls='text-color-red';
						}
						$html.='<tr class="white-bg tr_team2">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> 
								<div>
									<span class="lose '.$cls.'" '.$display.' id="team2_bet_count_old">(<span id="team2_total">'.round($team2_bet_total,2).'</span>)</span>
									<span class="towin text-color-green" style="display:none" id="team2_bet_count_new">0.00</span>					
								</div>
							</td>
							<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" data-team="team2"><a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].'" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['size'].'</span></a></td>
							<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team2">
								<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['size'].'</span>
								</a>
							</td>
							<td class="cyan-bg spark ODDSBack td_team2_back_0" data-team="team2">
								<a '.$login_check.' href="javascript:void(0)" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['size'].'</span>
								</a>
							</td>
							<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" data-team="team2">
								<a '.$login_check.' href="javascript:void(0)" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['size'].'</span>
								</a>
							</td>
							<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" data-team="team2">
								<a '.$login_check.' href="javascript:void(0)" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['size'].'</span>
								</a>
							</td>
							<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" data-team="team2">
								<a '.$login_check.' href="javascript:void(0)" data-val="'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['size'].'</span></a>
							</td>
						</tr>';
					}
					else
					{
						$html.='<tr class="white-bg tr_team2">
									<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> </td>
									<td class="light-blue-bg-2 td_team2_back_2"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
									<td class="link(target, link)ght-blue-bg-3 td_team2_back_1"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">
									--</a></td>
									<td class="cyan-bg td_team2_back_0"><a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
									<td class="pink-bg td_team2_lay_0"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
									<td class="light-pink-bg-2 td_team2_lay_1"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
									<td class="light-pink-bg-3 td_team2_lay_2"><a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a></td>
								</tr>';
					}
				}
				else
				{
					$html_chk.='
							<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
								</td>
							</tr>
							<tr class="white-bg tr_team2">
									<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
										<div>
											<span class="lose " id="team1_bet_count_old"></span>
											<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
										</div>
									</td>
									<td class="light-blue-bg-2 spark opnForm ODDSBack td_team2_back_2" ><a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
									<td class="link(target, link)ght-blue-bg-3 spark ODDSBack td_team2_back_1" data-team="team1"><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
									<td class="cyan-bg spark ODDSBack td_team2_back_0" ><a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
									<td class="pink-bg sparkLay ODDSLay td_team2_lay_0" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
									<td class="light-pink-bg-2 sparkLay ODDSLay td_team2_lay_1" ><a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
									<td class="light-pink-bg-3 sparkLay ODDSLay td_team2_lay_2" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
							</tr>';
				}
			} // end suspended if
				$html.=$html_chk;
				$html.='</table>';
			}
			else
			{
				$html='No data found.';
			}
			return $html;
	
	}
	public function matchCall($eventId, Request $request)
	{
		$matchtype=$request->matchtype;
		$match_id=$request->match_id;
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 
		if(!$matchList)
			return 'inactive';
		$match_m=@$matchList->suspend_m;
		$matchtype=$sport->id;
		$matchId=$request->matchid;
		$matchname=$request->matchname;
		$event_id=$request->event_id;
		$team=explode(" v ",strtolower($matchname));
		$sport_id=$matchList->sports_id;
		
		$min_bet_odds_limit=$matchList->min_bet_odds_limit;
		$max_bet_odds_limit =$matchList->max_bet_odds_limit;
		
		$team1_bet_total='';
		$team1_bet_class='';
		
		$team2_bet_total='';
		$team2_bet_class='';
		
		$team_draw_bet_total='';
		$team_draw_bet_class='';
		
		$match_data=app('App\Http\Controllers\RestApi')->DetailCall($matchId,$event_id,$matchtype);
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$event_id)->where('bet_type','ODDS')->where('isDeleted',0)->get();
			//dd(DB::getQueryLog());
			$team2_bet_total=0;
			$team1_bet_total=0;
			$team_draw_bet_total=0;
			if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit; ///nnn 16-7-2021
									
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									//$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
									
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit; ///nnn 16-7-2021
								
								if(count($abc)>=2)
								{	
									//$team_draw_bet_total=$team_draw_bet_total-($bet->bet_odds/($bet->bet_amount-1));
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit; ///nnn 16-7-2021
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								//$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		}
		//echo $match_data;
		$section='3';
		if($sport_id=='1'){
			$section='2';
		}
		$team1=''; $team2=''; $team3='';
		$html='';
		$html.= '<table class="table custom-table inplay-table w1-table">
			<tr class="betstr">
				<td class="text-color-grey">'.$section.' Selections</td>
				<td colspan="2">101.7%</td>
				<td>
					<a class="backall">
						<img src="'.asset('asset/front/img/bluebg1.png').'">
						<span>Back all</span>
					</a>
				</td>
				<td>
					<a class="layall">
						<img src="'.asset('asset/front/img/pinkbg1.png').'">
						<span>Lay all</span>
					</a>
				</td>
				<td colspan="2">97.9%</td>
				</tr>'; 
				//data-toggle="modal" data-target="#myLoginModal"
				$login_check='';
				$sessionData = Session::get('playerUser');
				if(!empty($sessionData))
				{
					if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
						$login_check='onclick="opnForm(this);"';
				}
				else
				{
					$login_check='data-toggle="modal" data-target="#myLoginModal"';
				}
				
				if($match_data!=0)
				{
					$html_chk='';
					if($match_m=='0')
					{
						if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
						{
							$team3.='<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
							$team3.='<a  class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>~';
							$team3.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
							$team3.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
							$team3.='<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
							$team3.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>';
							
							$team3.='***<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
							</tr>';
							
							/*$html.='
							<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
							</tr>
							<tr class="white-bg">
								<td>
									<img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">The Draw  </b> 
									<div>
										<span class="lose " id="team1_bet_count_old"></span>
										<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack" >
									<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
								</td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
									<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
								</td>
								<td class="cyan-bg spark ODDSBack" >
									<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
								<td class="pink-bg sparkLay ODDSLay" >
									<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
								</td>
								<td class="light-pink-bg-2 sparkLay ODDSLay" >
									<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
								<td class="light-pink-bg-3 sparkLay ODDSLay" >
									<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
								</td>
							</tr>';*/
							
						}
						
						$team1.='<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team1.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>~';
						$team1.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team1.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team1.='<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team1.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>';
						$team1.='***<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>';
						
						$team2.='<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team2.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>~';
						$team2.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team2.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team2.='<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team2.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>';
						
						$team2.='***<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>';
						
						/*$html_chk.='
						<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
									<div>
										<span class="lose " id="team1_bet_count_old"></span>
										<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack" >
								<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
									<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
								<td class="cyan-bg spark ODDSBack" >
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								<td class="pink-bg sparkLay ODDSLay" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
								<td class="light-pink-bg-2 sparkLay ODDSLay" >
								<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								<td class="light-pink-bg-3 sparkLay ODDSLay" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
						</tr>
						<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>
						<tr class="white-bg">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
									<div>
										<span class="lose " id="team1_bet_count_old"></span>
										<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack" >
								<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
								</td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a></td>
								<td class="cyan-bg spark ODDSBack" >
								<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								<td class="pink-bg sparkLay ODDSLay" >
								<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a></td>
								<td class="light-pink-bg-2 sparkLay ODDSLay" >
								<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
								<td class="light-pink-bg-3 sparkLay ODDSLay" ><a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a></td>
						</tr>'; */
					 }
					 else
					 {				 
						if(@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price']!='')
						{	
							$team3.='<a '.$login_check.' data-val="'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black">
										<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['size'].'</span>
									</a>~';
							$team3.='<a '.$login_check.'  data-cls="cyan-bg" data-val="'. @$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].'" class="text-color-black back1btn"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].' <br><span>'.
											@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['size'].'</span>
										</a>~';
							$team3.='<a '.$login_check.' data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['size'].'</span></a>~';
							$team3.='<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['size'].'</span></a>~';
							$team3.='<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['size'].'</span></a>~';
							$team3.='<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['size'].'</span></a>';
							
							/*$display=''; $cls='';
							if($team_draw_bet_total=='')
							{
								$display='style="display:none"';
							}
							if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
							{
								$cls='text-color-red';
							}
						
							$html_chk.='<tr class="white-bg">
							<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team3"> The Draw </b> 
								<div>
									<span class="lose '.$cls.'" '.$display.' id="draw_bet_count_old">(<span id="draw_total">'.round($team_draw_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="draw_bet_count_new">0.00</span>
								</div>
							</td>
							<td class="light-blue-bg-2  spark ODDSBack" data-team="team3">
									<a '.$login_check.' data-val="'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black">
										<img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][2]['ex']['availableToBack'][2]['size'].'</span>
									</a>
								</td>
								<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team3">
										<a '.$login_check.'  data-cls="cyan-bg" data-val="'. @$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].'" class="text-color-black back1btn"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
											@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['price'].' <br><span>'.
											@$match_data[0]['runners'][2]['ex']['availableToBack'][1]['size'].'</span>
										</a>
									</td>
								<td class="cyan-bg spark ODDSBack" data-team="team3">
									<a '.$login_check.' data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToBack'][0]['size'].'</span></a>
								</td>
									<td class="pink-bg sparkLay ODDSLay" data-team="team3">
									<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][0]['size'].'</span></a>
								</td>
									<td class="light-pink-bg-2 sparkLay ODDSLay" data-team="team3">
										<a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][1]['size'].'</span></a>
								</td>
									<td class="light-pink-bg-3 sparkLay ODDSLay" data-team="team3"><a '.$login_check.'  data-val="'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['price'].' <br><span>'.
									@$match_data[0]['runners'][2]['ex']['availableToLay'][2]['size'].'</span></a></td>
						</tr>';*/
					}
					//check status
					if(@$match_data[0]['status']=='OPEN')
					{
						if(isset($match_data[0]['runners'][0]['ex']['availableToBack'][2]['price']))
						{
								$team1.='<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['size'].'</span></a>~';
								$team1.='<a '.$login_check.'  data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'<br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['size'].'</span></a>~';
								$team1.='<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['size'].'</span></a>~';
								$team1.='<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['size'].'</span></a>~';
								$team1.='<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['size'].'</span></a>~';
								$team1.='<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['size'].'</span></a>';
								
							
								/*$display=''; $cls='';
								if($team1_bet_total=='')
									$display='style="display:none"';
								if($team1_bet_total!='' && $team1_bet_total>=0)
								{
									$cls='text-color-green';
								}
								else if($team1_bet_total!='' && $team1_bet_total<0)
								{
									$cls='text-color-red';
								}
								$html.='<tr class="white-bg">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
											<div>
												<span class="lose '.$cls.'" '.$display.' id="team1_bet_count_old">(<span id="team1_total">'.round($team1_bet_total,2).'</span>)</span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">0.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack" data-team="team1">
										<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][2]['size'].'</span></a>
										</td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
										
										<a '.$login_check.'  data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['price'].'<br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][1]['size'].'</span></a>
										</td>
										<td class="cyan-bg spark ODDSBack" data-team="team1">
										<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToBack'][0]['size'].'</span></a>
										</td>
										<td class="pink-bg sparkLay ODDSLay" data-team="team1">
										<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][0]['size'].'</span></a>
										</td>
										<td class="light-pink-bg-2 sparkLay ODDSLay" data-team="team1">
										<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][1]['size'].'</span></a></td>
										<td class="light-pink-bg-3 sparkLay ODDSLay" data-team="team1">
										<a '.$login_check.'  data-val="'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['price'].' <br><span>'.@$match_data[0]['runners'][0]['ex']['availableToLay'][2]['size'].'</span></a></td>
								</tr>'; */
							
						}
						else
						{
							$team1.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
							$team1.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
							$team1.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team1.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team1.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team1.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>';
							
							/*$html.='<tr class="white-bg">
									<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> </td>
									<td class="light-blue-bg-2">
										<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
									</td>
									<td class="link(target, link)ght-blue-bg-3">
										<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
									</td>
									<td class="cyan-bg">
										<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
									</td>
									<td class="pink-bg">
										<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
									</td>
									<td class="light-pink-bg-2">
										<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
									</td>
									<td class="light-pink-bg-3">
										<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
									</td>
							</tr>';*/
						}
					 }
					 else
					 {
						 $team1.='<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						 $team1.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>~';
						 $team1.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						 $team1.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						 $team1.='<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						 $team1.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>';
						 $team1.='***<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
								</tr>';
						 
						 /*$html_chk.='
								<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
								</tr>
								<tr class="white-bg">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[0]).' </b> 
											<div>
												<span class="lose " id="team1_bet_count_old"></span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack" >
											<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
										</td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
											<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
										</td>
										<td class="cyan-bg spark ODDSBack" >
											<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
										<td class="pink-bg sparkLay ODDSLay" >
											<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
										</td>
										<td class="light-pink-bg-2 sparkLay ODDSLay" >
											<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
										<td class="light-pink-bg-3 sparkLay ODDSLay" >
											<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
								</tr>';*/
					 }
					 //end for status
					if(@$match_data[0]['status']=='OPEN')
					{
						if(isset($match_data[0]['runners'][1]['ex']['availableToBack'][2]['price']))
						{
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].'" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['size'].'</span></a>~';
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['size'].'</span></a>~';
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['size'].'</span></a>~';
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['size'].'</span></a>~';
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['size'].'</span></a>~';
							$team2.='<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['size'].'</span></a>';
							
							/*	$display=''; $cls='';
							if($team2_bet_total=='')
								$display='style="display:none"';
							if($team2_bet_total!='' && $team2_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team2_bet_total!='' && $team2_bet_total<0)
							{
								$cls='text-color-red';
							}
							$html.='<tr class="white-bg">
								<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> 
									<div>
										<span class="lose '.$cls.'" '.$display.' id="team2_bet_count_old">(<span id="team2_total">'.round($team2_bet_total,2).'</span>)</span>
										<span class="towin text-color-green" style="display:none" id="team2_bet_count_new">0.00</span>					
									</div>
								</td>
								<td class="light-blue-bg-2 spark opnForm ODDSBack" data-team="team2">
										<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].'" class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][2]['size'].'</span></a>
								</td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team2">
											<a '.$login_check.' href="javascript:void(0)" data-cls="cyan-bg" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].'" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][1]['size'].'</span></a>
								</td>
								<td class="cyan-bg spark ODDSBack" data-team="team2">
										<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].'" data-cls="cyan-bg" class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToBack'][0]['size'].'</span></a>
								</td>
										<td class="pink-bg sparkLay ODDSLay" data-team="team2">
										<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][0]['size'].'</span></a>
									</td>
									<td class="light-pink-bg-2 sparkLay ODDSLay" data-team="team2">
										<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][1]['size'].'</span></a>
									</td>
										<td class="light-pink-bg-3 sparkLay ODDSLay" data-team="team2">
									<a '.$login_check.' href="javascript:void(0)" data-val="'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].'" data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['price'].' <br><span>'.
										@$match_data[0]['runners'][1]['ex']['availableToLay'][2]['size'].'</span></a>
									</td>
									</tr>'; */
						}
						else
						{
							$team2.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team2.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team2.='<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team2.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team2.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>~';
							$team2.='<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>';
							
							/*$html.='<tr class="white-bg">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team2">  '.ucfirst($team[1]).' </b> </td>
										<td class="light-blue-bg-2">
											<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
										<td class="link(target, link)ght-blue-bg-3">
											<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
										<td class="cyan-bg">
											<a class="back1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
										<td class="pink-bg">
											<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
										<td class="light-pink-bg-2">
											<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
										<td class="light-pink-bg-3">
											<a class="lay1btn"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</a>
										</td>
									</tr>';*/
						}
					}
					else
					{
						$team2.='<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team2.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>~';
						$team2.='<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team2.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>~';
						$team2.='<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>~';
						$team2.='<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>';
						$team2.='***<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
								</tr>';
						
						/*$html_chk.='
								<tr class="fancy-suspend-tr">
									<td></td>
									<td class="fancy-suspend-td" colspan="6">
										<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data[0]['status'].'</span></div>
									</td>
								</tr>
								<tr class="white-bg">
										<td> <img src="'.asset('asset/front/img/bars.png').'"> <b class="team1">'.ucfirst($team[1]).' </b> 
											<div>
												<span class="lose " id="team1_bet_count_old"></span>
												<span class="towin text-color-green" style="display:none" id="team1_bet_count_new">10.00</span>
											</div>
										</td>
										<td class="light-blue-bg-2 spark opnForm ODDSBack" >
											<a class="back1btn text-color-black"><img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
										</td>
										<td class="link(target, link)ght-blue-bg-3 spark ODDSBack" data-team="team1">
											<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--<br><span>--</span></a>
										</td>
										<td class="cyan-bg spark ODDSBack" >
											<a  class="back1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
										<td class="pink-bg sparkLay ODDSLay" >
											<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">--</span></a>
										</td>
										<td class="light-pink-bg-2 sparkLay ODDSLay" >
											<a data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
										<td class="light-pink-bg-3 sparkLay ODDSLay" >
											<a  data-cls="pink-bg" class="lay1btn text-color-black"> <img src="'.asset('asset/front/img/disable-img.png').'" class="disimg">-- <br><span>--</span></a>
										</td>
								</tr>';*/
				}
			} // end suspended if
				/*$html.=$html_chk;
				$html.='</table>';
				return $html;*/
			}
			else
			{
				//return 'No data found.';
			}
			return $team1.'==='.$team2.'==='.$team3;
			
  	}
	public function getmatchdetails()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
						$match_array_data_cricket[]=$match->match_id;
					else if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
					else if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
		$imp_match_array_data_tenis=@implode(",",$match_array_data_tenis);
		$imp_match_array_data_soccer=@implode(",",$match_array_data_soccer);	
						
		$mdata=array(); $inplay=0;
		
				  	 		//$url="http://3.7.102.54/listMarketBookBetfair/1.181577392,1.180195059,1.183915893,1.184162114,1.184030231,1.184030131,1.184030030,1.184029930,1.184037030,1.184094405,1.184094505,1.184094605,1.181577392";
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
		
		$match_data = json_decode($return, true);
		//print_r($match_data);
				
		$cricket='<div class="programe-setcricket">
		<div class="firstblock-cricket lightblue-bg1">
		<span class="fir-col1"></span>
        <span class="fir-col2">1</span>
        <span class="fir-col2">X</span>
        <span class="fir-col2">2</span>
        <span class="fir-col3"></span>
        </div>';

		$html='';
		for($j=0;$j<sizeof($match_data);$j++)
		{
			$inplay_game='';
			$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
			if(isset($match_data[$j]['inplay']))
			{
				if($match_data[$j]['inplay']==1)
				{
					$dt='';
					$style="fir-col1-green";
					$inplay_game=" <span style='color: green;font-weight: bold;'>In-Play</span>";
				}
				else
				{
					$match_date='';
					if (Carbon::parse($match_detail['match_date'])->isToday())
						$match_date = date('H:i A',strtotime($match_detail['match_date']));
					else if (Carbon::parse($match_detail['match_date'])->isTomorrow())
						$match_date ='Tomorrow '.date('H:i A',strtotime($match_detail['match_date']));
					else
						$match_date =$match_detail['match_date'];
								
					$dt=$match_date;
					$style="fir-col1";
					$inplay_game='';
				}
			}
			else
			{
				$match_date='';
				if (Carbon::parse($match_detail['match_date'])->isToday())
					$match_date = date('H:i A',strtotime($match_detail['match_date']));
				else if (Carbon::parse($match_detail['match_date'])->isTomorrow())
					$match_date ='Tomorrow '.date('H:i A',strtotime($match_detail['match_date']));
				else
					$match_date =$match_detail['match_date'];
								
				$dt=$match_date;
				$style="fir-col1";
				$inplay_game='';
			}
			$fancy='';
			if($match_detail['fancy']==1 && $inplay_game!='')
				$fancy='<span style="color:green" class="game-fancy in-play blue-bg-3 text-color-white">Fancy</span>';
			elseif($match_detail['fancy']==1 && $inplay_game=='')
				$fancy='<span style="color:green" class="game-fancy blue-bg-3 text-color-white">Fancy</span>';
			if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
			{
				
					$html.='
					<div class="secondblock-cricket white-bg">
						<span class="'.$style.'"  >
							<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								
							<div>'.$dt.'</div>'.$fancy.'			
						</span>
						<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
				
			}
			else
			{
				$html.='
				<div class="secondblock-cricket white-bg">
					<span class="'.$style.'"  >
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								
						<div>'.$dt.'</div>'.$fancy.'			
					</span>
					<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
					</span>';
			}
			if(isset($match_data[$j]['runners'][2]))
			{
				if(@$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price']!='' && @$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price']!='')
				{
				$html.='<span class="fir-col2">
				<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
				<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
				</span>';
				}
				else
				{
					$html.='<span class="fir-col2">
					<a class="backbtn lightblue-bg2">--</a>
					<a class="laybtn lightpink-bg1">--</a>
				</span>';
				}
			}
			else
			{
				$html.='<span class="fir-col2">
					<a class="backbtn lightblue-bg2">--</a>
					<a class="laybtn lightpink-bg1">--</a>
				</span>';
			}
			if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
			{
				if(@$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']!='' && @$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']!="")
				{
					$html.='<span class="fir-col2">
					<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
					<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
					</span></div>';
				}
				else
				{
					$html.='<span class="fir-col2">
					<a class="backbtn lightblue-bg2">--</a>
					<a class="laybtn lightpink-bg1">--</a>
					</span></div>';
				}
			}
			else
			{
				$html.='<span class="fir-col2">
				<a class="backbtn lightblue-bg2">--</a>
				<a class="laybtn lightpink-bg1">--</a>
				</span></div>';
			}
		}
		$cricket_final_html.=$html;
		$final_html.=$cricket.$cricket_final_html.'</div>';
				
		//for tennis
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_tenis;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
				
		$match_data = json_decode($return, true);
		$tennis='<div class="programe-setcricket">
				<div class="firstblock-cricket lightblue-bg1">
				<span class="fir-col1"></span>
                <span class="fir-col2">1</span>
                <span class="fir-col2">X</span>
                <span class="fir-col2">2</span>
                <span class="fir-col3"></span>
                </div>';
				for($j=0;$j<sizeof($match_data);$j++)
				{
					$html='';
					$match_detail = Match::where('match_id',@$match_data[$j]['marketId'])->where('status',1)->first();
						
					if(isset($match_data[$j]['inplay'])==1)
					{
						$dt='';
						$style="fir-col1-green";
						$inplay_game=" <span style='color: green;font-weight: bold;'>In-Play</span>";
					}
					else
					{
						$match_date='';
						if (Carbon::parse($match_detail['match_date'])->isToday())
							$match_date = date('H:i A',strtotime($match_detail['match_date']));
						else if (Carbon::parse($match_detail['match_date'])->isTomorrow())
							$match_date ='Tomorrow '.date('H:i A',strtotime($match_detail['match_date']));
						else
							$match_date =$match_detail['match_date'];
								
						$dt=$match_date;
						$style="fir-col1";
						$inplay_game='';
					}
					if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']))
					{
						$html.='
						<div class="secondblock-cricket white-bg">
						<span class="'.$style.'"  >
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a><div>'.$dt.'</div></span>
						<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='
						<div class="secondblock-cricket white-bg">
						<span class="'.$style.'"  >
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a><div>'.$dt.'</div></span>
						<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$j]['runners'][2]))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
						</span></div>';
						$tennis_final_html.=$html;
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span></div>';
						$tennis_final_html.=$html;
					}
				}
				$final_html.="~~".$tennis.$tennis_final_html.'</div>';
				
				//for soccer
				$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_soccer;
				$headers = array('Content-Type: application/json');
				$process = curl_init();
				curl_setopt($process, CURLOPT_URL, $url);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($process, CURLOPT_TIMEOUT, 30);
				curl_setopt($process, CURLOPT_HTTPGET, 1);
				curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
				$return = curl_exec($process);
				curl_close($process);
				
				$match_data = json_decode($return, true);
				$soccer='<div class="programe-setcricket">
				<div class="firstblock-cricket lightblue-bg1">
				<span class="fir-col1"></span>
                <span class="fir-col2">1</span>
                <span class="fir-col2">X</span>
                <span class="fir-col2">2</span>
                <span class="fir-col3"></span>
                </div>';
				for($k=0;$k<sizeof($match_data);$k++)
				{
					$html='';
					$match_detail = Match::where('match_id',@$match_data[$k]['marketId'])->where('status',1)->first();
					
					if($match_data[$k]['inplay']==1)
					{
						$dt='';
						$style="fir-col1-green";
						$inplay_game=" <span style='color: green;font-weight: bold;'>In-Play</span>";
					}
					else
					{
						$match_date='';
						if (Carbon::parse($match_detail['match_date'])->isToday())
							$match_date = date('H:i A',strtotime($match_detail['match_date']));
						else if (Carbon::parse($match_detail['match_date'])->isTomorrow())
							$match_date ='Tomorrow '.date('H:i A',strtotime($match_detail['match_date']));
						else
							$match_date =$match_detail['match_date'];
								
						$dt=$match_date;
						$style="fir-col1";
						$inplay_game='';
					}
					if(isset($match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price']))
					{
						$html.='
						<div class="secondblock-cricket white-bg">
							<span class="'.$style.'"  >
							<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>		 </span>
						<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$k]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='
						<div class="secondblock-cricket white-bg">
							<span class="'.$style.'"  >
							<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>		 </span>
						<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$k]['runners'][2]['ex']['availableToBack'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$k]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$k]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$k]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$k]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
						</span></div>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span></div>';
					}
						
					$soccer_final_html.=$html;
				}
				$final_html.="~~".$soccer.$soccer_final_html.'</div>';
	  
	  return $final_html;
  	}
	public function getmatchdetails_NEW()
	{
		$sports = Sport::all();

		$html=''; $i=0;
	  	foreach($sports as $sport)
	 	{
			$html.='<div class="programe-setcricket">
					<div class="firstblock-cricket lightblue-bg1">
						<span class="fir-col1"></span>
						<span class="fir-col2">1</span>
						<span class="fir-col2">X</span>
						<span class="fir-col2">2</span>
						<span class="fir-col3"></span>
					</div>';
		  	$match_array_data_cricket[]=array();
			$match_array_data_tenis[]=array();
			$match_array_data_soccer[]=array();
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			
			foreach($match_link as $match)
			{
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
					{	
						//echo $match->match_id;
						$match_array_data_cricket[]=$match->match_id;
					}
					else if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
					else if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
					
				}
			}
			
		}
		
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
		$imp_match_array_data_tenis=@implode(",",$match_array_data_tenis);
		$imp_match_array_data_soccer=@implode(",",$match_array_data_soccer);	
		$mdata=array(); $inplay=0;
		//$restapi=new RestApi();
		//$match_data=app('App\Http\Controllers\RestApi')->GetMatchOdds($match->match_id);
		//$match_data=app('App\Http\Controllers\RestApi')->GetMatchOdds($imp_match_array_data_cricket);
		
		$imp_match_array_data_cricket;
		$url="http://3.7.102.54/listMarketBookBetfair/".$imp_match_array_data_cricket;

		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;

		$return_array = json_decode($return, true);
		print_r($return_array);
		
		//$data=json_decode($match_data,true);
		//print_r($data);
  	}
	public function matchCallForFancyNBM($matchId, Request $request)
	{
		$matchtype=$request->matchtype;
		$match_id=$request->match_id;			
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 

		$min_bet_odds_limit=@$matchList->min_bookmaker_limit;
		$max_bet_odds_limit =@$matchList->max_bookmaker_limit;
		
		$min_bet_fancy_limit=@$matchList->min_fancy_limit;
		$max_bet_fancy_limit =@$matchList->max_fancy_limit;

		$matchtype=$sport->id;
		$eventId=$request->event_id;
		$matchname=$request->matchname;
		$match_b=@$matchList->suspend_b;
        $match_f=@$matchList->suspend_f;
		$html=''; $html_bm_team="";
		
		@$team_name=explode(" v ",strtolower($matchname));
		$team1_name=@$team_name[0];
		if(@$team_name[1])
			@$team2_name=$team_name[1];
		else
			$team2_name='';
		
		
		$match_detail = Match::where('event_id',$request->event_id)->where('status',1)->first();
		
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($eventId,$matchId,$matchtype);
		
		$team2_bet_total=0;
		$team1_bet_total=0;
		$team_draw_bet_total=0;
		
		//for bm
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('bet_type','BOOKMAKER')->get();
			//dd(DB::getQueryLog());
			
			if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{	
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		}
		
		$html_two=''; $html_two_team="";
		$back='';
		$login_check='';
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
			 $login_check='onclick="opnForm(this);"';
		}
		else
		{
			$login_check='data-toggle="modal" data-target="#myLoginModal"';
		}
		
		if(!empty($match_data) && $match_data!=0)
		{
			
			//for bookmaker			
			$html_bm_team.='
			<tr>
                <td class="text-color-grey fancybet-block" colspan="7">
                    <div class="dark-blue-bg-1 text-color-white">
                        <a> <img src="'.asset('asset/front/img/pin-bg.png').'"> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                        Bookmaker Market <span class="zeroopa">| Zero Commission</span>
                    </div>
                    <div class="fancy_info text-color-white">
                        <span class="light-grey-bg-5 text-color-blue-1">Min</span> <span id="div_min_bet_bm_limit">'.$match_detail['min_bookmaker_limit'].'</span>
                        <span class="light-grey-bg-5 text-color-blue-1">Max</span> <span id="div_max_bet_bm_limit">'.$match_detail['max_bookmaker_limit'].'</span>
                    </div>
                </td>
            </tr>

			<tr class="bets-fancy white-bg">
				<td colspan="3" style="width:170px"></td>
				<td class="text-right">Back</td>
				<td class="text-left">Lay</td>
				<td colspan="2"></td>
			</tr>';
			//print_r($match_data['bm']);
			
			$team_name_array=array();
			$team_name_array[]=@$match_data['bm'][0]['nation'];
			$team_name_array[]=@$match_data['bm'][1]['nation'];
			$team_name_array[]=@$match_data['bm'][2]['nation'];
			
			
			$team1_name= $arry_position=array_search(ucwords($team1_name),$team_name_array);
			$team2_name= $arry_position=array_search(ucwords($team2_name),$team_name_array);
			$team3_name=0;
			if($team1_name==0 && $team2_name==1)
				$team3_name=2;
			else if($team1_name==1 && $team2_name==0)
				$team3_name=2;
			else if($team1_name==2 && $team2_name==1)
				$team3_name=0;
			else if($team1_name==1 && $team2_name==2)
				$team3_name=0;
			else if($team1_name==0 && $team2_name==2)
				$team3_name=1;
			else if($team1_name==2 && $team2_name==0)
				$team3_name=1;
			
			$team1=$team2=$team3='';
			if($team1_name!='' || $team2_name!='')
			{
					if($match_b=='0'){
						$team1.='<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3']).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>~';
						$team1.='<div class="back-gradient text-color-black">										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>~';
						$team1.='<div class="back-gradient text-color-black">
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>~';
						$team1.='<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
									</div>~';
						$team1.='<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>~';
						$team1.='<div class="lay-gradient text-color-black		
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>';
						$team1.='***tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
							</td>
						</tr>';
						
						$team2='<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>~';
						$team2='<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
										
									</div>~';
						$team2='<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>~';
						$team2='<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>~';
						$team2='<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>~';
						$team2='<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>';
						$team2='***<tr class="fancy-suspend-tr">
								<td></td>
								<td class="fancy-suspend-td" colspan="6">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
							</tr>';
					}
					else{
					
						if(isset($match_data['bm'][$team1_name]['status']) && $match_data['bm'][$team1_name]['status']!='SUSPENDED')
						{
							$display=''; $cls='';
							if($team1_bet_total=='')
								$display='style="display:none"';
							if($team1_bet_total!='' && $team1_bet_total>=0)
							{
								$cls='text-color-green';
							}
							else if($team1_bet_total!='' && $team1_bet_total<0)
							{
								$cls='text-color-red';
							}					
							$team1.='<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
										
									</div>~';
							$team1.='<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>~';
							$team1.='<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>~';
							$team1.='<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>~';
							$team1.='<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
									</div>~';
							$team1.='<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>';
							
				}
				else
				{
					$display=''; $cls='';
					if($team1_bet_total=='')
						$display='style="display:none"';
					if($team1_bet_total!='' && $team1_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team1_bet_total!='' && $team1_bet_total<0)
					{
						$cls='text-color-red';
					}
					
					$team1.='<div class="back-gradient text-color-black">
								<div id="back_3" class="light-blue-bg-2">
									<a>  </a>
								</div>
							</div>~';
					$team1.='<div class="back-gradient text-color-black">
								
								<div id="back_2" class="light-blue-bg-3">
									<a>  </a>
								</div>
							</div>~';
					$team1.='<div class="back-gradient text-color-black">
							<div id="back_1"><a class="cyan-bg">  </a></div>
							</div>~';
					$team1.='<div class="lay-gradient text-color-black">
								<div id="lay_1"><a class="pink-bg">  </a></div>
								
							</div>~';
					$team1.='<div class="lay-gradient text-color-black">
								
								<div id="lay_2" class="light-pink-bg-2">
									<a>  </a>
								</div>
							</div>~';
					$team1.='<div class="lay-gradient text-color-black">
								
								<div id="lay_3" class="light-pink-bg-3">
									<a>  </a>
								</div>
							</div>';
					
							
				}
				if(isset($match_data['bm'][$team2_name]['status']) && @$match_data['bm'][$team2_name]['status']!='SUSPENDED')
				{
					$display=''; $cls='';
					if($team2_bet_total=='')
						$display='style="display:none"';
					if($team2_bet_total!='' && $team2_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team2_bet_total!='' && $team2_bet_total<0)
					{
						$cls='text-color-red';
					}
					
							
							$team2.='<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b3'],2).'">'.round(@$match_data['bm'][$team2_name]['b3'],2).'</a>
										</div>
									</div>~';
							$team2.='<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b2'],2).'">'.round(@$match_data['bm'][$team2_name]['b2'],2).'</a>
										</div>
									</div>~';
							$team2.='<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b1'],2).'">'.round(@$match_data['bm'][$team2_name]['b1'],2).'</a>
										</div>
									</div>~';
							$team2.='<div class="lay-gradient text-color-black">
										<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l1'],2).'">'.round(@$match_data['bm'][$team2_name]['l1'],2).'</a></div>
									</div>~';
							$team2.='<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l2'],2).'">'.round(@$match_data['bm'][$team2_name]['l2'],2).'</a>
										</div>
									</div>~';
							$team2.='<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l3'],2).'">'.round(@$match_data['bm'][$team2_name]['l3'],2).'</a>
										</div>
									</div>';
				}
				else
				{
					$display=''; $cls='';
					if($team2_bet_total=='')
						$display='style="display:none"';
					if($team2_bet_total!='' && $team2_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team2_bet_total!='' && $team2_bet_total<0)
					{
						$cls='text-color-red';
					}
					
					$team2.='<div class="back-gradient text-color-black">
								<div id="back_3" class="light-blue-bg-2">
									<a> </a>
								</div>
							</div>~';
					$team2.='<div class="back-gradient text-color-black">
								
								<div id="back_2" class="light-blue-bg-3">
									<a> </a>
								</div>
							</div>~';
					$team2.='<div class="back-gradient text-color-black">
								
								<div id="back_1"><a class="cyan-bg"> </a></div>
							</div>~';
					$team2.='<div class="lay-gradient text-color-black">
								<div id="lay_1"><a class="pink-bg"> </a></div>
								
				            </div>~';
					$team2.='<div class="lay-gradient text-color-black">
								<div id="lay_2" class="light-pink-bg-2">
										<a> </a>
								</div>
				            </div>~';
					$team2.='<div class="lay-gradient text-color-black">
								
								<div id="lay_3" class="light-pink-bg-3">
										<a> </a>
								</div>
				            </div>';
							
				}
				if(isset($match_data['bm'][2]['status']))
				{
					if(@$match_data['bm'][2]['status']!='SUSPENDED')
					{
						$display=''; $cls='';
						if($team_draw_bet_total=='')
						{
							$display='style="display:none"';
						}
						if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
						{
							$cls='text-color-red';
						}
							$team3.='<div class="back-gradient text-color-black">
											<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b3'],2).'">'.round(@$match_data['bm'][$team3_name]['b3'],2).'</a>
											</div>
									</div>~';
							$team3.='<div class="back-gradient text-color-black">
											
											<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b2'],2).'">'.round(@$match_data['bm'][$team3_name]['b2'],2).'</a>
											</div>
											
										</div>~';
							$team3.='<div class="back-gradient text-color-black">
											
											<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b1'],2).'">'.round(@$match_data['bm'][$team3_name]['b1'],2).'</a>
											</div>
										</div>~';
							$team3.='<div class="lay-gradient text-color-black">
											<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l1'],2).'">'.round(@$match_data['bm'][$team3_name]['l1'],2).'</a>
											</div>
										</div>~';
							$team3.='<div class="lay-gradient text-color-black">
											
											<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l2'],2).'">'.round(@$match_data['bm'][$team3_name]['l2'],2).'</a>
											</div>
										</div>~';
							$team3.='<div class="lay-gradient text-color-black">
											
											<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l3'],2).'">'.round(@$match_data['bm'][$team3_name]['l3'],2).'</a>
											</div>
										</div>';
					}
					else
					{
						$display=''; $cls='';
						if($team_draw_bet_total=='')
						{
							$display='style="display:none"';
						}
						if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
						{
							$cls='text-color-red';
						}
						
						$team3.='<div class="back-gradient text-color-black">
									<div id="back_3" class="light-blue-bg-2">
										<a>  </a>
									</div>
								</div>~';
						$team3.='<div class="back-gradient text-color-black">
									
									<div id="back_2" class="light-blue-bg-3">
										<a>  </a>
									</div>
								</div>~';
						$team3.='<div class="back-gradient text-color-black">
									
									<div id="back_1"><a class="cyan-bg">  </a></div>
								</div>~';
						$team3.='<div class="lay-gradient text-color-black">
									<div id="lay_1"><a class="pink-bg">  </a></div>
								</div>~';
						$team3.='<div class="lay-gradient text-color-black">
									<div id="lay_2" class="light-pink-bg-2">
										<a>  </a>
									</div>
								</div>~';
						$team3.='<div class="lay-gradient text-color-black">
									
									<div id="lay_3" class="light-pink-bg-3">
										<a>  </a>
									</div>
								</div>';
								
					}
				}
			 } // end suspended if
			}
			if($team1!='' || $team2!='' || $team3!='')
			{	
				//$html=$html_bm_team.$html;
				$html=$team1.'==='.$team2.'==='.$team3;
			}
			
			
			//for fancy
			$back=''; $lay='';
			$login_check='';
			$sessionData = Session::get('playerUser');
			if(!empty($sessionData))
			{
				if($min_bet_fancy_limit>0 && $min_bet_fancy_limit!="" && $max_bet_fancy_limit>0 && $max_bet_fancy_limit!="")
				 $login_check='onclick="opnForm(this);"';
			}
			else
			{
				$login_check='data-toggle="modal" data-target="#myLoginModal"';
			}
			$html_two_team.='
				<tr>
                	<td class="text-color-grey fancybet-block" colspan="7">
                    	<div class="dark-blue-bg-1 text-color-white">
                        	<a> <img src="'.asset('asset/front/img/pin-bg.png').' "> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                            Fancy Bet <span id="div_min_bet_fancy_limit" style="display:none">'.$min_bet_fancy_limit.'</span> <span id="div_max_bet_fancy_limit" style="display:none">'.$max_bet_fancy_limit.'</span>
                       	</div>
                  	</td>
              	</tr>
				<tr class="bets-fancy white-bg">
                	<td colspan="3"></td>
                    <td>No</td>
                    <td>Yes</td>
                    <td colspan="1"></td>
               	</tr>
			';
			$nat=array(); $gstatus=array(); $b=array(); $l=array(); $bs=array(); $ls=array(); $min=array(); $max=array(); $sid=array();
			if(@$match_data['fancy'])
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
				sort($sid);
				//print_r($sid);
				$fancy_row=$request->fancy_row;
				for($i=0;$i<sizeof($sid);$i++)
				{
					$max_val=0;
					if($max[$sid[$i]]>999)
					{
						$input = number_format($max[$sid[$i]]);
						$input_count = substr_count($input, ',');
						$arr = array(1=>'K','M','B','T');
						if(isset($arr[(int)$input_count]))      
						   $max_val= substr($input,0,(-1*$input_count)*4).$arr[(int)$input_count];
						else
							$max_val= $input;
					}
					
					if($match_f=='0'){
						$sessionData = Session::get('playerUser');
						if(!empty($sessionData))
							{
								//$userId = Auth::user()->id;
								$getUser = Session::get('playerUser');
								$userId =$getUser->id;
								//DB::enableQueryLog();
								$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
								//dd(DB::getQueryLog());
								$abc=sizeof($my_placed_bets);
								if(sizeof($my_placed_bets)>0)
								{
									$run_arr=array();
									foreach($my_placed_bets as $bet)
									{
										$down_position=$bet->bet_odds-1;
										if(!in_array($down_position,$run_arr))
										{
											$run_arr[]=$down_position;
										}
										$level_position=$bet->bet_odds;
										if(!in_array($level_position,$run_arr))
										{
											$run_arr[]=$level_position;
										}
										$up_position=$bet->bet_odds+1;
										if(!in_array($up_position,$run_arr))
										{
											$run_arr[]=$up_position;
										}
									}
									array_unique($run_arr);
									sort($run_arr);
									$bet_chk=''; 
									for($kk=0;$kk<sizeof($run_arr);$kk++)
									{
										$bet_deduct_amt=0; $placed_bet_type='';
										foreach($my_placed_bets as $bet)
										{
											if($bet->bet_side=='back')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
													
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_profit;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
											}
											else if($bet->bet_side=='lay')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
												}
											}
										}
										if($final_exposer=="")
											$final_exposer=$bet_deduct_amt;
										else
										{
											if($final_exposer>$bet_deduct_amt)
												$final_exposer=$bet_deduct_amt;
										}
										
										if($bet_deduct_amt>0) {
											$position.='<tr> 
											<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
											<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
											</tr>';
										}
										else
										{
											$position.='<tr> 
											<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
											<td class="text-right pink-bg">'.$bet_deduct_amt.'</td>
											</tr>';
										}
									}
									if($position!='')
									{
										$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
											<div class="modal-dialog">
												<div class="modal-content light-grey-bg-1">
													<div class="modal-header">
														<h4 class="modal-title text-color-blue-1">Run Position</h4>
														<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
													</div>
													<div class="modal-body white-bg p-3">
														<table class="table table-bordered w-100 fonts-1 mb-0">
															<thead>
																<tr>
																	<th width="50%" class="text-center">Run</th>
																	<th width="50%" class="text-right">Amount</th>
																</tr>
															</thead>
															<tbody> '.$position.'</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>';
									}
								}
							}
							
							$display=''; $cls='';
							if($bet_model=='')
							{
								$display='style="display:block"';
							}
							if($bet_model!='')
							{
								$cls='text-color-red';
							}
							//end for bet calculation
						
						
						 if($i>$fancy_row)
						 {
							
								$back.='<tr class="fancy-suspend-tr">
								<td colspan="3"></td>
								<td class="fancy-suspend-td" colspan="2">
									<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
								</tr>
								<tr class="white-bg tr_fancy_'.$i.'">
										<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
											<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
												<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
											</a>
											'.$bet_model.'
											</div>
										</td>
										<td class="pink-bg back1btn text-center FancyLay td_fancy_lay_'.$i.'" >
											<a><br> <span>--</span></a></td>
										<td class="lay1btn cyan-bg text-center FancyBack td_fancy_back_'.$i.'">
											<a>--<br> <span>--</span></a>
										</td>
										<td class="zeroopa1" colspan="1"> <span></span>'.'----'.$fancy_row.'<br></td>
									</tr>==';
						 }
						 else
						 {
							$back.='<a><br> <span>--</span></a>~<a>--<br> <span>--</span></a>==';
						 }
					}
					else{
						$placed_bet=''; $position=''; $bet_model=''; $abc=''; $final_exposer='';
						if($gstatus[$sid[$i]]!='Ball Running' &&  $gstatus[$sid[$i]]!='Suspended' && $l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0)
						{
							if($l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0 && $l[$sid[$i]]!='' && $b[$sid[$i]]!='' )
							{
								//bet calculation
								
								$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->>bet_profit;;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->>bet_profit;;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								if($i>$fancy_row)
						 		{
									
									$back.='<tr class="white-bg">
									<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
										<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
										
									</td>
									<td class="pink-bg back1btn text-center FancyLay" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="pink-bg" data-volume="'.round($ls[$sid[$i]]).'" data-val="'.round($l[$sid[$i]]).'">'.round($l[$sid[$i]]).'<br> <span>'.round($ls[$sid[$i]]).'</span></a></td>
									<td class="lay1btn cyan-bg text-center FancyBack" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="cyan-bg" data-volume="'.round($bs[$sid[$i]]).'" data-val="'.round($b[$sid[$i]]).'">'.round($b[$sid[$i]]).'<br> <span>'.round($bs[$sid[$i]]).'</span></a>
									</td>
									<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].'----'.$fancy_row.'</td>
									</tr>==';
								}
								else
								{
								$back.='<a '.$login_check.' data-cls="pink-bg" data-volume="'.round($ls[$sid[$i]]).'" data-val="'.round($l[$sid[$i]]).'">'.round($l[$sid[$i]]).'<br> <span>'.round($ls[$sid[$i]]).'</span></a>~<a '.$login_check.' data-cls="cyan-bg" data-volume="'.round($bs[$sid[$i]]).'" data-val="'.round($b[$sid[$i]]).'">'.round($b[$sid[$i]]).'<br> <span>'.round($bs[$sid[$i]]).'</span></a>==';
								}
							}
							else
							{
								//for bet calculation
								$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								if($i>$fancy_row)
						 		{
									
									$back.='<tr class="fancy-suspend-tr-1">
									<td colspan="3"></td>
									<td class="fancy-suspend-td-1" colspan="2">
										<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>SUSPENDED</span></div>
									</td>
									</tr>
									<tr class="white-bg">
										<td colspan="3"><b>'.$nat[$sid[$i]].' </b></td>
										<td class="pink-bg  back1btn text-center1111"><a> <br> <span> </span></a></td>
										<td class="cyan-bg lay1btn  text-center"><a> <br> <span> </span></a></td>
										<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].'----'.$fancy_row.' </td>
									</tr>==';
								}
								else
								{
									$back.='<a> <br> <span> </span></a>~<a> <br> <span> </span></a>==';
									
								}
							}
						}
						else
						{
							//for bet calculation
							$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								if($i>$fancy_row)
						 		{
										
										$back.='<tr class="fancy-suspend-tr-1">
											<td colspan="3"></td>
											<td class="fancy-suspend-td-1" colspan="2">
												<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>'.$gstatus[$sid[$i]].'</span></div>
											</td>
										</tr>
										<tr class="white-bg">
											<td colspan="3"><b>'.$nat[$sid[$i]].' </b>
												<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
														<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
													</a>
													'.$bet_model.'
													</div>
											</td>
											<td class="pink-bg  back1btn text-center"><a> <br> <span> </span></a></td>
											<td class="cyan-bg lay1btn  text-center"><a> <br> <span> </span></a></td>
											<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$matchList['min_fancy_limit'].' / '.$matchList['max_fancy_limit'].'----'.$fancy_row.' </td>
										</tr>==';
								}
								else
								{
									$back.='<a> <br> <span> </span></a>~<a> <br> <span> </span></a>==';
								}
						}
					} // end suspended if
				}
				if($back=='')
				{
					$back='';
				}
					//$back=$html_two_team.$back;
			}
		}
		
		//print_r($match_data);
		if($html=='')
			$html='';
		echo $html.'####'.$back;
	
	}
	public function matchCallFor_FANCY($matchId, Request $request)
	{
		$matchtype=$request->matchtype;
		$match_id=$request->match_id;			
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 

		$min_bet_odds_limit=$matchList->min_bookmaker_limit;
		$max_bet_odds_limit =$matchList->max_bookmaker_limit;
		
		$min_bet_fancy_limit=$matchList->min_fancy_limit;
		$max_bet_fancy_limit =$matchList->max_fancy_limit;

		$matchtype=$sport->id;
		$eventId=$request->event_id;
		$matchname=$request->matchname;
		$match_b=$matchList->suspend_b;
        $match_f=$matchList->suspend_f;
		$html=''; $html_bm_team="";
		
		@$team_name=explode(" v ",strtolower($matchname));
		$team1_name=@$team_name[0];
		if(@$team_name[1])
			@$team2_name=$team_name[1];
		else
			$team2_name='';
		
		$html_two_team=''; $html_two='';
		$match_detail = Match::where('event_id',$request->event_id)->where('status',1)->first();
		
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($eventId,$matchId,$matchtype);
		
		$team2_bet_total=0;
		$team1_bet_total=0;
		$team_draw_bet_total=0;
		//for fancy
		$login_check='';
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			if($min_bet_fancy_limit>0 && $min_bet_fancy_limit!="" && $max_bet_fancy_limit>0 && $max_bet_fancy_limit!="")
			 $login_check='onclick="opnForm(this);"';
		}
		else
		{
			$login_check='data-toggle="modal" data-target="#myLoginModal"';
		}
		$html_two_team.='
			<tr>
                	<td class="text-color-grey fancybet-block" colspan="7">
                    	<div class="dark-blue-bg-1 text-color-white">
                        	<a> <img src="'.asset('asset/front/img/pin-bg.png').' "> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                            Fancy Bet <span id="div_min_bet_fancy_limit" style="display:none">'.$min_bet_fancy_limit.'</span> <span id="div_max_bet_fancy_limit" style="display:none">'.$max_bet_fancy_limit.'</span>
                       	</div>
                  	</td>
              	</tr>
				<tr class="bets-fancy white-bg">
                	<td colspan="3"></td>
                    <td>No</td>
                    <td>Yes</td>
                    <td colspan="1"></td>
               	</tr>
			';
			$nat=array(); $gstatus=array(); $b=array(); $l=array(); $bs=array(); $ls=array(); $min=array(); $max=array(); $sid=array();
			if(@$match_data['fancy'])
			{
				//echo 'hello';
				//print_r($match_data['fancy']);
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
				
				sort($sid);
				//print_r($sid);
				for($i=0;$i<sizeof($sid);$i++)
				{
					$max_val=0;
					if($max[$sid[$i]]>999)
					{
						$input = number_format($max[$sid[$i]]);
						$input_count = substr_count($input, ',');
						$arr = array(1=>'K','M','B','T');
						if(isset($arr[(int)$input_count]))      
						   $max_val= substr($input,0,(-1*$input_count)*4).$arr[(int)$input_count];
						else
							$max_val= $input;
					}
					
					if($match_f=='0'){
						
						$sessionData = Session::get('playerUser');
							if(!empty($sessionData))
							{
								//$userId = Auth::user()->id;
								$getUser = Session::get('playerUser');
								$userId =$getUser->id;
								//DB::enableQueryLog();
								$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
								//dd(DB::getQueryLog());
								$abc=sizeof($my_placed_bets);
								if(sizeof($my_placed_bets)>0)
								{
									$run_arr=array();
									foreach($my_placed_bets as $bet)
									{
										$down_position=$bet->bet_odds-1;
										if(!in_array($down_position,$run_arr))
										{
											$run_arr[]=$down_position;
										}
										$level_position=$bet->bet_odds;
										if(!in_array($level_position,$run_arr))
										{
											$run_arr[]=$level_position;
										}
										$up_position=$bet->bet_odds+1;
										if(!in_array($up_position,$run_arr))
										{
											$run_arr[]=$up_position;
										}
									}
									array_unique($run_arr);
									sort($run_arr);
									$bet_chk=''; 
									for($kk=0;$kk<sizeof($run_arr);$kk++)
									{
										$bet_deduct_amt=0; $placed_bet_type='';
										foreach($my_placed_bets as $bet)
										{
											if($bet->bet_side=='back')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
													$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
													$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
												}
											}
											else if($bet->bet_side=='lay')
											{
												if($bet->bet_odds==$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
												}
												else if($bet->bet_odds<$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
													$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
												}
												else if($bet->bet_odds>$run_arr[$kk])
												{
													//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
													$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
												}
											}
										}
										if($final_exposer=="")
											$final_exposer=$bet_deduct_amt;
										else
										{
											if($final_exposer>$bet_deduct_amt)
												$final_exposer=$bet_deduct_amt;
										}
										
										if($bet_deduct_amt>0) {
											$position.='<tr> 
											<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
											<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
											</tr>';
										}
										else
										{
											$position.='<tr> 
											<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
											<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
											</tr>';
										}
									}
									if($position!='')
									{
										$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
											<div class="modal-dialog">
												<div class="modal-content light-grey-bg-1">
													<div class="modal-header">
														<h4 class="modal-title text-color-blue-1">Run Position</h4>
														<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
													</div>
													<div class="modal-body white-bg p-3">
														<table class="table table-bordered w-100 fonts-1 mb-0">
															<thead>
																<tr>
																	<th width="50%" class="text-center">Run</th>
																	<th width="50%" class="text-right">Amount</th>
																</tr>
															</thead>
															<tbody> '.$position.'</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>';
									}
								}
							}
							
							$display=''; $cls='';
							if($bet_model=='')
							{
								$display='style="display:block"';
							}
							if($bet_model!='')
							{
								$cls='text-color-red';
							}
							//end for bet calculation
						
						$html_two.='
						<tr class="fancy-suspend-tr">
						<td colspan="3"></td>
						<td class="fancy-suspend-td" colspan="2">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
						</tr>
						<tr class="white-bg tr_fancy_'.$i.'">
								<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
									<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
										<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
									</a>
									'.$bet_model.'
									</div>
								</td>
								<td class="pink-bg back1btn text-center FancyLay td_fancy_lay_'.$i.'" >
									<a><br> <span>--</span></a></td>
								<td class="lay1btn cyan-bg text-center FancyBack td_fancy_back_'.$i.'">
									<a>--<br> <span>--</span></a>
								</td>
								<td class="zeroopa1" colspan="1"> <span></span> <br></td>
							</tr>';
					}
					else{
					$placed_bet=''; $position=''; $bet_model=''; $abc=''; $final_exposer='';
						if($gstatus[$sid[$i]]!='Ball Running' &&  $gstatus[$sid[$i]]!='Suspended' && $l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0)
						{
							if($l[$sid[$i]]!=0 && round($b[$sid[$i]])!=0 && $l[$sid[$i]]!='' && $b[$sid[$i]]!='' )
							{
								//bet calculation
								
								$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								
								$html_two.='<tr class="white-bg tr_fancy_'.$i.'">
									<td colspan="3"><b>'.$nat[$sid[$i]].'</b>
										<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
										
									</td>
									<td class="pink-bg back1btn text-center FancyLay td_fancy_lay_'.$i.'" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="pink-bg" data-volume="'.round($ls[$sid[$i]]).'" data-val="'.round($l[$sid[$i]]).'">'.round($l[$sid[$i]]).'<br> <span>'.round($ls[$sid[$i]]).'</span></a></td>
									<td class="lay1btn cyan-bg text-center FancyBack td_fancy_back_'.$i.'" data-team="'.$nat[$sid[$i]].'">
										<a '.$login_check.' data-cls="cyan-bg" data-volume="'.round($bs[$sid[$i]]).'" data-val="'.round($b[$sid[$i]]).'">'.round($b[$sid[$i]]).'<br> <span>'.round($bs[$sid[$i]]).'</span></a>
									</td>
									<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].'</td>
								</tr>';
							}
							else
							{
								//for bet calculation
								$sessionData = Session::get('playerUser');
	if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
								$html_two.='<tr class="fancy-suspend-tr-1 ">
								<td colspan="3"></td>
								<td class="fancy-suspend-td-1" colspan="2">
									<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>SUSPENDED</span></div>
								</td>
								</tr>
								<tr class="white-bg tr_fancy_'.$i.'">
									<td colspan="3"><b>'.$nat[$sid[$i]].' </b></td>
									<td class="pink-bg  back1btn text-center1111 td_fancy_lay_'.$i.'"><a> <br> <span> </span></a></td>
									<td class="cyan-bg lay1btn  text-center td_fancy_back_'.$i.'"><a> <br> <span> </span></a></td>
									<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$match_detail['min_fancy_limit'].' / '.$match_detail['max_fancy_limit'].' </td>
								</tr>
								';
							}
						}
						else
						{
							//for bet calculation
							$sessionData = Session::get('playerUser');
								if(!empty($sessionData))
								{
									//$userId = Auth::user()->id;
									$getUser = Session::get('playerUser');
									$userId =$getUser->id;
									//DB::enableQueryLog();
									$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('team_name',@$nat[$sid[$i]])->where('bet_type','SESSION')->orderBy('created_at', 'asc')->get();
									//dd(DB::getQueryLog());
									$abc=sizeof($my_placed_bets);
									if(sizeof($my_placed_bets)>0)
									{
										$run_arr=array();
										foreach($my_placed_bets as $bet)
										{
											$down_position=$bet->bet_odds-1;
											if(!in_array($down_position,$run_arr))
											{
												$run_arr[]=$down_position;
											}
											$level_position=$bet->bet_odds;
											if(!in_array($level_position,$run_arr))
											{
												$run_arr[]=$level_position;
											}
											$up_position=$bet->bet_odds+1;
											if(!in_array($up_position,$run_arr))
											{
												$run_arr[]=$up_position;
											}
										}
										array_unique($run_arr);
										sort($run_arr);
										$bet_chk=''; 
										for($kk=0;$kk<sizeof($run_arr);$kk++)
										{
											$bet_deduct_amt=0; $placed_bet_type='';
											foreach($my_placed_bets as $bet)
											{
												if($bet->bet_side=='back')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - equal -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;	
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
														
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - grater -> '.$bet_deduct_amt.'+'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt+$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Back - lessthan -> '.$bet_deduct_amt.'-'.$bet->bet_amount;	
														$bet_deduct_amt=$bet_deduct_amt-$bet->bet_amount;
													}
												}
												else if($bet->bet_side=='lay')
												{
													if($bet->bet_odds==$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--lay  - equal -> '.$bet_deduct_amt.'-'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;	
													}
													else if($bet->bet_odds<$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - greater -> '.$bet_deduct_amt.'-'.$bet->exposureAmt;
														$bet_deduct_amt=$bet_deduct_amt-$bet->exposureAmt;
													}
													else if($bet->bet_odds>$run_arr[$kk])
													{
														//$bet_chk=$kk.'=='.$bet->bet_odds.'--Lay  - less -> '.$bet_deduct_amt.'+'.$bet->bet_amount;
														$bet_deduct_amt=$bet_deduct_amt+$bet->bet_amount;
													}
												}
											}
											if($final_exposer=="")
												$final_exposer=$bet_deduct_amt;
											else
											{
												if($final_exposer>$bet_deduct_amt)
													$final_exposer=$bet_deduct_amt;
											}
											
											if($bet_deduct_amt>0) {
												$position.='<tr> 
												<td class="text-center cyan-bg">'.$run_arr[$kk].'</td>
												<td class="text-right cyan-bg">'.$bet_deduct_amt.'</td>
												</tr>';
											}
											else
											{
												$position.='<tr> 
												<td class="text-center pink-bg">'.$run_arr[$kk].'</td>
												<td class="text-right pink-bg">'.$bet_deduct_amt.'<br>'.$bet_chk.'</td>
												</tr>';
											}
										}
										if($position!='')
										{
											$bet_model='<div class="modal credit-modal" id="runPosition'.$i.'">
												<div class="modal-dialog">
													<div class="modal-content light-grey-bg-1">
														<div class="modal-header">
															<h4 class="modal-title text-color-blue-1">Run Position</h4>
															<button type="button" class="close" data-dismiss="modal"><img src="'.asset('asset/front/img/close-icon.png').'" alt=""></button>
														</div>
														<div class="modal-body white-bg p-3">
															<table class="table table-bordered w-100 fonts-1 mb-0">
																<thead>
																	<tr>
																		<th width="50%" class="text-center">Run'.$abc.'</th>
																		<th width="50%" class="text-right">Amount</th>
																	</tr>
																</thead>
																<tbody> '.$position.'</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>';
										}
									}
								}
								
								$display=''; $cls='';
								if($bet_model=='')
								{
									$display='style="display:block"';
								}
								if($bet_model!='')
								{
									$cls='text-color-red';
								}
								//end for bet calculation
							$html_two.='<tr class="fancy-suspend-tr-1">
								<td colspan="3"></td>
								<td class="fancy-suspend-td-1" colspan="2">
									<div class="fancy-suspend-1 black-bg-5 text-color-white"><span>'.$gstatus[$sid[$i]].'</span></div>
								</td>
							</tr>
							<tr class="white-bg tr_fancy_'.$i.'">
								<td colspan="3"><b>'.$nat[$sid[$i]].' </b>
									<div><a data-toggle="modal" data-target="#runPosition'.$i.'">
											<span class="lose '.$cls.'" '.$display.' id="Fancy_Total_Div"><span id="Fancy_Total_'.$i.'">'.$final_exposer.'</span></span>
										</a>
										'.$bet_model.'
										</div>
								</td>
								<td class="pink-bg  back1btn text-center td_fancy_lay_'.$i.'"><a> <br> <span> </span></a></td>
								<td class="cyan-bg lay1btn  text-center td_fancy_back_'.$i.'"><a> <br> <span> </span></a></td>
								<td class="zeroopa1" colspan="1"> <span>Min/Max</span> <br> '.$matchList['min_fancy_limit'].' / '.$matchList['max_fancy_limit'].' </td>
							</tr>
							';
						}
					} // end suspended if
				}
				if($html_two!='')
					$html_two=$html_two_team.$html_two.'<input type="hidden" name="hid_fancy" id="hid_fancy" value="'.$i.'">';
			}
		return $html_two;
	}
	public function matchCallFor_BM($matchId, Request $request)
	{
		
		$matchtype=$request->matchtype;
		$match_id=$request->match_id;			
		$sport = Sport::where('sId',$matchtype)->first();
		$matchList = Match::where('id',$match_id)->where('status',1)->first(); 

		$min_bet_odds_limit=$matchList->min_bookmaker_limit;
		$max_bet_odds_limit =$matchList->max_bookmaker_limit;
		
		$min_bet_fancy_limit=$matchList->min_fancy_limit;
		$max_bet_fancy_limit =$matchList->max_fancy_limit;

		$matchtype=$sport->id;
		$eventId=$request->event_id;
		$matchname=$request->matchname;
		$match_b=$matchList->suspend_b;
        $match_f=$matchList->suspend_f;
		$html=''; $html_bm_team="";
		
		@$team_name=explode(" v ",strtolower($matchname));
		$team1_name=@$team_name[0];
		if(@$team_name[1])
			@$team2_name=$team_name[1];
		else
			$team2_name='';
		
		
		$match_detail = Match::where('event_id',$request->event_id)->where('status',1)->first();
		
		$match_data=app('App\Http\Controllers\RestApi')->Fancy_and_Bookmaker_DetailCall($eventId,$matchId,$matchtype);
		
		$team2_bet_total=0;
		$team1_bet_total=0;
		$team_draw_bet_total=0;
		
		//for bm
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			//$userId = Auth::user()->id;
			$getUser = Session::get('playerUser');
			$userId =$getUser->id;
			//DB::enableQueryLog();
			$my_placed_bets = MyBets::where('user_id',$userId)->where('match_id',$eventId)->where('bet_type','BOOKMAKER')->get();
			//dd(DB::getQueryLog());
			
			if(sizeof($my_placed_bets)>0)
			{
				foreach($my_placed_bets as $bet)
				{
					$abc=json_decode($bet->extra,true);
					if(count($abc)>=2)
					{
						if (array_key_exists("teamname1",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on draw
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->bet_profit;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname2",$abc))
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{	
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
						else if (array_key_exists("teamname3",$abc) && array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total-$bet->exposureAmt;
								}
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								if(count($abc)>=2)
								{
									$team_draw_bet_total=$team_draw_bet_total+$bet->bet_amount;
								}
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
					}
					else if(count($abc)==1)
					{
						if (array_key_exists("teamname1",$abc))
						{
							//bet on team2
							if($bet->bet_side=='back')
							{
								$team2_bet_total=$team2_bet_total+$bet->bet_profit;
								$team1_bet_total=$team1_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team2_bet_total=$team2_bet_total-$bet->bet_profit;
								$team1_bet_total=$team1_bet_total+$bet->bet_amount;
							}
						}
						else
						{
							//bet on team1
							if($bet->bet_side=='back')
							{
								$team1_bet_total=$team1_bet_total+$bet->bet_profit;
								$team2_bet_total=$team2_bet_total-$bet->exposureAmt;
							}
							if($bet->bet_side=='lay')
							{
								$team1_bet_total=$team1_bet_total-$bet->bet_profit;
								$team2_bet_total=$team2_bet_total+$bet->bet_amount;
							}
						}
					}
				}
			}
			
		}
		
		$html_two=''; $html_two_team="";
		
		$login_check='';
		$sessionData = Session::get('playerUser');
		if(!empty($sessionData))
		{
			if($min_bet_odds_limit>0 && $min_bet_odds_limit!="" && $max_bet_odds_limit>0 && $max_bet_odds_limit!="")
			 $login_check='onclick="opnForm(this);"';
		}
		else
		{
			$login_check='data-toggle="modal" data-target="#myLoginModal"';
		}
		
		if(!empty($match_data) && $match_data!=0)
		{
			
			//for bookmaker			
			$html_bm_team.='
			<tr>
                <td class="text-color-grey fancybet-block" colspan="7">
                    <div class="dark-blue-bg-1 text-color-white">
                        <a> <img src="'.asset('asset/front/img/pin-bg.png').'"> <img src="'.asset('asset/front/img/pin-bg-1.png').'" class="hover-img"> </a>
                        Bookmaker Market <span class="zeroopa">| Zero Commission</span>
                    </div>
                    <div class="fancy_info text-color-white">
                        <span class="light-grey-bg-5 text-color-blue-1">Min</span> <span id="div_min_bet_bm_limit">'.$match_detail['min_bookmaker_limit'].'</span>
                        <span class="light-grey-bg-5 text-color-blue-1">Max</span> <span id="div_max_bet_bm_limit">'.$match_detail['max_bookmaker_limit'].'</span>
                    </div>
                </td>
            </tr>

			<tr class="bets-fancy white-bg">
				<td colspan="3" style="width:170px"></td>
				<td class="text-right">Back</td>
				<td class="text-left">Lay</td>
				<td colspan="2"></td>
			</tr>';
			//print_r($match_data['bm']);
			
			$team_name_array=array();
			$team_name_array[]=@$match_data['bm'][0]['nation'];
			$team_name_array[]=@$match_data['bm'][1]['nation'];
			$team_name_array[]=@$match_data['bm'][2]['nation'];
			
			
			$team1_name= $arry_position=array_search(ucwords($team1_name),$team_name_array);
			$team2_name= $arry_position=array_search(ucwords($team2_name),$team_name_array);
			$team3_name=0;
			if($team1_name==0 && $team2_name==1)
				$team3_name=2;
			else if($team1_name==1 && $team2_name==0)
				$team3_name=2;
			else if($team1_name==2 && $team2_name==1)
				$team3_name=0;
			else if($team1_name==1 && $team2_name==2)
				$team3_name=0;
			else if($team1_name==0 && $team2_name==2)
				$team3_name=1;
			else if($team1_name==2 && $team2_name==0)
				$team3_name=1;
			
			if($team1_name!='' || $team2_name!='')
			{
				
				
					if($match_b=='0'){

						$html.='<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
                    <tr class="white-bg">
								<td class="padding3">'.@$match_data['bm'][$team1_name]['nation'].'<br>
								<div>
									<span class="lose" id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="spark">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3']).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black		
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>
							<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
							<tr class="white-bg">
								<td class="padding3">'.@$match_data['bm'][$team2_name]['nation'].'<br>
								<div>
									<span class="lose" id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="spark">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
					}else{
					
				if(isset($match_data['bm'][$team1_name]['status']) && $match_data['bm'][$team1_name]['status']!='SUSPENDED')
				{
					$display=''; $cls='';
					if($team1_bet_total=='')
						$display='style="display:none"';
					if($team1_bet_total!='' && $team1_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team1_bet_total!='' && $team1_bet_total<0)
					{
						$cls='text-color-red';
					}					
					$html.='

					<tr class="white-bg">
								<td class="padding3">'.@$match_data['bm'][$team1_name]['nation'].'<br>
								<div>
									<span class="lose '.$cls.'" '.$display.' id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
									<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
								</div>
								</td>
								<td class="spark">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b3'],2).'">'.round(@$match_data['bm'][$team1_name]['b3'],2).'</a>
										</div>
										
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.'  data-val="'.round(@$match_data['bm'][$team1_name]['b2'],2).'">'.round(@$match_data['bm'][$team1_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['b1'],2).'">'.round(@$match_data['bm'][$team1_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay">
									<div class="lay-gradient text-color-black">
										<div id="lay_1"  class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l1'],2).'">'.@round($match_data['bm'][$team1_name]['l1'],2).'</a></div>
										
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l2'],2).'">'.round(@$match_data['bm'][$team1_name]['l2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team1_name]['sectionId'].'">
											<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team1_name]['l3'],2).'">'.round(@$match_data['bm'][$team1_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
				}
				else
				{
					$display=''; $cls='';
					if($team1_bet_total=='')
						$display='style="display:none"';
					if($team1_bet_total!='' && $team1_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team1_bet_total!='' && $team1_bet_total<0)
					{
						$cls='text-color-red';
					}
					$html.='
					
					<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
					<tr class="white-bg">
						<td class="padding3">'.@$match_data['bm'][$team1_name]['nation'].'<br>
							<div>
								<span class="lose '.$cls.'" '.$display.' id="team1_betBM_count_old">(<span id="team1_BM_total">'.round($team1_bet_total,2).'</span>)</span>
								<span class="tolose text-color-red" style="display:none" id="team1_betBM_count_new">(6.7)</span>
							</div>
						</td>
						<td>
							<div class="back-gradient text-color-black">
								<div id="back_3" class="light-blue-bg-2">
									<a>  </a>
								</div>
							</div>
						</td>
                        <td>
							<div class="back-gradient text-color-black">
								
								<div id="back_2" class="light-blue-bg-3">
									<a>  </a>
								</div>
							</div>
						</td>
                        <td>
							<div class="back-gradient text-color-black">
								
								<div id="back_1"><a class="cyan-bg">  </a></div>
							</div>
						</td>
                        
						<td>
							<div class="lay-gradient text-color-black">
								<div id="lay_1"><a class="pink-bg">  </a></div>
								
							</div>
						</td>
                        <td>
							<div class="lay-gradient text-color-black">
								
								<div id="lay_2" class="light-pink-bg-2">
									<a>  </a>
								</div>
							</div>
						</td>
                        <td>
							<div class="lay-gradient text-color-black">
								
								<div id="lay_3" class="light-pink-bg-3">
									<a>  </a>
								</div>
							</div>
						</td>
					</tr>
					';
							
				}
				if(isset($match_data['bm'][$team2_name]['status']) && @$match_data['bm'][$team2_name]['status']!='SUSPENDED')
				{
					$display=''; $cls='';
					if($team2_bet_total=='')
						$display='style="display:none"';
					if($team2_bet_total!='' && $team2_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team2_bet_total!='' && $team2_bet_total<0)
					{
						$cls='text-color-red';
					}
					$html.='<tr class="white-bg">
								<td class="padding3">'.@$match_data['bm'][$team2_name]['nation'].'<br>
									<div>
										<span class="lose '.$cls.'" '.$display.' id="team2_betBM_count_old">(<span id="team2_BM_total">'.round($team2_bet_total,2).'</span>)</span>
										<span class="tolose text-color-red" style="display:none" id="team2_betBM_count_new">(6.7)</span>
									</div>
								</td>
								<td class="spark">
									<div class="back-gradient text-color-black">
										<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b3'],2).'">'.round(@$match_data['bm'][$team2_name]['b3'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b2'],2).'">'.round(@$match_data['bm'][$team2_name]['b2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="spark">
									<div class="back-gradient text-color-black">
										
										<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['b1'],2).'">'.round(@$match_data['bm'][$team2_name]['b1'],2).'</a>
										</div>
									</div>
								</td>
                                
                                
								<td class="sparkLay">
									<div class="lay-gradient text-color-black">
										<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l1'],2).'">'.round(@$match_data['bm'][$team2_name]['l1'],2).'</a></div>
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l2'],2).'">'.round(@$match_data['bm'][$team2_name]['l2'],2).'</a>
										</div>
									</div>
								</td>
                                <td class="sparkLay">
									<div class="lay-gradient text-color-black">
										
										<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team2_name]['sectionId'].'">
											<a  data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team2_name]['l3'],2).'">'.round(@$match_data['bm'][$team2_name]['l3'],2).'</a>
										</div>
									</div>
								</td>
							</tr>';
				}
				else
				{
					$display=''; $cls='';
					if($team2_bet_total=='')
						$display='style="display:none"';
					if($team2_bet_total!='' && $team2_bet_total>=0)
					{
						$cls='text-color-green';
					}
					else if($team2_bet_total!='' && $team2_bet_total<0)
					{
						$cls='text-color-red';
					}
					$html.='<tr class="fancy-suspend-tr">
						<td></td>
						<td class="fancy-suspend-td" colspan="6">
							<div class="fancy-suspend black-bg-5 text-color-white"><span>SUSPENDED</span></div>
						</td>
					</tr>
					<tr class="white-bg">
						<td class="padding3">'.@$match_data['bm'][$team2_name]['nation'].'<br>
							<div>
								<span class="lose '.$cls.'" '.$display.' id="team2_betBM_count_old">(<span id="team2_BM_total">'.round($team2_bet_total,2).'</span>)</span>
								<span class="tolose text-color-red" style="display:none" id="team2_betBM_count_new">(6.7)</span>
							</div>
						</td>
						<td>
							<div class="back-gradient text-color-black">
								<div id="back_3" class="light-blue-bg-2">
									<a> </a>
								</div>
							</div>
						</td>
                        <td>
							<div class="back-gradient text-color-black">
								
								<div id="back_2" class="light-blue-bg-3">
									<a> </a>
								</div>
							</div>
						</td>
                        <td>
							<div class="back-gradient text-color-black">
								
								<div id="back_1"><a class="cyan-bg"> </a></div>
							</div>
						</td>
                        
                        
						<td>
							<div class="lay-gradient text-color-black">
								<div id="lay_1"><a class="pink-bg"> </a></div>
								
				            </div>
						</td>
                        <td>
							<div class="lay-gradient text-color-black">
								<div id="lay_2" class="light-pink-bg-2">
										<a> </a>
								</div>
				            </div>
						</td>
                        <td>
							<div class="lay-gradient text-color-black">
								
								<div id="lay_3" class="light-pink-bg-3">
										<a> </a>
								</div>
				            </div>
						</td>
					</tr>
					';
							
				}
				if(isset($match_data['bm'][2]['status']))
				{
					if(@$match_data['bm'][2]['status']!='SUSPENDED')
					{
						$display=''; $cls='';
						if($team_draw_bet_total=='')
						{
							$display='style="display:none"';
						}
						if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
						{
							$cls='text-color-red';
						}
						
						$html.='<tr class="white-bg">
									<td class="padding3">'.@$match_data['bm'][$team3_name]['nation'].'<br>
										<div>
											<span class="lose '.$cls.'" '.$display.' id="draw_betBM_count_old">(<span id="draw_BM_total">'.round($team_draw_bet_total,2).'</span>)</span>
											<span class="tolose text-color-red" style="display:none" id="draw_betBM_count_new">(6.7)</span>
										</div>
									</td>
									<td class="spark">
										<div class="back-gradient text-color-black">
											<div id="back_3" class="BmBack light-blue-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b3'],2).'">'.round(@$match_data['bm'][$team3_name]['b3'],2).'</a>
											</div>
										</div>
									</td>
                                    <td class="spark">
										<div class="back-gradient text-color-black">
											
											<div id="back_2" class="BmBack light-blue-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b2'],2).'">'.round(@$match_data['bm'][$team3_name]['b2'],2).'</a>
											</div>
											
										</div>
									</td>
                                    <td class="spark">
										<div class="back-gradient text-color-black">
											
											<div id="back_1" class="BmBack" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="cyan-bg" class="cyan-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['b1'],2).'">'.round(@$match_data['bm'][$team3_name]['b1'],2).'</a>
											</div>
										</div>
									</td>
                                    
                                    
									<td class="sparkLay">
										<div class="lay-gradient text-color-black">
											<div id="lay_1" class="BmLay pink-bg" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l1'],2).'">'.round(@$match_data['bm'][$team3_name]['l1'],2).'</a>
											</div>
										</div>
									</td>
                                    <td class="sparkLay">
										<div class="lay-gradient text-color-black">
											
											<div id="lay_2" class="BmLay light-pink-bg-2" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l2'],2).'">'.round(@$match_data['bm'][$team3_name]['l2'],2).'</a>
											</div>
										</div>
									</td>
                                    <td class="sparkLay">
										<div class="lay-gradient text-color-black">
											
											<div id="lay_3" class="BmLay light-pink-bg-3" data-team="team'.@$match_data['bm'][$team3_name]['sectionId'].'">
												<a data-cls="pink-bg" '.$login_check.' data-val="'.round(@$match_data['bm'][$team3_name]['l3'],2).'">'.round(@$match_data['bm'][$team3_name]['l3'],2).'</a>
											</div>
										</div>
									</td>
								</tr>';
					}
					else
					{
						$display=''; $cls='';
						if($team_draw_bet_total=='')
						{
							$display='style="display:none"';
						}
						if($team_draw_bet_total!='' && $team_draw_bet_total>=0)
						{
							$cls='text-color-green';
						}
						else if($team_draw_bet_total!='' && $team_draw_bet_total<0)
						{
							$cls='text-color-red';
						}
						$html.='<tr class="fancy-suspend-tr">
							<td></td>
							<td class="fancy-suspend-td" colspan="6">
								<div class="fancy-suspend black-bg-5 text-color-white"><span>'.@$match_data['bm'][$team3_name]['status'].'</span></div>
							</td>
						</tr>
						<tr class="white-bg">
							<td class="padding3">'.@$match_data['bm'][$team3_name]['nation'].'<br>
							<div>
								<span class="lose '.$cls.'" '.$display.' id="draw_betBM_count_old">(<span id="draw_BM_total">'.round($team_draw_bet_total).'</span>)</span>
								<span class="tolose text-color-red" style="display:none" id="draw_betBM_count_new">(6.7)</span>
							</div>
							</td>
							<td>
								<div class="back-gradient text-color-black">
									<div id="back_3" class="light-blue-bg-2">
										<a>  </a>
									</div>
								</div>
							</td>
                            <td>
								<div class="back-gradient text-color-black">
									
									<div id="back_2" class="light-blue-bg-3">
										<a>  </a>
									</div>
								</div>
							</td>
                            <td>
								<div class="back-gradient text-color-black">
									
									<div id="back_1"><a class="cyan-bg">  </a></div>
								</div>
							</td>
                            
                            
							<td>
								<div class="lay-gradient text-color-black">
									<div id="lay_1"><a class="pink-bg">  </a></div>
								</div>
							</td>
                            <td>
								<div class="lay-gradient text-color-black">
									<div id="lay_2" class="light-pink-bg-2">
										<a>  </a>
									</div>
								</div>
							</td>
                            <td>
								<div class="lay-gradient text-color-black">
									
									<div id="lay_3" class="light-pink-bg-3">
										<a>  </a>
									</div>
								</div>
							</td>
						</tr>
						';
								
					}
				}
			 } // end suspended if
			}
			if($html!='')
				$html=$html_bm_team.$html;
		}
		//print_r($match_data);
		echo $html;
	
	}
	public function casino()
	{     
		$casino = Casino::all();
		return view('front.casino',compact('casino'));
	}
	public function inplay()
	{     
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
						$match_array_data_cricket[]=$match->match_id;
					else if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
					else if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
		$imp_match_array_data_tenis=@implode(",",$match_array_data_tenis);
		$imp_match_array_data_soccer=@implode(",",$match_array_data_soccer);	
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
				
		$html=''; $cricket_html='';
		for($j=0;$j<sizeof($match_data);$j++)
		{
			$inplay_game='';
			$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
			if(isset($match_data[$j]['inplay']))
			{
				if($match_data[$j]['inplay']==1)
				{
					if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
						
					}
					else
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
						
					}
					if(isset($match_data[$j]['runners'][2]))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
						</span></div>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span></div>';
					}
				}
			}
		}
		$cricket_html.=$html;
		
		$html=''; $soccer_html='';
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_soccer;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
				
		$match_data = json_decode($return, true);
				
		for($j=0;$j<sizeof($match_data);$j++)
		{
			$inplay_game='';
			$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
			if(isset($match_data[$j]['inplay']))
			{
				if($match_data[$j]['inplay']==1)
				{
					if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
						
					}
					else
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
						
					}
					if(isset($match_data[$j]['runners'][2]))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
						</span></div>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span></div>';
					}
				}
			}
		}
		$soccer_html.=$html;
		
		//for tennis
		$html=''; $tennis_html='';
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_tenis;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		$match_data = json_decode($return, true);
		
		for($j=0;$j<sizeof($match_data);$j++)
		{
			$inplay_game='';
			$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
			if(isset($match_data[$j]['inplay']))
			{
				if($match_data[$j]['inplay']==1)
				{
					if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
						
					}
					else
					{
						$html.='<div class="secondblock-cricket active-block active-tag white-bg"><span class="fir-col1">
						<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].'</a>
						<div  class="text-color-green">In-Play</div>
						</span>';
						
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
						
					}
					if(isset($match_data[$j]['runners'][2]))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
						</span>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span>';
					}
					if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
						<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
						</span></div>';
					}
					else
					{
						$html.='<span class="fir-col2">
						<a class="backbtn lightblue-bg2">--</a>
						<a class="laybtn lightpink-bg1">--</a>
						</span></div>';
					}
				}
			}
		}
		$tennis_html.=$html;
		return view('front.inplay',compact('sports','cricket_html','soccer_html','tennis_html'));
	}
	public function getmatchdetailsOfInplay()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
						$match_array_data_cricket[]=$match->match_id;
					else if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
					else if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
		$imp_match_array_data_tenis=@implode(",",$match_array_data_tenis);
		$imp_match_array_data_soccer=@implode(",",$match_array_data_soccer);	
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
				$headers = array('Content-Type: application/json');
				$process = curl_init();
				curl_setopt($process, CURLOPT_URL, $url);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
				#curl_setopt($process, CURLOPT_HEADER, 1);
				curl_setopt($process, CURLOPT_TIMEOUT, 30);
				curl_setopt($process, CURLOPT_HTTPGET, 1);
				#curl_setopt($process, CURLOPT_VERBOSE, 1);
				curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
				$return = curl_exec($process);
				curl_close($process);
				// echo $return;
				
				$match_data = json_decode($return, true);
				//print_r($match_data);
				
				$cricket='<div class="programe-setcricket">
				<div class="firstblock-cricket lightblue-bg1">
				<span class="fir-col1"></span>
                <span class="fir-col2">1</span>
                <span class="fir-col2">X</span>
                <span class="fir-col2">2</span>
                <span class="fir-col3"></span>
                </div>';
				$html='';
				for($j=0;$j<sizeof($match_data);$j++)
				{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
								
								if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
								{
									$html.='
									<div class="secondblock-cricket white-bg">
										<span class="'.$style.'"  >
										<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
									<span class="fir-col2">
									<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
									<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
									</span>';
								}
								else
								{
									$html.='
									<div class="secondblock-cricket white-bg">
										<span class="'.$style.'"  >
										<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
									<span class="fir-col2">
									<a class="backbtn lightblue-bg2">--</a>
									<a class="laybtn lightpink-bg1">--</a>
									</span>';
								}
								if(isset($match_data[$j]['runners'][2]))
								{
									$html.='<span class="fir-col2">
									<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
									<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
									</span>';
								}
								else
								{
									$html.='<span class="fir-col2">
									<a class="backbtn lightblue-bg2">--</a>
									<a class="laybtn lightpink-bg1">--</a>
									</span>';
								}
								if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
								{
									$html.='<span class="fir-col2">
									<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
									<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
									</span></div>';
								}
								else
								{
									$html.='<span class="fir-col2">
									<a class="backbtn lightblue-bg2">--</a>
									<a class="laybtn lightpink-bg1">--</a>
									</span></div>';
								}
							}
						}
				}
				
				if($html=='')
					$cricket_final_html='No match found.';
				else
					$cricket_final_html.=$html;
				
				$final_html.=$cricket.$cricket_final_html.'</div>';
				
				//for tennis
				$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_tenis;
				$headers = array('Content-Type: application/json');
				$process = curl_init();
				curl_setopt($process, CURLOPT_URL, $url);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($process, CURLOPT_TIMEOUT, 30);
				curl_setopt($process, CURLOPT_HTTPGET, 1);
				curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
				$return = curl_exec($process);
				curl_close($process);
				
				$match_data = json_decode($return, true);
				
				$tennis='<div class="programe-setcricket">
				<div class="firstblock-cricket lightblue-bg1">
				<span class="fir-col1"></span>
                <span class="fir-col2">1</span>
                <span class="fir-col2">X</span>
                <span class="fir-col2">2</span>
                <span class="fir-col3"></span>
                </div>';
				for($j=0;$j<sizeof($match_data);$j++)
				{
					$html='';
					$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						
					if(isset($match_data[$j]['inplay'])==1)
					{
						
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
							<span class="'.$style.'"  >
							<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a><div>'.$dt.'</div></span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
							<span class="'.$style.'"  >
							<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a><div>'.$dt.'</div></span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
							$tennis_final_html.=$html;
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
							$tennis_final_html.=$html;
						}
					}
				}
				if($html=='')
					$tennis_final_html='No match found.';
				else
					$tennis_final_html.=$html;
				
				$final_html.="~~".$tennis.$tennis_final_html.'</div>';
				
				//for soccer
				$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_soccer;
				$headers = array('Content-Type: application/json');
				$process = curl_init();
				curl_setopt($process, CURLOPT_URL, $url);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($process, CURLOPT_TIMEOUT, 30);
				curl_setopt($process, CURLOPT_HTTPGET, 1);
				curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
				$return = curl_exec($process);
				curl_close($process);
				
				$match_data = json_decode($return, true);
				$soccer='<div class="programe-setcricket">
				<div class="firstblock-cricket lightblue-bg1">
				<span class="fir-col1"></span>
                <span class="fir-col2">1</span>
                <span class="fir-col2">X</span>
                <span class="fir-col2">2</span>
                <span class="fir-col3"></span>
                </div>';
				for($k=0;$k<sizeof($match_data);$k++)
				{
					$html='';
					$match_detail = Match::where('match_id',$match_data[$k]['marketId'])->where('status',1)->first();
					
					if(isset($match_data[$k]['inplay'])==1)
					{
						
						if(isset($match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>		 </span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$k]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>		 </span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$k]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$k]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$k]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$k]['runners'][0]['ex']['availableToBack'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$k]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$k]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
						
						$soccer_final_html.=$html;
					}
				}
				if($html=='')
					$soccer_final_html='No match found.';
				else
					$soccer_final_html.=$html;
					
				$final_html.="~~".$soccer.$soccer_final_html.'</div>';
	  
	  return $final_html;
	}
	public function cricket()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
						$match_array_data_cricket[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return view('front.cricket',compact('sports','cricket_html'));
	}
	public function getmatchdetailsOfCricket()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==4)
						$match_array_data_cricket[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_cricket);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='<div class="firstblock-cricket lightblue-bg1">
                                <span class="fir-col1"></span>
                                <span class="fir-col2">1</span>
                                <span class="fir-col2">X</span>
                                <span class="fir-col2">2</span>
                                <span class="fir-col3"></span>
                            </div>';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return $cricket_html;
	}
	
	
	//soccer
	public function soccer()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_soccer);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_soccer);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.@$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.@$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return view('front.soccer',compact('sports','cricket_html'));
	}
	public function getmatchdetailsOfSoccer()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==1)
						$match_array_data_soccer[]=$match->match_id;
				}
			}
		}
		
		$imp_match_array_data_cricket=@implode(",",$match_array_data_soccer);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='<div class="firstblock-cricket lightblue-bg1">
                                <span class="fir-col1"></span>
                                <span class="fir-col2">1</span>
                                <span class="fir-col2">X</span>
                                <span class="fir-col2">2</span>
                                <span class="fir-col3"></span>
                            </div>';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return $cricket_html;
	}
	
	//tennis
	public function tennis()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_tenis);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return view('front.tennis',compact('sports','cricket_html'));
	}
	public function getmatchdetailsOfTennis()
	{
		$sports = Sport::all();

		$html=''; $i=0; $final_html=''; $cricket_final_html=''; $tennis_final_html=''; $soccer_final_html='';
		
		$match_array_data_cricket=array();
		$match_array_data_tenis=array();
		$match_array_data_soccer=array();
		
	  	foreach($sports as $sport)
	 	{
			$match_link = Match::where('sports_id',$sport->sId)->where('status',1)->orderBy('match_date','DESC')->get();
			foreach($match_link as $match)
			{
				//echo $match;
				if(@$match->match_id!='')
				{
					if($match->sports_id==2)
						$match_array_data_tenis[]=$match->match_id;
				}
			}
		}
		//print_r($match_array_data_cricket);
		$imp_match_array_data_cricket=@implode(",",$match_array_data_tenis);
						
		$mdata=array(); $inplay=0;
		
		$url='http://3.7.102.54/listMarketBookBetfair/'.$imp_match_array_data_cricket;
		$headers = array('Content-Type: application/json');
		$process = curl_init();
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
		#curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		#curl_setopt($process, CURLOPT_VERBOSE, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		// echo $return;
				
		$match_data = json_decode($return, true);
		//print_r($match_data);
		$cricket_html='<div class="firstblock-cricket lightblue-bg1">
                                <span class="fir-col1"></span>
                                <span class="fir-col2">1</span>
                                <span class="fir-col2">X</span>
                                <span class="fir-col2">2</span>
                                <span class="fir-col3"></span>
                            </div>';	
		for($j=0;$j<sizeof($match_data);$j++)
					{
						$inplay_game='';
						$match_detail = Match::where('match_id',$match_data[$j]['marketId'])->where('status',1)->first();
						if(isset($match_data[$j]['inplay']))
						{
							if($match_data[$j]['inplay']==1)
							{
								$dt='';
								$style="fir-col1-green";
								$inplay_game=" <span style='color:green'>In-Play</span>";
							}
							else
							{
								$dt=$match_detail['match_date'];
								$style="fir-col1";
								$inplay_game='';
							}
							
						}
						else
						{
							$dt=$match_detail['match_date'];
							$style="fir-col1";
							$inplay_game='';
						}
						if(isset($match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price']))
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][0]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][0]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='
							<div class="secondblock-cricket white-bg">
								<span class="'.$style.'"  >
								<a href="matchDetail/'.$match_detail['id'].'" class="text-color-blue-light">'.$match_detail['match_name'].$inplay_game.'</a>								<div>'.$dt.'</div>			</span>
							<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][2]))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][2]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][2]['ex']['availableToLay'][0]['price'].'</a>
							</span>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span>';
						}
						if(isset($match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price']) && isset($match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price']))
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">'.$match_data[$j]['runners'][1]['ex']['availableToBack'][0]['price'].'</a>
							<a class="laybtn lightpink-bg1">'.$match_data[$j]['runners'][1]['ex']['availableToLay'][0]['price'].'</a>
							</span></div>';
						}
						else
						{
							$html.='<span class="fir-col2">
							<a class="backbtn lightblue-bg2">--</a>
							<a class="laybtn lightpink-bg1">--</a>
							</span></div>';
						}
					}
					$cricket_html.=$html.'</div>';
		
		return $cricket_html;
	}
	public function getleftpanelMenu()
	{
		$html='';
		$sports = Sport::all();
		foreach($sports as $sport)
		{
        $html.='<li>
            <a href="#homeSubmenu_'.$sport->sId.'" class="text-color-black2" data-toggle="collapse" aria-expanded="false">'.$sport->sport_name.'</a>
            <a href="#homeSubmenu_'.$sport->sId.'" data-toggle="collapse" aria-expanded="false">
                <img src="'.asset("asset/front/img/leftmenu-arrow3.png").'" class="hoverleft"><img class="hover-img" src="'.asset('asset/front/img/leftmenu-arrow4.png').'">
            </a>
            <ul class="dropul white-bg list-unstyled collapse" id="homeSubmenu_'.$sport->sId.'">';
                
                	$sId = $sport->sId;
					$match_data=app('App\Http\Controllers\RestApi')->GetAllMatch();
        			$leage=array();
				
                if($match_data!=0)
				{
                    foreach ($match_data as $matches)
					{
                       	if($matches['SportsId'] == $sId && $matches['Market']=='Match Odds'){
                            if(!in_array($matches['Competition'], $leage))
							{
                                $leage[] = $matches['Competition'];
							}
						}
					}
                    foreach ($leage as $value)
                    {
					    $html.='<li>
                            <a href="#homeSubmenu1_'.str_replace(' ', '_', $value).'" data-toggle="collapse" aria-expanded="false" class="text-color-black2">'.$value.'</a>
                            <a href="#homeSubmenu1_'.str_replace(' ', '_', $value).'" data-toggle="collapse" aria-expanded="false">
                                <img src="'.asset('asset/front/img/leftmenu-arrow3.png').'" class="hoverleft"><img class="hover-img" src="'.asset('asset/front/img/leftmenu-arrow4.png').'">
                            </a>
                            <ul class="dropul white-bg list-unstyled collapse" id="homeSubmenu1_'.str_replace(' ', '_', $value).'">';
                            	 
								$leage = $value;
        						$match_data_leage=app('App\Http\Controllers\RestApi')->GetAllMatch();
									
                                if($match_data_leage!=0)
                                {
								    foreach ($match_data_leage as $matches_leage)
									{
                                        $matchList = Match::where('event_id',$matches_leage['EventId'])->where('status',1)->where('match_id',$matches_leage['MarketId'])->first();
										//print_r($matchList);
										
										//if(sizeof($matchList)>0)
										//{
											if($matches_leage['SportsId'] == $sId && $matches_leage['Market']=='Match Odds')
											{
												if($leage == $matches_leage['Competition'])
												{ 
													
												
													$html.='<li>
														<a href="#homeSubmenu2_'.$matches_leage['EventId'].'" data-toggle="collapse" aria-expanded="false" class="text-color-black2">'.$matches_leage['Event'].'</a>
														<a href="#homeSubmenu2_'.$matches_leage['EventId'].'" data-toggle="collapse" aria-expanded="false">
															<img src="'.asset('asset/front/img/leftmenu-arrow3.png').'" class="hoverleft"><img class="hover-img" src="'.asset('asset/front/img/leftmenu-arrow4.png').'">
														</a>
														<ul class="dropul white-bg list-unstyled collapse" id="homeSubmenu2_'.$matches_leage['EventId'].'">
															<li>
																<a class="text-color-black2 w-100" href="matchDetail/'.$matchList['id'].'"> <img src="'.asset('asset/front/img/green-dots.png').'"> Match Odds</a>
															</li>
														</ul>
													</li>';
												}
											}
										//}
									}
								}
                            $html.='</ul>
                        </li>';
                    }
				}
				$html.='</ul>
					</li>';
			}
				echo $html;
	}

	public function myprofile()
	{
		$loginuser =  Session::get('playerUser');
		
		$user = User::where('id',$loginuser->id)->first();

		return view('front.myprofile',compact('user'));
	}
	public function balanceoverview()
	{
		$loginuser =  Session::get('playerUser');
		$user = User::where('id',$loginuser->id)->first();

		return view('front.balance-overview',compact('user'));
	}
	public function accountstatement()
	{
		return view('front.account-statement');
	}
	public function mybets()
	{
		return view('front.my-bets');
	}
	public function activitylog()
	{
		$loginuser =  Session::get('playerUser');
		$user = User::where('id',$loginuser->id)->first();

		return view('front.activity-log',compact('user'));
	}
	public function updateUserPassword(Request $request,$id)
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
        return redirect()->route('front')
                        ->with('message','Password Change Successfully');
    }

    public function multimarket()
	{
		$sports = Sport::all();
  		$settings = setting::first();

		$restapi=new RestApi();		
		return view('front.multimarket',compact('sports','settings'));
	}	
}

