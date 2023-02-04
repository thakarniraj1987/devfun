@extends('layouts.app')
@section('content')
<?php $loginUser = Auth::user(); 
use App\Match;?>
<section class="risk_management_details_wrapper white-bg ">
    <div class="container">
        @if($errors->any())
        <h4>{{$errors->first()}}</h4>
        @endif
        <div class="inner-title-2 text-color-blue-2">
            <h2>Risk Management Summary</h2>
        </div>
        <div></div>  
  
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="riskmanage_content">
                    <div class="riskmanage_head green-bg-1">
                        <div class="btn-group">
                            <button type="button" class="btn yellow-gradient-bg text-color-black btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                User lock
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" class="dropdown-item">All Block</a>
                                    <ul class="dropdown-menu">
                                        @if($matchList->status_m == 1 && $matchList->status_b == 1 && $matchList->status_b == 1)
                                           
                                        <li>
                                            <a class="dropdown-item" href="{{route('allBlock',$matchList->id)}}">All [Block]</a>
                                        </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="{{route('allunBlock',$matchList->id)}}">All [Un-Block]</a>
                                            </li>
                                        @endif
                                           
                                        @if($matchList->status_m == '1')
                                            <li><a class="dropdown-item" href="{{route('blockMatch',$matchList->id)}}"  id="{{$matchList->id}}">Match Odds [Block]</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{route('unblockMatch',$matchList->id)}}">Match Odds [Un-Block]</a></li>
                                        @endif

                                        @if($matchList->status_b == '1')

                                            <li><a class="dropdown-item" href="{{route('blockBook',$matchList->id)}}">Bookmaker [Block]</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{route('unblockBook',$matchList->id)}}">Bookmaker [Un-Block]</a></li>
                                        @endif

                                        @if($matchList->status_f == '1')
                                            <li><a class="dropdown-item" href="{{route('blockFancy',$matchList->id)}}">Fancy [Block]</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{route('unblockFancy',$matchList->id)}}">Fancy [Un-Block]</a></li>
                                        @endif
                                    </ul>
                                </li>
                                    
                                <li>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myuserwise">User Wise</a>
                                </li>
                            </ul>
                        </div>

                        <h4 class="text-color-white">{{$matchList->match_name}}</h4>

                    </div>

                    <div class="riskmanage_body_content">
                        <div class="row">
                            <div class="col-lg-7 col-xs-12 p-0">
                                <div class="risk_matchodds_left">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="r_match_title">
                                                        Match Odds <span class="allow_bets"></span>
                                                    </th>
                                                    <th width="8.33333333%" class=""></th>
                                                    @if($loginUser->agent_level=='COM')
                                                    @if($matchList->suspend_m==1)
                                                    <th width="8.33333333%" class="p-0"><a data-status="suspend_m" data-suspend="0" class="chkaction yellow-gradient-bg text-color-black" href="javascript:void(0);">Suspend</a></th>
                                                    @else
                                                    <th width="8.33333333%" class="p-0"><a data-status="suspend_m" data-suspend="1" class="chkaction yellow-gradient-bg text-color-black" href="javascript:void(0);">Unsuspend</a></th>
                                                    @endif
                                                    @else 
                                                    <th width="8.33333333%" class="p-0"></th> 
                                                    @endif
                                                    <th width="8.33333333%" class="cyan-bg text-color-white text-center btnbl bet_type_uppercase">Back</th>
                                                    <th width="8.33333333%" class="pink-bg text-color-white text-center btnbl bet_type_uppercase">Lay</th>
                                                    <th width="8.33333333%" class=""></th>
                                                    <th width="8.33333333%" class=""></th>
                                                </tr>
                                            </thead>
                                            <tbody id="inplay-tableblock" class="inplay-tableblock">
                                                <tr class="rf_tr">
                                                	<td colspan="7"><div id="site_statistics_loading" class="loaderimage"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($matchList->bookmaker==1)
                                    <div class="table-responsive noData bookmakerHide">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="r_match_title">
                                                       Bookmaker <span class="allow_bets"></span>
                                                    </th>
                                                    <th width="8.33333333%" class=""></th>
                                                    @if($loginUser->agent_level=='COM')
                                                    @if($matchList->suspend_b==1)
                                                    <th width="8.33333333%" class="p-0"><a data-status="suspend_b" data-suspend="0" class="chkaction yellow-gradient-bg  text-color-black" href="javascript:void(0);">Suspend</a></th>
                                                    @else
                                                    <th width="8.33333333%" class="p-0"><a  data-status="suspend_b" data-suspend="1" class="chkaction yellow-gradient-bg  text-color-black" href="javascript:void(0);">Unsuspend</a></th>
                                                    @endif
                                                    @endif
                                                    <th width="8.33333333%" class="cyan-bg text-color-white text-center btnbl bet_type_uppercase">Back</th>
                                                    <th width="8.33333333%" class="pink-bg text-color-white text-center btnbl bet_type_uppercase">Lay</th>
                                                    <th width="8.33333333%" class=""></th>
                                                    <th width="8.33333333%" class=""></th>
                                                </tr>
                                            </thead>
                                            <tbody id="inplay-tableblock-bookmaker" class="inplay-tableblock-bookmaker">
                                                <tr class="rf_tr">
                                                	<td colspan="7"><div id="site_statistics_loading" class="loaderimage"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    
                                    @if($matchList->fancy==1)
                                    <div class="table-responsive noData">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="r_match_title">Sessions</th>
                                                    <th width="8.33333333%" class=""></th>
                                                    @if($loginUser->agent_level=='COM')
                                                    @if($matchList->suspend_f==1)
                                                    <th width="8.33333333%" class="p-0"><a data-status="suspend_f"  data-suspend="0" class="chkaction yellow-gradient-bg  text-color-black" href="javascript:void(0);">Suspend</a></th>
                                                    @else
                                                    <th width="8.33333333%" class="p-0"><a data-status="suspend_f" data-suspend="1" class="chkaction yellow-gradient-bg  text-color-black" href="javascript:void(0);">Unsuspend</a></th>
                                                    @endif
                                                    @else
                                                     <th width="8.33333333%" class="p-0"></th>
                                                    @endif
                                                    <th width="8.33333333%" class="pink-bg text-color-white text-center btnbl bet_type_uppercase">No</th>
                                                    <th width="8.33333333%" class="cyan-bg text-color-white text-center btnbl bet_type_uppercase">Yes</th>
                                                    <th width="8.33333333%" class=""></th>
                                                    <th width="8.33333333%" class=""></th>
                                                </tr>
                                            </thead> 
                                            <tbody id="inplay-tableblock-fancy" class="inplay-tableblock-fancy">
                                                <tr class="rf_tr">
                                                	<td colspan="7"><div id="site_statistics_loading" class="loaderimage"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-5 col-xs-12 p-0 risk_live_right">
                                <div class="panel panel-default">
                                    <div class="panel-heading darkblue-bg" role="tab">
                                        <h2 class="panel-title">
                                            <a class="text-color-white" role="button" data-toggle="collapse" data-parent="#accordion" href="#risk1" aria-expanded="true" aria-controls="risk1">
                                                <div class="w-100">Live TV
                                                    <span class="float-right pr-2"><i class="fas fa-tv"></i></span>
                                                </div>
                                            </a>
                                        </h2>
                                    </div>
                                    <div id="risk1" class="panel-collapse tv_tabs_block collapse" role="tabpanel">
                                        <ul class="nav nav-tabs darkblue-bg" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link text-color-white red-bg active" data-toggle="tab" href="#tabs-1" role="tab">Channel 1</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-color-white red-bg" data-toggle="tab" href="#tabs-2" role="tab">Channel 2</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-color-white red-bg" data-toggle="tab" href="#tabs-3" role="tab">Channel 3</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-color-white red-bg" data-toggle="tab" href="#tabs-4" role="tab">Channel 4</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-color-white red-bg" data-toggle="tab" href="#tabs-5" role="tab">Channel 5</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                                @if($managetv->cs1 == 'on')
                                                <iframe src="{{$managetv->channel1}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                @else
                                                    <p>Video Not Added</p>
                                                @endif
                                            </div>
                                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                                @if($managetv->cs2 == 'on')
                                                <iframe src="{{$managetv->channel2}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                @else
                                                    <p>Video Not Added</p>
                                                @endif
                                            </div>
                                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                                @if($managetv->cs3 == 'on')
                                                <iframe src="{{$managetv->channel3}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                @else
                                                    <p>Video Not Added</p>
                                                @endif
                                            </div>
                                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                                @if($managetv->cs4 == 'on')
                                                <iframe src="{{$managetv->channel4}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                @else
                                                    <p>Video Not Added</p>
                                                @endif
                                            </div>
                                            <div class="tab-pane" id="tabs-5" role="tabpanel">
                                                @if($managetv->cs5 == 'on')
                                                <iframe src="{{$managetv->channel5}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                @else
                                                    <p>Video Not Added</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading darkblue-bg" role="tab">
                                        <h2 class="panel-title">
                                            <a class="text-color-white" role="button" data-toggle="collapse" data-parent="#accordion" href="#risk3" aria-expanded="true" aria-controls="risk3">					
                                                Matched Bets [{{count($my_placed_bets)}}]
                                            </a>
                                        </h2>
                                    </div>
                                    <div id="risk3" class="panel-collapse collapse show" role="tabpanel">
                                        <div class="row unmatch_wrap">            
                                        </div>
                                        <div class="custom_table_scroll">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Client</th>
                                                            <th class="text-center">Selection</th>
                                                            <th class="text-center">B/L</th>
                                                            <th class="text-center">Odds</th>
                                                            <th class="text-center">Stake</th>
                                                            <th class="text-center">P&L</th>
                                                            <th>Placed Time</th>
                                                            <th class="text-center">Info</th>
                                                            @if($loginUser->agent_level =='COM')
                                                            <th>DLT</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="match_odds_bet">
                                                    	{!!$html!!}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
                                @if($matchList->sports_id=='4')
                                    @if($matchList->bookmaker==1)
                                    <div class="panel panel-default">
                                        <div class="panel-heading darkblue-bg" role="tab">
                                            <h2 class="panel-title">
                                                <a class="text-color-white" role="button" data-toggle="collapse" data-parent="#accordion" href="#risk4" aria-expanded="true" aria-controls="risk4">
                                                    Book Making Bets [{{count($my_placed_bets_BM)}}]
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="risk4" class="panel-collapse collapse show" role="tabpanel">
                                            <div class="row unmatch_wrap">             
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Client</th>
                                                            <th>Selection</th>
                                                            <th>B/L</th>
                                                            <th>Odds</th>
                                                            <th>Stake</th>
                                                            <th>P&L</th>
                                                            <th>Status</th>
                                                            <th>Placed Time</th>
                                                            <th>ID</th>
                                                            <th>Info</th>
                                                             @if($loginUser->agent_level =='COM')
                                                            <th>DLT</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="match_bm_bet"> {!!$html_BM!!}</tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($matchList->fancy==1)
                                    <div class="panel panel-default">
                                        <div class="panel-heading darkblue-bg" role="tab">
                                            <h2 class="panel-title">
                                                <a class="text-color-white" role="button" data-toggle="collapse" data-parent="#accordion" href="#risk3" aria-expanded="true" aria-controls="risk3">
                                                    Fancy Bets [{{count($my_placed_bets_fancy)}}]
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="risk3" class="panel-collapse collapse show" role="tabpanel">
                                            <div class="row unmatch_wrap">
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Client</th>
                                                            <th>Selection</th>
                                                            <th>Y/N</th>
                                                            <th>R/S</th>
                                                            <th>Stake</th>
                                                            <th>Placed Time</th>
                                                            <th>Info</th>
                                                             @if($loginUser->agent_level =='COM')
                                                            <th>DLT</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="match_fancy_bet"> {!!$html_Fancy!!}</tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- User Wise Lock Modal -->
<div class="modal credit-modal" id="myuserwise">
    <div class="modal-dialog">
        <div class="modal-content light-grey-bg-1">
            <div class="modal-header border-0">
                <h4 class="modal-title text-color-blue-1">Active User</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ URL::to('asset/img/close-icon.png')}}"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="agentform">
                    @csrf
                    <div class="form-modal addform-modal">
                        @if(!empty($list))
                            @php $i=1; $count = 0;@endphp
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>Sr No.</th>
                                    <th>User Name</th>
                                    <th>Checked</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php 
                                	$matchdata = Match::where('id',$matchList->id)->first();
                                	$ans = json_decode($matchdata->user_list);
                                ?>
                         
                                @foreach($list as $data)
                                <?php 
                                	$chk='';
                                	if(!empty($ans)){
                                		foreach($ans as $data1){
											if($data1 == $data->id){
												$chk ='checked';
											}
										}
                                	}
								?>
                                    <?php 
                                        if (0 == $i % 2){
                                            $trclr = 'even';
                                        }
                                        else{
                                            $trclr = 'odd';
                                        }
                                    ?>
                                    <tr class="{{$trclr}}">
                                        <td>{{$i}}</td>
                                        <td>{{$data->user_name}}</td>

                                        <td><input type="checkbox" name="usercheck[]" id="usercheck" value="{{$data->id}}" class="myuserwise userWiseLock" {{$chk}}></td>

                                       
                                    </tr>
                                    @php $i++; $count++;@endphp
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End User Wise Lock Modal -->

<div class="modal credit-modal" id="bookModal">
    <div class="modal-dialog">
        <div class="modal-content light-grey-bg-1">
            <div class="modal-header">
                <h4 class="modal-title text-color-blue-1">Fancy Book</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ URL::to('asset/img/close-icon.png')}}"></button>
            </div>
            <div class="modal-body table_book">
                <table class="table">
                    <thead>
                        <th><b>Score</b></th>
                        <th><b>Amount</b></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>285</b></td>
                            <td class="text-color-red"><b>-2308</b></td>
                        </tr>
                        <tr>
                            <td><b>286</b></td>
                            <td class="text-color-red"><b>-2308</b></td>
                        </tr>
                        <tr>
                            <td><b>287</b></td>
                            <td class="text-color-red"><b>-798</b></td>
                        </tr>
                        <tr>
                            <td><b>288</b></td>
                            <td class="text-color-red"><b>-792</b></td>
                        </tr>
                        <tr>
                            <td><b>289</b></td>
                            <td class="text-color-red"><b>-868</b></td>
                        </tr>
                        <tr>
                            <td><b>290</b></td>
                            <td class="text-color-red"><b>-566</b></td>
                        </tr>
                        <tr>
                            <td><b>291</b></td>
                            <td class="text-color-red"><b>-582</b></td>
                        </tr>
                        <tr>
                            <td><b>292</b></td>
                            <td class="text-color-red"><b>-478</b></td>
                        </tr>
                        <tr>
                            <td><b>293</b></td>
                            <td class="text-color-green"><b>222</b></td>
                        </tr>
                        <tr>
                            <td><b>294</b></td>
                            <td class="text-color-green"><b>806</b></td>
                        </tr>
                        <tr>
                            <td><b>295</b></td>
                            <td class="text-color-green"><b>1004</b></td>
                        </tr>
                        <tr>
                            <td><b>296</b></td>
                            <td class="text-color-green"><b>1648</b></td>
                        </tr>
                        <tr>
                            <td><b>297</b></td>
                            <td class="text-color-green"><b>1864</b></td>
                        </tr>
                        <tr>
                            <td><b>298</b></td>
                            <td class="text-color-green"><b>1566</b></td>
                        </tr>
                        <tr>
                            <td><b>299</b></td>
                            <td class="text-color-green"><b>2054</b></td>
                        </tr>
                        <tr>
                            <td><b>300</b></td>
                            <td class="text-color-green"><b>2054</b></td>
                        </tr>
                        <tr>
                            <td><b>301</b></td>
                            <td class="text-color-green"><b>2062</b></td>
                        </tr>
                        <tr>
                            <td><b>302</b></td>
                            <td class="text-color-green"><b>2062</b></td>
                        </tr>
                        <tr>
                            <td><b>303</b></td>
                            <td class="text-color-green"><b>2288</b></td>
                        </tr>
                        <tr>
                            <td><b>304</b></td>
                            <td class="text-color-green"><b>2302</b></td>
                        </tr>
                        <tr>
                            <td><b>305</b></td>
                            <td class="text-color-green"><b>2352</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal credit-modal" id="rejectModal">
    <div class="modal-dialog">
        <div class="modal-content light-grey-bg-1">
            <div class="modal-header">
                <h4 class="modal-title text-color-blue-1">Reject Bet</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ URL::to('asset/img/close-icon.png')}}"></button>
            </div>
            <div class="modal-body reject_wrap">
                <form action="" class="mt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label class="label-control">Bet ID :</label></div>
                                <div class="col-md-6"><input type="text" class="form-control" id="" name=""></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label class="label-control">Password :</label></div>
                                <div class="col-md-6"><input type="password" maxlength="8" class="form-control" id="" name=""></div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="submit-btn text-color-yellow">Reject Multiple Bets</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(".userWiseLock").change(function(){
        var _token = $("input[name='_token']").val();
        var matchid='{{$matchList->match_id}}';
        var event_id='{{$matchList->event_id}}';
        var mid='{{$matchList->id}}';
        var checks = $('input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get()

        $.ajax({
            type: "POST",
            url: '{{route("userWiseBlock")}}',
            data: {
                _token: _token,
                matchid: matchid,
                event_id: event_id,
                checks : checks,
                mid : mid
            },
            success: function(data) {
               toastr.success('Bet Lock Successfully !!!');
            }
        });
    });

    function delete_bet(bid)
    {
    	if(confirm("Are you sure you want to delete this bet?"))
    	{
    		var _token = $("input[name='_token']").val();
    		$.ajax({
    			type: "POST",
    			url: '{{route("delete_user_bet")}}',
    			data: {_token:_token,bid:bid},
    			success: function(data){
    				if(data.trim()!='Fail')
    				{	
    					alert("Bet deleted.");
    					$("#rollback_row_"+bid).show();
    					$("#delete_row_"+bid).hide();
    				}
    				else
    				{
    					alert("Problem in bet deleted. Try again.");
    					$("#rollback_row_"+bid).hide();
    					$("#delete_row_"+bid).show();
    				}
    			}
    		});
    	}
    	else
    		return false;
    }
    function rollback_bet(bid)
    {
    	if(confirm("Are you sure you want to rollback this bet?"))
    	{
    		var _token = $("input[name='_token']").val();
    		$.ajax({
    			type: "POST",
    			url: '{{route("rollback_user_bet")}}',
    			data: {_token:_token,bid:bid},
    			success: function(data){
    				if(data.trim()!='Fail')
    				{	
    					alert("Bet rollbacked.");
    					$("#rollback_row_"+bid).hide();
    					$("#delete_row_"+bid).show();
    				}
    				else
    				{
    					alert("Problem in bet deleted. Try again.");
    					$("#rollback_row_"+bid).show();
    					$("#delete_row_"+bid).hide();
    				}
    			}
    		});
    	}
    	else
    		return false;
    }
    function matchDeclareRedirect() 
    {
        var match_id = '{{$matchList->id}}';
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: "POST",
            url: '{{route("matchDeclareRedirect")}}',
            data: {
                _token: _token,
                match_id:match_id,
            },
            success: function(data) {                
                if(data.result=='error'){
                    window.location.href = "{{ route('home')}}";
                }
            }
        });
    }
    $(document).ready(function(){
        setInterval(function() {
            matchDeclareRedirect(); 
        }, 10000);

    	//default call
    	var _token = $("input[name='_token']").val();
		var match_type='{{$matchList->sports_id}}';
		var matchid='{{$matchList->match_id}}';
		var matchname='{{$matchList->match_name}}';
		var event_id='{{$matchList->event_id}}';
        var match_m='{{$matchList->suspend_m}}';
        var match_b='{{$matchList->suspend_b}}';
        var match_f='{{$matchList->suspend_f}}';

		$.ajax({
			type: "POST",
			url: '{{route("risk_management_details_ajax",$matchList->match_id)}}',
			data: {_token:_token,matchtype:match_type,matchid:matchid,matchname:matchname,event_id:event_id,match_m:match_m},
			beforeSend:function(){
				$('#loaderimagealldiv').show();
			},
			complete: function(){
				$('#loaderimagealldiv').hide();
			},
			success: function(data){
				$("#inplay-tableblock").html(data);
			}
		});
    	
    	//fancy and bookmaker
    	$.ajax({
    		type: "POST",
    		url: '{{route("risk_management_matchCallForFancyNBM",$matchList->match_id)}}',
    		data: {_token:_token,matchtype:match_type,event_id:event_id,matchname:matchname,matchid:matchid,match_b:match_b,match_f:match_f},
    		beforeSend:function(){
    			$('#loaderimagealldiv').show();
    		},
    		complete: function(){
    			$('#loaderimagealldiv').hide();
    		},
    		success: function(data){  
                if(data == '~~'){
                    $('.noData').css('display','none');
                }  
    			if(data!='')
    			{
    				var spl=data.split('~~');
                    if(spl[0]==''){
                        $('.bookmakerHide').css('display','none');
                    }
    				$("#inplay-tableblock-bookmaker").html(spl[0]);
    				$("#inplay-tableblock-fancy").html(spl[1]);
    			}
    		}
    	});
    		
    	setInterval(function(){
    	   var _token = $("input[name='_token']").val();
			var match_type='{{$matchList->sports_id}}';
			var matchid='{{$matchList->match_id}}';
			var matchname='{{$matchList->match_name}}';
			var event_id='{{$matchList->event_id}}';
			var match_m='{{$matchList->suspend_m}}';
            var match_b='{{$matchList->suspend_b}}';
            var match_f='{{$matchList->suspend_f}}'; 

			$.ajax({
    			type: "POST",
    			url: '{{route("risk_management_details_ajax",$matchList->match_id)}}',
    			data: {_token:_token,matchtype:match_type,matchid:matchid,matchname:matchname,event_id:event_id,match_m:match_m},
    			beforeSend:function(){
                	$('#loaderimagealldiv').show();
               	},
                complete: function(){
                	$('#loaderimagealldiv').hide();
                },
    			success: function(data){
    				$("#inplay-tableblock").html(data);

    			}
    		});
    		
    		//BM and Fancy
    		$.ajax({
    			type: "POST",
    			url: '{{route("risk_management_matchCallForFancyNBM",$matchList->match_id)}}',
    			data: {_token:_token,matchtype:match_type,event_id:event_id,matchname:matchname,matchid:matchid,match_b:match_b,match_f:match_f},
    			beforeSend:function(){
    				$('#loaderimagealldiv').show();
    			},
    			complete: function(){
    				$('#loaderimagealldiv').hide();
    			},
    			success: function(data){
    				if(data!='')
    				{
    					var spl=data.split('~~');
                    if(spl[0]==''){
                      $('.bookmakerHide').css('display','none');
                    }
    					$("#inplay-tableblock-bookmaker").html(spl[0]);
    					$("#inplay-tableblock-fancy").html(spl[1]);
    				}
    			}
    		});
    		
    		//odds bets
    		$.ajax({
    			type: "POST",
    			url: '{{route("risk_management_odds_bet")}}',
    			data: {_token:_token,matchid:matchid},
    			beforeSend:function(){
    				$('#loaderimagealldiv').show();
    			},
    			complete: function(){
    				$('#loaderimagealldiv').hide();
    			},
    			success: function(data){
    				if(data!='')
    				{
    					var spl=data.split('~~');
    					$("#match_odds_bet").html(spl[0]);
    					$("#match_bm_bet").html(spl[1]);
    					$("#match_fancy_bet").html(spl[2]);
    				}
    			}
    		});
    	},10000);
    });

    $(".chkaction").on('click', function(event){
        var _token = $("input[name='_token']").val();
        var status = $(this).attr('data-status');
        var suspend = $(this).attr('data-suspend');
        var chk=(this.checked ? $(this).val() : "");
        var fid='{{$matchList->id}}';
        $.ajax({
            type: "POST",
            url: '{{route("saveMatchSuspend")}}',
            data: {_token:_token,status:status,fid:fid,suspend:suspend},
            success: function(data){
                location.reload();
                if(data.success!='success')
                    alert('Problem in action update');
            }
        });
    });
    
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection