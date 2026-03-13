<?php
require_once('include/Dashlets/Dashlet.php');

class SalespersonDashlet extends Dashlet {

    function SalespersonDashlet($id, $def = null) {
        parent::Dashlet($id);
        $this->title = '📊 Sales Team Performance';
    }

    function display() {
        global $db;
        $html = '

        <style>
        .sales-table{
            width:100%;
            border-collapse:collapse;
            font-family:Arial;
            background:#fff;
            box-shadow:0 3px 10px rgba(0,0,0,0.08);
        }

        .sales-table th{
            background:#66727d;
            color:#fff;
            padding:10px;
            font-size:12px;
            text-align:left;
        }

        .sales-table td{
            padding:4px;
            font-size:11px;
            text-align:left;
            border-bottom:1px solid #eee;
        }

        .sales-table tr:nth-child(even){
            background:#f8f9fc;
        }

        .sales-table tr:hover{
            background:#eef2ff;
        }

        .badge{
            padding:4px 10px;
            border-radius:20px;
            color:#fff;
            font-size:12px;
            font-weight:bold;
        }

        .blue{background:#36b9cc}
        .green{background:#1cc88a}
        .orange{background:#f6c23e;color:#000}
        .red{background:#e74a3b}
        .purple{background:#6f42c1}
        </style>

        <table class="sales-table">
        <tr>
            <th>Salesperson</th>
            <th>Total Leads</th>
            <th>Today Leads</th>
            <th>Total Calls</th>
            <th>Today Calls</th>
            <th>Total SMS IN</th>
            <th>Today SMS IN</th>
            <th>Total SMS Out</th>
            <th>Today SMS Out</th>
        </tr>
        ';

        $query = "
        SELECT 
        u.id,
        u.clearlyip_did_c,
        CONCAT(u.first_name,' ',u.last_name) username,

        IFNULL(l.total_leads,0) total_leads,
        IFNULL(l.today_leads,0) today_leads,
        IFNULL(l.converted,0) converted,

        IFNULL(c.total_calls,0) total_calls,
        IFNULL(c.today_calls,0) today_calls,
        IFNULL(msg.total_in,0) total_in,
        IFNULL(msg.total_out,0) total_out,
        IFNULL(msg.today_in,0) today_in,
        IFNULL(msg.today_out,0) today_out

        FROM users u

        LEFT JOIN (
            SELECT assigned_user_id,
            COUNT(id) total_leads,

            SUM(
              CASE WHEN date_entered >= CURDATE()
              AND date_entered < CURDATE() + INTERVAL 1 DAY
              THEN 1 ELSE 0 END
            ) today_leads,

            SUM(CASE WHEN status='Converted' THEN 1 ELSE 0 END) converted

            FROM leads
            WHERE deleted=0
            GROUP BY assigned_user_id
        ) l ON l.assigned_user_id = u.id


        LEFT JOIN (
            SELECT assigned_user_id,
            COUNT(id) total_calls,

            SUM(
              CASE WHEN date_entered >= CURDATE()
              AND date_entered < CURDATE() + INTERVAL 1 DAY
              THEN 1 ELSE 0 END
            ) today_calls

            FROM calls
            WHERE deleted=0
            GROUP BY assigned_user_id
        ) c ON c.assigned_user_id = u.id

        LEFT JOIN (
            SELECT u.id user_id,
            SUM(
                CASE 
                WHEN n.description LIKE '%--- OUT |%' 
                AND n.description LIKE CONCAT('%From: ',u.clearlyip_did_c,'%')
                THEN 1 ELSE 0 END
            ) total_out,

            SUM(
                CASE 
                WHEN n.description LIKE '%--- IN |%' 
                AND n.description LIKE CONCAT('%To: ',u.clearlyip_did_c,'%')
                THEN 1 ELSE 0 END
            ) total_in,

            SUM(
                CASE 
                WHEN n.description LIKE '%--- OUT |%' 
                AND n.description LIKE CONCAT('%From: ',u.clearlyip_did_c,'%')
                AND n.date_entered >= CURDATE()
                AND n.date_entered < CURDATE()+INTERVAL 1 DAY
                THEN 1 ELSE 0 END
            ) today_out,

            SUM(
                CASE 
                WHEN n.description LIKE '%--- IN |%' 
                AND n.description LIKE CONCAT('%To: ',u.clearlyip_did_c,'%')
                AND n.date_entered >= CURDATE()
                AND n.date_entered < CURDATE()+INTERVAL 1 DAY
                THEN 1 ELSE 0 END
            ) today_in

            FROM users u
            LEFT JOIN notes n ON n.deleted=0
            GROUP BY u.id

        ) msg ON msg.user_id = u.id


        WHERE u.deleted=0 
        AND u.status='Active'

        ORDER BY total_leads DESC;

        ";

        $res = $db->query($query);
        $totalLeadsAll = 0;
        $totalTodayLeadsAll = 0;
        $totalCallsAll = 0;
        $totalTodayCallsAll = 0;

        $totalSmsInAll = 0;
        $totalSmsOutAll = 0;
        $totalTodayInAll = 0;
        $totalTodayOutAll = 0;
        while($row = $db->fetchByAssoc($res)){

            $conversion = 0;
            if($row['total_leads'] > 0){
                $conversion = round(($row['converted']/$row['total_leads'])*100);
            }
            $userId = $row['id'];
            $clearlyip_did_c = $row['clearlyip_did_c'];
            $totalLeadsAll += $row['total_leads'];
            $totalTodayLeadsAll += $row['today_leads'];

            $totalCallsAll += $row['total_calls'];
            $totalTodayCallsAll += $row['today_calls'];

            $totalSmsInAll += $row['total_in'];
            $totalSmsOutAll += $row['total_out'];

            $totalTodayInAll += $row['today_in'];
            $totalTodayOutAll += $row['today_out'];
            $total_in = '<a href="javascript:void(0)" 
            onclick="openMasterChat(\'IN\',\''.$clearlyip_did_c.'\')"
            class="badge green">'.$row['total_in'].'</a>';

            $total_out = '<a href="javascript:void(0)" 
            onclick="openMasterChat(\'OUT\',\''.$clearlyip_did_c.'\')"
            class="badge red">'.$row['total_out'].'</a>';

            $today_in = '<a href="javascript:void(0)" 
            onclick="openMasterChat(\'today_IN\',\''.$clearlyip_did_c.'\')"
            class="badge green">'.$row['today_in'].'</a>';

            $today_out = '<a href="javascript:void(0)" 
            onclick="openMasterChat(\'today_OUT\',\''.$clearlyip_did_c.'\')"
            class="badge red">'.$row['today_out'].'</a>';

            $totalLeadUrl = "index.php?module=Leads&action=index&query=true&searchFormTab=advanced_search&assigned_user_id_advanced=$userId";

            $todayLeadUrl = "index.php?module=Leads&action=index&query=true&searchFormTab=advanced_search&assigned_user_id_advanced=$userId&range_date_entered_advanced=today";

            $totalCallUrl = "index.php?module=Calls&action=index&query=true&searchFormTab=advanced_search&assigned_user_id_advanced=$userId";

            $todayCallUrl = "index.php?module=Calls&action=index&query=true&searchFormTab=advanced_search&assigned_user_id_advanced=$userId&range_date_entered_advanced=today";
            $totalLeadLink = "
            <a href='javascript:void(0)'
            onclick=\"openLeadPanel('$userId','all')\">
            <span class='badge blue'>{$row['total_leads']}</span>
            </a>";

            $todayLeadLink = "
            <a href='javascript:void(0)'
            onclick=\"openLeadPanel('$userId','today')\">
            <span class='badge green'>{$row['today_leads']}</span>
            </a>";
            
            $html .= "<tr>
                <td><b>{$row['username']}</b></td>

                <td>{$totalLeadLink}</td>
                <td>{$todayLeadLink}</td>

                <td><a href='$totalCallUrl' target='_blank'><span class='badge orange'>{$row['total_calls']}</span></a></td>
                <td><a href='$todayCallUrl' target='_blank'><span class='badge red'>{$row['today_calls']}</span></a></td>

                
                <td>{$total_in}</td>
                <td>{$today_in}</td>
                <td>{$total_out}</td>
                <td>{$today_out}</td>
            </tr>";

        }
        $html .= "
        <tr style='background:#222;color:#fff;font-weight:bold'>
        <td>TOTAL</td>

        <td><span class='badge blue'>$totalLeadsAll</span></td>
        <td><span class='badge green'>$totalTodayLeadsAll</span></td>

        <td><span class='badge orange'>$totalCallsAll</span></td>
        <td><span class='badge red'>$totalTodayCallsAll</span></td>

        <td><span class='badge green'>$totalSmsInAll</span></td>
        <td><span class='badge green'>$totalTodayInAll</span></td>

        <td><span class='badge red'>$totalSmsOutAll</span></td>
        <td><span class='badge red'>$totalTodayOutAll</span></td>

        </tr>";
        //<td><span class='badge purple'>{$row['converted']}</span></td>
        $html .= "</table>

        <div id='smsPopup' style='display:none'>
        <div id='smsPopupData'>Loading...</div>
        </div>

        <script>
            function openMasterChat(type,did){

                if(!did){
                    alert('No DID');
                    return;
                }

                $('#smsPopup').dialog({
                modal:true,
                width:1200,
                height:650,
                title:'Sales SMS Panel'
                });

                $('#smsPopupData').html('Loading chats...');

                $.ajax({
                    url:'index.php?entryPoint=getSMSPopup',
                    type:'POST',
                    data:{did:did,type:type},
                    success:function(res){
                        $('#smsPopupData').html(res);
                    }
                });
            }

            function openLeadPanel(userId,type){

                $('#smsPopup').dialog({
                modal:true,
                width:1200,
                height:650,
                title:(type=='today'?'Today Leads':'All Leads')
                });

                $('#smsPopupData').html('Loading leads...');

                $.ajax({
                    url:'index.php?entryPoint=getUserLeadsPanel',
                    type:'POST',
                    data:{user:userId,type:type},
                    success:function(res){
                    $('#smsPopupData').html(res);
                    }
                });
            }
        </script>
        ";
        return $html;
    }
}
