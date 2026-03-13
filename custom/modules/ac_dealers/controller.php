<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class ac_dealersController extends SugarController {

    public function action_getDealerList() {
        $sql = "SELECT id, name FROM ac_dealers 
                WHERE deleted = 0 
                ORDER BY name ASC";

        $result = $GLOBALS['db']->query($sql);
        $dealers = [];

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $dealers[] = ['id' => $row['id'], 'name' => $row['name']];
        }

        echo json_encode($dealers);
        exit;
    }
}