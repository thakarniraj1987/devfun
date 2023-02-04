@extends('layouts.app')
@section('content')
<?php
use App\Sport;
?>
<section>
    <div class="container">
        <div class="inner-title player-right justify-content-between py-2">
            <div class="row w-100">
                <div class="col-lg-6 col-md-6 col-sm-12 pl-0">
                    <h2>Website Setting</h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 pr-0 text-right">
                    <a data-toggle="modal" data-target="#myweb" class="submit-btn text-color-yellow" >
                    Add Website </a>
                </div>
            </div>
        </div>
        <div class="list-games-block match_history_table">
            <table id="example1" class="display nowrap" style="width:100%">
                <thead>
                    <tr class="light-grey-bg">
                        <th style="width:80px;">Sr. No.</th>
                        <th style="width:300px;">Site Title</th>
                        <th>Domain</th>
                        <th>Favicon</th>
                        <th>Logo</th>
                        <th>Login Image</th>
                        <th style="width:80px;">Active/Inactive</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($list))
                        @php $i=1; @endphp
                        @foreach($list as $data)
                            <tr class="white-bg">
                                <td>{{$i}}</td>
                                <td>{{$data->title}}</td>
                                <td>{{$data->domain}}</td>
                                @if($data->favicon != '')
                                    <td><img src="{{ URL::to('asset/front/img/')}}/{{$data->favicon}}" width="100px;" height="100px;"></td>
                                @else
                                    <td>--</td>
                                @endif
                                @if($data->logo != '')
                                    <td><img src="{{ URL::to('asset/front/img/')}}/{{$data->logo}}" width="100px;" height="100px;"></td>
                                @else
                                    <td>--</td>
                                @endif

                                @if($data->login_image != '')
                                    <td><img src="{{ URL::to('asset/front/img/')}}/{{$data->login_image}}" width="100px;" height="100px;"></td>
                                @else
                                    <td>--</td>
                                @endif

                               @php $webstatus='';@endphp

                                @if($data->status==1)
                                @php
                                $webstatus = 'checked'
                                @endphp
                                @endif

                                <td>
                                    <input type="checkbox" data-fid="{{$data->id}}" {{$webstatus}} id="{{$data->id}}" class="status chkstatusetting" value="1">

                                    <a href="{{route('WebsettingData',$data->id)}}" class="text-color-yellow" id="{{$data->id}}"  style="color: #000 !important;">
                                    <i class="fas fa-edit"></i> </a>

                                </td>
                                
                               
                            </tr>
                        @php $i++; @endphp
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal credit-modal changepwd-modal" id="myweb"> 
    <div class="modal-dialog">
        <div class="modal-content light-grey-bg-1">
            <div class="modal-header">
                <h4 class="modal-title text-color-blue-1">Add New Website</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <form method="post" action="{{route('addWebsite')}}" id="form" autcomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-modal">
                        <div>
                            <span>Site Title</span>
                            <span><input id="title" name="title" type="text" placeholder="Site Title" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <span class="text-danger cls-error" id="errtitle"></span>

                        <div>
                            <span>Domain</span>
                            <span><input type="text" id="domain" name="domain" placeholder="Domain" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                         <div>
                            <span>Favicon Icon</span>
                            <span><input type="file" id="favicon" name="favicon" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <div>
                            <span>Logo</span>
                            <span><input type="file" id="logo" name="logo" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <div>
                            <span>Login Image</span>
                            <span><input type="file" id="login_image" name="login_image" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <span class="text-danger cls-error" id="errnewpwd"></span>
                    </div>
                    <div class="button-wrap">
                        
                        <button class="submit-btn text-color-yellow" name="btnpwd" id="btnpwd" value="save"> Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal credit-modal changepwd-modal" id="mywebedit"> 
    <div class="modal-dialog">
        <div class="modal-content light-grey-bg-1">
            <div class="modal-header">
                <h4 class="modal-title text-color-blue-1">Add New Website</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <form method="post" action="{{route('addWebsite')}}" id="form" autcomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-modal">
                        <div>
                            <span>Site Title</span>
                            <span><input id="title" name="title" type="text" placeholder="Site Title" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <span class="text-danger cls-error" id="errtitle"></span>

                        <div>
                            <span>Domain</span>
                            <span><input type="text" id="domain" name="domain" placeholder="Domain" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                         <div>
                            <span>Favicon Icon</span>
                            <span><input type="file" id="favicon" name="favicon" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <div>
                            <span>Logo</span>
                            <span><input type="file" id="logo" name="logo" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <div>
                            <span>Login Image</span>
                            <span><input type="file" id="login_image" name="login_image" class="form-control white-bg"> <label class="text-color-red"> * </label> </span>
                        </div>
                        <span class="text-danger cls-error" id="errnewpwd"></span>

                    </div>
                    <div class="button-wrap">
                        
                        <button class="submit-btn text-color-yellow" name="btnpwd" id="btnpwd" value="save"> Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    /*function weblock(val){
        var data = val;
        $.ajax({
            type: "post",
            url: '{{route("updateWebsetting")}}',
            data: {"_token": "{{ csrf_token() }}","data":data},
            success: function(data){
               toastr.success('WebSite Updated successfully !!!');
            }
        });
    }*/

   $(".chkstatusetting").on('click', function(event) {
    var _token = $("input[name='_token']").val();
    var fid = $(this).attr('data-fid');
    var chk = (this.checked ? $(this).val() : "");
    $.ajax({
        type: "POST",
        url: '{{route("updateWebsetting")}}',
        data: {
            _token: _token,
            fid: fid,
            chk: chk
        },
        success: function(data) {
            toastr.success('WebSite Updated successfully !!!');
        }
    });
});
    
</script>
@endsection