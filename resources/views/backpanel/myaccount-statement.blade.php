@extends('layouts.app')
@section('content')
<?php 
use App\setting;
use App\User;
use App\CreditReference;
$settings = ""; $balance=0;
$loginuser = Auth::user(); 
$ttuser = User::where('id',$loginuser->id)->first();
$auth_id = Auth::user()->id;
$auth_type = Auth::user()->agent_level;
if($auth_type=='COM'){
	$settings = setting::latest('id')->first();
	$balance=$settings->balance;
}
else
{
	$settings = CreditReference::where('player_id',$auth_id)->first();
	$balance=$settings['available_balance_for_D_W'];
}
?>


<section>
	<div class="container">
    	<div class="breadcrumbs">
        	<ul>
            	<li> <a href="#" class="text-color-black" > <span class="red-bg text-color-white">{{$user->agent_level}}</span> {{$user->user_name}} </a> </li>
            </ul>
    	</div>
    </div>
</section>
<section class="myaccount-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-12 pl-0">
				@include('backpanel/downline-account-menu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12">
                	<div class="pagetitle text-color-blue-2 mb-10">
						<h1> Account Statement </h1>
					</div>
					<form>
                        <div class="row">
							@csrf
							<div class="col-md-3">
								<label>Client: </label>
								<select name="user" id="user" class="form-control acc-filter">
									@foreach($list as $data)
								  		<option value="{{$data->user_name}}">{{$data->user_name}}</option>
								  	@endforeach
								</select>
							</div>
							<div class="col-md-3">
								<label>From: </label>
								<input name="fromdate" id="fromdate" class="form-control" type="date">
							</div>
							<div class="col-md-3">
								<label>To: </label>
								<input name="todate" id="todate" class="form-control" type="date">
							</div>
							<div class="col-md-1">
                            	<label> &nbsp; </label>
								<input id="acntbtn" type="button" value="Submit" name="acntbtn" class="submit-btn text-color-yellow">
							</div>
                        </div>
					</form>
				<div class="white-bg mt-20 acc-statement">
					<table class="table custom-table white-bg text-color-blue-2" id="pager">
                    <thead>
                        <tr>
                            <th class="light-grey-bg">Date/Time</th>
                            <th class="light-grey-bg">Deposit</th>
                            <th class="light-grey-bg">Withdraw</th>
                            <th class="light-grey-bg">Balance</th>
                            <th class="light-grey-bg">Remark</th>
                            <th class="light-grey-bg">From/To</th>
                        </tr>
                    </thead>
                    <tbody id="tbdata">
			        </tbody>
					</table>
				</div>
                <div class="pagination-wrap light-grey-bg-1">
                    <ul class="pages">
                        <li id="prev"><a class="disable disable-bg disable-color">Prev</a></li>
                        <li id="pageNumber"><a class="active text-color-yellow">1</a></li>
						<li id="pageNumber"><a>2</a></li>
						<li id="pageNumber"><a>3</a></li>
                        <li id="next"><a class="">Next</a></li>
                    </ul>
                </div>
			</div>
		</div>
    </div>
</section>

<script>
$('#acntbtn').click(function(){  
	var startdate = $("#fromdate").val();
	var todate = $("#todate").val();
	var user = $("#user").val();
	
	$.ajax({
        type: "post",
        url: '{{route("data-myaccount-statement")}}',
        data: {"_token": "{{ csrf_token() }}","startdate":startdate,"todate":todate,"user":user},
        success: function(data){
           	$("#tbdata").html(data);
        }
    });
});

$(document).ready(function() {  
    $('#pager').DataTable( {  
        initComplete: function () {  
            this.api().columns().every( function () {  
                var column = this;  
                var select = $('<select><option value=""></option></select>')  
                    .appendTo( $(column.footer()).empty() )  
                    .on( 'change', function () {  
                        var val = $.fn.dataTable.util.escapeRegex(  
                            $(this).val()  
                        );  
                        column  
                            .search( val ? '^'+val+'$' : '', true, false )  
                            .draw();  
                    } );  
                column.data().unique().sort().each( function ( d, j ) {  
                    select.append( '<option value="'+d+'">'+d+'</option>' )  
                } );  
            } );  
        }  
    } );  
} ); 
</script>
@endsection