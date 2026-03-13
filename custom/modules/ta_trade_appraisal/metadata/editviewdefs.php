<?php
$module_name = 'ta_trade_appraisal';

$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array(
        'form' => array(
           'enctype' => 'multipart/form-data',
           'hidden' => array(
                '<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}">'
            ),
        ),

        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
        'includes' => array(
            array('file' => 'custom/modules/ta_trade_appraisal/js/vin_verify.js'),
        ),
    ),

    'panels' => array(
        'default' => array(

            // ✅ VIN + Verify button
            array(
                array(
                    'name' => 'vin',
                    'label' => 'LBL_VIN',
                    'customCode' => '
                        <div class="input-group">
                            <input type="text" id="vin" name="vin" maxlength="17"
                                value="{$fields.vin.value}"
                                class="form-control" placeholder="Enter 17-character VIN">

                            <span class="input-group-btn" style="padding-left:6px;">
                                <button type="button" class="button" onclick="verifyVIN();">
                                    Verify VIN
                                </button>
                            </span>
                        </div>
                        <div style="margin-top:5px;">
                            <small id="vin_status" class="text-muted"></small>
                        </div>
                    ',
                ),
                array('name' => 'mileage', 'label' => 'LBL_MILEAGE'),
            ),

            array(
                array('name' => 'vehicle_year', 'label' => 'LBL_VEHICLE_YEAR'),
                array('name' => 'vehicle_make', 'label' => 'LBL_VEHICLE_MAKE'),
            ),

            array(
                array('name' => 'vehicle_model', 'label' => 'LBL_VEHICLE_MODEL'),
                array('name' => 'lead_name', 'label' => 'LBL_LEAD_NAME'),
            ),

            array(
                array('name' => 'vehicle_condition', 'label' => 'LBL_VEHICLE_CONDITION'),
                array('name' => 'vehicle_state', 'label' => 'LBL_VEHICLE_STATE'),
            ),

            array(
                array('name' => 'has_modifications', 'label' => 'LBL_HAS_MODIFICATIONS'),
                array('name' => 'modification_details', 'label' => 'LBL_MODIFICATION_DETAILS'),
            ),

            array(
                array('name' => 'has_payoff', 'label' => 'LBL_HAS_PAYOFF'),
                array('name' => 'payoff_amount', 'label' => 'LBL_PAYOFF_AMOUNT'),
            ),

            array(
                array('name' => 'appraisal_value', 'label' => 'LBL_APPRAISAL_VALUE'),
                array('name' => 'appraisal_comment', 'label' => 'LBL_APPRAISAL_COMMENT'),
            ),
            array(
              array(
                'name' => 'vehicle_photos',
                'label' => 'LBL_VEHICLE_PHOTOS',
                'customCode' => '<input type="file" name="vehicle_photos_upload[]" multiple accept="image/*">',
              ),
            ),
        ),
    ),
);
