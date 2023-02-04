@extends('layouts.front_layout')
@section('content')
<?php 
use App\setting;
use App\User;
use App\CreditReference;
$settings = CreditReference::where('player_id',$loginuser->id)->first();
$balance=$settings['available_balance_for_D_W'];

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<section>
    <div class="container-fluid">
        <div class="main-wrapper">
           @include('front.leftpanel-account')
            <div class="dashboard-right-pannel">
                <div class="pagetitle text-color-blue-2">
                    <h1>Account Statement</h1>
                </div>
                <div class="summery-table mt-3">
                    <table class="table custom-table" id="table">
                        <thead>
                            <tr class="light-grey-bg">
                                <th>Date/Time</th>
                                <th class="text-right">Deposit</th>
                                <th class="text-right">Withdraw</th>
                                <th class="text-right">Balance</th>
                                <th class="text-right">Remark</th>
                                <th class="text-right">From/To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; $previousValue = null; $prev_bal=0; $chk_ori=0; $closing_balance=0; $next_row_balance=0; @endphp
                            
                            @foreach($credit as $data)
                                <?php 
                                    $from_data = User::where('id',$data->parent_id)->first();
                                    $todatasds = User::where('id',$data->child_id)->first();
                                ?>
                                <tr>
                                    <td>{{$data->created_at}}</td>
                                    <td class="text-color-green text-right">
                                        <?php 
                                        if($data->balanceType == 'DEPOSIT'){
                                            echo $data->amount;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-color-red text-right">
                                        <?php 
                                        if($data->balanceType == 'WITHDRAW'){
                                            echo $data->amount;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php 
                                        if ($i == 0){
                                            $prev_bal=$balance; 

                                            if($data->balanceType == 'DEPOSIT'){
                                                $closing_balance=$player_balance;
                                                echo $closing_balance;
                                                $next_row_balance=$player_balance-$data->amount;
                                            }

                                            if($data->balanceType == 'WITHDRAW'){
                                                $closing_balance=$player_balance;
                                                echo $closing_balance;
                                                $next_row_balance =$player_balance+$data->amount;
                                            }
                                        }
                                        else{
                                            if($data->balanceType == 'DEPOSIT'){
                                                $closing_balance=$player_balance-$data->amount;
                                                echo $next_row_balance;
                                                $next_row_balance=$next_row_balance-$data->amount;
                                            }
                                            if($data->balanceType == 'WITHDRAW'){
                                                $closing_balance=$player_balance+$data->amount;
                                                echo $next_row_balance;
                                                $next_row_balance=$next_row_balance+$data->amount;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right">{{$data->extra}}</td>
                                    <?php
                                    $uname=''; 
                                    if(!empty($todatasds)){
                                        $uname=$todatasds->user_name;
                                    }
                                    ?>
                                    <td class="text-right">{{$from_data->user_name}}  <i class="fas fa-caret-right text-color-grey"></i> {{$uname}}</td>
                                </tr>
                                @php 
                                $i++; 
                                $previousValue = $data;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <ul class="paginationn-full">
                        <li id="prev"> <a href="javascript:void(0);" class="disable-bg disable-color">Prev</a> </li>
                        
                        <li id="pageNumber"> <a href="javascript:void(0);" class="linkitem black-bg2 text-color-yellow">1</a> </li>
                        
                        <li id="next"> <a href="javascript:void(0);" class="disable-bg disable-color">Next</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready( function () {
 var table = $('#table').DataTable();
});
</script>
@include('layouts.footer')
@endsection