@extends('layouts.front_layout')
@section('content')
<style>
    body {
        overflow: hidden;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="main-wrapper">
            @include('layouts.leftpanel')
            <div class="middle-section">
                <div class="news-addvertisment black-gradient-bg text-color-white">
                    <h4>News</h4>
                    <marquee>
                        <a href="#" class="text-color-blue">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</a>
                    </marquee>
                </div>
				<div class="middle-wraper">
					<div class="in_play_tabs">
                    	<ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-color-blue-1 white-bg active" href="#inplay" role="tab" data-toggle="tab">In-Play</a>
                            </li>
                        </ul>
						<div class="tab-content">
                        	<div role="tabpanel" class="tab-pane active" id="inplay">
                            	<div class="programe-setcricket today_content">
                                    <a class="todaytitle darkblue-bg text-color-white" data-toggle="collapse" href="#cricket-collapse" role="button" aria-expanded="false" aria-controls="cricket-collapse">
                                    	Cricket <img src="{{URL::to('asset/front/img/minus-icon.png')}}"></a>		
                                 	<div class="collapse show" id="cricket-collapse">
                                        <div class="firstblock-cricket lightblue-bg1">
                                            <span class="fir-col1"></span>
                                            <span class="fir-col2">1</span>
                                            <span class="fir-col2">X</span>
                                            <span class="fir-col2">2</span>
                                            <span class="fir-col3"></span>
                                        </div>
                                        @if($cricket_html!='')
                                        {!!$cricket_html!!}
                                        @else
                                        	No match found.
                                        @endif
                                    </div>
                                </div>  
                            	<div class="programe-setcricket today_content">
                                    <a class="todaytitle darkblue-bg text-color-white" data-toggle="collapse" href="#soccer-collapse" role="button" aria-expanded="false" aria-controls="soccer-collapse">
                                    	Soccer <img src="{{URL::to('asset/front/img/minus-icon.png')}}"></a>		
                                   	<div class="collapse" id="soccer-collapse">
                                        <div class="firstblock-cricket lightblue-bg1">
                                            <span class="fir-col1"></span>
                                            <span class="fir-col2">1</span>
                                            <span class="fir-col2">X</span>
                                            <span class="fir-col2">2</span>
                                            <span class="fir-col3"></span>
                                        </div>
                                        @if($soccer_html!='')
                                        {!! $soccer_html !!}
                                        @else
                                        	No match found.
                                        @endif
                                    </div>
                                </div>
                                <div class="programe-setcricket today_content">
                                    <a class="todaytitle darkblue-bg text-color-white" data-toggle="collapse" href="#tennis-collapse" role="button" aria-expanded="false" aria-controls="tennis-collapse">
                                    Tennis <img src="{{URL::to('asset/front/img/minus-icon.png')}}"></a>
                                    <div class="collapse" id="tennis-collapse">
                                        <div class="firstblock-cricket lightblue-bg1">
                                            <span class="fir-col1"></span>
                                            <span class="fir-col2">1</span>
                                            <span class="fir-col2">X</span>
                                            <span class="fir-col2">2</span>
                                            <span class="fir-col3"></span>
                                        </div>
                                        @if($tennis_html!='')
                                        {!! $tennis_html !!}
                                        @else
                                        	No match found.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.rightpanel')
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	setInterval(function(){
	    var _token = $("input[name='_token']").val();
		$.ajax({
			type: "POST",
			url: '{{route("getmatchdetailsOfInplay")}}',
			data: {_token:_token},
			beforeSend:function(){
           		$('#site_statistics_loading').show();
            },
            complete: function(){
            	$('#site_statistics_loading').hide();
            },
			success: function(data){
				var dt=data.split("~~");
				var i=0;
				for(i=0;i<dt.length;i++)
				{
					if(i==0)
						$("#cricket-collapse").html(dt[i]);
					else if(i==2)
						$("#soccer-collapse").html(dt[i]);
					else if(i==1)
						$("#tennis-collapse").html(dt[i]);
				}
			}
		});
	},10000);
});
</script>
@endsection