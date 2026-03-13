<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/entryPoint.php');
global $db;

// Token validation
$token = $_GET['token'] ?? '';
if (!$token) die('Invalid link');

$res = $db->query("
    SELECT * FROM tradein_appraisal_tokens
    WHERE token = '{$db->quote($token)}'
      AND is_used = 0
      AND (expires_at IS NULL OR expires_at > NOW())
    LIMIT 1
");
$tokenRow = $db->fetchByAssoc($res);
$phone_number = (isset($tokenRow['phone_number']) && !empty($tokenRow['phone_number']))?$tokenRow['phone_number']:'';
$email_address = (isset($tokenRow['email_address']) && !empty($tokenRow['email_address']))?$tokenRow['email_address']:'';
if (!$tokenRow) die('Link expired or invalid');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trade-In Vehicle Appraisal</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body { background:#f4f6f9; }
        .card { margin-top:40px; }
        .required::after { content:" *"; color:red; }
        
           .btn-primary { background-color: #f08377 !important;border-color: #f08377 !important;}
           .bg-primary { background-color: #534d64 !important;}
           .btn-n {line-height: 0.5 !important;}
    </style>
    <script>

    function toggleModifications(val) {
        var box = document.getElementById('modification_box');
        box.style.display = (val == '1') ? 'block' : 'none';
    }
    function verifyVIN() {
        var vin = document.getElementById('vin').value.trim();
        var status = document.getElementById('vin_status');

        if (vin.length !== 17) {
            status.innerHTML = 'VIN must be 17 characters';
            status.style.color = 'red';
            return;
        }

        status.innerHTML = 'Verifying VIN...';
        status.style.color = 'gray';

        var url = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/'
                  + vin + '?format=json';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data.Results || !data.Results[0]) {
                    throw 'Invalid response';
                }

                var r = data.Results[0];

                if (!r.Make || !r.Model) {
                    status.innerHTML = 'Invalid VIN';
                    status.style.color = 'red';
                    return;
                }
                console.log(r);
                document.getElementById('vehicle_year').value   = r.ModelYear || '';
                document.getElementById('vehicle_make').value   = r.Make || '';
                document.getElementById('vehicle_model').value  = r.Model || '';
                document.getElementById('vehicle_engine').value = r.EngineModel || '';

                status.innerHTML = 'VIN verified successfully';
                status.style.color = 'green';
            })
            .catch(() => {
                status.innerHTML = 'Error verifying VIN';
                status.style.color = 'red';
            });
    }
    </script>

</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Trade-In Vehicle Appraisal</h4>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="index.php?entryPoint=tradeinAppraisalSubmit"
                          enctype="multipart/form-data">

                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input type="hidden" name="phone_number" value="<?= $phone_number; ?>">
                        <input type="hidden" name="email_address" value="<?= $email_address; ?>">

                        <div class="form-group">
                            <label class="required">VIN</label>
                            <div class="input-group">
                                <input type="text" id="vin" name="vin"
                                       maxlength="17"
                                       class="form-control"
                                       placeholder="Enter 17-character VIN"
                                       required>

                                <div class="input-group-append">
                                    <button type="button"
                                            class="btn btn-n btn-primary"
                                            onclick="verifyVIN()">
                                        Verify VIN
                                    </button>
                                </div>
                            </div>
                            <small id="vin_status" class="form-text text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Year</label>
                            <input type="text" name="vehicle_year" id="vehicle_year"
                                   class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Make</label>
                            <input type="text" name="vehicle_make" id="vehicle_make"
                                   class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="vehicle_model" id="vehicle_model"
                                   class="form-control" readonly>
                        </div>

                        <!-- <div class="form-group">
                            <label>Engine</label> -->
                            <input type="hidden" name="vehicle_engine" id="vehicle_engine">
                        <!-- </div> -->
                        <!-- Mileage -->
                        <div class="form-group">
                            <label class="required">Mileage</label>
                            <input type="number"
                                   name="mileage"
                                   class="form-control"
                                   min="0"
                                   placeholder="e.g. 45000"
                                   required>
                        </div>

                        <!-- Vehicle Condition -->
                        <div class="form-group">
                            <label class="required">Vehicle Condition</label>
                            <select name="vehicle_condition" class="form-control" required>
                                <option value="">Select Condition</option>
                                <option value="excellent">Excellent</option>
                                <option value="great">Great</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                            </select>
                        </div>

                        <!-- Has Modifications -->
                        <div class="form-group">
                            <label>Does the vehicle have any modifications?</label>
                            <select name="has_modifications"
                                    class="form-control"
                                    onchange="toggleModifications(this.value)">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <!-- Modification Details -->
                        <div class="form-group"
                             id="modification_box"
                             style="display:none;">
                            <label>Please describe the modifications</label>
                            <textarea name="modification_details"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Lift kit, custom exhaust, aftermarket wheels, etc."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="required">Vehicle State</label>
                            <input type="text" name="vehicle_state"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Payoff?</label>
                            <select name="has_payoff" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Payoff Amount</label>
                            <input type="number" step="0.01"
                                   name="payoff_amount"
                                   class="form-control">
                        </div>

                        <!-- <div class="form-group">
                            <label>Carfax Link</label>
                            <input type="url" name="carfax_link"
                                   class="form-control">
                        </div> -->

                        <div class="form-group">
                            <label>Vehicle Photos</label>
                            <input type="file" name="vehicle_photos[]" class="form-control-file"
                               multiple
                               accept="image/*">
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Submit Appraisal
                        </button>
                    </form>
                </div>

                <div class="card-footer text-muted text-center">
                    Secure submission • No login required
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
