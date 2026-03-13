document.addEventListener('DOMContentLoaded', function() {
    var saveContinueBtn = document.getElementById('save_and_continue');
    if (saveContinueBtn) {
        saveContinueBtn.style.display = 'none'; // hide button
    }
});
function validateAndSaveLead() {
    
    var form = document.getElementById('EditView');
    var stockInput = document.getElementById('stock_number');
    var stockVal = stockInput.value;
    var recordId = document.querySelector("input[name='record']").value;
    console.log(recordId);
    stockInput.style.border = '';
    stockInput.style.backgroundColor = '';
    
        if (stockVal.length > 0) {
            // Ajax duplicate check
            $.ajax({
                url: "index.php?module=Leads&action=validatelead&sugar_body_only=true",
                type: "GET",
                data: { stock_number: stockVal, record_id: recordId },
                async: false, // block until done
                success: function(res) {
                    try {
                        var data = JSON.parse(res);
                        if (data.duplicate) {
                            alert("Duplicate Stock Number found! Please use a unique value.");
                            stockInput.focus();
                            stockInput.style.border = "2px solid red";
                            stockInput.style.backgroundColor = "#ffcccc";
                            return false;
                        } else {
                            SUGAR.ajaxUI.submitForm(form);
                        }
                    } catch (e) {
                        //alert('dfsdf12');
                        console.error("Invalid response:", res);
                        SUGAR.ajaxUI.submitForm(form);
                    }
                },
                error: function() {
                    //alert('dfsdf');
                    console.error("Ajax error");
                    SUGAR.ajaxUI.submitForm(form);
                }
            });
        } else {
            // No stock_number, just submit
            SUGAR.ajaxUI.submitForm(form);
        }
    
    return false; // prevent default
}


function toggleTradeInFields() {
    const tradeInChecked = document.getElementById('trade_in')?.checked;
    const leadType = document.getElementById('lead_type')?.value;
    var recordId = $('input[name="record"]').val();
    const tradeFields = [
        'trade_year',
        'trade_make',
        'trade_miles',
        'finance_or_paid',
        'finance_lender',
        'amount_owed',
        'vin',
        'appraisal_mileage',
        'appraisal_vehicle_model',
        'appraisal_vehicle_engine',
        'appraisal_vehicle_condition',
        'appraisal_vehicle_state',
        'appraisal_has_modifications',
        'appraisal_modification_details',
        'appraisal_has_payoff',
        'appraisal_payoff_amount',
        'appraisal_value',
        'appraisal_appraisal_comment',
        'appraisal_vehicle_photos'
    ];

    if (recordId) {
        tradeFields.forEach(function (id) {
            $('#' + id).closest('.edit-view-row-item, tr').hide();
        });
        
        $('#trade_in').closest('.edit-view-row-item').hide();

        return;
    }

    tradeFields.forEach(fieldId => {
        const el = document.getElementById(fieldId);
        if (el) {
            const row = el.closest('.edit-view-row-item') || el.closest('tr');
            if (row) {
                row.style.display = (tradeInChecked) ? '' : 'none';
                //row.style.display = (tradeInChecked && leadType === 'used_car') ? '' : 'none';
            }
        }
    });
}
function toggleLeaseLeadFields() {
    const leadType = document.getElementById('lead_type')?.value;

    const listedPrice = document.getElementById('listed_price_c');
    const marketValue = document.getElementById('market_value_c');
    const paymentType = document.getElementById('form_of_payment'); // dropdown

    function showHideField(fieldEl, show) {
        if (fieldEl) {
            const row = fieldEl.closest('.edit-view-row-item') || fieldEl.closest('tr');
            if (row) row.style.display = show ? '' : 'none';
        }
    }

    if (leadType === 'lease_car') {
        // ✅ hide Listed Price & Market Value
        showHideField(listedPrice, false);
        showHideField(marketValue, false);

        // ✅ auto set Form of Payment = Lease
        if (paymentType) {
            paymentType.disabled = false;   // pehle enable so value set ho jaye
            paymentType.value = "lease";    // option value match hona chahiye
            /*paymentType.disabled = true; */   // lock
        }
    } else {
        // ✅ show again
        showHideField(listedPrice, true);
        showHideField(marketValue, true);

        if (paymentType) {
            paymentType.disabled = false;
        }
    }
}

function toggleLeadTypeFields() {
    const leadType = document.getElementById('lead_type')?.value;
    const tradeInCheckbox = document.getElementById('trade_in');
    const currentLeaseCheckbox = document.getElementById('current_lease');

    if (tradeInCheckbox) {
        const tradeInRow = tradeInCheckbox.closest('.edit-view-row-item') || tradeInCheckbox.closest('tr');
        if (tradeInRow) {
            tradeInRow.style.display = (leadType === 'used_car') ? '' : 'none';
        }
    }

    if (currentLeaseCheckbox) {
        const currentLeaseRow = currentLeaseCheckbox.closest('.edit-view-row-item') || currentLeaseCheckbox.closest('tr');
        if (currentLeaseRow) {
            currentLeaseRow.style.display = (leadType === 'lease_car') ? '' : 'none';
        }
    }

    const leaseExpiry = document.getElementById('lease_expiry');
    if (leaseExpiry) {
        const leaseExpiryRow = leaseExpiry.closest('.edit-view-row-item') || leaseExpiry.closest('tr');
        if (leaseExpiryRow) {
            leaseExpiryRow.style.display = (leadType === 'lease_car' && currentLeaseCheckbox?.checked) ? '' : 'none';
        }
    }

    const leaseMiles = document.getElementById('lease_miles_per_year');
    if (leaseMiles) {
        const leaseMilesRow = leaseMiles.closest('.edit-view-row-item') || leaseMiles.closest('tr');
        if (leaseMilesRow) {
            leaseMilesRow.style.display = (leadType === 'lease_car') ? '' : 'none';
        }
    }

    const usedCarOnlyFields = ['stock_number', 'appt_test_drive'];
    usedCarOnlyFields.forEach(fieldId => {
        const el = document.getElementById(fieldId);
        if (el) {
            const row = el.closest('.edit-view-row-item') || el.closest('tr');
            if (row) {
                row.style.display = (leadType === 'used_car') ? '' : 'none';
            }
        }
    });

    toggleTradeInFields();
    toggleLeaseLeadFields();
}

function toggleLeaseExpiryOnCurrentLease() {
    const leadType = document.getElementById('lead_type')?.value;
    const currentLeaseCheckbox = document.getElementById('current_lease');
    const leaseExpiry = document.getElementById('lease_expiry');

    if (leaseExpiry) {
        const leaseExpiryRow = leaseExpiry.closest('.edit-view-row-item') || leaseExpiry.closest('tr');
        if (leaseExpiryRow) {
            leaseExpiryRow.style.display = (leadType === 'lease_car' && currentLeaseCheckbox?.checked) ? '' : 'none';
        }
    }
}
function fetchProductByStockNumber() {
    var stock = $('#stock_number').val().trim();

    if (stock === '') return;

    $.ajax({
        url: 'index.php?module=Leads&action=getProductByStockNumber&sugar_body_only=true',
        type: 'POST',
        dataType: 'json',
        data: { stock_number: stock },
        success: function (res) {
            if (res.status === 'success') {

                // Example mapping (aap apne field IDs match karo)
                if (res.data.interested_year) $('#interested_year').val(res.data.interested_year);
                if (res.data.interested_make) $('#interested_make').val(res.data.interested_make);
                if (res.data.interested_model) $('#interested_model').val(res.data.interested_model);

                //if (res.data.listed_price_c) $('#listed_price_c').val(res.data.listed_price_c);
                //if (res.data.market_value_c) $('#market_value_c').val(res.data.market_value_c);

                if (res.data.product_name_c) $('#product_name_c').val(res.data.product_name_c);
                if (res.data.product_id) $('#aos_product_id_c').val(res.data.product_id);

            } else {
                alert(res.message || 'Product not found for this stock number');
                $('#interested_year').val('');
                $('#interested_make').val('');
                $('#interested_model').val('');

                $('#product_name_c').val('');
                $('#aos_product_id_c').val('');
            }
        },
        error: function () {
            alert('Server error while fetching product');
        }
    });
}
$(document).ready(function () {

    // record id check (Edit vs Create)
    var recordId = $('input[name="record"]').val();

    if (recordId) {
        // EDIT MODE → hide fields
        var hideFields = [
            'vin',
            'trade_year',
            'trade_make',
            'trade_miles',
            'finance_or_paid',
            'finance_lender',
            'appraisal_mileage',
            'appraisal_vehicle_model',
            'appraisal_vehicle_engine',
            'appraisal_vehicle_condition',
            'appraisal_vehicle_state',
            'appraisal_has_modifications',
            'appraisal_modification_details',
            'appraisal_has_payoff',
            'appraisal_payoff_amount',
            'appraisal_value',
            'appraisal_appraisal_comment',
            'appraisal_vehicle_photos'
        ];

        hideFields.forEach(function (id) {
            var $el = $('#' + id);
            if ($el.length) {
                $el.closest('tr').hide(); // full row hide
            }
        });
    }

});
// Wait for full page load (with AJAX handling)
$(document).ready(function () {
    toggleLeadTypeFields();

    $('#lead_type').on('change', toggleLeadTypeFields);
    $('#trade_in').on('change', toggleTradeInFields);
    $('#current_lease').on('change', toggleLeaseExpiryOnCurrentLease);
});
var style = document.createElement('style');
style.innerHTML = `
    div[data-field="appt_test_drive"] {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
    }
    div[data-field="appt_test_drive"] > .label.col-sm-4,
        div[data-field="credit_application"] > .label.col-sm-4,
        div[data-field="trade_in"] > .label.col-sm-4,
        div[data-field="current_lease"] > .label.col-sm-4{
        flex: 0 0 45% !important;
        width: 45% !important;
    }
    div[data-field="lease_miles_per_year"] > .label {
        flex: 0 0 45% !important;
        width: 25% !important;
    }

    #lease_miles_per_year { 
        width: 47% !important;
    }
    #lease_expiry { 
        width: 78% !important;
    }

    div[data-field="appt_test_drive"] > .edit-view-field.col-sm-8,
        div[data-field="credit_application"] > .edit-view-field.col-sm-8,
        div[data-field="trade_in"] > .edit-view-field.col-sm-8 ,
        div[data-field="current_lease"] > .edit-view-field.col-sm-8 ,
        div[data-field="lease_miles_per_year"] > .edit-view-field.col-sm-8 {
        flex: 0 0 45% !important;
        width: 45% !important;
    }
    div[data-field="amount_owed"] > .edit-view-field.col-sm-8{        
        width: 33% !important;
    }

`;
document.head.appendChild(style);