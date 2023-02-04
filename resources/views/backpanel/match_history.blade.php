@extends('layouts.app')
@section('content')
<?php
use App\Sport;
?>
<section>
    <div class="container">
        <div class="inner-title player-right justify-content-between py-2">
            <h2>Match History</h2>
        </div>
        <div class="list-games-block match_history_table">
            <table id="example2" class="display nowrap" style="width:100%">
                <thead>
                    <tr class="light-grey-bg">
                        <th>Sr.No.</th>
                        <th>Sport Name</th>
                        <th>Match Name</th>
                        <th>Match Id</th>
                        <th>Event Id</th>
                        <th>Open Date</th>
                        <th>Winner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count=1; ?>
                        @foreach($matchList as $match)
                        <?php
                    	if($match->sports_id==4){
                    		$sport='Cricket';
                    	}elseif($match->sports_id==2){
                    		$sport='Tennis';
                    	}elseif($match->sports_id==1){
                    		$sport='Soccer';
                    	}
                	?>
                    <tr class="white-bg">
                        <td>{{$count}}</td>
                        <td>{{$sport}}</td>
                        <td>{{$match->match_name}}</td>
                        <td>{{$match->match_id}}</td>
                        <td>{{$match->event_id}}</td>
                        <td>{{date("d/m/Y H:i:s",strtotime($match->match_date))}}</td>
                        <td>{{$match->winner}}</td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{$match->id}}" onclick="resultRollbackMatch(this);" class="text-color-blue">RESULT ROLLBACK</a>
                        </td>
                    </tr>
                    <?php $count++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    var _token = $("input[name='_token']").val();
    function resultRollbackMatch(val) {
        if (!confirm('Are you Sure RollBack?')) {
            return false;
        }
        var id = $(val).data('id');
        $.ajax({
            url: "{{route('resultRollbackMatch')}}",
            type: "POST",
            data: {
                _token: _token,
                id: id,
            },
            success: function(response) { //alert(response);
           		location.reload();
           		toastr.success('RollBack Successfully!');                
            },
        });
    }
</script>
@endsection
