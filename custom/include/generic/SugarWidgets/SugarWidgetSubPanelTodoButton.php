<?php
require_once('include/generic/SugarWidgets/SugarWidgetField.php');

class SugarWidgetSubPanelTodoButton extends SugarWidgetField
{
    public function displayList(&$layout_def)
    {
            
        $record = $layout_def['fields']['ID'];
        return '<button class="todoSubpanelBtn"
        data-id="'.$record.'"
        style="background:#f08377;color:#fff;border:none;padding:4px 8px;border-radius:4px;">
        To-Do</button>';
    }
}
