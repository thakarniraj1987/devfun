<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="title_new_at">
                Match & Session Plus Minus Report Selection Match Code : <?php echo $event->event_id; ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:scroll;">
            <?php
            // p($reports);
            // if(!empty($reports))
            // {
            //     foreach($reports as $report)
            //     {

            //     }
            // }
            ?>
            <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                <tbody>
                    <tr class="bengani-bg">
                        <td width="60"><strong>ADMIN </strong></td>
                        <td><strong><?php echo $reports->user_name; ?>(<?php echo $reports->name; ?>)</strong></td>
                    </tr>

                    <tr>
                        <?php
                        if (!empty($reports->admins)) {
                            $admins = $reports->admins;


                            foreach ($admins as $admin) { ?>
                    <tr>
                        <td colspan="2" height="25">

                            <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                <tbody>
                                    <tr class="red-bg">
                                        <td width="60"><strong>SUB ADMIN </strong></td>
                                        <td><strong><?php echo $admin->user_name; ?>(<?php
                                                                                        echo $admin->name; ?>)</strong></td>
                                    </tr>


                                    <?php
                                    if (!empty($admin->hypers)) {
                                        $hypers = $admin->hypers;


                                        foreach ($hypers as $hyper) { ?>
                                            <tr>
                                                <td colspan="2" height="25">

                                                    <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                                        <tbody>
                                                            <tr class="yellow-bg">
                                                                <td width="60"><strong>MASTER AGENT </strong></td>
                                                                <td><strong><?php echo $hyper->user_name; ?>(<?php
                                                                                                                echo $hyper->name; ?>)</strong></td>
                                                            </tr>
                                                            <?php


                                                            if (!empty($hyper->supers)) {
                                                                $supers = $hyper->supers;
                                                                foreach ($supers as $super) { ?>
                                                                    <tr>
                                                                        <td colspan="2" height="25">

                                                                            <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                                                                <tbody>
                                                                                    <tr class="sky-blue-bg">
                                                                                        <td width="60"><strong>SUPER AGENT </strong></td>
                                                                                        <td><strong><?php echo $super->user_name; ?>(<?php
                                                                                                                                        echo $super->name; ?>)</strong></td>
                                                                                    </tr>
                                                                                    <?php if (!empty($super->masters)) {
                                                                                        $masters = $super->masters;



                                                                                        foreach ($masters as $master) {
                                                                                            
                                                                                            
                                                                                        $agent_match_amt_6 = 0;
                                                                                        $agent_sess_amt_6 = 0;
                                                                                        $agent_total_match_amt_6 = 0;

                                                                                        $agent_match_comm_amt_6 = 0;
                                                                                        $agent_sess_comm_amt_6 = 0;
                                                                                        $agent_total_comm_amt_6 = 0;


                                                                                        $agent_net_amt_6 = 0;
                                                                                        $agent_share_amt_6 = 0;
                                                                                        $agent_final_amt_6 = 0;




                                                                                     

                                                                                        $super_agent_match_comm_amt_6 = 0;
                                                                                        $super_agent_sess_comm_amt_6 = 0;
                                                                                        $super_agent_total_comm_amt_6 = 0;
                                                                                        $super_agent_net_amt_6 = 0;
                                                                                        $super_agent_share_amt_6 = 0;
                                                                                        $super_agent_final_amt_6 = 0;



                                                                                        $master_agent_match_comm_amt_6 = 0;
                                                                                        $master_agent_sess_comm_amt_6 = 0;
                                                                                        $master_agent_total_comm_amt_6 = 0;
                                                                                        $master_agent_net_amt_6 = 0;
                                                                                        $master_agent_share_amt_6 = 0;
                                                                                        $master_agent_final_amt_6 = 0;


                                                                                        $sub_admin_match_comm_amt_6 = 0;
                                                                                        $sub_admin_sess_comm_amt_6 = 0;
                                                                                        $sub_admin_total_comm_amt_6 = 0;
                                                                                        $sub_admin_net_amt_6 = 0;
                                                                                        $sub_admin_share_amt_6 = 0;
                                                                                        $sub_admin_final_amt_6 = 0;


                                                                                        $admin_match_comm_amt_6 = 0;
                                                                                        $admin_sess_comm_amt_6 = 0;
                                                                                        $admin_total_comm_amt_6 = 0;
                                                                                        $admin_net_amt_6 = 0;
                                                                                        $admin_share_amt_6 = 0;
                                                                                        $admin_final_amt_6 = 0;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td colspan="2" height="25">

                                                                                                    <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                                                                                        <tbody>
                                                                                                            <tr class="blue-bg">
                                                                                                                <td width="60"><strong>AGENT </strong></td>
                                                                                                                <td><strong><?php echo $master->user_name; ?>(<?php
                                                                                                                                                                echo $master->name; ?>)</strong></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2" height="25">

                                                                                                                    <!--CLIENT START HERE-->
                                                                                                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="table table-striped table-bordered" style="padding-bottom:100px;">
                                                                                                                        <tbody>
                                                                                                                            <tr>


                                                                                                                                <td colspan="11" align="right" valign="middle" style="text-align:center;"><strong>AGENT PLUS MINUS</strong></td>
                                                                                                                                <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>SUPER AGENT PLUS MINUS</strong></td>
                                                                                                                                <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>MASTER AGENT PLUS MINUS</strong></td>
                                                                                                                                <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>SUB ADMIN PLUS MINUS</strong></td>

                                                                                                                                <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>ADMIN PLUS MINUS</strong></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td width="180" height="25" align="left" valign="middle"><strong>CLIENT</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>M AMT</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>SESS.</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>TOT. AMT</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>M. COM</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>S. COM</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>TOL. COM</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>NET AMT</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>SHR AMT</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>MOB. APP</strong></td>
                                                                                                                                <td width="100" align="right" style="text-align:right;" valign="middle"><strong>FINAL</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                                                                                                <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>
                                                                                                                            </tr>

                                                                                                                            <?php



                                                                                                                            if (!empty($master->users)) {
                                                                                                                                $users = $master->users;

                                                                                                                                foreach ($users as $user) {


                                                                                                                                    /**************AGENT MATCH COMM */
                                                                                                                                    $agent_match_comm = 0;
                                                                                                                                    $match_amt = $user->user['match_pl'];
                                                                                                                                    $agent_match_comm_per =  $user->master['match_comm'];


                                                                                                                                    if ($match_amt > 0) {
                                                                                                                                        $agent_match_comm = (abs($match_amt) * $agent_match_comm_per) / 100;
                                                                                                                                    }


                                                                                                                                    // p($agent_match_comm);
                                                                                                                                    /**************AGENT MATCH COMM */

                                                                                                                                    /**************AGENT SESSION COMM */
                                                                                                                                    $agent_session_comm = 0;
                                                                                                                                    $session_amt = $user->user['session_pl'];
                                                                                                                                    $agent_session_comm_per =  $user->master['sessional_commission'];




                                                                                                                                    if ($user->user['total_session_stake'] > 0) {
                                                                                                                                        $agent_session_comm = (abs($user->user['total_session_stake']) * $agent_session_comm_per) / 100;
                                                                                                                                    }
                                                                                                                                    /**************AGENT SESSION COMM */

                                                                                                                                    $total_agent_comm = $agent_match_comm + $agent_session_comm;


                                                                                                                                    $total_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                                                    $total_agent_amt_and_comm = $total_agent_amt - $total_agent_comm;

                                                                                                                                    $total_agent_share_amt =  ($total_agent_amt_and_comm * $user->master['partnership']) / 100;

                                                                                                                                    $agent_final_amt = $total_agent_amt_and_comm - $total_agent_share_amt;


                                                                                                                                    /**************SUPER AGENT MATCH COMM */
                                                                                                                                    $super_agent_match_comm = 0;
                                                                                                                                    $match_amt = $user->user['match_pl'];
                                                                                                                                    $super_agent_match_comm_per =  $user->super_master['match_comm'];


                                                                                                                                    if ($match_amt > 0) {
                                                                                                                                        $super_agent_match_comm = (abs($match_amt) * $super_agent_match_comm_per) / 100;
                                                                                                                                    }

                                                                                                                                    // p($agent_match_comm);
                                                                                                                                    /**************SUPER MATCH COMM */

                                                                                                                                    /**************SUPER AGENT SESSION COMM */
                                                                                                                                    $super_agent_session_comm = 0;
                                                                                                                                    $session_amt = $user->user['session_pl'];
                                                                                                                                    $super_agent_session_comm_per =  $user->super_master['sessional_commission'];


                                                                                                                                    if ($user->user['total_session_stake'] > 0) {
                                                                                                                                        $super_agent_session_comm = (abs($user->user['total_session_stake']) * $super_agent_session_comm_per) / 100;
                                                                                                                                    }
                                                                                                                                    /**************SUPER AGENT SESSION COMM */


                                                                                                                                    $total_super_agent_comm = $super_agent_match_comm + $super_agent_session_comm;

                                                                                                                                    $total_super_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                                                    $total_super_agent_amt_and_comm = $total_super_agent_amt - $total_super_agent_comm;
                                                                                                                                    $total_super_agent_share_amt =  ($total_super_agent_amt_and_comm * $user->super_master['partnership']) / 100;

                                                                                                                                    $total_super_agent_final_amt = $total_super_agent_amt_and_comm - $total_super_agent_share_amt;




                                                                                                                                    /**************MASTER AGENT MATCH COMM */
                                                                                                                                    $master_agent_match_comm = 0;
                                                                                                                                    $match_amt = $user->user['match_pl'];
                                                                                                                                    $master_agent_match_comm_per =  $user->hyper_super_master['match_comm'];


                                                                                                                                    if ($match_amt > 0) {
                                                                                                                                        $master_agent_match_comm = (abs($match_amt) * $master_agent_match_comm_per) / 100;
                                                                                                                                    }

                                                                                                                                    // p($agent_match_comm);
                                                                                                                                    /**************MASTER AGENT MATCH COMM */

                                                                                                                                    /**************MASTER AGENT SESSION COMM */
                                                                                                                                    $master_agent_session_comm = 0;
                                                                                                                                    $session_amt = $user->user['session_pl'];
                                                                                                                                    $master_agent_session_comm_per =  $user->hyper_super_master['sessional_commission'];


                                                                                                                                    if ($user->user['total_session_stake'] > 0) {
                                                                                                                                        $master_agent_session_comm = (abs($user->user['total_session_stake']) * $master_agent_session_comm_per) / 100;
                                                                                                                                    }
                                                                                                                                    /**************MASTER AGENT SESSION COMM */


                                                                                                                                    $total_master_agent_comm = $master_agent_match_comm + $master_agent_session_comm;

                                                                                                                                    $total_master_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                                                    $total_master_agent_amt_and_comm = $total_master_agent_amt - $total_master_agent_comm;
                                                                                                                                    $total_master_agent_share_amt =  ($total_master_agent_amt_and_comm * $user->hyper_super_master['partnership']) / 100;
                                                                                                                                    $total_master_agent_final_amt = $total_master_agent_amt_and_comm - $total_master_agent_share_amt;




                                                                                                                                    /**************SUB ADMIN MATCH COMM */
                                                                                                                                    $sub_admin_match_comm = 0;
                                                                                                                                    $match_amt = $user->user['match_pl'];
                                                                                                                                    $sub_admin_match_comm_per =  $user->admin['match_comm'];


                                                                                                                                    if ($match_amt > 0) {
                                                                                                                                        $sub_admin_match_comm = (abs($match_amt) * $sub_admin_match_comm_per) / 100;
                                                                                                                                    }

                                                                                                                                    // p($agent_match_comm);
                                                                                                                                    /**************SUB ADMIN MATCH COMM */

                                                                                                                                    /**************SUB ADMIN SESSION COMM */
                                                                                                                                    $sub_admin_session_comm = 0;
                                                                                                                                    $session_amt = $user->user['session_pl'];
                                                                                                                                    $sub_admin_session_comm_per =  $user->admin['sessional_commission'];


                                                                                                                                    if ($user->user['total_session_stake'] > 0) {
                                                                                                                                        $sub_admin_session_comm = (abs($user->user['total_session_stake']) * $sub_admin_session_comm_per) / 100;
                                                                                                                                    }
                                                                                                                                    /**************SUB ADMIN SESSION COMM */


                                                                                                                                    $total_sub_admin_comm = $sub_admin_match_comm + $sub_admin_session_comm;

                                                                                                                                    $total_sub_admin_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                                                    $total_sub_admin_amt_and_comm = $total_sub_admin_amt - $total_sub_admin_comm;
                                                                                                                                    $total_sub_admin_share_amt =  ($total_sub_admin_amt_and_comm * $user->admin['partnership']) / 100;
                                                                                                                                    $total_sub_admin_final_amt = $total_sub_admin_amt_and_comm - $total_sub_admin_share_amt;



                                                                                                                                    /************** ADMIN MATCH COMM */
                                                                                                                                    $sub_admin_match_comm = 0;
                                                                                                                                    $match_amt = $user->user['match_pl'];
                                                                                                                                    $sub_admin_match_comm_per =  $user->admin['match_comm'];


                                                                                                                                    if ($match_amt > 0) {
                                                                                                                                        $sub_admin_match_comm = (abs($match_amt) * $sub_admin_match_comm_per) / 100;
                                                                                                                                    }

                                                                                                                                    // p($agent_match_comm);
                                                                                                                                    /************** ADMIN MATCH COMM */

                                                                                                                                    /************** ADMIN SESSION COMM */
                                                                                                                                    $admin_session_comm = 0;
                                                                                                                                    $session_amt = $user->user['session_pl'];
                                                                                                                                    $admin_session_comm_per =  $user->super_admin['sessional_commission'];


                                                                                                                                    if ($user->user['total_session_stake'] > 0) {
                                                                                                                                        $admin_session_comm = (abs($user->user['total_session_stake']) * $admin_session_comm_per) / 100;
                                                                                                                                    }
                                                                                                                                    /************** ADMIN SESSION COMM */


                                                                                                                                    $total_admin_comm = $admin_match_comm + $admin_session_comm;

                                                                                                                                    $total_admin_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                                                    $total_admin_amt_and_comm = $total_admin_amt - $total_admin_comm;
                                                                                                                                    $total_admin_share_amt =  ($total_admin_amt_and_comm * $user->super_admin['partnership']) / 100;
                                                                                                                                    $total_admin_final_amt = $total_admin_amt_and_comm - $total_admin_share_amt;


                                                                                                                                    $agent_match_amt_6 += $user->user['match_pl'];
                                                                                                                                    $agent_sess_amt_6 += $user->user['session_pl'];
                                                                                                                                    $agent_total_match_amt_6 += $total_agent_amt;

                                                                                                                                    $agent_match_comm_amt_6 += $agent_match_comm;
                                                                                                                                    $agent_sess_comm_amt_6 += $agent_session_comm;
                                                                                                                                    $agent_total_comm_amt_6 += $total_agent_comm;


                                                                                                                                    $agent_net_amt_6 += $total_agent_amt_and_comm;
                                                                                                                                    $agent_share_amt_6 += $total_agent_share_amt;
                                                                                                                                    $agent_final_amt_6 += $agent_final_amt;



                                                                                                                                    $super_agent_match_comm_amt_6 += $super_agent_match_comm;
                                                                                                                                    $super_agent_sess_comm_amt_6 += $super_agent_session_comm;
                                                                                                                                    $super_agent_total_comm_amt_6 += $total_super_agent_comm;
                                                                                                                                    $super_agent_net_amt_6 += $total_super_agent_amt_and_comm;
                                                                                                                                    $super_agent_share_amt_6 += $total_super_agent_share_amt;
                                                                                                                                    $super_agent_final_amt_6 += $total_super_agent_final_amt;




                                                                                                                                    $master_agent_match_comm_amt_6 += $master_agent_match_comm;
                                                                                                                                    $master_agent_sess_comm_amt_6 += $master_agent_session_comm;
                                                                                                                                    $master_agent_total_comm_amt_6 += $total_master_agent_comm;
                                                                                                                                    $master_agent_net_amt_6 += $total_master_agent_amt_and_comm;
                                                                                                                                    $master_agent_share_amt_6 += $total_master_agent_share_amt;
                                                                                                                                    $master_agent_final_amt_6 += $total_master_agent_final_amt;


                                                                                                                                    $sub_admin_match_comm_amt_6 += $master_agent_match_comm;
                                                                                                                                    $sub_admin_sess_comm_amt_6 += $master_agent_session_comm;
                                                                                                                                    $sub_admin_total_comm_amt_6 += $total_master_agent_comm;
                                                                                                                                    $sub_admin_net_amt_6 += $total_sub_admin_amt_and_comm;
                                                                                                                                    $sub_admin_share_amt_6 += $total_sub_admin_share_amt;
                                                                                                                                    $sub_admin_final_amt_6 += $total_sub_admin_final_amt;



                                                                                                                                    $admin_match_comm_amt_6 += $sub_admin_match_comm;
                                                                                                                                    $admin_sess_comm_amt_6 += $sub_admin_session_comm;
                                                                                                                                    $admin_total_comm_amt_6 += $total_sub_admin_comm;
                                                                                                                                    $admin_net_amt_6 += $total_admin_amt_and_comm;
                                                                                                                                    $admin_share_amt_6 += $total_admin_share_amt;
                                                                                                                                    $admin_final_amt_6 += $total_admin_final_amt;

                                                                                                                            ?>
                                                                                                                                    <tr>
                                                                                                                                        <td height="25" align="left" valign="middle" class="FontText"> <?php echo $user->user_name; ?>(<?php echo $user->name; ?>)</td>

                                                                                                                                        <td style="text-align:right;"><?php echo number_format($user->user['match_pl'], 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($user->user['session_pl'], 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_agent_amt, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($agent_match_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($agent_session_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_agent_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_agent_amt_and_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($total_agent_share_amt, 2); ?></td>
                                                                                                                                        <td style="text-align:right;">0.00</td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($agent_final_amt, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($super_agent_match_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($super_agent_session_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_amt_and_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($total_super_agent_share_amt, 2); ?></td>
                                                                                                                                        <td style="text-align:right;">0.00</td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_final_amt, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($master_agent_match_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($master_agent_session_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_amt_and_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($total_master_agent_share_amt, 2); ?></td>
                                                                                                                                        <td style="text-align:right;">0.00</td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_final_amt, 2); ?></strong></td>

                                                                                                                                        <td style="text-align:right;"><?php echo number_format($sub_admin_match_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($sub_admin_session_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_sub_admin_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_sub_admin_amt_and_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($total_sub_admin_share_amt, 2); ?></td>
                                                                                                                                        <td style="text-align:right;">0.00</td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_sub_admin_final_amt, 2); ?></strong></td>

                                                                                                                                        <td style="text-align:right;"><?php echo number_format($admin_match_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($admin_session_comm, 2); ?></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_admin_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_admin_amt_and_comm, 2); ?></strong></td>
                                                                                                                                        <td style="text-align:right;"><?php echo number_format($total_admin_share_amt, 2); ?></td>
                                                                                                                                        <td style="text-align:right;">0.00</td>
                                                                                                                                        <td style="text-align:right;"><strong><?php echo number_format($total_admin_final_amt, 2); ?></strong></td>

                                                                                                                                    </tr>

                                                                                                                            <?php }
                                                                                                                            } ?>
                                                                                                                            <tr>
                                                                                                                                <td width="250" height="25" align="left" valign="middle"><strong>AGENT TOTAL</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_match_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_total_match_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php 
                                                                                                                                echo number_format($agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_sess_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_share_amt_6, 2); ?> </strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_final_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_sess_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_total_comm_amt_6); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_final_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_match_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_final_amt_6, 2); ?></strong></td>

                                                                                                                                 <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_match_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($sub_admin_final_amt_6, 2); ?></strong></td>



                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_match_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($admin_final_amt_6, 2); ?></strong></td>

                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                    <!--CLIENT END HERE-->

                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                    <?php }
                                                                                    } ?>

                                                                                   
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>

                                                            <?php }
                                                            } ?>

                                                       
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                    <?php }
                                    }

                                    ?>


                                  


                                </tbody>
                            </table>
                        </td>
                    </tr>
            <?php }
                        } ?>

            </tr>

          
                </tbody>
            </table>


        </div>
    </div>
</div>


<script>
    $('#from-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD'
    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD'
    });

    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {

        var sportId = $("#sportid").val();
        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var searchTerm = $("input[name='searchTerm']").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterProfiltLoss',
            data: {
                sportId: sportId,
                tdate: tdate,
                fdate: fdate,
                searchTerm: searchTerm,
                user_id: "<?php echo $user_id; ?>"
            },
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            complete: function() {
                $.unblockUI();
            },
            success: function(res) {
                $('#tablegh').html('');
                $('#tablegh').html(res);
            }
        });
    }
</script>