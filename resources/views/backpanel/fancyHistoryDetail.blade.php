@extends('layouts.app')
@section('content')
<section>
  <div class="container">
    <div class="inner-title">
      <h2>Fancy History</h2>
    </div>

    <div class="fancy-history-details">
      <table class="table custom-table white-bg text-color-blue-2 fancy_tablenew">
        <thead>
          <tr>
            <th class="white-bg text-left">Sr.No.</th>
            <th class="white-bg text-left">Fancy Name</th>
            <th class="white-bg text-center">Result</th>
            <th class="white-bg text-center">Action</th>
            <th class="white-bg text-center">Bet</th>
          </tr>
        </thead>

        <tbody id="appendBF">
          <?php $count=1; ?>
          @foreach($fancyResult as $fancyResults)
          <tr class="white-bg">
            <td class="text-center">{{$count}}</td>
            <td class="text-left">{{$fancyResults->fancy_name}}</td>
            <td class="text-center">{{$fancyResults->result}} </td>
            <td class="text-center"> <a href="javascript:void(0);" onclick="resultrollback('<?php echo $fancyResults->id; ?>');" class="text-color-blue-light">Result Rollback</a></td>
            <td class="text-center"> <a href="#" class="text-color-blue-light">Bet</a></td>
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
  function resultrollback(val){
      if(!confirm('Are you Sure RollBack Result?')){
        return false;
      }
    $.ajax({
      url: "{{route('resultRollback')}}",
      type: "POST",
      data: {
          _token:_token,
          id:val,         
      },     
      success: function(data){
        if(data.success=='success'){
          location.reload();
          toastr.success('RollBack Successfully!');        
        }
      },
    });
  }
</script>
@endsection