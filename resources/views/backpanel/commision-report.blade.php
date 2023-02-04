@extends('layouts.app')
@section('content')
<section>
	<div class="container">
    	<div class="breadcrumbs">
        	<ul>
            	<li> <a href="#" class="text-color-black" > <span class="red-bg text-color-white">com</span> nipa </a> </li>
            </ul>
    	</div>
    </div>
</section>
<section class="myaccount-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-12 pl-0">
				@include('backpanel.account-menu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12">
            	<div class="pagetitle text-color-blue-2 mb-10">
					<h1> Commission Report </h1>
				</div>
				<form >
                	<div class="row datediv1">
						<div class="col-md-3 datediv">
							<label>Selecte From Date: </label>
							<input name="fromdate" id="fromdate" class="form-control period_date1" type="text" autocomplete="off">
                             <img src="{{ URL::to('asset/img/calendar-icon.png') }}" class="calendar-icon_2">
						</div>
						<div class="col-md-3 datediv">
							<label>Select To Date: </label>
							<input name="todate" id="todate" class="form-control period_date2" type="text" readonly="" autocomplete="off">
                            <img src="{{ URL::to('asset/img/calendar-icon.png') }}" class="calendar-icon_2">
						</div>
						<div class="col-md-3">
							<label>User : </label>
							<select name="userName" id="userName" class="form-control acc-filter">
                                <option value=""> All </option>
                                @foreach($user as $users)
								<option value="{{$users->id}}">{{$users->user_name}}</option>
                                @endforeach
                                
							</select>
						</div>
						<div class="col-md-1">
                        	<label> &nbsp; </label>
							<input id="acntbtn" type="button" value="Submit" name="acntbtn" class="submit-btn text-color-yellow" onclick="getCommissionReport()">
						</div>
					</div>
				</form>
				<div class="white-bg mt-20 acc-statement">					
					<table class="table custom-table white-bg text-color-blue-2">
                        <thead>
                            <tr>
                                <th class="light-grey-bg">Sr. No</th>
                                <th class="light-grey-bg">User Name</th>
                                <th class="light-grey-bg">Com. Presentage</th>
                                <th class="light-grey-bg">Commission</th>
                            </tr>
                        </thead>
    			        <tbody id="append_data">
                        </tbody>
				    </table>
				</div>
                You Can Got Only Max 15 Days Report
			</div>
		</div>
    </div>
</section>

<div class="modal credit-modal showForm" id="mycomreport">
    <div class="modal-dialog">
        <div class="modal-content white-bg">
        	<div class="modal-header border-0">
                <h4 class="modal-title text-color-blue-1 user_name">(Pankaj)</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ URL::to('asset/img/close-icon.png')}}"></button>
            </div>
            <div class="modal-body">
				<table class="table custom-table white-bg text-color-blue-2">
                    <thead>
                        <tr>
                            <th class="light-grey-bg">Sr. No</th>
                            <th class="light-grey-bg">Match Name</th>
                            <th class="light-grey-bg">User Profit</th>
                            <th class="light-grey-bg">Commission</th>
                        </tr>
                    </thead>
                    <tbody id="appendpopup_data">
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $( "#fromdate" ).datepicker({
        dateFormat: "yy-mm-dd",
        onClose: function() {
            var date2 = $('#fromdate').datepicker('getDate');
            date2.setDate(date2.getDate()+14)
            $( "#todate" ).datepicker("setDate", date2);
        }
    });
    $( "#todate" ).datepicker({
        dateFormat: "yy-mm-dd",
    });
});

var _token = $("input[name='_token']").val();
function getCommissionReport() {    
    var date_from = $('#fromdate').val();
    var todate = $('#todate').val();
    var userName = $('#userName').val();
    $.ajax({
        type: "POST",
        url: '{{route("getCommissionReport")}}',
        data: {
            _token: _token,
            date_from:date_from,
            todate:todate,
            userName:userName,
        },              
        success: function(data) {
            $('#append_data').html(data.html);
        }
    });
}

function openReport(vl) {
    var userId = $(vl).data("id");
    var name = $(vl).data("name");
    var date_from = $('#fromdate').val();
    var todate = $('#todate').val();
    $.ajax({
        type: "POST",
        url: '{{route("getCommissionPopup")}}',
        data: {
            _token: _token,
            date_from:date_from,
            todate:todate,
            userId:userId,
        },              
        success: function(data) {
            $('.user_name').html(name);
            $(".showForm").modal('show');
            $('#appendpopup_data').html(data.html);
        }
    });
}
</script>
@endsection