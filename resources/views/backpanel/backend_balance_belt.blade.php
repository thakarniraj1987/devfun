<?php
use App\setting;
use App\CreditReference;
use App\User;
$settings = ""; $balance=0;
$auth_id = Auth::user()->id;
$auth_type = Auth::user()->agent_level;
if($auth_type=='COM'){
	$settings = setting::latest('id')->first();
	$balance=$settings->balance;
  $remain_bal=$settings->balance;;
}
else
{
	$settings = CreditReference::where('player_id',$auth_id)->first();
	$balance=$settings['available_balance_for_D_W'];
  $remain_bal=$settings['remain_bal'];

}
$children = array();
function databackend($id)
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

$backdata = databackend($auth_id);
//print_r($backdata);
$totalClientBal=0;
$totalAgentBal=0;
$totalClientExposure=0;
if(!empty($backdata)){
  foreach ($backdata as $key => $value) {
    $subdata = User::where('id',$key)->first();
    if($subdata->agent_level=='PL'){
      $credit_data = CreditReference::where('player_id',$subdata->id)->select('remain_bal','exposure')->first();                
      if(!empty($credit_data)){
          $totalClientBal += $credit_data->remain_bal;
           $totalClientExposure += $credit_data->exposure;
      }
    }else{
	  $credit_data = CreditReference::where('player_id',$subdata->id)->select('available_balance_for_D_W')->first();                
      if(!empty($credit_data)){
          $totalAgentBal += $credit_data->available_balance_for_D_W;
          $totalClientExposure += $credit_data->exposure;
      }
    }
  }
}
?>
<section>
  <div class="container">
    <div class="remaining-wrap white-bg text-color-blue-1">
      <div class="block-remain">
        <span class="text-color-lght-grey">Remaining Balance</span>
        <h4>PTH {{number_format($balance,2, '.', '')}}  </h4>
      </div>
      @if($loginuser->agent_level != 'DL')
      <div class="block-remain">
        <span class="text-color-lght-grey">Total Agent Balance</span>
        <h4>PTH {{number_format($totalAgentBal,2, '.', '')}}</h4>
      </div>
      @endif
      <div class="block-remain">
        <span class="text-color-lght-grey">Total Client Balance</span>
        <h4>PTH {{number_format($totalClientBal,2, '.', '')}}</h4>
      </div>
      <div class="block-remain">
        <span class="text-color-lght-grey">Exposure</span>
        <h4>PTH <div class="text-color-red">({{number_format($totalClientExposure,2, '.', '')}})</div></h4>
      </div>
      <div class="block-remain">
        <span class="text-color-lght-grey">Available Balance</span>
        <h4>PTH {{number_format($remain_bal,2, '.', '')}}</h4>
      </div>
      <div class="block-remain">
        <span class="text-color-lght-grey">Ledger Exposure</span>
        <h4>PTH <div class="text-color-green" id="ledger_exposure_div">0.00</div></h4>
      </div>
    </div>
  </div>
</section>