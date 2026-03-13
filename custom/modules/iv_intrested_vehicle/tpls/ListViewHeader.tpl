{if $smarty.request.form_of_payment == 'lease'}
<h2 style="margin-bottom:10px;">Lease/Finance Sold Vehicles</h2>
{/if}

{if $smarty.request.form_of_payment == 'finance'}
<h2 style="margin-bottom:10px;">Lease Finance Sold Vehicles</h2>
{/if}
{if $smarty.request.form_of_payment == 'used'}
<h2 style="margin-bottom:10px;">Used Sold Vehicles</h2>
{/if}
{literal}
<style>
    .pd-add {
        padding: 7px 4px !important;
    }
</style>
{/literal}
<div style="margin-bottom:10px;">
    <input type="button" value="Update Details" class="button" onclick="openUpdatePopup()">
</div>
<div id="soldVehicleTable"></div>
<script>
    var form_of_payment = "{$smarty.request.form_of_payment}";
</script>
<script src="custom/modules/iv_intrested_vehicle/js/sold_vehicles.js"></script>
<div id="updateVehicleModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h4 class="modal-title">Update Vehicle Details</h4>
</div>

<div class="modal-body">
<label>Dealer</label>
<select id="dealer_id" class="form-control" style="background-color: aquamarine;min-width: 100%;">
    <option value="">-- Select Dealer --</option>
</select>
{if $smarty.request.form_of_payment == 'used'}

 <label>Type </label>
<select id="form_of_payment" class="form-control" style="background-color: #69ecff;min-width: 100%;">
  <option value="">-- Select Type --</option>
  <option value="cash">Cash</option>
  <option value="finance">Finance</option>
</select>
{/if}

{if $smarty.request.form_of_payment == 'lease'}
<label>Start Date</label>
<input type="date" id="start_date" class="form-control">
 <label>Term </label>
<select id="trim_c" class="form-control" onchange="calculateEndDate()" style="background-color: #69ecff;min-width: 100%;">
  <option value="">-- Select Term --</option>
  <option value="3">3 Months</option>
  <option value="6">6 Months</option>
  <option value="12">12 Months</option>
  <option value="24">24 Months</option>
  <option value="36">36 Months</option>
  <option value="48">48 Months</option>
  <option value="60">60 Months</option>
  <option value="72">72 Months</option>
  <option value="84">84 Months</option>
</select>

<label>End Date</label>
<input type="date" id="end_date" class="form-control" readonly>

<label>Month</label>
<input type="text" id="month_c" class="form-control">
<label>Miles Per Year</label>
<input type="text" id="miles_per_year" class="form-control">

<label>Monthly Payment</label>
<input type="text" id="monthly_payments_c" class="form-control">

<label>Bank</label>
<input type="text" id="bank_c" class="form-control">

{/if}






</div>

<div class="modal-footer">
<button type="button" class="button" onclick="saveVehicleUpdate()">Save</button>
<button type="button" class="button" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>