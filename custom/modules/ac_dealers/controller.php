 <?php
 if (!defined('sugarEntry') || !sugarEntry) {
     die('Not A Valid Entry Point');
 }
 
class ac_dealersController extends SugarController
{
    public function action_getDealerList()
    {
        $sql = "SELECT id, name FROM ac_dealers WHERE deleted = 0 ORDER BY name ASC";
        $result = $GLOBALS['db']->query($sql);
        $dealers = array();
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $dealers[] = array('id' => $row['id'], 'name' => $row['name']);
        }
        header('Content-Type: application/json');
        echo json_encode($dealers);
        sugar_cleanup(true);
    }
    public function action_createWholesaleDealPopup()
    {
        $selectedDealerId = isset($_REQUEST['record']) ? $_REQUEST['record'] : '';
        if (empty($selectedDealerId) && !empty($_REQUEST['dealer_id'])) {
            $selectedDealerId = $_REQUEST['dealer_id'];
        }
        $dealers = $this->getDealerOptions();
        $searchStock = isset($_REQUEST['search_stock']) ? trim($_REQUEST['search_stock']) : '';
        $searchVehicle = isset($_REQUEST['search_vehicle']) ? trim($_REQUEST['search_vehicle']) : '';
        $sourceType = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : 'inventory';
        $vehicles = $this->getInventoryVehicles($searchStock, $searchVehicle);
        echo '<!DOCTYPE html><html><head><title>Create Wholesale Deal</title>';
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
        echo '<style>
            body{font-family:Arial;background:#f6f7fb;margin:0;padding:16px;}
            .card{background:#fff;border:1px solid #ddd;border-radius:10px;padding:14px;margin-bottom:12px;}
            .row{display:flex;gap:10px;flex-wrap:wrap;align-items:end;}
            .field{display:flex;flex-direction:column;min-width:220px;}
            .field label{font-weight:600;margin-bottom:4px;}
            input[type=text], select, textarea{padding:7px;border:1px solid #bbb;border-radius:6px;width:94%;}
            .btn{background:#534d64;color:#fff;border:none;padding:9px 14px;border-radius:6px;cursor:pointer;}
            .btn.secondary{background:#f08377;}
            table{width:100%;border-collapse:collapse;margin-top:10px;}
            th,td{border:1px solid #ddd;padding:6px;text-align:left;}
            th{background:#fafafa;}
        </style>';
        echo '</head><body>';
        echo '<h2 style="margin-top:0;">Create Wholesale Deal</h2>';
        echo '<form method="POST" action="index.php?module=ac_dealers&action=saveWholesaleDeal">';
        echo '<div class="card">';
        echo '<div class="row">';
        echo '<div class="field" style="min-width:340px;">';
        echo '<label>Select Dealer (Search)</label>';
        echo '<select name="dealer_id" id="dealer_id" required>';
        echo '<option value="">-- Select Dealer --</option>';
        foreach ($dealers as $dealer) {
            $selected = ($selectedDealerId === $dealer['id']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($dealer['id']) . '" ' . $selected . '>' . htmlspecialchars($dealer['name']) . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<div class="field">';
        echo '<label>Source Type</label>';
        echo '<div>';
        echo '<label style="font-weight:normal;"><input type="radio" name="source_type" value="inventory" ' . ($sourceType === 'inventory' ? 'checked' : '') . '> Select from Inventory</label>&nbsp;&nbsp;';
        echo '<label style="font-weight:normal;"><input type="radio" name="source_type" value="outside" ' . ($sourceType === 'outside' ? 'checked' : '') . '> Outside from Inventory</label>';
        echo '</div></div></div></div>';
        echo '<div id="inventorySection" class="card" style="display:' . ($sourceType === 'inventory' ? 'block' : 'none') . ';">';
        echo '<h3 style="margin-top:0;">Product Selection</h3>';
        echo '<div class="row">';
        echo '<div class="field"><label>Search by Stock No</label><input type="text" id="search_stock" name="search_stock" value="' . htmlspecialchars($searchStock) . '"></div>';
        echo '<div class="field"><label>Search by Vehicle Name</label><input type="text" id="search_vehicle" name="search_vehicle" value="' . htmlspecialchars($searchVehicle) . '"></div>';
        echo '<div><button class="btn secondary" id="search_vehicle_btn" type="submit" formaction="index.php?module=ac_dealers&action=createWholesaleDealPopup">Search Vehicle</button></div>';
        echo '</div>';
        echo '<div class="field" style="margin-top:10px;">';
        echo '<label>Select Product</label>';
        echo '<select name="vehicle_id" id="vehicle_id">';
        echo '<option value="">-- Select Product from Inventory --</option>';
        foreach ($vehicles as $v) {
            $label = $v['name'] . ' | ' . $v['stocknumber_c'] . ' | ' . $v['vin'];
            echo '<option value="' . htmlspecialchars($v['id']) . '">' . htmlspecialchars($label) . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<table><tr><th>Vehicle Name</th><th>Stock No</th><th>VIN</th><th>Cost Price</th><th>Status</th></tr>';
        if (empty($vehicles)) {
            echo '<tr><td colspan="5">No vehicles found.</td></tr>';
        } else {
            foreach ($vehicles as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['stocknumber_c']) . '</td>';
                echo '<td>' . htmlspecialchars($row['part_number']) . '</td>';
                echo '<td>' . htmlspecialchars($row['cost']) . '</td>';
                echo '<td>' . htmlspecialchars($row['inventory_status_c']) . '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
        echo '</div>';
        echo '<div id="outsideSection" class="card" style="display:' . ($sourceType === 'outside' ? 'block' : 'none') . ';">';
        echo '<h3 style="margin-top:0;">Outside from Inventory</h3>';
        echo '<div class="row">';
        echo '<div class="field"><label>Enter VIN Number</label><input type="text" maxlength="17" name="outside_vin" id="outside_vin"></div>';
        echo '<div><button class="btn secondary" type="button" id="verifyVinBtn">Fetch Vehicle Details</button></div>';
        echo '</div>';
        echo '<small id="vin_status" style="display:block;margin:6px 0;color:#666;"></small>';
        echo '<div class="row">';
        echo '<div class="field"><label>Vehicle Name</label><input type="text" name="outside_vehicle_name" id="outside_vehicle_name"></div>';
        echo '<div class="field"><label>Make</label><input type="text" name="outside_make" id="outside_make"></div>';
        echo '<div class="field"><label>Model</label><input type="text" name="outside_model" id="outside_model"></div>';
        echo '<div class="field"><label>Year</label><input type="text" name="outside_year" id="outside_year"></div>';
        echo '<div class="field"><label>Color</label><input type="text" name="outside_color" id="outside_color"></div>';
        echo '<div class="field"><label>Mileage</label><input type="text" name="outside_mileage" id="outside_mileage"></div>';
        echo '</div></div>';
        echo '<div class="card">';
        echo '<div class="row">';

        
        echo '<div class="field"><label>Cost Price</label><input type="text" name="cost_price" id="cost_price"></div>';
        echo '<div class="field"><label>Selling Price</label><input type="text" name="selling_price" id="selling_price"></div>';

        echo '</div>';
        echo '<div style="margin-top:10px;"><button class="btn" type="submit">Create Wholesale Deal</button></div>';
        echo '</div>';
        echo '</form>';
        echo '<script>
        (function($){
            function toggleSections(){
                var type = $("input[name=source_type]:checked").val() || "inventory";
                var isInventory = type === "inventory";
                $("#inventorySection").toggle(isInventory);
                $("#outsideSection").toggle(!isInventory);
                // Outside mode me product selection poora hide+disable
                $("#search_stock, #search_vehicle, #search_vehicle_btn, #vehicle_id").prop("disabled", !isInventory);
                // Inventory mode me VIN block disable
                $("#outside_vin, #verifyVinBtn, #outside_vehicle_name, #outside_make, #outside_model, #outside_year, #outside_color, #outside_mileage").prop("disabled", isInventory);
            }
            function verifyVIN(){
                var vin = $("#outside_vin").val().trim();
                var status = $("#vin_status");
                if(vin.length !== 17){
                    status.text("VIN must be 17 characters").css("color","red");
                    return;
                }
                status.text("Verifying VIN...").css("color","#666");
                var url = "https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/" + vin + "?format=json";
                fetch(url)
                    .then(function(resp){ return resp.json(); })
                    .then(function(data){
                        if(!data.Results || !data.Results[0]){
                            throw new Error("Invalid response");
                        }
                        var r = data.Results[0];
                        if(!r.Make || !r.Model){
                            status.text("Invalid VIN").css("color","red");
                            return;
                        }
                        $("#outside_year").val(r.ModelYear || "");
                        $("#outside_make").val(r.Make || "");
                        $("#outside_model").val(r.Model || "");
                        if(!$("#outside_vehicle_name").val()){
                            $("#outside_vehicle_name").val((r.ModelYear || "") + " " + (r.Make || "") + " " + (r.Model || ""));
                        }
                        status.text("VIN verified successfully").css("color","green");
                    })
                    .catch(function(){
                        status.text("Error verifying VIN").css("color","red");
                    });
            }
            $(document).on("change", "input[name=source_type]", toggleSections);
                $("#verifyVinBtn").on("click", verifyVIN);
                toggleSections();
        })(jQuery);
        </script>';
        echo '</body></html>';
        sugar_cleanup(true);
    }
    public function action_saveWholesaleDeal()
    {
        $dealerId = isset($_REQUEST['dealer_id']) ? $_REQUEST['dealer_id'] : '';
        $sourceType = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : 'inventory';
        $vehicleId = isset($_REQUEST['vehicle_id']) ? $_REQUEST['vehicle_id'] : '';
        $vehicleIds = isset($_REQUEST['vehicle_ids']) ? (array)$_REQUEST['vehicle_ids'] : array();
 

        if (!empty($vehicleId)) {
            $vehicleIds[] = $vehicleId;
        }
        $vehicleIds = array_unique(array_filter($vehicleIds));
        if (empty($dealerId)) {
            sugar_die('Dealer is required.');
        }
        if ($sourceType === 'inventory' && empty($vehicleIds)) {
            sugar_die('Please select one inventory product from dropdown.');
        }
        $dealer = BeanFactory::getBean('ac_dealers', $dealerId);
        if (empty($dealer->id)) {
            sugar_die('Invalid dealer selected.');
        }
        $deal = BeanFactory::newBean('wd_wholesale_deals');
        $deal->name = 'Wholesale Deal - ' . $dealer->name . ' - ' . date('Y-m-d H:i');
        $deal->deal_id = 'WD-' . strtoupper(substr(create_guid(), 0, 8));
        $deal->wholesaler_id = $dealerId;
        $deal->wholesaler_name = $dealer->name;
        $deal->deal_date = date('Y-m-d');
        $deal->status = 'draft';
        $deal->agreement_status = 'draft';
        $deal->docusign_status = 'not_sent';
        $deal->agreement_template = isset($_REQUEST['agreement_template']) ? $_REQUEST['agreement_template'] : '';
        $deal->notes = isset($_REQUEST['notes']) ? $_REQUEST['notes'] : '';
        $deal->save();
        $totalAmount = 0;
        $count = 0;
 
         if ($sourceType === 'inventory') {
                     foreach ($vehicleIds as $id) {
                         $product = BeanFactory::getBean('AOS_Products', $id);
                         if (empty($product->id)) {
                             continue;
                         }
                         $this->createDealItemFromProduct($deal, $product);
                         $price = !empty($product->cost_price) ? (float)$product->cost_price : 0;
                         $totalAmount += $price;
                         $count++;
                         $product->inventory_status_c = 'reserved_wholesale';
                         $product->save();
                     }
                 } else {
                     $vin = isset($_REQUEST['outside_vin']) ? trim($_REQUEST['outside_vin']) : '';
                     if (empty($vin)) {
                         sugar_die('VIN is required for outside inventory flow.');
                     }
                     $product = BeanFactory::newBean('AOS_Products');
                     $product->name = !empty($_REQUEST['outside_vehicle_name']) ? $_REQUEST['outside_vehicle_name'] : ('Vehicle ' . $vin);
                     $product->vin = $vin;
                     $product->make_c = isset($_REQUEST['outside_make']) ? $_REQUEST['outside_make'] : '';
                     $product->model_c = isset($_REQUEST['outside_model']) ? $_REQUEST['outside_model'] : '';
                     $product->year_c = isset($_REQUEST['outside_year']) ? $_REQUEST['outside_year'] : '';
                     $product->exteriorcolor_c = isset($_REQUEST['outside_color']) ? $_REQUEST['outside_color'] : '';
                     $product->odometer_c = isset($_REQUEST['outside_mileage']) ? $_REQUEST['outside_mileage'] : '';
                     $product->cost_price = unformat_number(isset($_REQUEST['cost_price']) ? $_REQUEST['cost_price'] : 0);
                     $product->price = unformat_number(isset($_REQUEST['selling_price']) ? $_REQUEST['selling_price'] : 0);
                     $product->inventory_status_c = 'reserved_wholesale';
                     $product->status = 'active';
                     $product->sold = 'no';
                     $product->save();
                     $this->createDealItemFromProduct($deal, $product);
                     $totalAmount += (float)$product->cost_price;
                     $count++;
                 }
                 $deal->total_vehicle_count = $count;
                 $deal->total_amount = $totalAmount;
                 $deal->save();
                 SugarApplication::redirect('index.php?module=wd_wholesale_deals&action=DetailView&record=' . $deal->id);
             }
             protected function createDealItemFromProduct($deal, $product)
             {
                 $item = BeanFactory::newBean('wdi_wholesale_deal_items');
                 $item->name = $product->name;
                 $item->vehicle_id = $product->id;
                 $item->vehicle_name = $product->name;
                 $item->vin = $product->vin;
                 $item->stock_number = isset($product->stocknumber_c) ? $product->stocknumber_c : '';
                 $item->make = isset($product->make_c) ? $product->make_c : '';
                 $item->model = isset($product->model_c) ? $product->model_c : '';
                 $item->year = isset($product->year_c) ? $product->year_c : '';
                 $item->price = isset($product->cost_price) ? $product->cost_price : 0;
                 $item->deal_id = $deal->id;
                 $item->deal_name = $deal->name;
                 $item->save();
             }
             protected function getDealerOptions()
             {
                 $options = array();
                 $sql = "SELECT id, name FROM ac_dealers WHERE deleted = 0 ORDER BY name ASC";
         $result = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $options[] = $row;
        }
        return $options;
    }
    protected function getInventoryVehicles($searchStock, $searchVehicle)
    {
        $where = "p.deleted = 0";
        $where .= " AND p.sold = 'no'";
        $where .= " AND p.status = 'active'";
 
        if (!empty($searchStock)) {
             $stock = $GLOBALS['db']->quote($searchStock);
             $where .= " AND p.stocknumber_c LIKE '%{$stock}%'";
         }
         if (!empty($searchVehicle)) {
             $vehicle = $GLOBALS['db']->quote($searchVehicle);
             $where .= " AND p.name LIKE '%{$vehicle}%'";
         }
         $sql = "SELECT p.id, p.name, p.stocknumber_c, p.cost, p.part_number, p.inventory_status_c
                 FROM aos_products p
                 WHERE {$where}
                 ORDER BY p.date_entered DESC
                 LIMIT 100";
                 //echo "<pre>";print_r($sql);die;
         $rows = array();
         $result = $GLOBALS['db']->query($sql);
         while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $rows[] = $row;
         }
 

        return $rows;
     }

}
