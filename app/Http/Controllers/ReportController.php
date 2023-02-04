<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Redirect;
use Auth;
use App\Match;
use App\MyBets;
Use DB;
use App\UserExposureLog;

class ReportController extends Controller
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
    $user = User::where('agent_level','PL')->get();
    return view('backpanel.commision-report',compact('user'));	        
  }
  public function getCommissionReport(Request $request )
  {
    $date_from = date('d-m-Y',strtotime($request->date_from));
    $date_to1 = date('d-m-Y',strtotime($request->todate));

    $date_to = date("Y-m-d", strtotime($date_to1 ."+1 day"));
         
    $userId = $request->userName;
    $profitSum=0;
    $commissionpro=0;
      
    $html='';
    if(!empty($userId)){
      $getresult = MyBets::select('users.user_name','users.commission','match.event_id','match.id as mid','users.id','match.winner','my_bets.user_id')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')->where('my_bets.bet_type','ODDS')->where('my_bets.user_id',$userId)->groupBy('my_bets.user_id')->whereBetween('match.match_date', [$date_from, $date_to])->get();
    }else{
      $getresult = MyBets::select('users.user_name','users.commission','match.event_id','match.id as mid','users.id','match.winner','my_bets.user_id')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')->where('my_bets.bet_type','ODDS')->groupBy('my_bets.user_id')->whereBetween('match.match_date', [$date_from, $date_to])->get();
    }    
    $count=1;
    $totalcomm=0;
    $totalcommperc=0;
    $betparray = array();
    foreach ($getresult as $value) {     
    	$userData = User::find($value->user_id);
    	$commission=0;
  
    	$getallBet = UserExposureLog::where('user_id',$value->user_id)->where('bet_type','ODDS')->where('win_type','Profit')->get();

    	foreach ($getallBet as $valuebet) 
    	{
    		$commission_sum=0;
    		if($valuebet->profit>0)
    			$commission_sum = $valuebet->profit*$userData->commission/100;
    		$commission+=$commission_sum;      
    	}
      $totalcommperc+= $value->commission;
      $totalcomm+= $commission;
  
    	$html.='<tr>
        <td>'.$count.'.</td>
          <td> <a data-id="'.$value->id.'" data-name="'.$value->user_name.'" onclick="openReport(this);">'.$value->user_name.'</a> </td>
          <td class="text-color-green">'.$value->commission.'%</td>
          <td class="text-color-green">'.$commission.'</td>
      </tr> ';
      $count++;
    }   
    $html.=' <tr>
      <td colspan="2" class="text-right"> <b> Grand Total </b> </td>';
        $html.='<td class="text-color-green"> <b></b> </td>
        <td class="text-color-green"> <b>'.$totalcomm.'</b> </td>
    </tr>';
    return response()->json(array('result'=> 'success','html'=>$html));      
  }
  public function getCommissionPopup(Request $request)
  {
    $userId = $request->userId;
    $date_from = date('d-m-Y',strtotime($request->date_from));
    $date_to1 = date('d-m-Y',strtotime($request->todate));

    $date_to = date("d-m-Y", strtotime($date_to1 ."+1 day"));

    $html='';
    $count=1;
   
    $getresultpopup = MyBets::select('match.match_date','match.event_id','match.id as mid','my_bets.user_id','match.match_name','my_bets.team_name','match.winner','my_bets.bet_profit')->join('match','match.event_id','=','my_bets.match_id')->where('my_bets.bet_type','ODDS')->where('match.winner','!=',Null)->where('my_bets.user_id',$userId)->groupBy('my_bets.match_id')->whereBetween('match.match_date', [$date_from, $date_to])->get();

    $userData = User::find($userId);

    $profitSumarray=array();
    $totalProfit=0;
    $totalCommission=0;
    //echo "<pre>"; print_r($getresultpopup);echo"<pre>";exit;
    foreach ($getresultpopup as $valuepopup) 
    {
     
      //echo $valuepopup; 
	    $profitSum=0;
	    $getallBet = UserExposureLog::where('match_id',$valuepopup->mid)->where('user_id',$valuepopup->user_id)->where('bet_type','ODDS')->where('win_type','Profit')->first();
    
    
	     $commission=0;
    	if($getallBet->profit>0)
    		$commission = $getallBet->profit*$userData->commission/100;
    	  $totalProfit += $getallBet->profit;
        $totalCommission += $commission;
       	$date = $valuepopup->match_date;
        $html.='<tr>
            <td>'.$count.'.</td>
              <td> '.$valuepopup->match_name.' '.$date.' 30-07-2021 08:00:00 </td>
              <td class="text-color-green"> '.$getallBet->profit.'</td>
              <td class="text-color-green"> '.$commission.'</td>
          </tr> ';
          $count++;
    }
    $html.=' <tr>
      <td colspan="2" class="text-right"> <b> Grand Total </b> </td>
        <td class="text-color-green"> <b>'.$totalProfit.'</b> </td>
        <td class="text-color-green"> <b>'.$totalCommission.'</b> </td>
    </tr>';
    return response()->json(array('result'=> 'success','html'=>$html));        
  }   
}
