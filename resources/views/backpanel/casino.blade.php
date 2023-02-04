@extends('layouts.app')
@section('content')

<section>
    <div class="container">
        <div class="inner-title player-right justify-content-between py-2">
            <h2>Casino</h2>
            <div class="btn-wrapadd">
                <a href="{{route('addCasino')}}" class="add_player grey-gradient-bg text-color-black">Add Casino</a>
            </div>
        </div>
        <div class="list-games-block">
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="light-grey-bg">Sr.No.</th>
                        <th class="light-grey-bg">Casino Name</th>
                        <th class="light-grey-bg">Image</th>
                        <th class="light-grey-bg">Link</th>
                        <th class="light-grey-bg">Active/Inactive</th>
                        <th class="light-grey-bg">Min</th>
                        <th class="light-grey-bg">Max</th>
                        <th class="light-grey-bg" width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach($casino as $casinoes)
                    @php $Status=''; @endphp
                     @if($casinoes->status==1)
                                @php
                                $Status = 'checked'
                                @endphp
                                @endif

                    <tr>
                        <td class="white-bg">{{$count}}</td>
                        <td class="white-bg">{{$casinoes->casino_name}}</td>
                        <td class="white-bg"><img src="{{ URL::to('public/asset/upload') }}/{{$casinoes->casino_image}}" width="100px;" height="100px;"></td>
                        <td class="white-bg">{{$casinoes->casino_link}}</td>
                        <td class="white-bg"><input type="checkbox" {{$Status}} id="checkactive{{$casinoes->id}}" class="chkstatusactive" data-fid="{{$casinoes->id}}" value="1"></td>
                        <td class="white-bg"><input type="text" id="casinomin{{$casinoes->id}}" name="min" class="form-control txtcasinomin allowNumeric" data-fid="{{$casinoes->id}}" value="{{$casinoes->min_casino}}"></td>
                        <td class="white-bg"><input type="text" id="casinomax{{$casinoes->id}}" name="max" class="form-control txtcasinomax allowNumeric" data-fid="{{$casinoes->id}}" value="{{$casinoes->max_casino}}"></td>
                        <td class="white-bg">
                            <a href="" class="btn-list black-bg2 text-color-white">Edit</a>
                            <a href="" class="btn-list black-bg2 text-color-white">Delete</a>
                        </td>
                    </tr>
                    <?php $count++; ?>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(".chkstatusactive").on('click', function(event) {
    var _token = $("input[name='_token']").val();
    var fid = $(this).attr('data-fid');
    var chk = (this.checked ? $(this).val() : "");
    $.ajax({
        type: "POST",
        url: '{{route("chkstatusactive")}}',
        data: {
            _token: _token,
            fid: fid,
            chk: chk
        },
        success: function(data) {
            if(data.result=='success'){
                toastr.success(data.message);
            }
        }
    });
});

$(".txtcasinomin").blur(function() {
    var _token = $("input[name='_token']").val();
    var fid = $(this).attr('data-fid');
    var chk = $(this).val();
    $.ajax({
        type: "POST",
        url: '{{route("savecasinoMinLimit")}}',
        data: {
            _token: _token,
            fid: fid,
            chk: chk
        },

        success: function(data) {
            if (data.trim() == 'Fail')
                toastr.error('Problem in updating min limit!');
            else
            toastr.success('Status changed successfully!');
        }
    });
});

$(".txtcasinomax").blur(function() {
    var _token = $("input[name='_token']").val();
    var fid = $(this).attr('data-fid');
    var chk = $(this).val();
    $.ajax({
        type: "POST",
        url: '{{route("savecasinoMaxLimit")}}',
        data: {
            _token: _token,
            fid: fid,
            chk: chk
        },

        success: function(data) {
            if (data.trim() == 'Fail')
                toastr.error('Problem in updating max limit!');
            else
            toastr.success('Status changed successfully!');
        }
    });
});

$(".allowNumeric").keypress(function(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});
</script>
@endsection