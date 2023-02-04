@extends('layouts.app')
@section('content')
<section class="profit-section section-mlr">
    <div class="container">
        <div class="inner-title">
            <h2>Profit/Loss Report by Market</h2>
        </div>
        <form method="post">
            <div class="timeblock light-grey-bg-2">
                <div class="timeblock-box">
                    <span>Sports</span>
                    <select name="sportsevent" id="sportsevent" class="form-control">
                        <option value="0">All</option>
                        @foreach($sports as $data)
                            <option value="{{$data->sId}}">{{strtoupper($data->sport_name)}}</option>
                        @endforeach
                    </select>
                    <div class="datediv2">
                        <span>Time Zone</span>
                        <select name="" id="" class="form-control timezone-select">
                            <option value="IST">IST(Bangalore / Bombay / New Delhi) (GMT+5:30)</option>
                        </select>
                    </div>
                    <div class="datebox">
                        <span>Period</span>
                        <div class="datediv1">
                            <div class="datediv">
                                <input type="text" name="fromdate" id="fromdate" class="form-control period_date3" placeholder="2021-05-12">
                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                            </div>
                            <input type="text" name="" id="" placeholder="09:00" maxlength="5" class="form-control disable" disabled>                    
                            <div class="datediv">
                                <input type="text" name="todate" id="todate" class="form-control period_date4" placeholder="2021-05-13">
                                <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                            </div>
                            <input type="text" name="" id="" placeholder="08:59" maxlength="5" class="form-control disable" disabled>
                        </div>
                    </div>
                    <div class="datediv2">
                        <span>Agent/Player</span>
                        <select name="childlist" id="childlist" class="form-control">
                            <option value="0">All</option>
                            @foreach($users as $data1)
                            <option value="{{$data1->id}}">{{$data1->agent_level}} - {{$data1->user_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="timeblock-box">
                    <ul>
                        <li> <a class="justbtn grey-gradient-bg text-color-black1" onclick="getHistory('today')"> Just For Today </a> </li>
                        <li> <a class="justbtn grey-gradient-bg text-color-black1" onclick="getHistory('yesterday')"> From Yesterday </a> </li>
                        <li> <a class="submit-btn text-color-yellow" id="" onclick="getHistory('history')"> Get P & L </a> </li>
                    </ul>
                </div>
            </div>
        </form>

        <div class="maintable-raju-block" id="market-table">
            <table class="table custom-table white-bg text-color-blue-2">
                <thead>
                    <tr>
                        <th class="light-grey-bg">UID</th>
                        <th class="light-grey-bg">Match P/L</th>
                        <th class="light-grey-bg">Fancy P/L</th>
                        <th class="light-grey-bg">Fancy Stake</th>
                        <th class="light-grey-bg">Commission</th>
                        <th class="light-grey-bg">Net P/L</th>
                    </tr>
                </thead>
                <tbody id="PLdata">
                </tbody>
                <tbody id="totalcnt"></tbody>
            </table>
        </div>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
var _token = $("input[name='_token']").val();
function getHistory(val) {
    var sport = $('#sportsevent').find(":selected").val();
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    var childlist = $('#childlist').find(":selected").val();
    $.ajax({
        type: "post",
        url: '{{route("marketPLdata")}}',
        data: {"_token": "{{ csrf_token() }}", "sport":sport, "fromdate":fromdate, "todate":todate, "childlist":childlist, "val":val,},
        success: function(data){
            var spl=data.split('~~');
            $( ".cnd" ).show();
            $('#PLdata').html(spl[0]);
            $("#totalcnt").html(spl[1]);
        }
    });
}
</script>
@endsection