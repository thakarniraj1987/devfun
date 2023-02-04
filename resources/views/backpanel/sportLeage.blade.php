@extends('layouts.app')
@section('content')

<section class="profit-section section-mlr pb-5">
  <div class="container">
    <div class="inner-title">
      <h2>Sports Leage</h2>
    </div>

    <div class="sports_leage">
      <div class="w-100 row">
        <form id="frmsp" name="frmsp" class="timeblock-box">
          <div class="datediv2">
            <label for="">Sports</label>
            <select name="sports" id="sports" class="form-control" onchange="getallMatch();" style="display:inline-block">
              <option value="">-Select Sport-</option>
                @foreach($sport as $sports)
                <option value="{{$sports->sId}}">{{$sports->sport_name}}</option>
                  @endforeach
            </select>
          </div>
          <div class="datediv2">
            <label for="">Leage</label>
            <select name="leage" id="leage" onchange="getLeageData();" class="form-control" style="display:inline-block">
              <option value="">Select Leage</option>
            </select>
          </div>
        </form>
      </div>
      <div id="site_statistics_loading" class="loaderimage"></div>
      <table class="table custom-table white-bg text-color-blue-2">
        <thead>
          <tr class="light-grey-bg">
              <th>Match Id</th>
              <th>Event Id</th>
              <th class="text-left">Match Name</th>
              <th class="text-left">Match Date</th>
              <th class="text-left">Action</th>
          </tr>
        </thead>
        <tbody id="append_tablebody">
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#frmsp').each(function() {
    this.reset()
  });
});

function getallMatch(sId) {
  $("#append_tablebody").html("");
  var _token = $("input[name='_token']").val();
  var sId = $('#sports').val();
  $.ajax({
    type: "post",
    url: '{{route("getallMatch")}}',
    data: {
      _token: _token,
      sId: sId
    },
    success: function(data) {
      $("#leage").html(data);
    }
  });
}

function getLeageData(sId) {
  var _token = $("input[name='_token']").val();
  var sId = $('#sports').val();
  var leage = $('#leage').val();
  $.ajax({
    type: "post",
    url: '{{route("getLeageData")}}',
    data: {
      _token: _token,
      sId: sId,
      leage: leage
    },
    success: function(data) {
      $("#append_tablebody").html(data);
    }
  });
}

function addMatch(val) {
  var event_id = $(val).data("eventid");
  var match_name = $(val).data("event");
  var match_id = $(val).data("marketid");
  var match_date = $(val).data("matchdate");
  var sports_id = $(val).data("sid");
  var leage = $(val).data("leage");
  var _token = $("input[name='_token']").val();
  $.ajax({
    type: "post",
    url: "{{route('addMatchFromAPI')}}",
    data: {
      _token: _token,
      match_name: match_name,
      match_id: match_id,
      match_date: match_date,
      event_id: event_id,
      sports_id: sports_id,
      leage:leage,
    },
    success: function(data) {
      if(data.result=='error'){
        toastr.error(data.message);
      }
      if(data.result=='success'){
        toastr.success(data.message);
      }
    }
  });
}
</script>
@endsection
