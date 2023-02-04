@extends('layouts.app')
@section('content')
<section class="profit-section section-mlr">
    <div class="container">
        <div class="inner-title">
            <h2>Bet List</h2>
        </div>
	    <form method="post">
            <div class="multiple-radiobtn">
                <label for="radio1">
                    <input type="radio" name="radio" id="radio1" value="all" checked> All
                </label>
                @foreach($sports as $sport)
                <label for="radio2">
                    <input type="radio" name="radio" id="radio2" value="{{$sport->sId}}"> {{strtoupper($sport->sport_name)}}
                </label>
                @endforeach
            </div>
	
            <div class="timeblock light-grey-bg-2">
                <div class="timeblock-box">
                    <span>Bet Status:</span>
                    <select name="" id="" class="form-control">
                        <option>Settled</option>
                        <option>Voided</option>	                   
                    </select>
                    <div class="datebox">
                        <span>Period</span>
                        <div class="datediv1">
                            <div class="datediv">
                                <input type="text" name="date_from" id="date_from" class="form-control period_date5" placeholder="">
                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                            </div>
                            <input type="text" name="" id="" placeholder="09:00" maxlength="5" class="form-control disable" disabled>
                        
                            <div class="datediv">
                                <input type="text" name="date_to" id="date_to" class="form-control period_date6" placeholder="">
                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                            </div>
                            <input type="text" name="" id="" placeholder="08:59" maxlength="5" class="form-control disable" disabled>
                        </div>
                    </div>
                </div>
                <div class="timeblock-box">
                    <ul>
                        <li> <a class="justbtn grey-gradient-bg text-color-black1"  onclick="getHistory('today')"> Just For Today </a> </li>
                        <li> <a class="submit-btn text-color-yellow" onclick="getHistory('history')"> Get History </a> </li>
                    </ul>
                </div>
            </div>
        </form>
        <p>
            Bet List enables you to review the bets you have placed. <br>
            Specify the time period during which your bets were placed, the type of markets on which the bets were placed, and the sport. <br>
            Bet List is available online for the past 30 days.
        </p>
        <div class="maintable-raju-block betlist-block" id="append_data">
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
var _token = $("input[name='_token']").val();
function getHistory(val) {
	var sport = $('input[name="radio"]:checked').val();
	var date_to = $('#date_to').val();
	var date_from = $('#date_from').val();
	$.ajax({
        type: "POST",
        url: '{{route("getHistory")}}',
        data: {
            _token: _token,
            sport:sport,
            date_from:date_from,
            date_to:date_to,
            val:val,

        },              
        success: function(data) {
        	$('#append_data').html(data.html);
        }
    });
}
</script>
@endsection