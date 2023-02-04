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
use App\setting;
use App\Match;
use App\UserExposureLog;

class RestrictionController extends Controller
{
    public function suspend_pa(Request $request)
    {
    	$user_id = $request->user_id;
    	$pw  = $request->password;
    	$status = $request->status;
    	$adminpass = Auth::user()->password;
        $data = User::where('id',$user_id)->first();

        if(empty($pw)){
            return response()->json(array('result'=> 'error'));
        }

    	if (Hash::check($pw, $adminpass)) 
    	{ 
            if($data->agent_level=='PL'){
                User::where('id', $user_id)->update(['status' =>$status]);
                //return response()->json(array('result'=> 'success'));
            }
            else{
                $x = $data->id;
                User::where('id', $x)->update(['status' =>$status]);

                //$ans = $this->data($x,$status);
                $ans = $this->childdata1($x);
                foreach ($ans as $key => $value) {
                    //echo $status;
                    User::where('id', $value)->update(['status' =>$status]);
                }
            }
            return response()->json(array('result'=> 'success'));
    	}
    	else
    	{
        	return response()->json(array('result'=> 'error'));
        }
    }

    function childdata1($id)
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

    function data($id,$status)
    {
        do {
            $subdata = User::where('parentid',$id)->get();
            foreach ($subdata as $key => $value) {
                User::where('id', $value->id)->update(['status' =>$status]);
            }

            $last = User::orderBy('id', 'DESC')->first();
          $id++;
        } while ($id <= $last->id);
       return 'done'; 
    }

    function datacli($id)
    {
        $adata = array();
        do {
            $subdata = User::where('parentid',$id)->where('agent_level','!=','PL')->get();
            $subdatacounta = User::where('parentid',$id)->where('agent_level','!=','PL')->count();
            foreach ($subdata as $key => $value) {
                $adata[]=  $value->id;
            }

            $last = User::orderBy('id', 'DESC')->first();
          $id++;
        } while ($subdatacounta != 0);
       return $adata;
    }

    function dataclient($id)
    {
        $adata = array();
        do {
            $subdata = User::where('parentid',$id)->get();
            $subdatacount = User::where('parentid',$id)->count();
            foreach ($subdata as $key => $value) {
                $adata[]=  $value->id;
            }

            $last = User::orderBy('id', 'DESC')->first();
          $id++;
        } while ($subdatacount != 0);
       return $adata;
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

    /*function subuser($id)
    {
        echo $id;
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

    public function agentSubDetail(Request $request)
    {
        $user_id = $request->user_id;
        $crumb = User::where('id',$user_id)->first();
        $user = User::where('parentid', $user_id)->get();
        $admin = Auth::user()->id;

        $html=''; $html1='';$html2='';
        $html.= ''; $html1.= ''; $html2.= ''; $passexp='';

        foreach ($user as $key => $row) 
        {
        // calculation
            $totalClientBal=0;
            $totalAgentBal=0;
            $totalExposure=0;
            $cumulative_pl=0;
            $total_Player_exposer=0;
            $total_ref_pl=0;
            $exposure_cli=0;
            $cumulative_pl_cli=0;

                $x = $row->id;
                $sum_credit=0;
                $credit_datamn = CreditReference::where('player_id',$row->id)->first();

                //$sum_credit+= $credit_datamn->credit;
				$sum_credit= $credit_datamn->credit;

                $credit_datacli = CreditReference::where('player_id',$row->id)->select('remain_bal','exposure')->first();
                $remain_bal_cli='';

                if(!empty($credit_datacli)){
                    $remain_bal_cli = $credit_datacli->remain_bal;
                    $exposure_cli = $credit_datacli->exposure;
                }

                $cumulative_pl_profit = UserExposureLog::where('user_id',$row->id)->where('win_type','Profit')->sum('profit');
                $cumulative_pl_loss = UserExposureLog::where('user_id',$row->id)->where('win_type','Loss')->sum('loss');  
                $cumulative_pl_cli=$cumulative_pl_profit-$cumulative_pl_loss;

            $dataResult =  $this->datacli($row->id);
            foreach ($dataResult as $value) { 
                $subdata = User::where('id',$value)->first();
                if($subdata->agent_level=='PL'){
                    $credit_data = CreditReference::where('player_id',$subdata->id)->select('remain_bal','exposure')->first();                
                    if(!empty($credit_data)){
                        $totalExposure += $credit_data->exposure;                          
                    }
                }else{

                    $credit_data = CreditReference::where('player_id',$subdata->id)->select('available_balance_for_D_W')->first();                
                    if(!empty($credit_data)){
                        $totalAgentBal += $credit_data->available_balance_for_D_W;
                    }
                }
            }

            $dataResultclient =  $this->dataclient($row->id);
            $cliarray = array();               
                foreach ($dataResultclient as $value) {           
                    $subdata = User::where('id',$value)->first();
                    if($subdata->agent_level=='PL'){
                        $cliarray[] = $subdata->id;
                        $credit_dataclient = CreditReference::where('player_id',$subdata->id)->select('remain_bal','exposure')->first();                

                        if(!empty($credit_dataclient)){
                            $totalClientBal += $credit_dataclient->remain_bal;
                            $total_Player_exposer+=$credit_dataclient->exposure;

                            /*echo "--v ".$totalClientBal;

                            exit;*/
                        }                        

                        //calculating cumulative p/l

                        $cumulative_pl=0;

                        $cumulative_pl_profit = UserExposureLog::where('user_id',$subdata->id)->where('win_type','Profit')->sum('profit');

                        $cumulative_pl_loss = UserExposureLog::where('user_id',$subdata->id)->where('win_type','Loss')->sum('loss');  

                        $cumulative_pl=$cumulative_pl_profit-$cumulative_pl_loss;
                    }
                }


                $credit_data = CreditReference::where('player_id',$row->id)->select('available_balance_for_D_W')->first();
                $availableBalance=''; $total_calculated_available_balance=0;

                if(!empty($credit_data)){
                    $availableBalance = $credit_data->available_balance_for_D_W;
                }

                $credit_data = CreditReference::where('player_id',$row->id)->select('remain_bal')->first();
                $remain_bal=''; 

                if(!empty($credit_data)){
                    $remain_bal = $credit_data->remain_bal;
                }

        // end calculation    

            if($row->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($row->agent_level == 'AD'){
                $color = 'pink-bg';
            }else if($row->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($row->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($row->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }

            if($row->agent_level == 'PL'){
                $html2.='
                <tr>
                    <td class="align-L white-bg">';
                        $html2.='<a class="ico_account text-color-blue-light" id="'.$row->id.'">
                            <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->first_name.' ['.$row->user_name.']
                        </a>
                    </td>
                    <td class="white-bg">'.$sum_credit.'</td>

                    <td class="white-bg">'.number_format($remain_bal_cli,2, '.', '').'</td>';

                    $html2.='<td class="white-bg text-color-red" style="display:table-cell;">('.number_format($exposure_cli,2, '.', '').')</td>';

                    $credit_data = CreditReference::where('player_id',$row->id)->first();
                    $credit=0;
                    if(!empty($credit_data['credit'])){
                        $credit = $credit_data['credit'];
                    }
                    $total_calculated_available_balance=$availableBalance+$totalAgentBal+$totalClientBal;

                    $refPL = $credit-(int)$remain_bal_cli;
                    if($refPL < 0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                    $total_ref_pl+=$cumulative_pl;

                    $html2.='<td class="white-bg '.$class.'">('.number_format(abs($refPL),2, '.', '').')</td>
                    <td class="white-bg">('.number_format(abs($cumulative_pl_cli),2, '.', '').')</td>

                    <td class="white-bg" style="display: table-cell;"> 
                    ';

                    if($row->status == 'active'){
                        $html2.='<span class="status-active light-green-bg text-color-green"><span class="round-circle green-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    if($row->status == 'suspend'){
                        $html2.='<span class="status-suspended light-red-bg text-color-red"><span class="round-circle red-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }
                    
                    if($row->status == 'locked'){
                        $html2.='<span class="status-locked light-blue-bg-2 text-color-darkblue"><span class="round-circle darkblue-bg1"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    $html2.='
                    </td>';
                    if($admin == $row->id){
                        $html2.='
                        <td class="white-bg">
                            <ul class="action-ul">
                                <li><a class="grey-gradient-bg setting" data-toggle="modal" data-target="#myStatus" data-id="'.$row->id.'" data-username="'.$row->user_name.'" data-agent="'.$row->agent_level.'" data-status="'.$row->status.'"><img src="'.asset('asset/img/setting-icon.png').'"></a></li>
                                <li><a class="grey-gradient-bg" href="changePass'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                            </ul>
                        </td>';
                    }

                    else{
                        $html2.='
                        <td class="white-bg">
                            <ul class="action-ul">
                                <li><a class="grey-gradient-bg" href="changePass/'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                                <li><a class="grey-gradient-bg" href="betHistoryBack/'.$row->id.'"><img src="'.asset('asset/img/updown-arrow-icon.png').'"></a>
                                </li>
                                <li><a class="grey-gradient-bg" href="betHistoryPLBack/'.$row->id.'"><img src="'.asset('asset/img/history-icon.png').'"></a>
                                </li>
                            </ul>
                        </td>';
                    }
                $html2.='</tr>';
            }
            else{
                $html.='
                <tr>
                    <td class="align-L white-bg">';

                        $html.='<a class="ico_account text-color-blue-light" id="'.$row->id.'"   onclick="subpagedata(this.id);">
                            <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->first_name.' ['.$row->user_name.']
                        </a>';

                    $credit_data = CreditReference::where('player_id',$row->id)->first();
                    $credit=0;
                    if(!empty($credit_data['credit'])){
                        $credit = $credit_data['credit'];
                    }
                $total_calculated_available_balance=$availableBalance+$totalAgentBal+$totalClientBal;
                    $html.='</td>

                    <td class="white-bg">'.$sum_credit.'</td>
                    <td class="white-bg">'.number_format($availableBalance,2, '.', '').'</td>
                    <td class="white-bg">'.number_format($totalAgentBal,2, '.', '').'</td>
                    <td class="white-bg">'.number_format($totalClientBal,2, '.', '').'</td>
                    <td class="white-bg">'.number_format($total_calculated_available_balance,2, '.', '').'</td>';
                    $html.='<td class="white-bg text-color-red" style="display:table-cell;">('.number_format($total_Player_exposer,2, '.', '').')</td>';
                    $refPL = $credit-(int)$total_calculated_available_balance;
                    if($refPL < 0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                    $total_ref_pl+=$cumulative_pl;

                    $html.='<td class="white-bg '.$class.'">('.number_format(abs($refPL),2, '.', '').')</td>
                    <td class="white-bg">('.number_format(abs($cumulative_pl),2, '.', '').')</td>

                    <td class="white-bg" style="display: table-cell;"> 
                    ';

                    if($row->status == 'active'){
                        $html.='<span class="status-active light-green-bg text-color-green"><span class="round-circle green-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    if($row->status == 'suspend'){
                        $html.='<span class="status-suspended light-red-bg text-color-red"><span class="round-circle red-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    if($row->status == 'locked'){
                        $html.='<span class="status-locked light-blue-bg-2 text-color-darkblue"><span class="round-circle darkblue-bg1"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    $html.='
                    </td>';

                    if($admin == $row->id){
                        $html.='
                        <td class="white-bg">
                            <ul class="action-ul">

                                <li><a class="grey-gradient-bg setting" data-toggle="modal" data-target="#myStatus" data-id="'.$row->id.'" data-username="'.$row->user_name.'" data-agent="'.$row->agent_level.'" data-status="'.$row->status.'"><img src="'.asset('asset/img/setting-icon.png').'"></a></li>

                                <li><a class="grey-gradient-bg" href="changePass'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                            </ul>
                        </td>';
                    }

                    else{
                        $html.='
                        <td class="white-bg">
                            <ul class="action-ul">
                                <li><a class="grey-gradient-bg" href="changePass/'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                            </ul>
                        </td>';
                    }
                $html.='</tr>';
            }
        }
        $html1.='
            <li class="firstli" id='.$crumb->id.'><a ><span class="blue-bg text-color-white">'.$crumb->agent_level.'</span><strong id='.$crumb->id.' onclick="backpagedata(this.id);">'.$crumb->user_name.'</strong></a> <img src="'.asset('asset/img/arrow-right2.png').'">
            </li>';

        return $html.'~~'.$html1.'~~'.$html2;
    }

    public function agentSubBackDetail(Request $request)
    {
        $user_id = $request->user_id;
        $crumb = User::where('id',$user_id)->first();
        $adata = $this->backdata($crumb->parentid);
        sort($adata);

        $html=''; $html1=''; $html2='';
        $html.= ''; $html1.= ''; $html2.= '';

        foreach ($adata as $bread) {
           $finaldata = User::where('id', $bread)->first();
           $html1.='

            <li class="firstli" id='.$finaldata['id'].'>';
            if($finaldata['agent_level'] == 'COM'){
                $html1.='
                    <a href="home">
                    <span class="blue-bg text-color-white">'.$finaldata->agent_level.'</span>
                    <strong id='.$finaldata->id.'>'.$finaldata->user_name.'</strong>
                    </a> 
                    <img src="'.asset('asset/img/arrow-right2.png').'"> 
                </li>';
            }

            else{
                $html1.='
                <a>
                    <span class="blue-bg text-color-white">'.$finaldata->agent_level.'</span>
                    <strong id='.$finaldata->id.'  onclick="backpagedata(this.id);">'.$finaldata->user_name.'</strong>
                </a> 
                <img src="'.asset('asset/img/arrow-right2.png').'"> 
            </li>';
            }
        }

    
        $user = User::where('parentid', $user_id)->get();
        $admin = Auth::user()->id;

        foreach ($user as $key => $row) {
            $total_ref_pl=0;
            $totalClientBal=0;
            $totalAgentBal=0;
            $totalExposure=0;
            $cumulative_pl=0;
            $total_Player_exposer=0;
            // calculation

            $x = $row->id;
            $ans = $this->childdata($x);
            $sum_credit=0;
            $credit_datamn = CreditReference::where('player_id',$row->id)->first();
            $sum_credit+= $credit_datamn->credit;

            foreach($ans as $datac)
            {
                $credit_data1 = CreditReference::where('player_id',$datac)->first();
                //$sumAmt+= $credit_data1->exposure;
                $sum_credit+= $credit_data1->credit;
            }

            $dataResult = $this->datacli($row->id);
            foreach ($dataResult as $value) { 
                    $subdata = User::where('id',$value)->first();
                    if($subdata->agent_level=='PL'){
                        $credit_data = CreditReference::where('player_id',$subdata->id)->select('remain_bal','exposure')->first();                
                        if(!empty($credit_data)){
                            $totalExposure += $credit_data->exposure;                          
                        }
                    }else{

                        $credit_data = CreditReference::where('player_id',$subdata->id)->select('available_balance_for_D_W')->first();                
                        if(!empty($credit_data)){
                            $totalAgentBal += $credit_data->available_balance_for_D_W;
                        }
                    }
                }
            $dataResultclient = $this->dataclient($row->id); 

            $cliarray = array();               
                foreach ($dataResultclient as $value) { 
                    $subdata = User::where('id',$value)->first();
                    if($subdata->agent_level=='PL'){
                        $cliarray[] = $subdata->id;
                        $credit_dataclient = CreditReference::where('player_id',$subdata->id)->select('remain_bal','exposure')->first();                

                        if(!empty($credit_dataclient)){
                            $totalClientBal += $credit_dataclient->remain_bal;
                            $total_Player_exposer+=$credit_dataclient->exposure;
                            /*echo "--v ".$totalClientBal;

                            exit;*/
                        }

                        //calculating cumulative p/l

                        $cumulative_pl=0;
                        $cumulative_pl_profit = UserExposureLog::where('user_id',$subdata->id)->where('win_type','Profit')->sum('profit');
                        $cumulative_pl_loss = UserExposureLog::where('user_id',$subdata->id)->where('win_type','Loss')->sum('loss');  
                        $cumulative_pl=$cumulative_pl_profit-$cumulative_pl_loss;
                    }
                }

            $credit_data = CreditReference::where('player_id',$row->id)->select('available_balance_for_D_W')->first();
                $availableBalance=''; $total_calculated_available_balance=0;
                if(!empty($credit_data)){
                    $availableBalance = $credit_data->available_balance_for_D_W;
                }

                $credit_data = CreditReference::where('player_id',$row->id)->select('remain_bal')->first();
                $remain_bal=''; 
                if(!empty($credit_data)){
                    $remain_bal = $credit_data->remain_bal;
                }

            // end calculation

            if($row->agent_level == 'SA'){
                $color = 'orange-bg';
            }else if($row->agent_level == 'AD'){
                $color = 'pink-bg';
            }else if($row->agent_level == 'SMDL'){
                $color = 'green-bg';
            }else if($row->agent_level == 'MDL'){
                $color = 'yellow-bg';
            }else if($row->agent_level == 'DL'){
                $color = 'blue-bg';
            }else{
                $color = 'red-bg';
            }

            $credit_data = CreditReference::where('player_id',$row->id)->first();
                $credit=0;
                if(!empty($credit_data['credit'])){
                    $credit = $credit_data['credit'];
                }
            $total_calculated_available_balance=$availableBalance+$totalAgentBal+$totalClientBal;
            $refPL = $credit-(int)$total_calculated_available_balance;
            if($refPL < 0){
                $class="text-color-red";
            }
            $total_ref_pl+=$cumulative_pl;

            if($row->agent_level == 'PL'){
                $html2.='
                <tr>
                    <td class="align-L white-bg">';
                        $html2.='<a class="ico_account text-color-blue-light" id="'.$row->id.'">
                            <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->first_name.' ['.$row->user_name.']
                        </a>
                    </td>
                    <td class="white-bg">'.$sum_credit.'</td>
                    <td class="white-bg">'.$availableBalance.'</td>';
                    $html2.='<td class="white-bg text-color-red" style="display:table-cell;">('.$total_Player_exposer.')</td>';
        
                    $credit_data = CreditReference::where('player_id',$row->id)->first();
                    $credit=0;
                    if(!empty($credit_data['credit'])){
                        $credit = $credit_data['credit'];
                    }

                    $total_calculated_available_balance=$availableBalance+$totalAgentBal+$totalClientBal;

                    $refPL = $credit-(int)$total_calculated_available_balance;
                    if($refPL < 0){
                        $class="text-color-green";
                    }else{
                        $class="text-color-red";
                    }
                    $total_ref_pl+=$cumulative_pl;

                    $html2.='<td class="white-bg '.$refPL.'">('.abs($refPL).')</td>
                    <td class="white-bg">('.abs($cumulative_pl).')</td>
                    <td class="white-bg" style="display: table-cell;"> 
                    ';

                    if($row->status == 'active'){
                        $html2.='<span class="status-active light-green-bg text-color-green"><span class="round-circle green-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    if($row->status == 'suspend'){
                        $html2.='<span class="status-suspended light-red-bg text-color-red"><span class="round-circle red-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    if($row->status == 'locked'){
                        $html2.='<span class="status-locked light-blue-bg-2 text-color-darkblue"><span class="round-circle darkblue-bg1"></span>'.ucfirst(trans($row->status)).'</span>';
                    }

                    $html2.='
                    </td>';

                    if($admin == $row->id){
                        $html2.='
                        <td class="white-bg">
                            <ul class="action-ul">

                                <li><a class="grey-gradient-bg setting" data-toggle="modal" data-target="#myStatus" data-id="'.$row->id.'" data-username="'.$row->user_name.'" data-agent="'.$row->agent_level.'" data-status="'.$row->status.'"><img src="'.asset('asset/img/setting-icon.png').'"></a></li>

                                <li><a class="grey-gradient-bg" href="changePass'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                            </ul>
                        </td>';
                    }
                    else{
                        $html2.='
                        <td class="white-bg">
                            <ul class="action-ul">

                                <li><a class="grey-gradient-bg" href="changePass/'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                            </ul>
                        </td>';
                    }

                $html2.='</tr>';
            }
            else{
                $html.='
                    <tr>
                        <td class="align-L white-bg">
                            <a class="ico_account text-color-blue-light" id="'.$row->id.'"   onclick="subpagedata(this.id);">
                                <span class="'.$color.' text-color-white">'.$row->agent_level.'</span>'.$row->first_name.' ['.$row->user_name.']
                            </a>
                        </td>

                        <td class="white-bg">'.$sum_credit.'</td>
                        <td class="white-bg">'.$availableBalance.'</td>
                        <td class="white-bg">'.$totalAgentBal.'</td>
                        <td class="white-bg">'.$totalClientBal.'</td>
                        <td class="white-bg">'.$total_calculated_available_balance.'</td>
                        <td class="white-bg text-color-red">('.$total_Player_exposer.')</td>
                        <td class="white-bg" style="display:table-cell;">('.abs($refPL).')</td>
                        <td class="white-bg">('.abs($cumulative_pl).')</td>
                        <td class="white-bg" style="display: table-cell;"> 
                        ';

                        if($row->status == 'active'){
                            $html.='<span class="status-active light-green-bg text-color-green"><span class="round-circle green-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                        }

                        if($row->status == 'suspend'){
                            $html.='<span class="status-suspended light-red-bg text-color-red"><span class="round-circle red-bg"></span>'.ucfirst(trans($row->status)).'</span>';
                        }


                        if($row->status == 'locked'){
                            $html.='<span class="status-locked light-blue-bg-2 text-color-darkblue"><span class="round-circle darkblue-bg1"></span>'.ucfirst(trans($row->status)).'</span>';
                        }

                            
                        $html.='
                        </td>';


                        if($admin == $row->id){
                            $html.='
                            <td class="white-bg">
                                <ul class="action-ul">

                                    <li><a class="grey-gradient-bg setting" data-toggle="modal" data-target="#myStatus" data-id="'.$row->id.'" data-username="'.$row->user_name.'" data-agent="'.$row->agent_level.'" data-status="'.$row->status.'"><img src="'.asset('asset/img/setting-icon.png').'"></a></li>


                                    <li><a class="grey-gradient-bg" href="changePass'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>

                                </ul>
                            </td>';
                        }

                        else{
                            $html.='
                            <td class="white-bg">
                                <ul class="action-ul">

                                    <li><a class="grey-gradient-bg" href="changePass'.$row->id.'"><img src="'.asset('asset/img/user-icon.png').'"></a></li>
                                </ul>

                            </td>';
                        }

                $html.='</tr>';
            }
        }

        return $html.'~~'.$html1.'~~'.$html2;

    }

    public function maintenance(){
        $mntnc = setting::first();
        $msg = $mntnc->maintanence_msg;
        return view('backpanel/maintanence',compact('msg'));
    }

    public function userWiseBlock(Request $request)
    {
        $matchid = $request->matchid;
        $event_id = $request->event_id;
        $checks = $request->checks;
        $mid = $request->mid;
        Match::where(['match_id'=>$matchid, 'event_id'=>$event_id])
        ->update(['user_list' => $checks]);
       return response()->json(array('success'=> 'success')); 
    }
}