@extends('layouts.app')
@section('content')
<section class="profit-section section-mlr">
    <div class="container">
        <div class="inner-title">
            <h2>Bet List Live</h2>
        </div>
        <div class="timeblock light-grey-bg-2">
            <div class="multiple-radiobtn pl-0 pr-0">
                <label for="radio1">
                    <input type="radio" name="radio" id="radio1" value="all" checked> All
                </label>
                @foreach($sports as $sport)
                <label for="radio2">
                    <input type="radio" name="radio" id="radio2" value="{{$sport->sId}}"> {{strtoupper($sport->sport_name)}}
                </label>
                @endforeach
            </div>
            <div class="timeblock-box">
                <div class="datediv2">
                    <span>Order of display:</span>
                    <select name="" id="" class="form-control">
                        <option>Stake</option>
                        <option>Time</option>
                    </select>
                </div>
                <div class="datediv2">
                    <span>Last:</span>
                    <select name="" id="" class="form-control">
                        <option>All</option>
                        <option>100 Txn</option>
                        <option>50 Txn</option>
                        <option>25 Txn</option>
                    </select>
                </div>
                <div class="datediv2">
                    <span>Bet Status:</span>
                    <select name="" id="" class="form-control">
                        <option>Matched</option>
                        <option>Declared</option>
                    </select>
                </div>
                <a class="submit-btn text-color-yellow btn1" onclick="getHistorylive()"> Refresh </a>
            </div>
        </div>
        <div class="maintable-raju-block betlistlive-block">
            <table class="table custom-table white-bg">
                <caption class="caption-highlight blue-bg-1 text-color-white">Bets</caption>
                <table class="table custom-table white-bg text-color-blue-2">
                    <thead>
                        <tr>
                            @if($loginUser->agent_level=='COM')
                            <th class="light-grey-bg">COM</th>
                            @endif
                            @if($loginUser->agent_level=='AD' || $loginUser->agent_level=='COM')
                            <th class="light-grey-bg">AD</th>
                            @endif
                            @if($loginUser->agent_level=='SP' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD')
                            <th class="light-grey-bg">SP</th>
                            @endif
                            @if($loginUser->agent_level=='SMDL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP')
                            <th class="light-grey-bg">SMDL</th>
                            @endif
                            @if($loginUser->agent_level=='MDL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP' || $loginUser->agent_level=='SMDL')
                            <th class="light-grey-bg">MDL</th>
                            @endif
                            @if($loginUser->agent_level=='DL' || $loginUser->agent_level=='COM' || $loginUser->agent_level=='AD' || $loginUser->agent_level=='SP' || $loginUser->agent_level=='SMDL' || $loginUser->agent_level=='MDL')
                            <th class="light-grey-bg">DL</th>  
                            @endif                          
                            <th class="light-grey-bg">PL</th>
                            <th class="light-grey-bg">Bet ID</th>
                            <th class="light-grey-bg">Bet taken</th>
                            <th class="light-grey-bg">Market</th>
                            <th class="light-grey-bg">Selection</th>
                            <th class="light-grey-bg">Type</th>
                            <th class="light-grey-bg">Odds req.</th>
                            <th class="light-grey-bg">Stake</th>
                            <th class="light-grey-bg">Exposure</th>
                        </tr>
                    </thead>
                    <tbody id="append_data">
                    </tbody>
                </table>
            </table>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
	var _token = $("input[name='_token']").val();
    $(document).ready(function(){
        getHistorylive();
        });
	function getHistorylive() {
		var sport = $('input[name="radio"]:checked').val();
	
		$.ajax({
            type: "POST",
            url: '{{route("getHistorylive")}}',
            data: {
                _token: _token,
                sport:sport,
               
            },              
            success: function(data) {
            	$('#append_data').html(data.html);
            }
        });
	}
</script>
@endsection