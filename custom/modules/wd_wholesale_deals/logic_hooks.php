<?php
$hook_version = 1;
$hook_array = array();
$hook_array['after_save'][] = array(
    1,
    'Update inventory when wholesale deal completed',
    'custom/modules/wd_wholesale_deals/logic_hooks/WholesaleDealHooks.php',
    'WholesaleDealHooks',
    'updateInventoryStatuses'
);
