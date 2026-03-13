
<?php



require_once('include/MVC/View/SugarView.php');

class Iv_intrested_vehicleViewLease_sold extends SugarView
{
    public function display()
    {
        $this->ss->display('custom/modules/iv_intrested_vehicle/tpls/ListViewHeader.tpl');
    }
}