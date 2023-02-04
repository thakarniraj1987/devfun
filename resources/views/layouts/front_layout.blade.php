<?php
$main_url=explode(".",$_SERVER['HTTP_HOST']);
//echo $main_url[0]; exit;

use App\Website;
use App\CreditReference;
use App\Match;
use Carbon\Carbon;
use App\UserStake;
use App\setting;
use App\User;


$website = Website::where('title',$main_url[0])->first();

$mntnc = setting::first();
$msg = $mntnc->maintanence_msg;

?>
@if($website->status == 1)

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('asset/front/img')}}/{{$website->favicon}}" type="image/x-icon">
    <title>{{$website->title}}</title>

    <link href="{{ asset('asset/front/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/color-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/owl.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/front/css/custom.css') }}" rel="stylesheet">
      <!-- toster script and js -->
    <?php /*?><link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet"><?php */?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('asset/css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/toastr.min.js') }}" ></script>
    <!-- Styles -->
    <style type="text/css">
        .toast {
            left: 50% !important;
            position: fixed !important;
            transform: translate(-50%, 0px) !important;
            z-index: 9999 !important;
        }
    </style>
</head>
<?php    
$url=explode("/",$_SERVER['REQUEST_URI']);
$page1=$url[1];
$page=explode(".php",$page1);
$page2=$page[0];
$getUserCheck = session('playerUser');
if(!empty($getUserCheck)){
$getUser = User::where('id',$getUserCheck->id)->where('check_login',1)->first();
}


//check is mobile or desktop
$useragent = $_SERVER['HTTP_USER_AGENT']; 
$iPod = stripos($useragent, "iPod"); 
$iPad = stripos($useragent, "iPad"); 
$iPhone = stripos($useragent, "iPhone");
$Android = stripos($useragent, "Android"); 
$iOS = stripos($useragent, "iOS");

$DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);
$is_agent='';
if (!$DEVICE) { 
    $is_agent='desktop';
}
else{ 
    $is_agent='mobile';
}
//end for check is mobile or desktop
?>
<body class="white-bg text-color-black1 chreme-bg">
    <div class="page-wrapper">
        <header class="main-header">
            <div class="top_header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="lefthead-logo">
                            <div class="logo">
                                <a href="{{route('front')}}"><img src="{{ URL::to('asset/front/img')}}/{{$website->logo}}"></a>
                            </div>
                            <div class="search-wrap">
                                <i class="fas fa-search"></i>
                                <input class="search-input" type="text" id="search_id" name="userId" placeholder="Search Events">
                            </div>
                        </div>
                        @if (!empty($getUser))
                        <?php $randomNumber = ''; 
                            $userId = $getUser->id;
                            $credit_ref=CreditReference::where(['player_id'=>$userId])->first();
                        ?>
                        <div class="righthead-login2">
                            <ul>
                                <li class="li-tv_bet d-lg-none">
                                    <a id="openTv" class="a-open_tv" data-toggle="collapse" data-target="#live_tv"><img src="{{ URL::to('asset/front/img/tv.svg')}}"></a>
                                    @if($page2=='matchDetail' && $is_agent=='mobile')
                                    <a id="openBetsBtn" class="a-open_bets"><img src="{{ URL::to('asset/front/img/coin.svg')}}">Bets</a>
                                    @endif
                                </li>
                                <li class="text-color-yellow1 mobile_balance">
                                    <a class="white-bg2">
                                        <p><span>Main Balance</span><span><b id="main_balance_div" class="" >PTH {{number_format(@$credit_ref['available_balance_for_D_W'],2)}}</b></span></p>
                                        <p><span>Exposure</span><span><b id="exposer_div" class="font-red">{{number_format(@$credit_ref['exposure'],2)}}</b></span></p>
                                        <span class="refimg black-gradient-bg1" id="refreshpage"><img src="{{ URL::to('asset/front/img/refresh.png')}}"></span>

                                    </a>
                                </li>
                                <li class="li-tv_set d-lg-none">
                                    <a id="settingsOpen" class="a-open_bets ui-link"><img src="{{ URL::to('asset/front/img/setting.svg')}}"></a>
                                </li>
                                <li class="dropdown text-color-yellow1">
                                    <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ URL::to('asset/front/img/user-yellow.png')}}"> {{$getUser->user_name}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <ul>
                                            <li class="text-color-blue-1">My Account <span class="gmtxt">{{$getUser->time_zone}}</span></li>
                                            <li><a class="dropdown-item" href="{{route('myprofile')}}">My Profile</a></li>
                                            <li><a class="dropdown-item" href="{{route('balance-overview')}}">Balance Overview</a></li>
                                            <li><a class="dropdown-item" href="{{route('account-statement')}}">Account Statement</a></li>
                                            <li><a class="dropdown-item" href="{{route('my-bets')}}">My Bets</a></li>
                                            <li><a class="dropdown-item" href="{{route('my-bets')}}">Bets History</a></li>
                                            <li><a class="dropdown-item" href="{{route('my-bets')}}">Profit & Loss</a></li>
                                            <li><a class="dropdown-item" href="{{route('activity-log')}}">Activity Log</a></li>
                                            <li><a class="dropdown-item" href="{{route('casinoreport')}}">Casino Result</a></li>
                                           
                                                <li class="logout"><a href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="darkblue-bg1 text-color-white">LOGOUT <img src="{{ URL::to('asset/front/img/logout-white.svg')}}"></a></li>
                                                <form id="logout-form" action="{{ route('frontLogout') }}" method="get">
                                                </form>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @else

                        <div class="lefthead-logo mobile_logo d-lg-none">
                            <div class="logo">
                                <a href="{{route('front')}}"><img src="{{ URL::to('asset/front/img')}}/{{$website->logo}}"></a>
                            </div>
                            <a href="#" class="loginbtn1 red-gradient-bg text-color-white" data-toggle="modal" data-target="#myLoginModalFront"><img src="{{ URL::to('asset/front/img/user.svg') }} "> Login</a>
                        </div>

                        <form method="POST" action="{{route('frontLogin')}}" class="d-none d-lg-block">
                            {{ csrf_field() }}                      
                            <ul class="righthead-login">
                                <li>
                                    <img src="{{ URL::to('asset/front/img/user-yellow.png') }} ">
                                    <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" autocomplete="email" autofocus>
                                    <span class="text-danger cls-error" id="erremail"></span>
                                    @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </li>
                                <li>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                    <span class="text-danger cls-error" id="errpass"></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </li>
                                <li>
                                    
                                    <input type="text" name="validationcode" id="validationcode" placeholder="Validation Code" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                    <span class="text-danger cls-error" id="errvalid"></span>
                                    <?php
                                        $randomNumber = random_int(1000, 9999);
                                    ?>
                                    <span class="validation-txt text-color-black">{{$randomNumber}}</span>
                                </li>
                                <li> <button type="submit" id="loginbtn" class="loginbtn1 red-gradient-bg text-color-white">Login <img src="{{ URL::to('asset/front/img/logout-white.svg') }} "></button> </li>
                            </ul>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bottom-header yellow-gradient-bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="mainmenu">
                            <nav id='cssmenu'>
                                <div class="button">
                                    <i class="fas fa-align-justify"></i>
                                    <i class="far fa-window-close"></i>
                                </div>
                                <ul>
                                    <?php

                                    $cricket_count=Match::where('sports_id',4)->where('status',1)->where('inplay',1)->where('action',1)->where('match_date','>=',Carbon::now()->toDateString())->count();       
                                    $tennis_count=Match::where('sports_id',2)->where('status',1)->where('action',1)->where('match_date','>=',Carbon::now()->toDateString())->count();                                   
                                    $soccer_count=Match::where('sports_id',1)->where('status',1)->where('action',1)->where('match_date','>=',Carbon::now()->toDateString())->count();                                   
                                    ?>
                                    <li class="{{ (request()->is('/' )) ? 'active' : '' }}">
                                        <a href="{{route('front')}}" class="text-color-black">Home</a>
                                    </li>
                                    <li class="{{ (request()->is('inplay' )) ? 'active' : '' }}">
                                        <a href="{{route('inplay')}}" class="text-color-black">In-Play</a>
                                    </li>
                                    @if (!empty($getUser))

                                    <li class="{{ (request()->is('multimarket' )) ? 'active' : '' }}">
                                        <a href="{{route('multimarket')}}" class="text-color-black">Multi Market</a>
                                    </li>
                                    @endif
                                    <li class="{{ (request()->is('cricket' )) ? 'active' : '' }}">
                                        <a href="{{route('cricket')}}" class="text-color-black">
                                            <span class="highlight-red grey-gradient-bg"> <span class="text-color-white red-gradient-bg cricketCount" id=""></span> </span>
                                            Cricket
                                        </a>
                                    </li>
                                    <li class="{{ (request()->is('soccer' )) ? 'active' : '' }}">
                                        <a href="{{route('soccer')}}" class="text-color-black">
                                            <span class="highlight-red grey-gradient-bg"> <span class="text-color-white red-gradient-bg soccerCount" id=""></span> </span>
                                               Soccer
                                        </a>
                                    </li>
                                    <li class="{{ (request()->is('tennis' )) ? 'active' : '' }}">
                                        <a href="{{route('tennis')}}" class="text-color-black">
                                            <span class="highlight-red grey-gradient-bg"> <span class="text-color-white red-gradient-bg tennisCount" id=""></span> </span>
                                            Tennis
                                        </a>
                                    </li>
                                    @if (!empty($getUser))
                                    <li class="casino-menu {{ (request()->is('casino' )) ? 'active' : '' }}">
                                        <a href="{{route('casino')}}" class="black-gradient-bg1 text-color-white">
                                            Casino <img src="{{ URL::to('asset/front/img/card-game.svg') }}  ">
                                        </a>
                                    </li>
                                    @else
                                    <li class="casino-menu {{ (request()->is('casino' )) ? 'active' : '' }}">
                                        <a href="javascript:void(0);" class="black-gradient-bg1 text-color-white">
                                            Casino <img src="{{ URL::to('asset/front/img/card-game.svg') }}  ">
                                        </a>
                                    </li>                                    
                                    @endif
                                </ul>
                            </nav>
                            <ul class="right-logout">
                                <li><span class="text-color-lime-green">Time Zone :</span> GMT+5:30</li>
                                <li class="clickli">
                                    <input type="checkbox" name="" id="one">
                                    <label for="one" class=" black-gradient-bg text-color-yellow1">
                                        One Click Bet
                                    </label>
                                </li>
                                <li class="logout-txt">
                                    <a id="frnt-stng">Setting <i class="fas fa-cog"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @if(!empty($getUser)) 
        <?php  $data = UserStake::where('user_id',$getUser->id)->first(); 
        $ans = json_decode($data->stake);
        ?> 
<div id="set_pop_setting" class="slip_set-pop active" style="display: none;">
    <div>
        <div id="coinList" class="set-content">
            <dl class="odds-set">
                <dd class="col-defult">
                    <label for="defult_stake">
                        <strong>Default stake</strong>
                    </label>
                    <input id="userCoin" class="stake-input" type="number" maxlength="7" value="1500">
                </dd>
                <a class="stkclose"><img src="{{ URL::to('asset/front/img/icon-close-yellow.svg')}}"></a>
            </dl>
            <dl id="stakeSet" class="stake-set stacksetdiv">
                <dt>Stake</dt>
                @if(!empty($data))
                   @php 
                    $i=0;
                   @endphp
                   @foreach($ans as $data1)
                    <dd>
                        <a id="coin_{{$i}}" style="cursor: pointer;" class="btn select">{{$data1}}</a>
                    </dd>
                    @php $i++; @endphp
                    @endforeach
                @endif
                <dd class="col-edit">
                    <a id="edit" class="btn-edit stake-edit">Edit 
                        <img src="data:image/gif;base64,R0lGODdhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" alt="gif">
                    </a>
                </dd>
            </dl>
            <dl id="editCustomizeStakeList" class="stake-set" style="display: none">
                <dt>Stake</dt>
                @if(!empty($data))
                    @php 
                        $i=0;
                    @endphp
                    @foreach($ans as $data1)
                        <dd>
                            <input id="stakeEdit_{{$i}}" class="stake_edit-input data-edit" type="text" maxlength="7" value="{{$data1}}" data-id="{{$i}}">
                        </dd>
                    @php $i++; @endphp
                    @endforeach
                 @endif                
                <dd class="col-edit">
                    <a id="ok" class="btn-send stake-ok" >OK</a>
                </dd>
            </dl>
            <dl class="odds-set">
                <dt>Odds</dt>
                <dd class="w-100">
                    <input id="enableSparkCheck" type="checkbox">
                    <label for="enableSparkCheck">Highlight when odds change</label>
                </dd>
            </dl>
        </div>
    </div>
</div>
@endif
<div class="modal loginmodal" id="myLoginModalFront" tabindex="-1" data-focus-on="input:first">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"> x
                <?php /*?><img src="{{ URL::to('asset/front/img/close-icon.png') }} "><?php */?>
            </button>
            <div class="modal-body">
                <div class="login-block yellow-bg">
                    <div class="loginleft-block login-header" style="background-image: url('{{ asset('asset/front/img') }}/{{$website->login_image}}');" >
                        <?php /*?><img src="{{ URL::to('asset/front/img/logo2.png') }} " alt="Logo"><?php */?>
                    </div>
                    <div class="loginright-block">
                        <h3> Please login to continue </h3>
                        <form method="post" action="{{route('frontLogin')}}">
                             {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="user_name" id="user_namefront" placeholder="Username" class="form-control">
                                <span class="text-danger cls-error" id="errusername_poup"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="passwordfront" placeholder="Password" class="form-control">
                                <span class="text-danger cls-error" id="errpassword_poup"></span>
                            </div>
                            <div class="form-group">
                                <?php $randomNumber_popupfront = random_int(1000, 9999);  ?>
                                <input type="text" name="validationcodefront" id="validationcodefront" placeholder="Validation Code" class="form-control">
                                <span class="validation-txt text-color-black">{{$randomNumber_popupfront}}</span>
                                <span class="text-danger cls-error" id="errvalid_poup"></span>
                            </div>
                           <!--  <a class="login-btn text-color-yellow"> Login<img src="{{ URL::to('asset/front/img/login/logout-yellow.svg') }} "> </a> -->
                           <button class="login-btn text-color-yellow loginbtnfront" type="submit"> Login<?php /*?><img src="{{ URL::to('asset/front/img/login/logout-yellow.svg') }} "><?php */?></button>
                           
                        </form>
                    </div>
                    
                    <ul class="policy-link">
                        <li><a class="ui-link" data-toggle="modal" data-target="#myLoginprivacy">Privacy Policy</a></li>
                        <li><a class="ui-link">Terms and Conditions</a></li>
                        <li><a class="ui-link">Rules and Regulations</a></li>
                        <li><a class="ui-link">KYC</a></li>
                        <li><a class="ui-link">Responsible Gaming</a></li>
                        <li><a class="ui-link">About Us</a></li>
                        <li><a class="ui-link">Self-Exclusion Policy</a></li>
                        <li><a class="ui-link">Underage Policy</a></li>
                    </ul>
                    
                    
                    <div class="social-block black-bg-rgb">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist" data-mouse="hover">
                            <li class="nav-item">
                                <a class="nav-link bg-transparent email" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-email" aria-selected="false">
                                    <img src="/asset/img/login/email.svg" title="Email">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent whatsapp" id="pills-whatsapp-tab" data-toggle="pill" href="#pills-whatsapp" role="tab" aria-controls="pills-whatsapp" aria-selected="false">
                                    <img src="/asset/img/login/whatsapp.svg" title="WhatsApp">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent telegram active show" id="pills-telegram-tab" data-toggle="pill" href="#pills-telegram" role="tab" aria-controls="pills-telegram" aria-selected="true">
                                    <img src="/asset/img/login/telegram.svg" title="Telegram">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent skype" id="pills-skype-tab" data-toggle="pill" href="#pills-skype" role="tab" aria-controls="pills-skype" aria-selected="false">
                                    <img src="/asset/img/login/skype.svg" title="Skype">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent instagram" id="pills-instagram-tab" data-toggle="pill" href="#pills-instagram" role="tab" aria-controls="pills-instagram" aria-selected="false">
                                    <img src="/asset/img/login/instagram.svg" title="Instagram">
                                </a>
                            </li>
                        </ul>
                                
                        <div class="tab-content">
                            <div class="tab-pane fade" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">
                                <a class="text-color-black" href="mailto:test@gmail.com">test@gmail.com</a>
                                <a class="text-color-black" href="mailto:test1@gmail.com">test1@gmail.com</a>
                            </div>
                            <div class="tab-pane fade" id="pills-whatsapp" role="tabpanel" aria-labelledby="pills-whatsapp-tab">
                                <a class="text-color-black" href="">1234567890</a>
                            </div>
                            <div class="tab-pane fade active show" id="pills-telegram" role="tabpanel" aria-labelledby="pills-telegram-tab">
                                <a class="text-color-black">test_telegram</a>
                            </div>
                            <div class="tab-pane fade" id="pills-skype" role="tabpanel" aria-labelledby="pills-skype-tab">
                                <a class="text-color-black">test_skype</a>
                            </div>
                            <div class="tab-pane fade" id="pills-instagram" role="tabpanel" aria-labelledby="pills-instagram-tab">
                                <a class="text-color-black" target="_blank">test_instagram</a>
                            </div>  
                        </div>
                                
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<div class="modal logincontentmodal" id="myLoginprivacy" tabindex="-1" data-focus-on="input:first">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Privacy Policy
            </div>
            <div class="modal-body">
                <h3>1. PRIVACY</h3>
                <p>betbuzz365 is committed to protecting your personal information. This Privacy Policy lets you know what information we collect when you use our services, why we collect this information and how we use the collected information.</p>
                <p>Please note that this Privacy Policy will be agreed between you and betbuzz365. (‘We’, ‘Us’ or ‘Our’, as appropriate). This Privacy Policy is an integrated part of betbuzz365’s Terms and Conditions.</p>
                <p>We may periodically make changes to this Privacy Policy and will notify you of these changes by posting the modified terms on our platforms. We recommend that you revisit this Privacy Policy regularly.</p>
                <h3>2.  INFORMATION COLLECTED</h3>
                <p>We may periodically make changes to this Privacy Policy and will notify you of these changes by posting the modified terms on our platforms. We recommend that you revisit this Privacy Policy regularly.</p>
                <p>We may periodically make changes to this Privacy Policy and will notify you of these changes by posting the modified terms on our platforms. We recommend that you revisit this Privacy Policy regularly.</p>
                <p>We may periodically make changes to this Privacy Policy and will notify you of these changes by posting the modified terms on our platforms. We recommend that you revisit this Privacy Policy regularly.</p>
                <p>We may periodically make changes to this Privacy Policy and will notify you of these changes by posting the modified terms on our platforms. We recommend that you revisit this Privacy Policy regularly.</p>
                
            </div>
            <div class="modal-footer" align="center">
                <button type="button" class="login-content-btn text-color-yellow" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal loginmodal" id="myLoginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="{{ URL::to('asset/front/img/close-icon.png') }} "></button>
            <div class="modal-body">
                <div class="login-block yellow-bg">
                    <div class="loginleft-block black-bg">
                        <img src="{{ URL::to('asset/front/img/logo2.png') }} " alt="Logo">
                    </div>
                    <div class="loginright-block">
                        <h3> Please login to continue </h3>
                        <form>
                            <div class="form-group">
                                <input type="text" name="username_popup" id="username_popup" placeholder="Username" class="form-control">
                                <span class="text-danger cls-error" id="errusername_poup"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_popup" id="password_popup" placeholder="Password" class="form-control">
                                <span class="text-danger cls-error" id="errpassword_poup"></span>
                            </div>
                            <div class="form-group">
                                <?php $randomNumber_popup = random_int(1000, 9999);  ?>
                                <input type="text" name="validationcode_popup" id="validationcode_popup" placeholder="Validation Code" class="form-control">
                                <span class="validation-txt text-color-black">{{$randomNumber_popup}}</span>
                                <span class="text-danger cls-error" id="errvalid_poup"></span>
                            </div>
                            <a class="login-btn text-color-yellow" id="popup_loginbtn"> Login<img src="{{ URL::to('asset/front/img/login/logout-yellow.svg') }} "> </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('content')
<div class="mobilemenu">
    <nav>
        <ul>
            <li>
                <a class="{{ (request()->is('cricket' )) ? 'select' : '' }}" href="{{route('cricket')}}">
                    <img class="icon-sports" src="{{ URL::to('asset/front/img/mmenu-img/Sports.svg') }}" alt="Sports">Sports
                </a>
            </li>
            <li class="{{ (request()->is('inplay' )) ? 'select' : '' }}">
                <a class="" href="{{route('inplay')}}">
                    <img class="icon-inplay" src="{{ URL::to('asset/front/img/mmenu-img/In-Play.svg') }}" alt="In-Play">In-Play
                </a>
            </li>
            <li  class="main-nav {{ (request()->is('/' )) ? 'select' : '' }}">
                <a class="" href="{{route('front')}}">
                    <img class="icon-home" src="{{ URL::to('asset/front/img/mmenu-img/Home.svg') }}" alt="Home">Home
                </a>
            </li>
            @if (!empty($getUser))
            <li class="{{ (request()->is('multimarket' )) ? 'select' : '' }}">
                <a class="multi_market" href="{{route('multimarket')}}">
                    <img class="icon-pin" src="{{ URL::to('asset/front/img/mmenu-img/Multi-Markets.svg') }}" alt="Multi Markets">Multi Markets
                </a>
            </li>
            @else
            <li class="{{ (request()->is('multimarket' )) ? 'select' : '' }}">
                <a class="multi_market" href="{{route('multimarket')}}">
                    <img class="icon-pin" src="{{ URL::to('asset/front/img/mmenu-img/Multi-Markets.svg') }}" alt="Multi Markets">Multi Markets
                </a>
            </li>
            @endif
            @if (!empty($getUser))
            <li class="{{ (request()->is('myaccount' )) ? 'select' : '' }}">
                <a class="" href="{{route('myaccount')}}">
                    <img class="icon-account" src="{{ URL::to('asset/front/img/mmenu-img/Account.svg') }}" alt="Account">Account
                </a>
            </li>
            @else
            <li>
                <a class="" href="#" data-toggle="modal" data-target="#myLoginModalFront">
                    <img class="icon-account" src="{{ URL::to('asset/front/img/mmenu-img/Account.svg') }}" alt="Account">Account
                </a>
            </li>            
            @endif
            
        </ul>
    </nav>
</div>
<div id="openBetsLeftSide" class="open_bets_leftside black-bg-rgb3">
    <div class="side_wrap light-grey-bg-1">
        <div class="side_head black-bg3 text-color-yellow1">
            <h3><img src="{{ URL::to('asset/front/img/coin.svg')}}">Open Bets</h3>
            <a class="close"><img src="{{ URL::to('asset/front/img/icon-close-yellow.svg')}}"></a>
        </div>
        <div class="side_content">
            @if($page2=='matchDetail' && $is_agent=='mobile')
                @include('../front/layout_bet_display_mobile_view')
            @endif
        </div>
    </div>
</div>
<div id="settingDiv" class="open_bets_leftside setting_stake black-bg-rgb3 d-lg-none">
    <div class="side_wrap setting_wrap white-bg">
        <div class="side_head black-bg3 text-color-yellow1">
            <h3><img src="{{ URL::to('asset/front/img/setting.svg')}}">Setting</h3>
            <a class="close"><img src="{{ URL::to('asset/front/img/icon-close-yellow.svg')}}"></a>
        </div>

        <div class="side_content settings_content">
            <h3 class="blue-gradient-bg1 text-color-white">Stake</h3>
            <form action="">
                <div class="dstake_set">
                    Default stake <input type="text" id="stake_default" name="" class="form-control text-right ">
                </div>

                <div class="dsake_quick" id="sedit_setting">
                    <span>Quick Stakes</span>
                    @if(!empty($data))
                       @php 
                        $i=0;
                       @endphp
                       @foreach($ans as $data1)
                        <div>
                            <a id="coinmobile_{{$i}}" style="cursor: pointer;" class="dstakeqbtn black-bg2 text-color-yellow1">{{$data1}}</a>
                        </div>
                        @php $i++; @endphp
                        @endforeach
                    @endif
                    <a class="dstake_edit grey-bg2 text-color-blue-2" id="sedit">Edit Stakes <img src="{{ URL::to('asset/front/img/edit-icon.svg')}}" alt=""></a>
                </div>

                <div class="dsake_quick" id="ssave_setting" style="display:none">
                    <span>Quick Stakes</span>
                    @if(!empty($data))
                       @php 
                        $i=0;
                       @endphp
                       @foreach($ans as $data1)
                    <div><input type="text" id="mobilestake{{$i}}"  class="form-control data-edit" maxlength="7" value="{{$data1}}" data-id="{{$i}}"></div>
                    @php $i++; @endphp
                    @endforeach
                    @endif
                    <button type="button" class="dstake_edit black-gradient-bg3 text-color-yellow1 shadow-none stake-ok" id="sok">OK</button>
                </div>

                <h3 class="blue-gradient-bg1 text-color-white">Odds</h3>
                <div class="odds_check">
                    <span>Highlight when odds change</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                <h3 class="blue-gradient-bg1 text-color-white">FancyBet</h3>
                <div class="odds_check">
                    <span>Accept Any Odds</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                <ul class="setbtn_list">
                    <li>
                        <a href="#" class="grey-gradient-bg1 text-color-black1 canceldset">Cancel</a>
                    </li>
                    <li>
                        <a href="#" class="black-gradient-bg3 text-color-yellow1">Save</a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('asset/front/js/jquery.js') }}"></script>
<script src="{{ asset('asset/front/js/popper.min.js') }}"></script>
<script src="{{ asset('asset/front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('asset/front/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('asset/front/js/jquery-ui.multidatespicker.js') }}"></script>
<script src="{{ asset('asset/front/js/owl.js') }}"></script>
<script src="{{ asset('asset/front/js/script.js') }}"></script>
<script src="{{ asset('asset/js/index.js') }}" ></script>

<script type="text/javascript">
   var _token = $("input[name='_token']").val();

   $(document).ready(function(){
    //default call
    $(window).load(function() { 
            $.ajax({
            type: "POST",
            url: '<?php echo e(route("getleftpanelMenu")); ?>',
            data: {_token:_token},
            timeout: 200000,
            beforeSend:function(){
                $('#site_statistics_loading').show();
            },
            complete: function(){
                $('#site_statistics_loading').hide();
            },
            success: function(data){
                
                $(".leftul").html(data);
                
            }
        });
    });
});
    $("#refreshpage").click(function(){
        window.location.reload();
    });
    $(".stkclose").click(function(){
        $("#set_pop_setting").css("display","none");
    });
    $("#frnt-stng").click(function(){
        $("#set_pop_setting").css("display","block");
    });
    $(".stake-edit").click(function(){
        $(".stacksetdiv").css("display","none");
        $("#editCustomizeStakeList").css("display","block");
    });
    $(".stake-ok").click(function(){
        $(".stacksetdiv").css("display","block");
        $("#editCustomizeStakeList").css("display","none");
    });
    $(".data-edit").change(function(){
        var id = $(this).attr("data-id"); 
        var data = $(this).val();
        var newval= $(this).val();
        $.ajax({
            type: 'POST',
            url: '{{route("stakechange")}}',
            data: {
                _token:_token,
                id:id,
                data:data
            },
            success: function(data) {
                $(".stacksetdiv").hide().fadeIn('fast');
                $('#coinmobile_'+id).text(newval);
                $('#coin_'+id).text(newval);
            }
        });
    });    
</script>
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
    toastr.success("{{ session('message') }}");
  @endif
  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
    toastr.error("{{ session('error') }}");
  @endif
  @if(Session::has('info'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
    toastr.info("{{ session('info') }}");
  @endif
  @if(Session::has('warning'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
    toastr.warning("{{ session('warning') }}");
  @endif
</script>
<script type="text/javascript">
    $('#loginbtn').click(function() {
        var user_name = $('#user_name').val();
        var password = $('#password').val();
        var randomNumber = '<?php echo $randomNumber; ?>';
        var validationcode = $('#validationcode').val();
        $('#erremail').html('');
        $('#errpass').html('');
        $('#errvalid').html('');

        if (user_name == '') {
            toastr.error('Username can not be blank!');
            return false;
        }
        if (password == '') {
            toastr.error('Password can not be blank!');
            return false;
        }
        if (validationcode != randomNumber) {
            toastr.error('Captcha is not valid!');
            return false;
        }
    });

   $('.loginbtnfront').click(function() {
    var user_name = $('#user_namefront').val();
    var password = $('#passwordfront').val();
    var randomNumber = '<?php echo $randomNumber_popupfront; ?>';
    var validationcode = $('#validationcodefront').val();       
    $('#erremail').html('');
    $('#errpass').html('');
    $('#errvalid').html('');

    if (user_name == '') {
        toastr.error('Username can not be blank!');
        return false;
    }
    if (password == '') {
        toastr.error('Password can not be blank!');
        return false;
    }
    if (validationcode != randomNumber) {
        toastr.error('Captcha is not valid!');
        return false;
    }
    });

    //popup login box function

    $('#popup_loginbtn').click(function() {
        var user_name = $('#username_popup').val();
        var password = $('#password_popup').val();
        var randomNumber = '<?php echo $randomNumber_popup; ?>';
        var validationcode = $('#validationcode_popup').val();
        $('#errusername_poup').html('');
        $('#errpassword_poup').html('');
        $('#errvalid_poup').html('');
        var chk = 0;

        if (user_name == '') {
            chk = 1;
            toastr.error('Username can not be blank!');
            return false;
        }
        if (password == '') {
            chk = 1;
            toastr.error('Password can not be blank!');
            return false;
        }
        if (validationcode != randomNumber) {
            chk = 1;
            toastr.error('Captcha is not valid!');
            return false;
        }
        if (chk == 0) {
            $.ajax({
                type: 'POST',
                url: '{{route("frontLogin_popup")}}',
                data: {
                    _token: _token,
                    user_name: user_name,
                    password: password,
                },
                success: function(data) {
                    if (data.trim() != 'Success')
                    {    //alert(data);
                    } 
                    else
                        window.location.reload();
                }
            });
        }
    });
</script>
<script type="text/javascript"> 
 
    function updatePassworduser() {
        $.ajax({
            type: "POST",
            url: '{{route("changePassLogoutuser")}}',
            data: {
                _token: _token,
            },
            success: function(data) {                
                if(data.result=='error'){
                    window.location.href = "{{ route('front')}}";
                }
            }
        });
    }

    function multiAcountLogout() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{route("multiaccountlogout")}}',
            data: {
                _token: _token,
            },
            success: function(data) { 
                if(data.result=='error'){
                    window.location.href = "{{ route('front')}}";
                }
                if (data.balance != '') {
                $("#main_balance_div").html('PTH ' + data.balance);
                }
            }
        });
    }
    function sportCount(){
         $.ajax({
        type: "get",
        url: '{{route("getcricketlivecount")}}',                 
        timeout: 10000,
        success: function(data) {
           //$('#cricketCount').html(dt[i]);
            var dt = data.split("~~");
            $('.cricketCount').html(dt[0]);
            $('.tennisCount').html(dt[1]);
            $('.soccerCount').html(dt[2]);
            
        }
    });
    }
    var getUser = '<?php echo isset($getUser) ? $getUser : '' ?>';

    $(document).ready(function(){
        $('#openTv').click(function() {
            $(".collape-link").collapse('show');
            });

        setInterval(function() {
            if(getUser != ''){
            updatePassworduser();
            multiAcountLogout();
            sportCount();
        }
    }, 10000)

    //auto logout ajax call 



    setInterval(function(){
        $.ajax({
            type: "get",
            url: '{{route("frontAutoLogout")}}',          
            success: function(data){
                if(data.result=='suspendsuccess'){
                    window.location.href = "{{ route('front')}}";
                }
                if(data.result=='msgsuccess'){
                    window.location.href = "{{ route('maintenance')}}";
                }
            }
        });
    },10000);
});
</script>
<script>
$('.period_date1').datepicker({
    dateFormat: "yy-mm-dd"
});
$('.period_date2').datepicker({
    dateFormat: "yy-mm-dd"
});
$('.period_date3').datepicker({
    dateFormat: "yy-mm-dd"
});
$('.period_date4').datepicker({
    dateFormat: "yy-mm-dd"
});

$(document).ready(function() {
    $.ajax({
        type: "get",
        url: '{{route("getcricketlivecount")}}',                 
        timeout: 10000,
        success: function(data) {
           //$('#cricketCount').html(dt[i]);
            var dt = data.split("~~");
            $('.cricketCount').html(dt[0]);
            $('.tennisCount').html(dt[1]);
            $('.soccerCount').html(dt[2]);
            
        }
    });    
});
 
$("#validationcodefront").keypress(function(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});

</script> 
</body>
</html>
@else
<!DOCTYPE html>
<html>
<head>
    <title>Maintanence</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100%;
            position: relative;
            top: 0;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .txt_maintanence {
            width: 100%;
            display: block;
            position: absolute;
            bottom: 50px;
            left: 0px;
            text-align: center;
        }
        .txt_maintanence h1 {
            font-weight: 400;
            font-size: 24px;
        }
    </style>
</head>
<body style="background-image: url(/public/asset/img/maintance-image.jpg)">
    <div class="txt_maintanence">
        <h1 style="color: #fff;">{{$msg}}</h1>
    </div>
</body>
</html>
@endif