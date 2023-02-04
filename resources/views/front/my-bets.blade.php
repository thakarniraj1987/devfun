@extends('layouts.front_layout')
@section('content')
<?php 
use App\Sport;
use App\Match;
use App\MyBets;
?>
<style type="text/css">
    .vlmtxt {
        font-size: 10px;
        color: #000000ad;;
    }
</style>
<body onload=display_ct();>
<section>
    <div class="container-fluid">
        <div class="main-wrapper">
            @include('front.leftpanel-account')
            <div class="dashboard-right-pannel">
                <div class="pagetitle text-color-blue-2">
                    <h1>My Bets</h1>
                </div>
                <div class="in_play_tabs mb-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-color-blue-1 white-bg active" href="#current_bets" data-toggle="tab">Current Bets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color-blue-1 white-bg" href="#bets_history" data-toggle="tab" >Bets History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color-blue-1 white-bg" href="#profit_loss" data-toggle="tab">Profit & Loss</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="current_bets">
                        <div class="in_play_tabs-2 mb-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg active" href="#exchange" data-toggle="tab">Exchange</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#sportsbook" data-toggle="tab">Sportsbook</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#bookMaker" data-toggle="tab">BookMaker</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#binary" data-toggle="tab">Binary</a>
                                </li>
                            </ul>
                            <div class="function-wrap light-grey-bg">
                                <ul class="inputlist">
                                    <li> <label>Bet Status</label> </li>
                                    <li>
                                        <select id="">
                                            <option value="">Matched</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="summery-table mt-3">
                            <table class="table custom-table mybets-table">
                                <thead>
                                    <tr>
                                        <td colspan="9" class="matched-txt text-color-white blue-bg-1">Matched</td>
                                    </tr>
                                    <tr class="light-grey-bg">
                                        <th width="9%">Bet ID</th>
                                        <th width="9%">PL ID</th>
                                        <th>Market</th>
                                        <th width="12%" class="text-right">Selection</th>
                                        <th width="4%" class="text-right">Type</th>
                                        <th width="8%" class="text-right">Bet placed</th>
                                        <th width="8%" class="text-right">Stake</th>
                                        <th width="8%" class="text-right">Avg. odds <br> matched</th>
                                    </tr>
                                </thead>
                                <tbody id="mobilebetlist">
                                    @foreach($getresult as $data)
										
                                            <?php 
                                            $sports = Sport::where('sId', $data->sportID)->first();
                                            $matchdata = Match::where('event_id', $data->match_id)->first();
                                            ?>
                                            <tr class="white-bg">
                                                <td width="9%"><img src="{{ URL::to('asset/front/img/plus-icon.png') }}"> <a class="text-color-blue-light">{{$data->id}}</a></td>
                                                <td width="9%">{{$loginUser->user_name}}</td>
                                                <td>{{$sports->sport_name}}<i class="fas fa-caret-right text-color-grey"></i> <strong>{{$matchdata->match_name}}</strong> <i class="fas fa-caret-right text-color-grey"></i>{{$data->bet_type}}</td>
                                                <td width="12%" class="text-right">{{$data->team_name}}</td>
                                                @if($data->bet_side == 'lay')
                                                	@if($data->bet_type=='SESSION')
                                                    	<td width="4%" class="text-right bet_type_uppercase" style="color: #e33a5e !important;">no</td>
                                                   	@else
                                                		<td width="4%" class="text-right bet_type_uppercase" style="color: #e33a5e !important;">{{$data->bet_side}}</td>
                                                    @endif
                                                @else
                                                	@if($data->bet_type=='SESSION')
                                                    	<td width="4%" class="text-right bet_type_uppercase" style="color: #1f72ac !important;">yes</td>
                                                    @else
                                                		<td width="4%" class="text-right bet_type_uppercase" style="color: #1f72ac !important;">{{$data->bet_side}}</td>
                                                    @endif
                                                @endif
                                                <td width="8%" class="text-right">{{$data->created_at}}</td>
                                                <td width="8%" class="text-right">{{$data->bet_amount}}</td>
                                                <td width="8%" class="text-right">{{$data->bet_odds}}
                                                    @if($data->bet_type=='SESSION')
                                                        <br>
                                                        <span class="vlmtxt">({{$data->bet_oddsk}})</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="bets_history">
                        <div class="in_play_tabs-2 mb-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg active" href="#exchange" data-toggle="tab">Exchange</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#sportsbook" data-toggle="tab">Sportsbook</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#bookMaker" data-toggle="tab">BookMaker</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#binary" data-toggle="tab">Binary</a>
                                </li>
                            </ul>
                        </div>
                        <div class="timeblock light-grey-bg-2">
                            <form>
                                @csrf
                                <div class="timeblock-box">
                                    <span>Bet Status:</span>
                                    <select name="" id="" class="form-control">
                                        <option>Settled</option>
                                    </select>
                                    <div class="datebox">
                                        <span>Period</span>
                                        <div class="datediv1">
                                            <div class="datediv">
                                                <input type="text" name="fromdate" id="fromdate" class="form-control period_date1" placeholder="2021-05-12">
                                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                            </div>
                                            <input type="text" name="" id="" placeholder="09:00" maxlength="5" class="form-control disable" disabled="">
                                            <div class="datediv">
                                                <input type="text" name="todate" id="todate" class="form-control period_date2" placeholder="2021-05-13">
                                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                            </div>
                                            <input type="text" name="" id="" placeholder="08:59" maxlength="5" class="form-control disable" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="timeblock-box">
                                    <ul>
                                        <li> <a class="justbtn grey-gradient-bg text-color-black1" id="bet-today"> Just For Today </a> </li>
                                        <li> <a class="justbtn grey-gradient-bg text-color-black1" id="betYest"> From Yesterday </a> </li>
                                        <li> <a class="submit-btn text-color-yellow black-gradient-bg1" id="betshistory"> Get History </a> </li>
                                    </ul>
                                </div>
                            </form>
                        </div>

                        <div class="summery-table mt-3">
                            <table class="table custom-table mybets-table">
                                <thead>
                                    <tr class="light-grey-bg">
                                        <th width="9%">Bet ID</th>
                                        <th width="9%">PL ID</th>
                                        <th>Market</th>
                                        <th width="12%" class="text-right">Selection</th>
                                        <th width="4%" class="text-right">Type</th>
                                        <th width="8%" class="text-right">Bet placed</th>
                                        <th width="8%" class="text-right">Stake</th>
                                        <th width="8%" class="text-right">Avg. odds <br> matched</th>
                                        <th width="10%" class="text-right">Profit/Loss</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyData">
                                </tbody>
                            </table>
                            <p>
                                Betting History enables you to review the bets you have placed. <br>
                                Specify the time period during which your bets were placed, the type of markets on which the bets were placed, and the sport. <br>
                                Betting History is available online for the past 30 days.
                            </p>
                            <ul class="paginationn-full">
                                <li id="prev"> <a href="javascript:void(0);" class="disable-bg disable-color">Prev</a> </li>
                                <li id="pageNumber"> <a href="javascript:void(0);" class="linkitem black-bg2 text-color-yellow">1</a> </li>
                                <li id="next"> <a href="javascript:void(0);" class="disable-bg disable-color">Next</a> </li>
                            </ul>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="profit_loss">
                        <div class="in_play_tabs-2 mb-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg active" href="#exchange" data-toggle="tab">Exchange</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#casino" data-toggle="tab">Casino</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#sportsbook" data-toggle="tab">Sportsbook</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#bookMaker" data-toggle="tab">BookMaker</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#bpoker" data-toggle="tab">BPoker</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-color-blue-1 white-bg" href="#binary" data-toggle="tab">Binary</a>
                                </li>
                            </ul>
                        </div>

                        <div class="whitewrap white-bg">
                            <h3>Profit &amp; Loss - Main wallet</h3>
                            <ul class="acc-info">
                                <li> <img src="{{ URL::to('asset/front/img/user-icon.png') }}"> {{$loginUser->user_name}}</li>
                                <li> <img src="{{ URL::to('asset/front/img/clock-icon.png') }}"></li>
                                <span id='ct' ></span>
                            </ul>

                            <div class="timeblock light-grey-bg-2">
                                <div class="timeblock-box">
                                    <div class="datebox">
                                        <span>Period</span>
                                        <div class="datediv1">
                                            <div class="datediv">
                                                <input type="text" name="fromdate" id="fromdate2" class="form-control period_date1" placeholder="{{date('Y-m-d')}}">
                                                <img src="{{asset('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                            </div>
                                            <input type="text" name="" id="" placeholder="09:00" maxlength="5" class="form-control disable" disabled="">
                                            <div class="datediv">
                                                <input type="text" name="todate" id="todate2" class="form-control period_date2" placeholder="{{date('Y-m-d')}}">
                                                <img src="{{asset('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                            </div>
                                            <input type="text" name="" id="" placeholder="08:59" maxlength="5" class="form-control disable" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="timeblock-box">
                                    <ul>
                                        <li> <a class="justbtn grey-gradient-bg text-color-black1" id="pl-today"> Just For Today </a> </li>
                                        <li> <a class="justbtn grey-gradient-bg text-color-black1" id="pl-yest"> From Yesterday </a> </li>
                                        <li> <a class="submit-btn text-color-yellow black-gradient-bg1" id="getPL"> Get P & L </a> </li>
                                    </ul>
                                </div>
                            </div>
                            <p>
                                Betting Profit & Loss enables you to review the bets you have placed. <br>
                                Specify the time period during which your bets were placed, the type of markets on which the bets were placed, and the sport.
                                <br>
                                Betting Profit & Loss is available online for the past 2 months.
                            </p>
                        </div>

                        <div class="summery-table mt-3 cnd" style="display: none">
                            <ul class="total-show">
                                <li >Total P/L: PTH <span class="amt"></span></li>
                                <li class="sports-switch">PTH <span class="amt"></span> </li>
                                <li class="sports-switch">
                                    <select name="sports" id="sportsevent">
                                        <option value="0">ALL</option>
                                        <option value="1">SOCCER</option>
                                        <option value="2">TENNIS</option>
                                        <option value="4">CRICKET</option>
                                    </select>
                                </li>
                            </ul>

                            <table class="table custom-table mybets-table">
                                <thead>
                                    <tr class="light-grey-bg">
                                        <th>Market</th>
                                        <th width="15%" class="text-right">Start Time</th>
                                        <th width="15%" class="text-right">Settled date</th>
                                        <th width="18%" class="text-right">Profit/Loss</th>
                                    </tr>
                                </thead>
                                <tbody id="PLdata">
                                </tbody>
                            </table>
                            <p>Profit and Loss is shown net of commission.</p>

                            <ul class="paginationn-full">
                                <li id="prev"> <a href="javascript:void(0);" class="disable-bg disable-color">Prev</a> </li>
                                <li id="pageNumber"> <a href="javascript:void(0);" class="linkitem black-bg2 text-color-yellow">1</a> </li>
                                <li id="next"> <a href="javascript:void(0);" class="disable-bg disable-color">Next</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

$('#getPL').click(function(){ 
    var fromdate = $("#fromdate2").val();
    var todate = $("#todate2").val();
    $.ajax({
        type: "post",
        url: '{{route("getPLdata")}}',
        data: {"_token": "{{ csrf_token() }}", "fromdate":fromdate, "todate":todate},
        success: function(data){
            var spl=data.split('~~');
            $( ".cnd" ).show();
            $('#PLdata').html(spl[0]);

            $(".amt").html(spl[1]);
        }
    });
});

$('#pl-today').click(function(){ 
    var tdate = new Date().toJSON().slice(0, 10);
    $.ajax({
        type: "post",
        url: '{{route("plToday")}}',
        data: {"_token": "{{ csrf_token() }}", "tdate":tdate},
        success: function(data){
            var spl=data.split('~~');
            $( ".cnd" ).show();
            $('#PLdata').html(spl[0]);
            $(".amt").html(spl[1]);
        }
    });
});

$('#pl-yest').click(function(){ 
    let d = new Date();
    d.setDate(d.getDate() - 1);
    var ydate = d.toISOString().split('T')[0];
    $.ajax({
        type: "post",
        url: '{{route("plYest")}}',
        data: {"_token": "{{ csrf_token() }}", "ydate":ydate},
        success: function(data){
            var spl=data.split('~~');
            $( ".cnd" ).show();
            $('#PLdata').html(spl[0]);
            $(".amt").html(spl[1]);
        }
    });
});

$( "#sportsevent" ).change(function() {
    var sport = $('#sportsevent').find(":selected").val();
    var fromdate = $("#fromdate2").val();
    var todate = $("#todate2").val();

    $.ajax({
        type: "post",
        url: '{{route("plSport")}}',
        data: {"_token": "{{ csrf_token() }}", "sport":sport, "fromdate":fromdate, "todate":todate},
        success: function(data){
            var spl=data.split('~~');
            $( ".cnd" ).show();
            $('#PLdata').html(spl[0]);
            $(".amt").html(spl[1]);
        }
    });
});

$('#betshistory').click(function(){ 
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    $.ajax({
        type: "post",
        url: '{{route("betHistory")}}',
        data: {"_token": "{{ csrf_token() }}", "fromdate":fromdate, "todate":todate},
        success: function(data){
            $('#bodyData').html(data);
        }
    });
});

$('#bet-today').click(function(){ 
    var tdate = new Date().toJSON().slice(0, 10);
    $.ajax({
        type: "post",
        url: '{{route("betToday")}}',
        data: {"_token": "{{ csrf_token() }}", "tdate":tdate},
        success: function(data){
            $('#bodyData').html(data);
        }
    });
});

$('#betYest').click(function(){ 
    let d = new Date();
    d.setDate(d.getDate() - 1);
    var ydate = d.toISOString().split('T')[0];
    $.ajax({
        type: "post",
        url: '{{route("betYest")}}',
        data: {"_token": "{{ csrf_token() }}", "ydate":ydate},
        success: function(data){
            $('#bodyData').html(data);
        }
    });
});
 
function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
    var x = new Date()
    var x1=x.getMonth() + 1+ "-" + x.getDate() + "-" + x.getFullYear(); 
    x1 = x1 + "   " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds();
    document.getElementById('ct').innerHTML = x1;
    display_c();
}
</script>
@include('layouts.footer')
@endsection