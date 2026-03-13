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


#[\AllowDynamicProperties]
class MyNotesDashlet extends DashletGeneric
{
    public function __construct($id, $def = null)
    {
        global $current_user, $app_strings, $dashletData;
        require('custom/modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.data.php');

        parent::__construct($id, $def);

        if (empty($def['title'])) {
            $this->title = translate('LBL_MY_NOTES_DASHLETNAME', 'Notes');
        }

        $this->searchFields = $dashletData['MyNotesDashlet']['searchFields'];
        $this->columns = $dashletData['MyNotesDashlet']['columns'];

        $this->seedBean = BeanFactory::newBean('Notes');
    }

    public function process($lvsParams = array(), $id = null)
    {
        global $current_user,$db;

        parent::process($lvsParams, $id);

        if (empty($this->lvs->data['data'])) {
            return;
        }
        foreach ($this->lvs->data['data'] as $rowNum => $row) {

            $leadId = $row['PARENT_ID'] ?? '';
            //echo "<pre>";print_r($leadId);die;
            $isNew = false;
            if (!empty($leadId) && $row['PARENT_TYPE'] === 'Leads') {

                $lead = BeanFactory::getBean('Leads', $leadId);

                if (!empty($lead) && !empty($lead->id)) {

                    $phone = '';
                    if (!empty($lead->phone_mobile)) {
                        $phone = $lead->phone_mobile;
                    } elseif (!empty($lead->phone_work)) {
                        $phone = $lead->phone_work;
                    }

                    // Prevent duplicate append
                    if (!empty($phone) && strpos($row['NAME'], $phone) === false) {
                        $this->lvs->data['data'][$rowNum]['NAME'] .= ' (' . $phone . ')';
                    }
                }
            }
            if (!empty($leadId)) {
                $q = "
                    SELECT id
                    FROM alerts
                    WHERE deleted = 0
                      AND is_read = 0
                      AND reminder_id = '{$leadId}'
                    LIMIT 1
                ";
                $r = $db->query($q);
                $isNew = (bool)$db->fetchByAssoc($r);
            }

            if ($isNew) {
                $this->lvs->data['data'][$rowNum]['ROW_CLASS'] = 'crm-new-record';
                $this->lvs->data['data'][$rowNum]['NAME'] .=
                    ' <span style="background:#28a745;color:white;padding:2px 6px;border-radius:3px;margin-left:8px;text-decoration:none;font-size:8px;">NEW</span>';
            } 

        }
    }

}
