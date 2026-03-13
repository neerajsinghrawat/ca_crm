<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/Dashlet.php');

class NextUserDashlet extends Dashlet
{
    function __construct($id, $def = null)
    {
        parent::__construct($id, $def);
        $this->title = "Next User Queue";
    }

    function display()
    {
        $html = "<div id='nextUserDashletContent'>".$this->getDashletContent()."</div>

        <script>
        function updateNextUser(url) {
            fetch(url)
              .then(response => response.text())
              .then(data => {
                  // reload only the dashlet content
                //  document.getElementById('nextUserDashletContent').innerHTML = data;
                  alert('Next user updated in queue!');
                           location.reload(); // refresh dashlet to show next user
                     //      SUGAR.mySugar.retrieveDashlet('b6bf7676-3436-a1bb-d4e9-68c12234a430'); return false;
              });
        }
        </script>";

        return parent::display() . $html;
    }

    private function getDashletContent()
    {
        global $db;

        // 🔹 Fetch salespersons
        $sql = "SELECT u.id, u.first_name, u.last_name
                FROM users u
                INNER JOIN acl_roles_users aru ON aru.user_id = u.id AND aru.deleted = 0
                INNER JOIN acl_roles ar ON ar.id = aru.role_id AND ar.deleted = 0
                WHERE u.deleted = 0 AND u.status = 'Active' AND ar.name = 'salesperson'
                ORDER BY u.user_name ASC";

        $result = $db->query($sql);
        $users = [];
        while ($row = $db->fetchByAssoc($result)) {
            $users[] = $row;
        }

        if (empty($users)) {
            return "<div>No salespersons found</div>";
        }

        // 🔹 Fetch salespersons
        $sqlpovs = "SELECT u.id, u.first_name, u.last_name
                FROM users u
                INNER JOIN acl_roles_users aru ON aru.user_id = u.id AND aru.deleted = 0
                INNER JOIN acl_roles ar ON ar.id = aru.role_id AND ar.deleted = 0
                WHERE u.deleted = 0 AND u.status = 'Active' AND ar.name = 'Pre-Owned vehicle SP'
                ORDER BY u.user_name ASC";

        $resultpovs = $db->query($sqlpovs);
        $userspovs = [];
        while ($rowpovs = $db->fetchByAssoc($resultpovs)) {
            $userspovs[] = $rowpovs;
        }

        if (empty($userspovs)) {
            return "<div>No salespersons found</div>";
        }

        // 🔹 Get last assigned index
        $lastIndex = 0;
        $res = $db->query("SELECT value FROM config WHERE category='lead_assign' AND name='last_index'");
        if ($row = $db->fetchByAssoc($res)) {
            $lastIndex = (int)$row['value'];
        }

        $lastIndexPov = 0;
        $resp = $db->query("SELECT value FROM config WHERE category='lead_assign' AND name='pov_last_index'");
        if ($rowp = $db->fetchByAssoc($resp)) {
            $lastIndexPov = (int)$rowp['value'];
        }
        // 🔹 Next index and user
        $nextIndex = ($lastIndex + 1) % count($users);
        $nextIndexPov = ($lastIndexPov + 1) % max(count($userspovs), 1);

        // 🔹 Show next 5 users in queue
        $queueHtml = "<ul style='padding-left:15px;'>";
        for ($i = 0; $i <  count($users); $i++) {
            $idx = ($nextIndex + $i) % count($users);
            $name = trim($users[$idx]['first_name'] . " " . $users[$idx]['last_name']);

            if ($i == 0) {
                // first one = next user, add button
                $callUrl = "index.php?module=Home&action=NextUserCall&next_index={$idx}";
                $queueHtml .= "<li><b>{$name}</b> 
                    <a href='#' onclick=\"updateNextUser('{$callUrl}'); return false;\"
                       style='background:#28a745;color:white;padding:2px 6px;border-radius:3px;margin-left:8px;text-decoration:none;font-size:12px;'>
                       ✅ Mark as Called
                    </a></li>";
            } else {
                $queueHtml .= "<li>{$name}</li>";
            }
        }
        $queueHtml .= "</ul>";

        $povHtml = "<ul style='padding-left:15px;'>";
            foreach ($userspovs as $i => $u) {
                $name = trim($u['first_name']." ".$u['last_name']);
                if ($i == $nextIndexPov) {
                    $callUrl = "index.php?module=Home&action=NextUserCall&key=pov&next_index={$i}";
                    $povHtml .= "<li><b>{$name}</b>
                        <a href='#' onclick=\"updateNextUser('{$callUrl}');return false;\"
                        style='background:#007bff;color:#fff;padding:2px 6px;
                        border-radius:3px;margin-left:6px;font-size:12px;'>✅ Mark as Called</a></li>";
                } else {
                    $povHtml .= "<li>{$name}</li>";
                }
            }
        $povHtml .= "</ul>";

        return "
        <div style='display:flex;gap:15px;padding:10px;'>

            <div style='width:50%;border-right:1px solid #ddd;'>
                <b>Lease/New vehicles SP Queue</b>
                {$queueHtml}
            </div>

            <div style='width:50%;'>
                <b>Pre-Owned Vehicle SP Queue</b>
                {$povHtml}
            </div>

        </div>";
    }
}
