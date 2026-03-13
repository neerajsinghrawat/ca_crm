<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


require_once('include/Dashlets/DashletGeneric.php');

class MyLeadsDashlet extends DashletGeneric
{

    public function __construct($id, $def = null)
    {
        global $current_user, $app_strings, $dashletData;

        $dashletData = $dashletData ?? [];

        require('custom/modules/Leads/Dashlets/MyLeadsDashlet/MyLeadsDashlet.data.php');
        //echo "<pre>";print_r($dashletData);die;
        parent::__construct($id, $def);
         if (empty($this->lvsParams['custom_select'])) {
                $this->lvsParams['custom_select'] = '';
            }
            $this->lvsParams['custom_select'] .= ', leads.is_new_lead_c';
        if (empty($def['title'])) {
            $this->title = translate('LBL_LIST_MY_LEADS', 'Leads');
        }
        
        $this->searchFields = $dashletData['MyLeadsDashlet']['searchFields'];
        $this->columns = $dashletData['MyLeadsDashlet']['columns'];
        $this->seedBean = BeanFactory::newBean('Leads');
    }
    public function process($lvsParams = array(), $id = null)
    {
        global $current_user,$db;

        parent::process($lvsParams, $id);

        if (empty($this->lvs->data['data'])) {
            return;
        }
        foreach ($this->lvs->data['data'] as $rowNum => $row) {

            $leadId = $row['ID'];

            // DIRECT DB READ (NO DASHLET DEPENDENCY)
            $sql = "
                SELECT is_new_lead_c
                FROM leads
                WHERE id = '{$db->quote($leadId)}'
                LIMIT 1
            ";
            $res = $db->query($sql);
            $dbRow = $db->fetchByAssoc($res);

            $isNew = isset($dbRow['is_new_lead_c']) ? (int)$dbRow['is_new_lead_c'] : 0;

            if ($isNew === 1 || $isNew === 2) {
                $this->lvs->data['data'][$rowNum]['ROW_CLASS'] = 'crm-new-record';
                $this->lvs->data['data'][$rowNum]['NAME'] .=
                    ' <span style="background:#28a745;color:white;padding:2px 6px;border-radius:3px;margin-left:8px;text-decoration:none;font-size:8px;">NEW</span>';
            } else {
                $this->lvs->data['data'][$rowNum]['ROW_CLASS'] = '';
            }

        }
    }


}
