<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Sport;
use App\MyBets;
use Redirect;
use Auth;
use DB;
use Carbon\Carbon;

class BetListController extends Controller
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
      $sports = Sport::where('status','active')->get();
      return view('backpanel/betlist',compact('sports'));
    }
    public function getHistory(Request $request )
    {
	 	$loginuser = Auth::user(); 
	  //get all child of agent
	  $loginUser = Auth::user();
	  $ag_id=$loginUser->id;
      $all_child = $this->GetChildofAgent($ag_id);
	  
      $val = $request->val;
      $sportId = $request->sport;
           
      $date_from = $request->date_from;
      $date_to = $request->date_to;     
          
      $html='';
      if($sportId=='all'){
        if($val=='today'){
        $date_from = date('Y-m-d');
        $date_to = date("Y-m-d", strtotime("+1 day"));
        }else{
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        }
       
        if($date_from != '' && $date_to != ''){   
          $getresult = MyBets::select('users.user_name','users.parentid','my_bets.id','my_bets.sportID','my_bets.created_at','match.match_name','match.winner','my_bets.bet_type','my_bets.bet_side','my_bets.bet_odds','my_bets.bet_amount','my_bets.bet_profit','my_bets.team_name')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')->whereBetween('my_bets.created_at', [$date_from, $date_to])->where('my_bets.result_declare',1)
		  ->where('my_bets.isDeleted',0)
		  ->whereIn('user_id', $all_child)
		  ->orderBy('my_bets.id','Desc')->get();
      }else{
          $getresult = MyBets::select('users.user_name','users.parentid','my_bets.id','my_bets.sportID','my_bets.created_at','match.match_name','match.winner','my_bets.bet_type','my_bets.bet_side','my_bets.bet_odds','my_bets.bet_amount','my_bets.bet_profit','my_bets.team_name')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')->where('my_bets.result_declare',1)
		  ->where('my_bets.isDeleted',0)
		  ->whereIn('user_id', $all_child)
		  ->orderBy('my_bets.id','Desc')->get();
      }
      }else{
        if($val=='today'){
        $date_from = date('Y-m-d');
        $date_to = date("Y-m-d", strtotime("+1 day"));
        }else{
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        }       
		
        $getresult = MyBets::select('users.user_name','users.parentid','my_bets.id','my_bets.sportID','my_bets.created_at','match.match_name','match.winner','my_bets.bet_type','my_bets.bet_side','my_bets.bet_odds','my_bets.bet_amount','my_bets.bet_profit','my_bets.team_name')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')->where('my_bets.sportID',$sportId)
  		->whereBetween('my_bets.created_at', [$date_from, $date_to])->where('my_bets.result_declare',1)
  		->where('my_bets.isDeleted',0)
		->whereIn('user_id', $all_child)
  		->orderBy('my_bets.id','Desc')->get();
		
      }
      $html.=' <table class="table custom-table white-bg text-color-blue-2" >
         <thead>
              <tr>';
				  if($loginuser->agent_level == 'MDL'){
				  	$html.='<th class="light-grey-bg">MDL</th>';
				  }
				  elseif($loginuser->agent_level == 'SMDL'){
				  	$html.='<th class="light-grey-bg">MDL</th>
					<th class="light-grey-bg">DL</th>';
				  }
				  elseif($loginuser->agent_level == 'AD'){
				  	$html.='<th class="light-grey-bg">SP</th>
				  	<th class="light-grey-bg">SMDL</th>
					<th class="light-grey-bg">MDL</th>
					<th class="light-grey-bg">DL</th>';
				  }
                  elseif($loginuser->agent_level == 'SP'){
				  	$html.='<th class="light-grey-bg">SMDL</th>
					<th class="light-grey-bg">MDL</th>
					<th class="light-grey-bg">DL</th>'; 
				  }
				  
				  $html.='<th class="light-grey-bg">PL ID</th>
                  <th class="light-grey-bg">Bet ID</th>
                  <th class="light-grey-bg">Bet placed</th>
                  <th class="light-grey-bg">Market</th>
                  <th class="light-grey-bg">Selection</th>
                  <th class="light-grey-bg">Type</th>
                  <th class="light-grey-bg">Odds req.</th>
                  <th class="light-grey-bg">Stake</th>
                  <th class="light-grey-bg">Profit/Loss</th>
              </tr>
          </thead>
      <tbody >';
      foreach ($getresult as $value) {
        $sportName='';
        if($value->sportID==4){
          $sportName = 'CRICKET';
        }elseif($value->sportID==2){
          $sportName = 'TENNIS';
        }elseif($value->sportID==1){
          $sportName = 'SOCCER';
        }
        $class="text-color-red";
        if($value->team_name == $value->winner){
          $class="text-color-green";
        }
		
		$parent = User::find($value->parentid);
		
		$ag_level=$parent->agent_level;
		$ag_name=$parent->user_name;
		
		$sp=$smld=$mdl=$dl='-';
		if($ag_level=='SP')
			$sp=$ag_name;
		else if($ag_level=='SMDL')
			$smld=$ag_name;
		else if($ag_level=='MDL')
			$mdl=$ag_name;
		else if($ag_level=='DL')
			$dl=$ag_name;
			
		$agent_tr='';	
		if($loginuser->agent_level == 'MDL'){
			$agent_tr.='<td class="white-bg">'.ucfirst($mdl).'</td>';
		}
		elseif($loginuser->agent_level == 'SMDL'){
			$agent_tr.='<td class="white-bg">'.ucfirst($mdl).'</td>
			<td class="white-bg">'.ucfirst($dl).'</td>';
		}
		elseif($loginuser->agent_level == 'AD'){
			$agent_tr.='<td class="white-bg">'.ucfirst($sp).'</td>
			 <td class="white-bg">'.ucfirst($smld).'</td>
			<td class="white-bg">'.ucfirst($mdl).'</td>
			<td class="white-bg">'.ucfirst($dl).'</td>';
		}
        elseif($loginuser->agent_level == 'SP'){
			$agent_tr.=' <td class="white-bg">'.ucfirst($smld).'</td>
			<td class="white-bg">'.ucfirst($mdl).'</td>
			<td class="white-bg">'.ucfirst($dl).'</td>'; 
		}	
		
        $html.=' <tr>
		  '.$agent_tr.'
          <td class="white-bg">'.ucfirst($value->user_name).'</td>
          <td class="white-bg"><a class="text-color-blue-light">'.$value->id.'</a></td>
          <td class="white-bg sm_txt">'.date('Y-m-d', strtotime($value->created_at)).' <br> '.date('H:i:s', strtotime($value->created_at)).'</td>
          <td class="white-bg">
              '.$sportName.' <i class="fas fa-caret-right text-color-grey"></i> <strong>'.$value->match_name.'</strong> <i class="fas fa-caret-right text-color-grey"></i>'.$value->bet_type.'
          </td>
          <td class="white-bg"><a class="text-color-blue-light">'.$value->team_name.'</a></td>';
		  if($value->bet_type=='SESSION')
		  {
			  if($value->bet_side=='back')
			 	 $html.='<td class="white-bg text-color-blue-light bet_type_uppercase">yes</td>';
			  else
			  	$html.='<td class="white-bg text-color-red bet_type_uppercase">no</td>';
		  }
		  else
		  {
          	if($value->bet_side=='back')
				$html.='<td class="white-bg text-color-blue-light bet_type_uppercase">'.$value->bet_side.'</td>';
			else
				$html.='<td class="white-bg text-color-red bet_type_uppercase">'.$value->bet_side.'</td>';
		  }
          $html.='<td class="white-bg">'.$value->bet_odds.'</td>
          <td class="white-bg">'.$value->bet_amount.'</td>
          <td class="'.$class.' white-bg ">('.$value->bet_profit.')</td>
      </tr>';
      }
    $html.=' </tbody>
      </table>
      <section>
          <div class="container">
              <div class="pagination-wrap light-grey-bg-1 mb-4">
                  <p>Bet List is shown net of commission.</p>
                  <ul class="pages">
                      <li id="prev"><a class="disable disable-bg disable-color">Prev</a></li>
                      <li id="pageNumber"><a class="active text-color-yellow">1</a></li>
                      <li id="next"><a class="">Next</a></li>
                  </ul>
              </div>
          </div>
      </section>';
      return response()->json(array('result'=> 'success','html'=>$html));      
    }
    public function betlistlive()
    {
      $sports = Sport::where('status','active')->get();
      $loginUser=Auth::user();
      return view('backpanel/betlistlive',compact('sports','loginUser'));
    }
    public function backdata($id)
    {
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
    public function getHistorylive(Request $request )
    {
      $val = $request->val;
      $sportId = $request->sport;
      $html=''; 
	  
	  //get all child of agent
	  $loginUser = Auth::user();
	  $ag_id=$loginUser->id;
      $all_child = $this->GetChildofAgent($ag_id);
	     
      if($sportId=='all'){
        $getresult = MyBets::select('users.user_name','my_bets.id','my_bets.sportID','my_bets.created_at','match.match_name','my_bets.bet_type','my_bets.exposureAmt','my_bets.bet_side','my_bets.bet_odds','my_bets.bet_amount','my_bets.bet_profit','my_bets.team_name','my_bets.user_id')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')
    	  ->where('my_bets.result_declare',0)
		  ->whereIn('user_id', $all_child)
		  ->where('my_bets.isDeleted',0)
    	  ->orderBy('my_bets.id','Desc')->get();
      }else{
        $getresult = MyBets::select('users.user_name','my_bets.id','my_bets.sportID','my_bets.created_at','match.match_name','my_bets.bet_type','my_bets.exposureAmt','my_bets.bet_side','my_bets.bet_odds','my_bets.bet_amount','my_bets.bet_profit','my_bets.team_name','my_bets.user_id')->join('users','users.id','=','my_bets.user_id')->join('match','match.event_id','=','my_bets.match_id')
  		 ->where('my_bets.sportID',$sportId)->where('my_bets.result_declare',0)
  		 ->where('my_bets.isDeleted',0)
		 ->whereIn('user_id', $all_child)
		 ->orderBy('my_bets.id','Desc')->get();
      }      
      foreach ($getresult as $value) {
        $sportName='';
        if($value->sportID==4){
          $sportName = 'CRICKET';
        }elseif($value->sportID==2){
          $sportName = 'TENNIS';
        }elseif($value->sportID==1){
          $sportName = 'SOCCER';
        }
        $getUser = User::where('id',$value->user_id)->first();
       
        $getUserparent = User::where('id',$getUser->parentid)->first();
        $ad='-';
        $sp='-';
        $smdl='-';
        $mdl='-';
        $dl='-';
        $com='-';
        if($getUserparent->agent_level =='AD'){
          $ad = $getUserparent->user_name;
        }elseif($getUserparent->agent_level =='SP'){
          $sp = $getUserparent->user_name;
        }elseif($getUserparent->agent_level =='SMDL'){
          $smdl = $getUserparent->user_name;
        }elseif($getUserparent->agent_level =='MDL'){
          $mdl = $getUserparent->user_name;
        }elseif($getUserparent->agent_level =='DL'){
          $dl = $getUserparent->user_name;
        }elseif($getUserparent->agent_level =='COM'){
          $com = $getUserparent->user_name;
        }
        if(!empty($getUserparent->parentid)){
        $getUserparent2 = User::where('id',$getUserparent->parentid)->first();
         if($getUserparent2->agent_level =='AD'){
          $ad = $getUserparent2->user_name;
        }elseif($getUserparent2->agent_level =='SP'){
          $sp = $getUserparent2->user_name;
        }elseif($getUserparent2->agent_level =='SMDL'){
          $smdl = $getUserparent2->user_name;
        }elseif($getUserparent2->agent_level =='MDL'){
          $mdl = $getUserparent2->user_name;
        }elseif($getUserparent2->agent_level =='DL'){
          $dl = $getUserparent2->user_name;
        }elseif($getUserparent2->agent_level =='COM'){
          $com = $getUserparent2->user_name;
        }
      }

      if(!empty($getUserparent2->parentid)){
        $getUserparent3 = User::where('id',$getUserparent2->parentid)->first();
         if($getUserparent3->agent_level =='AD'){
          $ad = $getUserparent3->user_name;
        }elseif($getUserparent3->agent_level =='SP'){
          $sp = $getUserparent3->user_name;
        }elseif($getUserparent3->agent_level =='SMDL'){
          $smdl = $getUserparent3->user_name;
        }elseif($getUserparent3->agent_level =='MDL'){
          $mdl = $getUserparent3->user_name;
        }elseif($getUserparent3->agent_level =='DL'){
          $dl = $getUserparent3->user_name;
        }elseif($getUserparent3->agent_level =='COM'){
          $com = $getUserparent3->user_name;
        }
      }

       if(!empty($getUserparent3->parentid)){
        $getUserparent4 = User::where('id',$getUserparent3->parentid)->first();

         if($getUserparent4->agent_level =='AD'){
          $ad = $getUserparent4->user_name;
        }elseif($getUserparent4->agent_level =='SP'){
          $sp = $getUserparent4->user_name;
        }elseif($getUserparent4->agent_level =='SMDL'){
          $smdl = $getUserparent4->user_name;
        }elseif($getUserparent4->agent_level =='MDL'){
          $mdl = $getUserparent4->user_name;
        }elseif($getUserparent4->agent_level =='DL'){
          $dl = $getUserparent4->user_name;
        }elseif($getUserparent4->agent_level =='COM'){
          $com = $getUserparent4->user_name;
        }
      }
        $loginUser=Auth::user();
        $html.=' <tr>';
        if($loginUser->agent_level=='COM'){
          $html.='<td class="white-bg">'.$com.'</td>';
        }
        if($loginUser->agent_level=='AD' || $loginUser->agent_level=='COM'){
            $html.='<td class="white-bg">'.$ad.'</td>';
          }
          if($loginUser->agent_level=='SP' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD'){
             $html.='<td class="white-bg">'.$sp.'</td>';
           }
           if($loginUser->agent_level=='SMDL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP'){
                 $html.='<td class="white-bg">'.$smdl.'</td>';
            }
            if($loginUser->agent_level=='MDL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP' || $loginUser->agent_level=='SMDL'){
                 $html.='<td class="white-bg">'.$mdl.'</td>';
               }
               if($loginUser->agent_level=='DL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP' || $loginUser->agent_level=='SMDL' || $loginUser->agent_level=='MDL'){
                  $html.='<td class="white-bg">'.$dl.'</td>';
                }
                
           $html.='<td class="white-bg">'.$getUser->user_name.'</td>
            <td class="white-bg">'.$value->id.'</td>
            <td class="white-bg sm_txt">'.date('Y-m-d', strtotime($value->created_at)).' <br> '.date('H:i:s', strtotime($value->created_at)).'</td>
            <td class="white-bg">
                '.$sportName.' <i class="fas fa-caret-right text-color-grey"></i> <strong>'.$value->match_name.'</strong> <i class="fas fa-caret-right text-color-grey"></i>'.$value->bet_type.'
            </td>
            <td class="white-bg"><a class="text-color-blue-light">'.$value->team_name.'</a></td>';
            if($value->bet_type=='SESSION')
			{
				if($value->bet_side=='back')
					$html.=' <td class="white-bg text-color-blue-light bet_type_uppercase">yes</td>';
				else
					$html.=' <td class="white-bg text-color-red bet_type_uppercase">no</td>';
			}
			else
			{
				if($value->bet_side=='back')
					$html.=' <td class="white-bg text-color-blue-light bet_type_uppercase">'.$value->bet_side.'</td>';
				else
					$html.=' <td class="white-bg text-color-red bet_type_uppercase">'.$value->bet_side.'</td>';
			}
            $html.='<td class="white-bg">'.$value->bet_odds.'</td>
            <td class="white-bg">'.$value->bet_amount.'</td>
            <td class="text-color-red white-bg">'.$value->exposureAmt.'</td>
        </tr>';
      }
    return response()->json(array('result'=> 'success','html'=>$html));      
  }
}
