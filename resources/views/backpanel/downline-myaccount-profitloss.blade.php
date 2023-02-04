@extends('layouts.app')
@section('content')
<?php 
$loginuser = Auth::user(); 
?>
<body onload=display_ct();>
<section class="myaccount-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pl-0">
                <div class="downline-block">
                    <div class="search-wrap">
                        <svg width="19" height="19" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.547 11.543H12l-.205-.172a4.539 4.539 0 001.06-2.914A4.442 4.442 0 008.41 4C5.983 4 4 5.989 4 8.457a4.442 4.442 0 004.445 4.457c1.094 0 2.12-.411 2.905-1.062l.206.171v.548L14.974 16 16 14.971l-3.453-3.428zm-4.102 0a3.069 3.069 0 01-3.077-3.086 3.068 3.068 0 013.077-3.086 3.069 3.069 0 013.076 3.086 3.069 3.069 0 01-3.076 3.086z" fill="rgb(30,30,30"></path>
                        </svg>
                        <div>
                            <input class="search-input navy-light-bg" type="text" name="userId" id="userId" placeholder="Find member...">
                            <button class="search-but yellow-bg1" id="searchUserId">Search</button>
                        </div>
                    </div>
                    <ul class="agentlist">
                        <li class="lastli"><a><span class="orange-bg text-color-white">{{$user->agent_level}}</span><strong>{{$user->user_name}}</strong></a></li>                       
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 pl-0">
                @include('backpanel/downline-account-menu')
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="whitewrap white-bg">
                    <h3>Profit &amp; Loss - Main wallet</h3>
                    <ul class="acc-info">
                        <li> <img src="{{ URL::to('asset/img/user-icon-blue.png')}}"> {{$user->user_name}}</li>
                        <li> <img src="{{ URL::to('asset/img/clock-icon.png')}}"></li> <span id='ct' ></span>
                    </ul>
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
                    <div class="timeblock light-grey-bg-2">
                        <div class="timeblock-box">
                            <div class="datebox">
                                <span>Period</span>
                                <div class="datediv1">
                                    <div class="datediv">
                                        <input type="text" name="date_from" id="date_from" class="form-control period_date3" placeholder="2021-05-12">
                                        <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                    </div>
                                    <input type="text" name="date_to" id="date_to" placeholder="09:00" maxlength="5" class="form-control disable" disabled="">

                                    <div class="datediv">
                                        <input type="text" name="" id="dp1621515090977" class="form-control period_date4" placeholder="2021-05-13">
                                        <img src="{{ URL::to('asset/img/calendar-icon.png')}}" class="calendar-icon">
                                    </div>
                                    <input type="text" name="" id="" placeholder="08:59" maxlength="5" class="form-control disable" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="timeblock-box">
                            <ul>
                                <input type="hidden" name="pid" id="pid" value="{{$id}}">
                                <li> <a class="justbtn grey-gradient-bg text-color-black1" onclick="getHistoryPL('today')"> Just For Today </a> </li>
                                <li> <a class="justbtn grey-gradient-bg text-color-black1" onclick="getHistoryPL('yesterday')"> From Yesterday </a> </li>
                                <li> <a class="submit-btn text-color-yellow black-gradient-bg1" onclick="getHistoryPL('historypl')"> Get P & L </a> </li>
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
                        <li>Total P/L: INR <span class="amt"></span></li>
                        <li class="sports-switch">INR <span class="amt"></span></li>
                        <li class="sports-switch">
                            <select name="sportsevent" id="sportsevent">
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
                    <div class="pagination-wrap">
                        <ul class="pages">
                            <li id="prev"><a class="disable disable-bg disable-color">Prev</a></li>
                            <li id="pageNumber"><a class="active text-color-yellow">1</a></li>
                            <li id="next"><a class="disable disable-bg disable-color">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function getHistoryPL(val) {
        var date_to = $('#date_to').val();
        var date_from = $('#date_from').val();
        var pid = $("#pid").val();
        var sport = $('#sportsevent').find(":selected").val();

        $.ajax({
            type: "POST",
            url: '{{route("getBetHistoryPLBack")}}',
            data: {
               "_token": "{{ csrf_token() }}",
                date_from:date_from,
                date_to:date_to,
                val:val,
                pid:pid,
                sport:sport,
            },              
            success: function(data) {
                var spl=data.split('~~');
                $( ".cnd" ).show();
                $('#PLdata').html(spl[0]);

                $(".amt").html(spl[1]);
            }
        });
    }

    $('.period_date3').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('.period_date4').datepicker({
        dateFormat: "yy-mm-dd"
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
@endsection
