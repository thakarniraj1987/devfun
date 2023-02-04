<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Request as resAll;
use Carbon\Carbon;
use App\CreditReference;
use DB;
use App\UserDeposit;
use App\setting;
use App\Sport;
use App\MyBets;
use App\Match;
use App\FancyResult;
use App\UserExposureLog;

class MyaccountController extends Controller
{
    public function index()
    {
        $loginuser = Auth::user();
        $user = User::where('id',$loginuser->id)->first();
        $id= $loginuser->id;
		return view('backpanel.myaccount-summary',compact('user','id'));
    }
   
    public function accountprofile()
    {
    	$loginuser = Auth::user();
		$user = User::where('id',$loginuser->id)->first();
		return view('backpanel.myaccount-profile',compact('user'));
    }
    public function myaccountstatement(Request $request)
    {
        $loginuser = Auth::user();
        $user = User::where('id',$loginuser->id)->first();
        $list = User::where('parentid', $loginuser->id)->latest()->get();
        $id= $loginuser->id;
        return view('backpanel.myaccount-statement',compact('user','list','id'));
    }
    public function datamyaccountstatement(Request $request)
    {
        $loginuser = Auth::user();
		$user = User::where('id',$loginuser->id)->first();

        $startdt = Carbon::parse($request->startdate);
        $enddt = Carbon::parse($request->todate);

        $start = $startdt->modify('-1 day');
        $end = $enddt->modify('+1 day');

        $user = $request->user;
        $userid = User::where('user_name',$user)->first();

		$credit = UserDeposit::where(['child_id' =>$userid->id, 'parent_id' => $loginuser->id])
        ->whereBetween('created_at',[$start, $end])
        ->latest()
        ->get();
		
		$credit = UserDeposit::where('child_id' ,$userid->id)->where('parent_id' ,$loginuser->id)
        ->whereBetween('created_at',[$start, $end])->latest()->get();
		
        $auth_id = Auth::user()->id;
        $auth_type = Auth::user()->agent_level;
        if($auth_type=='COM'){
            $settings = setting::latest('id')->first();
            $balance=$settings->balance;
        }
        else
        {
            $settings = CreditReference::where('player_id',$auth_id)->first();
            $balance=$settings['available_balance_for_D_W'];
        }
		
		$player_balance=CreditReference::where('player_id',$userid->id)->first();
        $player_balance=$player_balance['remain_bal'];
		
        $html=''; $html.='';
		$i = 0; $previousValue = null; $prev_bal=0; $chk_ori=0; $closing_balance=0; $next_row_balance=0;
		foreach($credit as $data)
		{
			$from_data = User::where('id',$data->parent_id)->first();                           
            $todatasds = User::where('id',$data->child_id)->first();
			$html.='
           		<tr>
					<td> '.$data->created_at.' </td>
					<td class="text-color-green"> ';
						if($data->balanceType == 'DEPOSIT')
						{
							$html.=''.$data->amount.' ';
						}
			$html.='           
                  	</td>
					<td class="text-color-red"> ';
						if($data->balanceType == 'WITHDRAW')
						{
                        	$html.=' '.$data->amount.' ';
                        }
			$html.='</td>
			<td> ';
 			if ($i == 0) 
			{
				$prev_bal=$balance;
				if($data->balanceType == 'DEPOSIT'){
					$closing_balance=$player_balance;
					$html.=' '.$closing_balance.' ';
					$next_row_balance = $player_balance-$data->amount;
               	}
                if($data->balanceType == 'WITHDRAW')
				{
					$closing_balance=$player_balance;
					$html.=' '.$closing_balance.' ';
					$next_row_balance = $player_balance+$data->amount;
                }
			}
            else
			{
				if($data->balanceType == 'DEPOSIT'){
                    $closing_balance=$player_balance-$data->amount;
					$html.=' '.$next_row_balance.' ';
					$next_row_balance = $next_row_balance-$data->amount;
               	}
                if($data->balanceType == 'WITHDRAW'){
					$closing_balance=$player_balance+$data->amount;
					$html.=' '.$next_row_balance.' ';
					$next_row_balance = $next_row_balance+$data->amount;
               	}
			}
			$html.=' </td>
			<td> '.$data->extra.' </td>';
			$uname='';
			if(!empty($todatasds)){
				$uname=$todatasds->user_name;
			}
			$html.='<td> '.$from_data->user_name.' <i class="fas fa-caret-right text-color-grey"></i> '.$uname.'</td>
			</tr>';
			$i++; 
			$previousValue = $data;
		}
		return $html;
	}
    public function myaccounttrasferredlog()
    {
        $loginuser = Auth::user();
        $user = User::where('id',$loginuser->id)->first();
        $id= $loginuser->id;
        return view('backpanel.myaccount-trasferred-log',compact('user','id'));
    }
    public function myaccountactivelog()
    {
        $loginuser = Auth::user();
        $user = User::where('id',$loginuser->id)->first(); 
        return view('backpanel.myaccount-active-log',compact('user'));
    }
    public function updateAccountPassword(Request $request,$id)
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
        return redirect()->route('home')->with('message','Password Change Successfully');
    }
    public function commisionreport(){
        $user = User::where('agent_level','PL')->get();
        return view('backpanel.commision-report',compact('user'));
    }
    public function profitlossmarket()
    {
        $loginuser = Auth::user();
        $sports = Sport::where('status', 'active')->get();
        $users = User::where('parentid', $loginuser->id)->latest()->get();
        return view('backpanel.profitloss-market',compact('sports','users'));
    }
    public function marketPLdata(Request $request)
    {
        $sport_data = $request->sport;
        $childlist = $request->childlist;
        $val = $request->val;

        $chk = User::where('id', $childlist)->first();

        $loginuser = Auth::user();
        $users = User::where('parentid', $loginuser->id)->latest()->get();
        $html=''; $html.= ''; $html1=''; $html1.= ''; 
        // all user 
        $totalmp=0; $totalfpl=0; $totalstk=0; $totalnet=0;

        if($val=='today')
        {
            $fromdate = date('Y-m-d');
            $todate = date("Y-m-d", strtotime("+1 day"));
        }
        elseif($val=='yesterday')
        {
            $fromdate = date("Y-m-d", strtotime("-1 day"));
            $todate = date('Y-m-d');
        }
        else
        {
            $fromdate = $request->fromdate;
            $todate1 = $request->todate;
            $todate = date("Y-m-d", strtotime($todate1 ."+1 day"));

        }
        if(empty($fromdate))
        {
            $fromdate = date('Y-m-d');
        }
        if(empty($todate))
        {
            $todate = date("Y-m-d", strtotime("+1 day"));
        }

        if($childlist !=0)
        {
            if($chk->agent_level != 'PL')
            {
                $x = $childlist;
                $ans = $this->childdata($x);

                if($sport_data != 0)
                {
                    foreach ($ans as $listc) 
                    {

                        $getresult = MyBets::where(['sportID' => $sport, 'user_id' => $listc, 'result_declare'=>1])
                        ->whereBetween('created_at',[$fromdate,$todate])
                        ->groupBy('match_id')
                        ->latest()
                        ->get();

                        foreach($getresult as $data)
                        {
                            $sports = Sport::where('sId', $data->sportID)->first();
                            $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                            $subresult = MyBets::where('match_id', $data->match_id)
                            ->whereBetween('created_at',[$fromdate,$todate])
                            ->latest()->get();

                            $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;

                            $loginUser= User::where('id',$listc)->first();

                            $exposer_odds=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','ODDS')->where('user_id', $loginUser->id)->first();
                            if(!empty($exposer_odds))
                            {
                                $odds_win_type=$exposer_odds['win_type'];
                                if($odds_win_type=='Profit')
                                    $sumAmt=$sumAmt+$exposer_odds->profit;
                                else
                                    $sumAmt=$sumAmt-$exposer_odds->loss;
                                $totalPr = ($sumAmt * $loginUser->commission) /100;
                            }
                           

                            foreach($subresult as $subd1){
                                $sports = Sport::where('sId', $subd1->sportID)->first();
                                $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                                $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();
                                $betAmt+=$subd1->bet_amount;
                                /*if($subd1->bet_type == 'ODDS'){
                                    if($matchdata->winner == $subd1->team_name){
                                        $sumAmt+=$subd1->bet_profit;
                                    }else{
                                        $sumAmt-=$subd1->exposureAmt;
                                    }
                                }*/
                              
                                if($subd1->bet_type == 'SESSION'){
                                    if(!empty($fancydata)){
                                        /*if($subd1->bet_side=='back')
                                        {
                                            if($subd1->bet_odds<=$fancydata->result)
                                            {
                                                $fncAmt+=$subd1->bet_profit;
                                            }
                                            else if($subd1->bet_odds>$fancydata->result)
                                            {
                                                $fncAmt-=$subd1->bet_amount;
                                            }
                                        }else if($subd1->bet_side=='lay')
                                        {
                                            if($subd1->bet_odds>$fancydata->result)
                                            {
                                                $fncAmt+=$subd1->bet_amount;
                                            }
                                            else if($subd1->bet_odds<=$fancydata->result)
                                            {
                                                $fncAmt-=$subd1->exposureAmt;
                                            }
                                        }*/
                                        $exposer_fancy=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','SESSION')->where('fancy_name',$subd1->team_name)->where('user_id', $loginUser->id)->first();
                                        if(!empty($exposer_fancy))
                                        {
                                            $fancy_win_type=$exposer_fancy['win_type'];
                                            if($fancy_win_type=='Profit')
                                                $sumAmt=$sumAmt+$exposer_fancy->profit;
                                            else
                                                $sumAmt=$sumAmt-$exposer_fancy->loss;
                                        }
                                    }
                                }
                                $totalval = $sumAmt + $fncAmt + $betAmt;
                            }
                            $totalmp+=$sumAmt;
                            $totalfpl+=$fncAmt;
                            $totalstk+=$betAmt;
                            $totalnet+=$totalval;

                            if(!empty($matchdata)){
                                $html.='
                                    <tr>
                                        <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                            <a class="ico_account text-color-blue-light">
                                                '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                            </a>
                                        </td>';
                                        if($sumAmt >= 0){
                                            $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                                        }else{
                                            $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                                        }

                                        if($fncAmt >= 0){
                                            $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                                        }else{
                                            $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                                        }
                                    
                                        $html.='<td class="white-bg">'.$betAmt.'</td>
                                        <td class="white-bg">0.00</td>';

                                        if($totalval >= 0){
                                            $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                                        }else{
                                            $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                                        }
                                        
                                    $html.='</tr>
                                ';
                            }
                        }
                    }
                }
                else{
                    foreach ($ans as $listc) 
                    {
                        $getresult = MyBets::where(['user_id' => $listc,'result_declare'=>1])
                        ->whereBetween('created_at',[$fromdate,$todate])
                        ->groupBy('match_id')
                        ->latest()
                        ->get();  

                        foreach($getresult as $data)
                        {
                            $sports = Sport::where('sId', $data->sportID)->first();
                            $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                            $subresult = MyBets::where('match_id', $data->match_id)
                            ->whereBetween('created_at',[$fromdate,$todate])
                            ->latest()->get();

                            $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;

                            $loginUser= User::where('id',$listc)->first();

                            $exposer_odds=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','ODDS')->where('user_id', $loginUser->id)->first();
                            if(!empty($exposer_odds))
                            {
                                $odds_win_type=$exposer_odds['win_type'];
                                if($odds_win_type=='Profit')
                                    $sumAmt=$sumAmt+$exposer_odds->profit;
                                else
                                    $sumAmt=$sumAmt-$exposer_odds->loss;
                                $totalPr = ($sumAmt * $loginUser->commission) /100;
                            }

                            foreach($subresult as $subd1){
                                $sports = Sport::where('sId', $subd1->sportID)->first();
                                $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                                $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();
                                $betAmt+=$subd1->bet_amount;
                                /*if($subd1->bet_type == 'ODDS'){
                                    if($matchdata->winner == $subd1->team_name){
                                        $sumAmt+=$subd1->bet_profit;
                                    }else{
                                        $sumAmt-=$subd1->exposureAmt;
                                    }
                                }*/
                              
                                if($subd1->bet_type == 'SESSION'){
                                    if(!empty($fancydata)){
                                        /*if($subd1->bet_side=='back')
                                        {
                                            if($subd1->bet_odds<=$fancydata->result)
                                            {
                                                $fncAmt+=$subd1->bet_profit;
                                            }
                                            else if($subd1->bet_odds>$fancydata->result)
                                            {
                                                $fncAmt-=$subd1->bet_amount;
                                            }
                                        }else if($subd1->bet_side=='lay')
                                        {
                                            if($subd1->bet_odds>$fancydata->result)
                                            {
                                                $fncAmt+=$subd1->bet_amount;
                                            }
                                            else if($subd1->bet_odds<=$fancydata->result)
                                            {
                                                $fncAmt-=$subd1->exposureAmt;
                                            }
                                        }*/
                                        $exposer_fancy=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','SESSION')->where('fancy_name',$subd1->team_name)->where('user_id', $loginUser->id)->first();
                                        if(!empty($exposer_fancy))
                                        {
                                            $fancy_win_type=$exposer_fancy['win_type'];
                                            if($fancy_win_type=='Profit')
                                                $sumAmt=$sumAmt+$exposer_fancy->profit;
                                            else
                                                $sumAmt=$sumAmt-$exposer_fancy->loss;
                                        }
                                    }
                                }
                                $totalval = $sumAmt + $fncAmt + $betAmt;
                            }
                            $totalmp+=$sumAmt;
                            $totalfpl+=$fncAmt;
                            $totalstk+=$betAmt;
                            $totalnet+=$totalval;

                            if(!empty($matchdata)){
                                $html.='
                                    <tr>
                                        <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                            <a class="ico_account text-color-blue-light">
                                                '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                            </a>
                                        </td>';
                                        if($sumAmt >= 0){
                                            $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                                        }else{
                                            $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                                        }

                                        if($fncAmt >= 0){
                                            $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                                        }else{
                                            $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                                        }
                                    
                                        $html.='<td class="white-bg">'.$betAmt.'</td>
                                        <td class="white-bg">0.00</td>';

                                        if($totalval >= 0){
                                            $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                                        }else{
                                            $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                                        }
                                        
                                    $html.='</tr>
                                ';
                            }
                        }                      
                    }
                }
            }
            else{
                if($sport_data != 0)
                {
                    $sport = $request->sport;

                    $getresult = MyBets::where(['sportID' => $sport, 'user_id' => $childlist, 'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }
                else{
                    $getresult = MyBets::where(['user_id' => $childlist,'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }

                foreach($getresult as $data)
                {
                    $sports = Sport::where('sId', $data->sportID)->first();
                    $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                    $subresult = MyBets::where('match_id', $data->match_id)
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->latest()->get();

                    $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;

                   

                    foreach($subresult as $subd1){
                        $sports = Sport::where('sId', $subd1->sportID)->first();
                        $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                        $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();
                        $betAmt+=$subd1->bet_amount;
                        if($subd1->bet_type == 'ODDS'){
                            if($matchdata->winner == $subd1->team_name){
                                $sumAmt+=$subd1->bet_profit;
                            }else{
                                $sumAmt-=$subd1->exposureAmt;
                            }
                        }
                      
                        if($subd1->bet_type == 'SESSION'){
                            if(!empty($fancydata)){
                                if($subd1->bet_side=='back')
                                {
                                    if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_profit;
                                    }
                                    else if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->bet_amount;
                                    }
                                }else if($subd1->bet_side=='lay')
                                {
                                    if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_amount;
                                    }
                                    else if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->exposureAmt;
                                    }
                                }
                            }
                        }
                        $totalval = $sumAmt + $fncAmt + $betAmt;
                    }
                    $totalmp+=$sumAmt;
                    $totalfpl+=$fncAmt;
                    $totalstk+=$betAmt;
                    $totalnet+=$totalval;

                    if(!empty($matchdata)){
                        $html.='
                            <tr>
                                <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                    <a class="ico_account text-color-blue-light">
                                        '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                    </a>
                                </td>';
                                if($sumAmt >= 0){
                                    $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                                }else{
                                    $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                                }

                                if($fncAmt >= 0){
                                    $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                                }else{
                                    $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                                }
                            
                                $html.='<td class="white-bg">'.$betAmt.'</td>
                                <td class="white-bg">0.00</td>';

                                if($totalval >= 0){
                                    $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                                }else{
                                    $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                                }
                                
                            $html.='</tr>
                        ';
                    }
                }
            }
        }
        else{
            if($sport_data != 0)
            {
                $sport = $request->sport;

                $getresult = MyBets::where(['sportID' => $sport,'result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }
            else{
                $getresult = MyBets::where(['result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }

            foreach($getresult as $data)
            {
                $sports = Sport::where('sId', $data->sportID)->first();
                $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                $subresult = MyBets::where('match_id', $data->match_id)
                ->whereBetween('created_at',[$fromdate,$todate])
                ->latest()->get();

                $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;


                foreach($subresult as $subd1){
                    $sports = Sport::where('sId', $subd1->sportID)->first();
                    $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                    $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();
                    $betAmt+=$subd1->bet_amount;

                    if($subd1->bet_type == 'ODDS'){
                        if($matchdata->winner == $subd1->team_name){
                            $sumAmt+=$subd1->bet_profit;
                        }else{
                            $sumAmt-=$subd1->exposureAmt;
                        }
                    }
                  
                    if($subd1->bet_type == 'SESSION'){
                        if(!empty($fancydata)){
                            if($subd1->bet_side=='back')
                            {
                                if($subd1->bet_odds<=$fancydata->result)
                                {
                                    $fncAmt+=$subd1->bet_profit;
                                }
                                else if($subd1->bet_odds>$fancydata->result)
                                {
                                    $fncAmt-=$subd1->bet_amount;
                                }
                            }else if($subd1->bet_side=='lay')
                            {
                                if($subd1->bet_odds>$fancydata->result)
                                {
                                    $fncAmt+=$subd1->bet_amount;
                                }
                                else if($subd1->bet_odds<=$fancydata->result)
                                {
                                    $fncAmt-=$subd1->exposureAmt;
                                }
                            }
                        }
                    }
                    $totalval = $sumAmt + $fncAmt + $betAmt;
                }
                $totalmp+=$sumAmt;
                $totalfpl+=$fncAmt;
                $totalstk+=$betAmt;
                $totalnet+=$totalval;

                if(!empty($matchdata)){
                    $html.='
                        <tr>
                            <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                <a class="ico_account text-color-blue-light">
                                    '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                </a>
                            </td>';
                            if($sumAmt >= 0){
                                $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                            }else{
                                $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                            }

                            if($fncAmt >= 0){
                                $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                            }else{
                                $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                            }
                        
                            $html.='<td class="white-bg">'.$betAmt.'</td>
                            <td class="white-bg">0.00</td>';

                            if($totalval >= 0){
                                $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                            }else{
                                $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                            }
                            
                        $html.='</tr>
                    ';
                }
            }
        }


        //echo "<pre>";print_r($getresult);echo "<pre>";exit;

        /*if($childlist == 0 && $sport == 0 || $sport != 0 || $val=='today' || $val=='yesterday')
        {  
            foreach ($users as $key => $value) {
                if($childlist == 0 && $sport == 0)
                {
                    $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }
                if($sport != 0){
                    $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1,'sportID' => $sport])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }
                if($childlist != 0 && $sport != 0)
                {
                    $getresult = MyBets::where(['sportID' => $sport, 'user_id' => $childlist, 'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }
                if($val=='today' && $childlist == 0 && $sport == 0){
                    $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }
                if($val=='yesterday' && $childlist == 0 && $sport == 0){
                    $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1])
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->groupBy('match_id')
                    ->latest()
                    ->get();
                }

                foreach($getresult as $data)
                {
                    $sports = Sport::where('sId', $data->sportID)->first();
                    $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                    $subresult = MyBets::where('match_id', $data->match_id)
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->latest()->get();

                    $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;
                    foreach($subresult as $subd1){
                        $sports = Sport::where('sId', $subd1->sportID)->first();
                        $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                        $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();
                        $betAmt+=$subd1->bet_amount;
                        if($subd1->bet_type == 'ODDS'){
                            if($matchdata->winner == $subd1->team_name){
                                $sumAmt+=$subd1->bet_profit;
                            }else{
                                $sumAmt-=$subd1->exposureAmt;
                            }
                        }
                      
                        if($subd1->bet_type == 'SESSION'){
                            if(!empty($fancydata)){
                                if($subd1->bet_side=='back')
                                {
                                    if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_profit;
                                    }
                                    else if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->bet_amount;
                                    }
                                }else if($subd1->bet_side=='lay')
                                {
                                    if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_amount;
                                    }
                                    else if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->exposureAmt;
                                    }
                                }
                            }
                        }
                        $totalval = $sumAmt + $fncAmt + $betAmt;
                    }
                    $totalmp+=$sumAmt;
                    $totalfpl+=$fncAmt;
                    $totalstk+=$betAmt;
                    $totalnet+=$totalval;

                    if(!empty($matchdata)){
                        $html.='
                            <tr>
                                <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                    <a class="ico_account text-color-blue-light">
                                        '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                    </a>
                                </td>';
                                if($sumAmt >= 0){
                                    $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                                }else{
                                    $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                                }

                                if($fncAmt >= 0){
                                    $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                                }else{
                                    $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                                }
                            
                                $html.='<td class="white-bg">'.$betAmt.'</td>
                                <td class="white-bg">0.00</td>';

                                if($totalval >= 0){
                                    $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                                }else{
                                    $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                                }
                                
                            $html.='</tr>
                        ';
                    }
                }
            }   
        }
        else{

            if($childlist != 0)
            {
                $getresult = MyBets::where(['user_id' => $childlist, 'result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }
            if($childlist != 0 && $sport != 0)
            {
                $getresult = MyBets::where(['sportID' => $sport, 'user_id' => $childlist, 'result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }
            if($val=='today' && $childlist != 0 && $sport == 0){

                $getresult = MyBets::where(['user_id' => $childlist, 'result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }
            if($val=='yesterday' && $childlist != 0 && $sport == 0){

                $getresult = MyBets::where(['user_id' => $childlist, 'result_declare'=>1])
                ->whereBetween('created_at',[$fromdate,$todate])
                ->groupBy('match_id')
                ->latest()
                ->get();
            }
            foreach($getresult as $data)
            {
                $sports = Sport::where('sId', $data->sportID)->first();
                $matchdata = Match::where('event_id', $data->match_id)->latest()->first();

                $subresult = MyBets::where('match_id', $data->match_id)
                    ->whereBetween('created_at',[$fromdate,$todate])
                    ->latest()->get();

                    $sumAmt=0; $fncAmt=0; $betAmt=0; $totalval=0;

                    foreach($subresult as $subd1){
                        $sports = Sport::where('sId', $subd1->sportID)->first();
                        $matchdata = Match::where('event_id', $subd1->match_id)->latest()->first();
                        $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();

                        $betAmt+=$subd1->bet_amount;

                        if($subd1->bet_type == 'ODDS'){
                            if($matchdata->winner == $subd1->team_name){
                                $sumAmt+=$subd1->bet_profit;
                            }else{
                                $sumAmt-=$subd1->exposureAmt;
                            }
                        }

                        if($subd1->bet_type == 'SESSION'){
                            if(!empty($fancydata)){
                                if($subd1->bet_side=='back')
                                {
                                    if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_profit;
                                    }
                                    else if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->bet_amount;
                                    }
                                }else if($subd1->bet_side=='lay')
                                {
                                    if($subd1->bet_odds>$fancydata->result)
                                    {
                                        $fncAmt+=$subd1->bet_amount;
                                    }
                                    else if($subd1->bet_odds<=$fancydata->result)
                                    {
                                        $fncAmt-=$subd1->exposureAmt;
                                    }
                                }
                            }
                        }
                        $totalval = $sumAmt + $fncAmt + $betAmt;
                    }

                    $totalmp+=$sumAmt;
                    $totalfpl+=$fncAmt;
                    $totalstk+=$betAmt;
                    $totalnet+=$totalval;

                if(!empty($matchdata)){
                    $html.='
                        <tr>
                            <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">
                                <a class="ico_account text-color-blue-light">
                                    '.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <strong> '.$matchdata->match_name.' </strong>
                                </a>
                            </td>';
                            if($sumAmt >= 0){
                                $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                            }else{
                                $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                            }

                            if($fncAmt >= 0){
                                $html.='<td class="text-color-green white-bg">'.$fncAmt.'</td>';
                            }else{
                                $html.='<td class="text-color-red white-bg">'.$fncAmt.'</td>';
                            }
                            
                            $html.='<td class="white-bg">'.$betAmt.'</td>
                            <td class="white-bg">0.00</td>';

                            if($totalval >= 0){
                                $html.='<td class="white-bg text-color-green">('.$totalval.')</td>';
                            }else{
                                $html.='<td class="white-bg text-color-red">('.$totalval.')</td>';
                            }
                            
                        $html.='</tr>
                    ';
                }
            }
        }*/

        $html1.='
            <tr class="table-total">
                <td class="white-bg">Total</td>';

                if($totalmp >= 0){
                    $html1.='<td class="text-color-green white-bg">'.$totalmp.'</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">'.$totalmp.'</td>';
                }

                if($totalfpl >= 0){
                    $html1.='<td class="text-color-green white-bg">'.$totalfpl.'</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">'.$totalfpl.'</td>';
                }

                if($totalstk >= 0){
                    $html1.='<td class="text-color-green white-bg">'.$totalstk.'</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">'.$totalstk.'</td>';
                }
               
                $html1.='<td class="white-bg">0.00</td>';

                if($totalstk >= 0){
                    $html1.='<td class="white-bg text-color-green">('.$totalnet.')</td>';
                }else{
                    $html1.='<td class="white-bg text-color-red">('.$totalnet.')</td>';
                }
                
            $html1.='</tr>
        ';
        return $html.'~~'.$html1;
    }
    public function profitlossdownline(Request $request)
    {
        $loginuser = Auth::user();
        $users = User::where('parentid', $loginuser->id)->latest()->get();
        //echo "<pre>";print_r($users);echo "<pre>"; exit;
        return view('backpanel.profitloss-downline',compact('users'));
    }
	/*public static function GetAllChildofUser($pid)
	{
		$parent=array();
		$subdata = User::where('parentid',$pid)->get();
		//$id=$subdata['parentid'];
		foreach($subdata as $sub)
		{
			
			if($sub->agent_level!='PL')
			{
				do {
					//$subdata = SELF::GetAllChildofUser($sub->id);
					$subdata = User::where('parentid',$sub->id)->first();
					$id=$subdata['parentid'];
					$parent[]=$id;
				} while ($sub->agent_level!='PL');
			}
			else
			{
				$parent[]=$sub->id;
			}
		}
		return json_encode($parent);
	}*/
    function childdata($id)
    {
	    $cat=User::where('parentid',$id)->get();
		$children = array();
		$i = 0;   
		foreach ($cat as $key => $cat_value) {
			$children[] = array();
			$children[] = $cat_value->id;
			$new=$this->childdata($cat_value->id);
			$children = array_merge($children, $new);
			$i++;
		} 
		$new=array();
		foreach($children as $child)
		{
			if(!empty($child))
			$new[]=$child;
		}
		return $new;
    }
     function backdataagent($id){
        $adata = array();
        do{
            $test = User::where('id',$id)->first();
            $adata[]=  $test->id;
            $first = User::orderBy('id', 'ASC')->first();
        }while($id = $test->parentid);
        return $adata;
    }
  
    function GetChildofAgent($id)
    {
        $cat=User::where('parentid',$id)->get();
        $children = array();
        $i = 0;   
        foreach ($cat as $key => $cat_value) {
            $children[] = array();
            $children[] = $cat_value->id;
            $new=$this->GetChildofAgent($cat_value->id);
            $children = array_merge($children, $new);
            $i++;
        } 
        $new=array();
        foreach($children as $child)
        {
            if(!empty($child))
            $new[]=$child;
        }
        return $new;
    }
	
    public function getHistoryPL(Request $request)
    {        
        $val = $request->val;
        $html=''; $html1='';
        $totalAmt=0;

        if($val=='today')
        {
            $date_from = date('Y-m-d');
            $date_to = date("Y-m-d", strtotime("+1 day"));
        }
        else if($val=='yesterday')
        {   
            $date_from = date("Y-m-d", strtotime("-1 day"));
            $date_to = date("Y-m-d");
        }
        else
        {
            $date_from = $request->date_from;
            $date_to1 = date('d-m-Y',strtotime($request->date_to));
            $date_to = date("Y-m-d", strtotime($date_to1 ."+1 day"));
        }       
        $loginuser = Auth::user();
        $ag_id=$loginuser->id;
        $all_child = $this->GetChildofAgent($ag_id);
        $users_all_count = User::where('parentid', $loginuser->id)->latest()->count();

       /* $users_all = User::select('users.id')->where('users.parentid', $loginuser->id)->leftjoin('my_bets','my_bets.user_id','=','users.id')->groupBy('my_bets.user_id')->whereBetween('my_bets.created_at', [$date_from, $date_to])->get();
        $agentarray=array();
        foreach ($users_all as $value) {           
              $agentarray[] = $this->backdataagent($value->id);
             
                }   */     

               /*  echo "<pre>";
              print_r($agentarray);
              exit;*/

        $users_all = User::where('parentid', $loginuser->id)->latest()->get();
        $users_all_count = User::where('parentid', $loginuser->id)->latest()->count();
        if($users_all_count != 0){
        foreach ($users_all as $key => $value) {
            if($value->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($value->agent_level == 'AD'){
                $color = 'black-bg';
            }else if($value->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($value->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($value->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }

            if($date_from != '' && $date_to != '')
            {  
                $x = $value->id;
                $ans = $this->childdata($x);
                $totpamount = 0;
                $totalLoss = 0;
                $totalProfit = 0;
                foreach($ans as $datac)
                {                       
                    $getdata_exposer = UserExposureLog::where(['user_id' => $datac])
                    ->get();  
                    foreach ($getdata_exposer as $value_expo) {
                        if($value_expo->win_type=='Loss'){
                            $totalLoss += $value_expo->loss;
                        }
                        if($value_expo->win_type=='Profit'){
                            $totalProfit += $value_expo->profit;
                        }
                    }
                   
 
                }
                $totpamount = $totalProfit-$totalLoss;
            }
            
      
            $html.='
                <tr>
                    <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">';
                      
                    $html.='<a class="ico_account text-color-blue-light" id="'.$value->id.'"  onclick="subpagedata(this.id);">
                        <span class="'.$color.' text-color-white">'.$value->agent_level.'</span>'.$value->user_name.'
                        </a>';
                    
                    $html.='</td>';
                    if($totpamount >=0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                    $html.='<td class=" '.$class.' white-bg">'.abs($totpamount).'</td>';

                    if($totpamount >=0){
                        $classdown="text-color-red";
                    }else{
                        $classdown="text-color-green";
                    }
                    $html.='<td class="'.$classdown.' white-bg">'.abs($totpamount).'</td>';
                    $html.='<td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>';
                    $html.='<td class="'.$classdown.' white-bg">('.abs($totpamount).')</td>';
                $html.='</tr>
            ';
            $totalAmt+=$totpamount;
        }

         $html1.='
            <tr class="table-total">
                <td class="white-bg">Total</td>';               
                $html1.='<td class="white-bg">'.abs($totalAmt).'</td>';
                $html1.='<td class="white-bg">'.abs($totalAmt).'</td>';
                $html1.='<td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>';              
                $html1.='<td class="white-bg">('.abs($totalAmt).')</td>';
            $html1.='</tr>';
    }else{
        $html .='<tr> <td class="white-bg" collapse=8>No data available</td> </tr>';
        $html1 .='';
    }
        
       

        return $html.'~~'.$html1;
       
    }
    // wrong calculation method ss comment
   /* public function getHistoryPL(Request $request)
    {
	    $val = $request->val;
        $html=''; $html1='';

        if($val=='today')
        {
            $date_from = date('Y-m-d');
            $date_to = date("Y-m-d", strtotime("+1 day"));
        }
        else if($val=='yesterday')
        {
            
            $date_from = date("Y-m-d", strtotime("-1 day"));
            $date_to = date("Y-m-d");
        }
        else
        {
            $date_from = $request->date_from;
            
            $date_to1 = date('d-m-Y',strtotime($request->date_to));
            $date_to = date("Y-m-d", strtotime($date_to1 ."+1 day"));
        }

        $loginuser = Auth::user();
        $users = User::where('parentid', $loginuser->id)->latest()->get();
         
        $totalAmt=0;

        foreach ($users as $key => $value) {

            if($value->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($value->agent_level == 'AD'){
                $color = 'black-bg';
            }else if($value->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($value->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($value->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }
            

            if($date_from != '' && $date_to != '')
            {               
                $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1])
                ->whereBetween('created_at',[$date_from,$date_to])
                ->get(); 

                $sumAmt=0; 

                
                                 
                if($value->agent_level == 'PL'){                   

                    foreach ($getresult as $data) {
                        $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                        $fancydata = FancyResult::where(['eventid' => $data->match_id, 'fancy_name' => $data->team_name])->first();

                        if($data->bet_type == 'ODDS'){

                            if($matchdata->winner == $data->team_name){
                               
                                $sumAmt+=$data->bet_profit;
                            }else{
                                
                                $sumAmt-=$data->exposureAmt;
                            }
                        }

                        if($data->bet_type == 'SESSION'){
                            if(!empty($fancydata)){
                                if($data->bet_side=='back')
                                {
                                    if($data->bet_odds<=$fancydata->result)
                                    {
                                        $sumAmt+=$data->bet_profit;
                                    }
                                    else if($data->bet_odds>$fancydata->result)
                                    {
                                        $sumAmt-=$data->bet_amount;
                                    }
                                }else if($data->bet_side=='lay')
                                {
                                    if($data->bet_odds>$fancydata->result)
                                    {
                                        $sumAmt+=$data->bet_amount;
                                    }
                                    else if($data->bet_odds<=$fancydata->result)
                                    {
                                        $sumAmt-=$data->exposureAmt;
                                    }
                                }
                            }
                        }
                        if($data->bet_type == 'BOOKMAKER'){
                            if($matchdata->winner == $data->team_name){
                                $sumAmt+=$data->bet_profit;
                            }else{
                                $sumAmt-=$data->exposureAmt;
                            }
                        }
                    }
                    
                }
                else
				{                    
                   $x = $value->id;
                    $ans = $this->childdata($x);
                    $totpamount = 0;
                        $totalLoss = 0;
                        $totalProfit = 0;
                    foreach($ans as $datac)
                    {
                       
                        $getdata = MyBets::where(['user_id' => $datac, 'result_declare'=>1])
                        ->whereBetween('created_at',[$date_from,$date_to])
                        ->get();

                     

                        foreach ($getdata as $data) {
                            $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                            $fancydata = FancyResult::where(['eventid' => $data->match_id, 'fancy_name' => $data->team_name])->first();

                        $getdata_exposer = UserExposureLog::where(['user_id' => $datac])
                        ->get();                          
                       
                        foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }                        
                        $totpamount = $totalLoss-$totalProfit;
                        

                            if($data->bet_type == 'ODDS'){
                                if($matchdata->winner == $data->team_name){
                                    $sumAmt+=$data->bet_profit;
                                }else{
                                    $sumAmt-=$data->exposureAmt;
                                }
                            }

                            if($data->bet_type == 'SESSION'){
                                if(!empty($fancydata)){
                                    if($data->bet_side=='back')
                                    {
                                        if($data->bet_odds<=$fancydata->result)
                                        {
                                            $sumAmt+=$data->bet_profit;
                                        }
                                        else if($data->bet_odds>$fancydata->result)
                                        {
                                            $sumAmt-=$data->bet_amount;
                                        }
                                    }else if($data->bet_side=='lay')
                                    {
                                        if($data->bet_odds>$fancydata->result)
                                        {
                                            $sumAmt+=$data->bet_amount;
                                        }
                                        else if($data->bet_odds<=$fancydata->result)
                                        {
                                            $sumAmt-=$data->exposureAmt;
                                        }
                                    }
                                }
                            }

                            if($data->bet_type == 'BOOKMAKER'){

                                if($matchdata->winner == $data->team_name){
                                    $sumAmt+=$data->bet_profit;
                                }else{
                                    $sumAmt-=$data->exposureAmt;
                                }
                            }
                        }
                        
                    }
                }
            }
            else
			{

                $getresult = MyBets::where(['user_id' => $value->id, 'result_declare'=>1])
                ->get();
                
                $sumAmt=0; 
                 
                if($value->agent_level == 'PL'){

                   

                    foreach ($getresult as $data) {
                        $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                        $fancydata = FancyResult::where(['eventid' => $data->match_id, 'fancy_name' => $data->team_name])->first();

                        if($data->bet_type == 'ODDS'){

                            if($matchdata->winner == $data->team_name){
                               
                                $sumAmt+=$data->bet_profit;
                            }else{
                                
                                $sumAmt-=$data->exposureAmt;
                            }
                        }

                        if($data->bet_type == 'SESSION'){
                            if(!empty($fancydata)){
                                if($data->bet_side=='back')
                                {
                                    if($data->bet_odds<=$fancydata->result)
                                    {
                                        $sumAmt+=$data->bet_profit;
                                    }
                                    else if($data->bet_odds>$fancydata->result)
                                    {
                                        $sumAmt-=$data->bet_amount;
                                    }
                                }else if($data->bet_side=='lay')
                                {
                                    if($data->bet_odds>$fancydata->result)
                                    {
                                        $sumAmt+=$data->bet_amount;
                                    }
                                    else if($data->bet_odds<=$fancydata->result)
                                    {
                                        $sumAmt-=$data->exposureAmt;
                                    }
                                }

                            }
                        }

                        if($data->bet_type == 'BOOKMAKER'){

                            if($matchdata->winner == $data->team_name){
                                $sumAmt+=$data->bet_profit;
                            }else{
                                $sumAmt-=$data->exposureAmt;
                            }
                        }
                    }
                    
                }
                else
                {
                    $x = $value->id;
                    $ans = $this->childdata($x);
                     $totpamount = 0;
                        $totalLoss = 0;
                        $totalProfit = 0;
                   
                    foreach($ans as $datac)
                    {
                        
                        $getdata = MyBets::where(['user_id' => $datac, 'result_declare'=>1])
                        ->get();

                        

                        foreach ($getdata as $data) {
                            $matchdata = Match::where('event_id', $data->match_id)->latest()->first();
                            $fancydata = FancyResult::where(['eventid' => $data->match_id, 'fancy_name' => $data->team_name])->first();
                              $getdata_exposer = UserExposureLog::where(['user_id' => $datac])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }                        
                        $totpamount = $totalLoss-$totalProfit;

                            if($data->bet_type == 'ODDS'){

                                if($matchdata->winner == $data->team_name){
                                   
                                    $sumAmt+=$data->bet_profit;
                                }else{
                                    
                                    $sumAmt-=$data->exposureAmt;
                                }
                            }
                           

                            if($data->bet_type == 'SESSION'){

                                if(!empty($fancydata)){

                                    if($data->bet_side=='back')
                                    {
                                        if($data->bet_odds<=$fancydata->result)
                                        {
                                            $sumAmt+=$data->bet_profit;
                                        }
                                        else if($data->bet_odds>$fancydata->result)
                                        {
                                            $sumAmt-=$data->bet_amount;
                                        }
                                    }else if($data->bet_side=='lay')
                                    {
                                        if($data->bet_odds>$fancydata->result)
                                        {
                                            $sumAmt+=$data->bet_amount;
                                        }
                                        else if($data->bet_odds<=$fancydata->result)
                                        {
                                            $sumAmt-=$data->exposureAmt;
                                        }
                                    }
                                }
                            }
                            
                            if($data->bet_type == 'BOOKMAKER'){

                                if($matchdata->winner == $data->team_name){
                                    $sumAmt+=$data->bet_profit;
                                }else{
                                    $sumAmt-=$data->exposureAmt;
                                }
                            }  
                        }
                        
                    }
                }
            }

            $totalAmt+=$sumAmt;
            $html.='
                <tr>
                    <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">';
                        if($value->agent_level == 'PL'){
                            $html.='<a class="ico_account text-color-blue-light" id="'.$value->id.'">
                            <span class="'.$color.' text-color-white">'.$value->agent_level.'</span>'.$value->user_name.'
                            </a>';
                        }else{
                            $html.='<a class="ico_account text-color-blue-light" id="'.$value->id.'"  onclick="subpagedata(this.id);">
                            <span class="'.$color.' text-color-white">'.$value->agent_level.'</span>'.$value->user_name.'
                            </a>';
                        }

                    $html.='</td>';

                    if($sumAmt >=0){
                        $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                    }else{
                        $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                    }

                    if($sumAmt >=0){
                        $html.='<td class="text-color-green white-bg">'.$sumAmt.'</td>';
                    }else{
                        $html.='<td class="text-color-red white-bg">'.$sumAmt.'</td>';
                    }

                    $html.='<td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>';

                    if($sumAmt >=0){
                        $html.='<td class="text-color-green white-bg">('.$sumAmt.')</td>';
                    }else{
                        $html.='<td class="text-color-red white-bg">('.$sumAmt.')</td>';
                    }

                $html.='</tr>
            ';
        }

        $html1.='
            <tr class="table-total">
                <td class="white-bg">Total</td>';
                if($totalAmt >= 0){
                    $html1.='<td class="text-color-green white-bg">'.$totalAmt.'</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">'.$totalAmt.'</td>';
                }
                
                if($totalAmt >= 0){
                    $html1.='<td class="text-color-green white-bg">'.$totalAmt.'</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">'.$totalAmt.'</td>';
                }

                $html1.='<td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>';
                
                if($totalAmt >= 0){
                    $html1.='<td class="text-color-green white-bg">('.$totalAmt.')</td>';
                }else{
                    $html1.='<td class="text-color-red white-bg">('.$totalAmt.')</td>';
                }

            $html1.='</tr>
        ';
        return $html.'~~'.$html1;
       
    }*/
    public function SubBackDetail(Request $request)
    {
        $user_id = $request->user_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        
        $crumb = User::where('id',$user_id)->first();
        $adata = $this->backdata($crumb->parentid);
        sort($adata);

        $html=''; $html1=''; $html2='';
        $html.= ''; $html1.= '';
        $totalAmt=0;
        foreach ($adata as $bread) {
           $finaldata = User::where('id', $bread)->first();
           $html1.='
            <li class="firstli" id='.$finaldata['id'].'>';
            if($finaldata['agent_level'] == 'COM'){
                $html1.='
                    <a href="profitloss-downline">
                    <span class="blue-bg text-color-white">'.$finaldata->agent_level.'</span>
                    <strong id='.$finaldata->id.'>'.$finaldata->first_name.'</strong>
                    </a> 
                    <img src="'.asset('asset/img/arrow-right2.png').'"> 
                </li>';
            }
            else{
                $html1.='
                <a>
                    <span class="blue-bg text-color-white">'.$finaldata->agent_level.'</span>
                    <strong id='.$finaldata->id.'  onclick="backpagedata(this.id);">'.$finaldata->first_name.'</strong>
                </a> 
                <img src="'.asset('asset/img/arrow-right2.png').'"> 
            </li>';
            }   
        }
       
        $user = User::where('parentid', $user_id)->get();
        $admin = Auth::user()->id;
       
        foreach ($user as $key => $row) {
            if($row->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($row->agent_level == 'AD'){
                $color = 'black-bg';
            }else if($row->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($row->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($row->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }
           
            if($date_from != '' && $date_to != ''){               
                $sumAmt=0; 
                $x = $row->id;
                $ans = $this->childdata($x);
                $totpamount = 0;
                $totalLoss = 0;
                $totalProfit = 0;
                foreach($ans as $datac)
                {
                    $getdata_exposer = UserExposureLog::where(['user_id' => $datac])
                    ->get();  
                    foreach ($getdata_exposer as $value_expo) {
                        if($value_expo->win_type=='Loss'){
                            $totalLoss += $value_expo->loss;
                        }
                        if($value_expo->win_type=='Profit'){
                            $totalProfit += $value_expo->profit;
                        }
                    }                    
                }
                $totpamount = $totalProfit-$totalLoss;
            }
            else{
                $sumAmt=0; 
                    $x = $row->id;                  
                    $ans = $this->childdata($x);

                    $totpamount = 0;
                    $totalLoss = 0;
                    $totalProfit = 0; 
                if(!empty($ans)){
                    foreach($ans as $datac)
                    {                      
                        $getdata_exposer = UserExposureLog::where(['user_id' => $datac])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }
                    }
                }else{
                      
                        $getdata_exposer = UserExposureLog::where(['user_id' => $row->id])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }
                    
                }
                
                $totpamount = $totalProfit-$totalLoss;
               
            }            
            $html.='
                <tr>
                    <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">';                       
                    $html.='<a class="ico_account text-color-blue-light" id="'.$row->id.'"  onclick="subpagedata(this.id);">
                            <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->user_name.'
                            </a>';
                    

                    $html.='</td>';
                    if($totpamount >=0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                    $html.='<td class="'.$class.' white-bg">'.abs($totpamount).'</td>';
                    
                    if($totpamount >=0){
                        $classdown="text-color-red";
                    }else{
                        $classdown="text-color-green";
                    }
                    $html.='<td class="'.$classdown.' white-bg">'.abs($totpamount).'</td>';
                    $html.='<td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>';
                    
                    $html.='<td class="'.$classdown.' white-bg">('.abs($totpamount).')</td>';
                   

                $html.='</tr>
            ';
            $totalAmt+=$totpamount;
        }
        
        $html2.='
            <tr class="table-total">
                <td class="white-bg">Total</td>';
                $html2.='<td class="white-bg">'.abs($totalAmt).'</td>';
                $html2.='<td class="white-bg">'.abs($totalAmt).'</td>';
                $html2.='<td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>';
                $html2.='<td class="white-bg">('.abs($totalAmt).')</td>';
            $html2.='</tr>';
       return $html.'~~'.$html1.'~~'.$html2;
    }
	
	function getAllChild($id)
	{
	  global $children;  
	  $subdata = User::where('parentid',$id)->get();
	  $count = count($subdata);
	  if($count > 0){
		foreach ($subdata as $key => $value) {
		  $children[$value->id] = databackend($value->id);
		}
	  }
	  return $children;
	}
    public function SubDetail(Request $request)
    {
        $user_id = $request->user_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $crumb = User::where('id',$user_id)->first();
        $user = User::where('parentid', $user_id)->get();       
        $admin = Auth::user()->id;

        $html=''; $html1=''; $html2='';
        $html.= ''; $html1.= '';

        $totalAmt=0;
        foreach ($user as $key => $row) {
            if($row->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($row->agent_level == 'AD'){
                $color = 'black-bg';
            }else if($row->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($row->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($row->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }
           
            if($date_from != '' && $date_to != '')
			{               
                    $sumAmt=0; 
                    $x = $row->id;
                    $ans = $this->childdata($x);
                    $totpamount = 0;
                    $totalLoss = 0;
                    $totalProfit = 0;                   
                    foreach($ans as $datac)
                    { 
                        $getdata_exposer = UserExposureLog::where(['user_id' => $datac])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }

                    }
                
                $totpamount = $totalLoss-$totalProfit;
            }
            else{

                    $sumAmt=0; 
                    $x = $row->id;                  
                    $ans = $this->childdata($x);

                    $totpamount = 0;
                    $totalLoss = 0;
                    $totalProfit = 0; 
                if(!empty($ans)){
                    foreach($ans as $datac)
                    {                      
                        $getdata_exposer = UserExposureLog::where(['user_id' => $datac])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }
                    }
                }else{
                      
                        $getdata_exposer = UserExposureLog::where(['user_id' => $row->id])->get();  
                            foreach ($getdata_exposer as $value) {
                            if($value->win_type=='Loss'){
                                $totalLoss += $value->loss;
                            }
                            if($value->win_type=='Profit'){
                                $totalProfit += $value->profit;
                            }
                        }
                    
                }
                
                $totpamount = $totalProfit-$totalLoss;
            }           
            $html.='
                <tr>
                <td class="white-bg"><img src="'.asset('asset/img/plus-icon.png').'">';
                $html.='<a class="ico_account text-color-blue-light" id="'.$row->id.'"  onclick="subpagedata(this.id);">
                    <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->user_name.'
                    </a>';
                $html.='</td>';

                    if($totpamount >=0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                $html.='<td class=" '.$class.' white-bg">'.abs($totpamount).'</td>';

                    if($totpamount >=0){
                       $classdown="text-color-red";
                    }else{
                       $classdown="text-color-green";
                    }
                    $html.='<td class="'.$classdown.' white-bg">'.abs($totpamount).'</td>';

                    $html.='<td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>
                    <td class="white-bg">0.00</td>';
                    $html.='<td class="'.$classdown.' white-bg">('.abs($totpamount).')</td>';

                $html.='</tr>
            ';
             $totalAmt+=$totpamount;
        }
        $html1.='
            <li class="firstli" id='.$crumb->id.'><a ><span class="blue-bg text-color-white">'.$crumb->agent_level.'</span><strong id='.$crumb->id.' onclick="backpagedata(this.id);">'.$crumb->first_name.'</strong></a> <img src="'.asset('asset/img/arrow-right2.png').'"> </li>';

        $html2.='
            <tr class="table-total">
                <td class="white-bg">Total</td>';
                $html2.='<td class="white-bg">'.abs($totalAmt).'</td>';
                $html2.='<td class=" white-bg">'.abs($totalAmt).'</td>';
                $html2.='<td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>
                <td class="white-bg">0.00</td>';                
                $html2.='<td class="white-bg">('.abs($totalAmt).')</td>';
               
            $html2.='</tr>
        ';

        return $html.'~~'.$html1.'~~'.$html2;
    }

    function backdata($id){
        $adata = array();
        do{
            $test = User::where('id',$id)->first();
            $adata[]=  $test->id;
            $first = User::orderBy('id', 'ASC')->first();
        }while($id = $test->parentid);
        return $adata;
    }
    public function betHistoryBack($id)
    {
        $getresult = MyBets::where('user_id', $id)->latest()->get();
        $user = User::where('id',$id)->first();
        return view('backpanel.downline-myaccount-history',compact('getresult','id','user'));
    }
    public function activityLog($id)
    {
      $user = User::find($id);
      return view('backpanel.downline-activityLog',compact('user','id'));
    }
    public function transactionHistory($id)
    {
     $getUserCheck = User::find($id);
     $user = User::find($id);
        if(!empty($getUserCheck)){
          $loginuser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
        }
        $credit = UserDeposit::where(['child_id' =>$loginuser->id, 'parent_id' => $loginuser->parentid])
        ->latest()
        ->get();

        $player_balance=CreditReference::where('player_id',$loginuser->id)->first();
        $player_balance=$player_balance['remain_bal'];
      return view('backpanel.transactionHistory',compact('user','id','loginuser','credit','player_balance'));
    }
    public function getBetHistoryPL(Request $request)
    {
        $val = $request->val;
        $pid = $request->pid;

        $loginUser = User::where('id', $pid)->first();
        if($val=='today')
        {
            $date_from = date('Y-m-d');
            $date_to = date("Y-m-d", strtotime("+1 day"));
        }
        else if($val=='yesterday')
        {
            $date_from = date("Y-m-d", strtotime("-1 day"));
            $date_to = date("Y-m-d");
        }
        else
        {
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }

        if($date_from != '' && $date_to != ''){

            $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1])
            ->whereBetween('created_at',[$date_from,$date_to])
            ->latest()->get();

        }else{

            $fromdate = date("Y-m-d", strtotime("-30 day"));
            $todate = date("Y-m-d");
            $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1])
            ->whereBetween('created_at',[$fromdate,$todate])
            ->latest()->get();
        }

        $html='';
        foreach($getresult as $data){
            $sports = Sport::where('sId', $data->sportID)->first();
            $matchdata = Match::where('event_id', $data->match_id)->first();
            $fancydata = FancyResult::where(['eventid' => $data->match_id, 'fancy_name' => $data->team_name])->first();
            $html.='
                <tr class="white-bg">
                    <td class="white-bg"><img src="">
                        <a class="text-color-blue-light">'.$data->id.'</a>
                    </td>
                    <td>'.$loginUser->user_name.'</td>
                    <td>'.$sports->sport_name.'<i class="fas fa-caret-right text-color-grey"></i> <b> '.$matchdata->match_name.' </b> <i class="fas fa-caret-right text-color-grey"></i> '.$data->bet_type.'</td>
                    <td class="text-right">'.$data->team_name.' </td>
                    ';
                    if($data->bet_side == 'lay'){
                        $html.='<td class="text-right" style="color: #e33a5e !important;">'.$data->bet_side.'</td>';
                    }
                    else{
                        $html.='<td class="text-right" style="color: #1f72ac !important;">'.$data->bet_side.'</td>';
                    }
                        
                    $html.='
                    <td class="text-right"> <span class="smtxt"> '.$data->created_at.'</span> </td>
                    <td class="text-right">'.$data->bet_amount.'</td>
                    <td class="text-right">'.$data->bet_odds.'</td>';
                    if($data->bet_type == 'ODDS'){

                        if($matchdata->winner == $data->team_name){
                           $html.='<td class="text-color-green text-right">('.$data->bet_profit.')</td>';
                        }else{
                            $html.='<td class="text-color-red text-right">('.$data->exposureAmt.')</td>';
                        }
                    }
                    if($data->bet_type == 'SESSION'){

                        if(!empty($fancydata)){

                            if($data->bet_side=='back')
                            {
                                if($data->bet_odds<=$fancydata->result)
                                {
                                    $html.='<td class="text-color-green text-right">('.$data->bet_profit.')</td>';
                                    
                                }
                                else if($data->bet_odds>$fancydata->result)
                                {
                                    $html.='<td class="text-color-red text-right">('.$data->bet_amount.')</td>';
                                    
                                }
                            }else if($data->bet_side=='lay')
                            {
                                if($data->bet_odds>$fancydata->result)
                                {
                                    $html.='<td class="text-color-green text-right">('.$data->bet_amount.')</td>';
                                }
                                else if($data->bet_odds<=$fancydata->result)
                                {
                                    $html.='<td class="text-color-red text-right">('.$data->exposureAmt.')</td>';
                                
                                }
                            }
                        }
                    }
                    if($data->bet_type == 'BOOKMAKER'){
                        if($matchdata->winner == $data->team_name){
                           $html.='<td class="text-color-green text-right">('.$data->bet_profit.')</td>';
                        }else{
                            $html.='<td class="text-color-red text-right">('.$data->exposureAmt.')</td>';
                        }
                    }
                    
                $html.='</tr>
            ';
        }
        return $html;
    }
    public function betHistoryPLBack($id)
    {
        $getresult = MyBets::where('user_id', $id)->latest()->get();
        $user = User::where('id',$id)->first();
        return view('backpanel.downline-myaccount-profitloss',compact('getresult','id','user'));
    }
    public function getBetHistoryPLBack(Request $request)
    {
        $val = $request->val;
        $pid = $request->pid;
        $sport = $request->sport;
        $loginUser = User::where('id', $pid)->first();
        if($val=='today')
        {
            $date_from = date('Y-m-d');
            $date_to = date("Y-m-d", strtotime("+1 day"));
        }
        else if($val=='yesterday')
        {
            $date_from = date("Y-m-d", strtotime("-1 day"));
            $date_to = date("Y-m-d");
        }
        else
        {
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }

        if($date_from != '' && $date_to != '')
        {
            $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1])
            ->whereBetween('created_at',[$date_from,$date_to])
            ->groupBy('match_id')
            ->latest()->get();
            
            if($sport != 0){
                $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1,'sportID' => $sport])
                ->whereBetween('created_at',[$date_from,$date_to])
                ->groupBy('match_id')
                ->latest()->get();
            }
        }
        else{
            if($sport == 0){
                $fromdate = date("Y-m-d", strtotime("-60 day"));
                $todate = date("Y-m-d");

                $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1])
                ->whereBetween('created_at',[$date_from,$date_to])
                ->groupBy('match_id')
                ->latest()->get();
            }
            else{
                $fromdate = date("Y-m-d", strtotime("-60 day"));
                $todate = date("Y-m-d");

                $getresult = MyBets::where(['user_id' => $pid, 'result_declare'=>1,'sportID' => $sport])
                ->whereBetween('created_at',[$date_from,$date_to])
                ->groupBy('match_id')
                ->latest()->get();
            }
        }

        $html=''; $html.= ''; $i=1; $amt=''; $amt.= ''; $totalp=0;
        
        foreach($getresult as $data){
            $sports = Sport::where('sId', $data->sportID)->first();
            $matchdata = Match::where('event_id', $data->match_id)->latest()->first();

            $subresult = MyBets::where('match_id', $data->match_id)
            ->whereBetween('created_at',[$date_from,$date_to])
            ->latest()->get();

            $sumAmt = 0;$totalAmt=0;$totalPr=0;

            $loginUser= User::where('id',$pid)->first();

            $exposer_odds=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','ODDS')->where('user_id', $loginUser->id)->first();
            if(!empty($exposer_odds))
            {
                $odds_win_type=$exposer_odds['win_type'];
                if($odds_win_type=='Profit')
                    $sumAmt=$sumAmt+$exposer_odds->profit;
                else
                    $sumAmt=$sumAmt-$exposer_odds->loss;
                $totalPr = ($sumAmt * $loginUser->commission) /100;
            }
            $exposer_bm=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','BOOKMAKER')->where('user_id', $loginUser->id)->first();
            if(!empty($exposer_bm))
            {
                $bm_win_type=$exposer_odds['win_type'];
                if($bm_win_type=='Profit')
                    $sumAmt=$sumAmt+$exposer_bm->profit;
                else
                    $sumAmt=$sumAmt-$exposer_bm->loss;
            }

            foreach($subresult as $subd1){
                $sports = Sport::where('sId', $subd1->sportID)->first();
                $matchdata1 = Match::where('event_id', $subd1->match_id)->latest()->first();

                $fancydata = FancyResult::where(['eventid' => $subd1->match_id, 'fancy_name' => $subd1->team_name])->first();


                /*if($subd1->bet_type == 'ODDS'){

                    if($matchdata1->winner == $subd1->team_name){
                        $sumAmt+=$subd1->bet_profit;
                    }else{
                        $sumAmt-=$subd1->exposureAmt;
                    }
                }*/
                if($subd1->bet_type == 'SESSION'){

                    if(!empty($fancydata)){

                        /*if($subd1->bet_side=='back')
                        {
                            if($subd1->bet_odds<=$fancydata->result)
                            {
                                $sumAmt+=$subd1->bet_profit;
                            }
                            else if($subd1->bet_odds>$fancydata->result)
                            {
                                $sumAmt-=$subd1->bet_amount;
                            }
                        }else if($subd1->bet_side=='lay')
                        {
                            if($subd1->bet_odds>$fancydata->result)
                            {
                                $sumAmt+=$subd1->bet_amount;
                            }
                            else if($subd1->bet_odds<=$fancydata->result)
                            {
                                $sumAmt-=$subd1->exposureAmt;
                            }
                        }*/

                        $exposer_fancy=UserExposureLog::where('match_id',$matchdata->id)->where('bet_type','SESSION')->where('fancy_name',$subd1->team_name)->where('user_id', $loginUser->id)->first();
                        if(!empty($exposer_fancy))
                        {
                            $fancy_win_type=$exposer_fancy['win_type'];
                            if($fancy_win_type=='Profit')
                                $sumAmt=$sumAmt+$exposer_fancy->profit;
                            else
                                $sumAmt=$sumAmt-$exposer_fancy->loss;
                        }
                    }

                }

                /*if($subd1->bet_type == 'BOOKMAKER'){
                    if($matchdata1->winner == $subd1->team_name){
                        $sumAmt+=$subd1->bet_profit;
                    }else{
                        $sumAmt-=$subd1->exposureAmt;
                    }
                }*/
                
            }

            $totalPr = ($sumAmt * $loginUser->commission) /100;

            $totalAmt = $sumAmt;

            $totalp+=$sumAmt;

            $html.='

            <tr class="white-bg">
                <td>'.$sports->sport_name.' <i class="fas fa-caret-right text-color-grey"></i> <b> '.$matchdata->match_name.' </b> </td>
                
                <td class="text-right">'.$matchdata->match_date.'</td>
                <td class="text-right">'.$matchdata->created_at.'</td>
               <td class="text-right"><a href="#collapse'.$i.'" data-toggle="collapse" aria-expanded="false" class="text-color-black">'.$totalAmt.'<img src="'.asset('asset/img/plus-icon.png').'"></a> </td>
            </tr>';
           
            $html.='<tr class="expand-block light-grey-bg-3 list-unstyled collapse" id="collapse'.$i.'">
                <td colspan="4">
                <img src="'.asset('img/arrow-down1.png').'" class="expandarrow">
                <table class="table-commission">
                    <thead>
                        <tr>
                            <th width="9%">Bet ID</th>
                            <th width="">Selection</th>
                            <th width="9%">Odds</th>
                            <th width="13%">Stake</th>
                            <th width="8%">Type</th>
                            <th width="16%">Placed</th>
                            <th width="23%">Profit/Loss</th>
                        </tr>
                    </thead>
                <tbody>';

                foreach($subresult as $subd){
                    $sports = Sport::where('sId', $subd->sportID)->first();
                    $matchdata2 = Match::where('event_id', $subd->match_id)->latest()->first();

                    $fancydata = FancyResult::where(['eventid' => $subd->match_id, 'fancy_name' => $subd->team_name])->first();

                    $html.='
                            <tr class="light-grey-bg-4">
                                <td>'.$subd->id.'</td>
                                <td>'.$subd->team_name.'</td>
                                <td>'.$subd->bet_odds.'</td>
                                <td>'.$subd->bet_amount.'</td>';
                                if($subd->bet_side == 'lay'){
                                    $html.='<td class="text-color-red"><span>'.$subd->bet_side.'</span></td>';
                                }else{
                                    $html.='<td class="text-color-blue-light"><span>'.$subd->bet_side.'</span></td>';
                                }

                                $html.='<td>'.$subd->created_at.' </td>';
                          

                                if($subd->bet_type == 'ODDS'){

                                    if($matchdata2->winner == $subd->team_name){
                                       $html.='<td class="text-color-green">('.$subd->bet_profit.')</td>';
                                    }else{
                                        $html.='<td class="text-color-red">('.$subd->exposureAmt.')</td>';
                                    }
                                }
                                if($subd->bet_type == 'SESSION'){

                                    if(!empty($fancydata)){

                                        if($subd->bet_side=='back')
                                        {
                                            if($subd->bet_odds<=$fancydata->result)
                                            {
                                                $html.='<td class="text-color-green">('.$subd->bet_profit.')</td>';
                                                
                                            }
                                            else if($subd->bet_odds>$fancydata->result)
                                            {
                                                $html.='<td class="text-color-red">('.$subd->bet_amount.')</td>';
                                                
                                            }
                                        }else if($subd->bet_side=='lay')
                                        {
                                            if($subd->bet_odds>$fancydata->result)
                                            {
                                                $html.='<td class="text-color-green">('.$subd->bet_amount.')</td>';
                                            }
                                            else if($subd->bet_odds<=$fancydata->result)
                                            {
                                                $html.='<td class="text-color-red">('.$subd->exposureAmt.')</td>';
                                            
                                            }
                                        }
                                    }

                                }
                                if($subd->bet_type == 'BOOKMAKER'){
                                    if($matchdata2->winner == $subd->team_name){
                                       $html.='<td class="text-color-green">('.$subd->bet_profit.')</td>';
                                    }else{
                                        $html.='<td class="text-color-red">('.$subd->exposureAmt.')</td>';
                                    }
                                }
                    $html.='</tr>';
                }
            $html.='</tbody>
                </table>
            </td>
        </tr>';
        $i++;
        }
        $amt.=''.$totalp.'';
        return $html.'~~'.$amt;
    }
}