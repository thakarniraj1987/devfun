@extends('layouts.app')
@section('content')
<?php
use App\Match;
?>
<section>
    <div class="container">
        <div class="fancy-history-block">
            <div class="in_play_tabs-2 mb-0">
                <ul class="nav nav-tabs" role="tablist">
                    <?php $count=1; ?>
                    @foreach($sports as $sport)
                    <li class="nav-item gettab{{$count}}" data-id="{{$sport->sport_name}}">
                        <a class="nav-link text-color-blue-1 white-bg  {{$sport->sport_name}}" href="#{{$sport->sport_name}}" data-toggle="tab">{{$sport->sport_name}}</a>
                    </li>
                    <?php $count++; ?>
                    @endforeach
                </ul>
                <div class="tab-content" id="tabdatadiv">
                    <?php $i=0; ?>
                    @foreach($sports as $sport)
                    <?php
                    $match = Match::where('sports_id',$sport->id)->get();
                    ?>
                    <div role="tabpanel" class="tab-pane @if($i==0) active @endif show" id="{{$sport->sport_name}}">
                        <div class="programe-setcricket">
                            <div class="firstblock-cricket lightblue-bg1">
                                <span class="fir-col1"></span>
                                <span class="fir-col2">1</span>
                                <span class="fir-col2">X</span>
                                <span class="fir-col2">2</span>
                                <span class="fir-col3"></span>
                            </div>
                             @foreach($match as $matches)
                            <div class="secondblock-cricket white-bg">
                                <span class="fir-col1">
                                    <a href="#" class="text-color-blue-light">{{$matches->match_name}}</a>
                                    <div>{{$matches->match_date}}</div>
                                </span>
                                <span class="fir-col2">
                                    <a class="backbtn lightblue-bg2">2.42</a>
                                    <a class="laybtn lightpink-bg1">2.9</a>
                                </span>
                                <span class="fir-col2">
                                    <a class="backbtn lightblue-bg2">--</a>
                                    <a class="laybtn lightpink-bg1">--</a>
                                </span>
                                <span class="fir-col2">
                                    <a class="backbtn lightblue-bg2">1.53</a>
                                    <a class="laybtn lightpink-bg1">1.7</a>
                                </span>
                                <span class="fir-col3">
                                    <a><img src="{{ URL::to('asset/front/img/round-pin.png') }}"> <img class="hover-img" src="{{ URL::to('asset/front/img/round-pin1.png') }}"></a>
                                </span>
                            </div>
                             @endforeach
                              @php $i++; @endphp
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    var gettab =  $('.gettab1').attr("data-id");
    $("."+gettab).addClass("active");
    setInterval(function(){
        var _token = $("input[name='_token']").val();
            $.ajax({
            type: "POST",
            url: '{{route("getmatchdetails")}}',
            data: {_token:_token},
            success: function(data){
                $("#tabdatadiv").html(data);
            }
        });
    },1000);
});
</script>
@endsection