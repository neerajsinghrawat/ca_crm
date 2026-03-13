<?php

class WholesaleDealHooks
{
    public function updateInventoryStatuses($bean, $event, $arguments)
    {
        if (!in_array($bean->agreement_status, array('signed', 'completed'))) {
            return;
        }

        $sql = "SELECT vehicle_id FROM wdi_wholesale_deal_items WHERE deleted = 0 AND deal_id = '" . $GLOBALS['db']->quote($bean->id) . "'";
        $result = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $product = BeanFactory::getBean('AOS_Products', $row['vehicle_id']);
            if (empty($product->id)) {
                continue;
            }

            $product->inventory_status_c = 'sold_wholesale';
            $product->save();
        }
    }
}
