<div class="footer_fixed chreme-bg">
    <div class="main_wrap container">
        <ul>
            <li>
                <span class="grey-gradient-bg"><img src="{{ URL::to('asset/img/coin-icon.png')}}"></span>
                <p>Bank</p>
            </li>
            <li>
                <span class="grey-gradient-bg"><img src="{{ URL::to('asset/img/updown-arrow-icon.png')}}"></span>
                <p>Betting Profit &amp; Loss</p>
            </li>
            <li>
                <span class="grey-gradient-bg"><img src="{{ URL::to('asset/img/history-icon.png')}}"></span>
                <p>Betting History</p>
            </li>
            <li>
                <span class="grey-gradient-bg"><img src="{{ URL::to('asset/img/user-icon.png')}}"></span>
                <p>Profile</p>
            </li>
            <li>
                <span class="grey-gradient-bg"><img src="{{ URL::to('asset/img/setting-icon.png')}}"></span>
                <p>Change Status</p>
            </li>
        </ul>
    </div>
</div>
</div>

<script src="{{ asset('asset/js/jquery.js') }}" ></script>
<script src="{{ asset('asset/js/popper.min.js') }}" ></script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('asset/js/jquery-ui.min.js') }}" ></script>
<script src="{{ asset('asset/js/jquery-ui.multidatespicker.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/dataTables.buttons.min.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/pdfmake.min.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/jszip.min.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/vfs_fonts.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/buttons.html5.min.js') }}" ></script>
<script src="{{ asset('asset/js/datatables/js/buttons.print.min.js') }}" ></script>
<script src="{{ asset('asset/js/script.js') }}" ></script>

<script>
function getBalance() {
	console.log('get balance');
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: "POST",
        url: '{{route("getAdminAgentBalance")}}',
        data: {
            _token: _token
        },
        success: function(data) {
            if (data != '') {
                var spl = data.split('~~');
                $("#myadminbalance").text('PTH ' + spl[0].toFixed(2));
            }
        }
    });
}
function updatePasswordadmin() {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: "POST",
        url: '{{route("changePassLogout")}}',
        data: {
            _token: _token,
        },
        success: function(data) {                
            if(data.result=='error'){
                window.location.href = "{{ route('backpanel')}}";
            }
            if(data.result=='msgsuccess'){
                    window.location.href = "{{ route('maintenance')}}";
            }
        }
    });
}
function maintenanceLogout() {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: "POST",
        url: '{{route("maintenanceLogout")}}',
        data: {
            _token: _token,
        },
        success: function(data) {
            if(data.result=='msgsuccess'){
                    window.location.href = "{{ route('maintenance')}}";
            }
        }
    });
}

$(document).ready(function() {
setInterval(function() {
    updatePasswordadmin();
	getBalance(); 
    maintenanceLogout();
}, 10000)
});

$(document).ready(function()
{
 //auto logout ajax call 
    setInterval(function(){
        $.ajax({
            type: "post",
            url: '{{route("autoLogout")}}',
            data: {"_token": "{{ csrf_token() }}"},
            beforeSend:function(){
                $('#site_statistics_loading').show();
            },
            complete: function(){
                $('#site_statistics_loading').hide();
            },
            success: function(data){
                if(data.result=='suspendsuccess'){
                window.location.href = "{{ route('backpanel')}}";
            }
            if(data.result=='msgsuccess'){
                window.location.href = "{{ route('maintenance')}}";
            }
        }
    });
    },100000);
});
</script>
</body>
</html>