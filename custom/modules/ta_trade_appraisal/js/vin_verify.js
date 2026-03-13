function verifyVIN() {
    var vinEl = document.getElementById('vin');
    var status = document.getElementById('vin_status');

    if (!vinEl || !status) return;

    var vin = vinEl.value.trim();

    if (vin.length !== 17) {
        status.innerHTML = 'VIN must be 17 characters';
        status.style.color = 'red';
        return;
    }

    status.innerHTML = 'Verifying VIN...';
    status.style.color = 'gray';

    var url = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/' + vin + '?format=json';

    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (!data.Results || !data.Results[0]) throw 'Invalid response';

            var r = data.Results[0];

            if (!r.Make || !r.Model) {
                status.innerHTML = 'Invalid VIN';
                status.style.color = 'red';
                return;
            }

            // ✅ SuiteCRM fields IDs (ensure your input ids match)
            if (document.getElementById('vehicle_year')) {
                document.getElementById('vehicle_year').value = r.ModelYear || '';
            }
            if (document.getElementById('vehicle_make')) {
                document.getElementById('vehicle_make').value = r.Make || '';
            }
            if (document.getElementById('vehicle_model')) {
                document.getElementById('vehicle_model').value = r.Model || '';
            }
            if (document.getElementById('vehicle_engine')) {
                document.getElementById('vehicle_engine').value = r.EngineModel || '';
            }
            if (document.getElementById('trade_year')) {
                document.getElementById('trade_year').value = r.ModelYear || '';
            }
            if (document.getElementById('trade_make')) {
                document.getElementById('trade_make').value = r.Make || '';
            }
            if (document.getElementById('appraisal_vehicle_model')) {
                document.getElementById('appraisal_vehicle_model').value = r.Model || '';
            }
            if (document.getElementById('appraisal_vehicle_engine')) {
                document.getElementById('appraisal_vehicle_engine').value = r.EngineModel || '';
            }

            status.innerHTML = 'VIN verified successfully';
            status.style.color = 'green';
        })
        .catch(() => {
            status.innerHTML = 'Error verifying VIN';
            status.style.color = 'red';
        });
}
