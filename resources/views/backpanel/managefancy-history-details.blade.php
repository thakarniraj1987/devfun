@extends('layouts.app')
@section('content')
<section>
  <div class="container">
    <div class="inner-title">
      <h2>Manage Fancy Detail</h2>
    </div>

    <div class="fancy-history-details">
      <table class="table custom-table white-bg text-color-blue-2 fancy_tablenew">
        <thead>
          <tr>
            <th class="white-bg text-left">Sr.No.</th>
            <th class="white-bg text-left">Fancy Name</th>
            <th class="white-bg text-center">Declare Run</th>
            <th class="white-bg text-center">Action</th>
          </tr>
        </thead>

        <tbody id="appendBF">
        </tbody>
      </table>
    </div>
  </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
var _token = $("input[name='_token']").val();
$(document).ready(function() {
	$.ajax({
    type: "POST",
    url: '{{route("getFancy",$match->id)}}',
    data: {
        _token: _token,                   
    },
    beforeSend: function() {
        $('#loaderimagealldiv').show();
    },
    complete: function() {
        $('#loaderimagealldiv').hide();
    },
    success: function(data) {
        $("#appendBF").html(data);
    }
  });
});

function resultDeclare(val){
  if(!confirm('Are you Sure?')){
    return false;
  }
  var fancyname = $(val).data('fancy');
  var match_id = $(val).data('match');
  var eventid = $(val).data('eventid');
  var betId = $(val).data('betid');
  var aa = $(val).data('fancyre');
  var fancy_result = $('#fancy_result'+aa).val();
  $.ajax({
    url: "{{route('resultDeclare')}}",
    type: "POST",
    data: {
      _token:_token,
      fancyname:fancyname,
      fancy_result:fancy_result,
      match_id:match_id,
      betId:betId,
      eventid:eventid,
    },     
    success: function(response){ 
      location.reload();
      toastr.success('Result declare successfully!');        
    },
  });
}

function resultDeclarecancel(val){
  if(!confirm('Are you Sure?')){
    return false;
  }
  var _token = $("input[name='_token']").val();
  var fancyname = $(val).data('fancy');
  var match_id = $(val).data('match');
  var betId = $(val).data('betid');
  $.ajax({
    url: "{{route('resultDeclarecancel')}}",
    type: "POST",
    data: {
        _token:_token,   
        fancyname:fancyname,
        match_id:match_id,
        betId:betId,
    },     
    success: function(response){
      toastr.success('Result declare successfully!');
      location.reload();
    },
  });
}
</script>
@endsection