/**
 * Click to Call functionality for Leads module
 */

// Load custom alert component
(function() {
    const script = document.createElement('script');
    script.src = 'custom/modules/Leads/js/custom_alert.js';
    document.head.appendChild(script);
})();

/**
 * Call specific phone number function
 * @param {string} phoneNumber - The phone number to call
 * @param {string} leadId - Label for the phone field (e.g., "Mobile Phone", "Work Phone")
 */
async function showClickToCallAlert(phoneNumber, leadId) {
    try {
        
        if (!leadId) {
            alert('Unable to find Lead ID');
            return;
        }
        
        // Show SuiteCRM loading panel
        SUGAR.ajaxUI.showLoadingPanel();
        
        // Make API call to the entry point
        const response = await fetch('index.php?entryPoint=ClickToCall', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone_number: phoneNumber,
                lead_id: leadId
            })
        });
        
        // Hide loading panel
        SUGAR.ajaxUI.hideLoadingPanel();
        
        // Parse JSON response
        const data = await response.json();
        
        if (data.success) {
            showCustomAlert('<strong>✓ ' + data.message + '</strong>', 'success');
        } else {
            // Enhanced error message display
            let errorTitle = '✗ Call Failed';
            let errorMessage = data.message || 'An unknown error occurred';
            
            // Check for specific error types
            if (errorMessage.includes('not enabled') || errorMessage.includes('configuration is incomplete')) {
                errorTitle = '✗ ClearlyIP Configuration Error';
            } else if (errorMessage.includes('not authenticated')) {
                errorTitle = '✗ Authentication Error';
            } else if (errorMessage.includes('Invalid phone number')) {
                errorTitle = '✗ Invalid Phone Number';
            }
            
            showCustomAlert('<strong>' + errorTitle + '</strong>\n\n' + errorMessage, 'error');
        }
        
    } catch (error) {
        // Hide SuiteCRM loading panel on error
        SUGAR.ajaxUI.hideLoadingPanel();
        showCustomAlert('<strong>Connection Error</strong>\n\nFailed to connect to the API.\nError: ' + error.message, 'error');
    }
}
