(function() {
    'use strict';
    
    // Poll interval in milliseconds (5 seconds)
    const POLL_INTERVAL = 5000;
    
    // Create broadcast channel for cross-tab communication
    const webhookChannel = new BroadcastChannel('webhook_notifications');
    
    /**
     * Show modal with webhook data
     */
    function showWebhookPopup(notification) {
        const data = notification.data;
        const timestamp = notification.timestamp;
        const matchedLeads = notification.matched_leads || [];
        
        // Format the data as JSON string
        const formattedData = JSON.stringify(data, null, 2);
        
        // Generate lead HTML with icons, names, and phone numbers
        let leadsHTML = '';
        if (matchedLeads && matchedLeads.length > 0) {
            leadsHTML = `
                <div style="margin-bottom: 20px; border-bottom: 1px solid #e0e0e0; padding-bottom: 15px;">
                    <strong style="color: #666; display: block; margin-bottom: 10px;">Incoming Call From Lead${matchedLeads.length > 1 ? 's' : ''}:</strong>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
            `;
            
            matchedLeads.forEach(lead => {
                const isNewLead = lead.is_new === true;
                const leadURL = `index.php?module=Leads&action=DetailView&record=${lead.id}`;
                leadsHTML += `
                    <div style="
                        padding: 10px;
                        background: #f8f9fa;
                        border-radius: 6px;
                        border-left: 4px solid #0088cc;
                    ">
                        <div style="flex: 1;">
                            <div style="margin-bottom: 4px;">
                                ${isNewLead ? 
                                    `<div>
                                        <span style="
                                            color: #28a745;
                                            font-weight: 600;
                                            font-size: 16px;
                                            display: inline-block;
                                        ">${lead.full_name || 'Unknown Caller'}</span>
                                        <span style="
                                            background: #28a745;
                                            color: white;
                                            font-size: 11px;
                                            padding: 2px 8px;
                                            border-radius: 3px;
                                            margin-left: 8px;
                                            font-weight: 600;
                                        ">NEW LEAD</span>
                                    </div>
                                    ${lead.addresses && lead.addresses.trim() !== '' ? `
                                        <div>
                                            <span style="
                                                color: #28a745;
                                                font-weight: 600;
                                                font-size: 16px;
                                                display: inline-block;
                                            ">${lead.addresses}</span>
                                        </div>
                                    ` : ''}` 
                                    : 
                                    `<a href="${leadURL}" target="_blank" style="
                                        color: #0088cc;
                                        text-decoration: none;
                                        font-weight: 600;
                                        font-size: 16px;
                                        display: inline-block;
                                        transition: color 0.2s;
                                    " onmouseover="this.style.color='#005580'; this.style.textDecoration='underline';" 
                                       onmouseout="this.style.color='#0088cc'; this.style.textDecoration='none';">
                                        ${lead.full_name || 'Unnamed Lead'}
                                    </a>`
                                }
                            </div>
                            <div style="
                                color: #666;
                                font-size: 14px;
                                display: flex;
                                align-items: center;
                                gap: 5px;
                            ">
                                <span style="font-weight: 500;">📞</span>
                                <span>${lead.phone || 'No phone'}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            leadsHTML += `
                    </div>
                </div>
            `;
        }
        
        // Create modal HTML
        const modalHTML = `
            <div id="webhookModal" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
            ">
                <div style="
                    background: #fff;
                    border-radius: 8px;
                    padding: 20px;
                    max-width: 600px;
                    width: 90%;
                    max-height: 80vh;
                    overflow-y: auto;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                ">
                    <div style="
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                        margin-bottom: 15px;
                        border-bottom: 2px solid #0088cc;
                        padding-bottom: 10px;
                    ">
                        <button onclick="document.getElementById('webhookModal').remove()" style="
                            background: #dc3545;
                            color: white;
                            border: none;
                            border-radius: 4px;
                            padding: 5px 15px;
                            cursor: pointer;
                            font-size: 16px;
                            font-weight: bold;
                        ">✕</button>
                    </div>
                    ${leadsHTML}
                </div>
            </div>
        `;
        
        // Remove any existing modal
        const existingModal = document.getElementById('webhookModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add modal to page
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
    }
    
    /**
     * Check for new webhook notifications
     */
    async function checkForNotifications() {
        try {
            const response = await fetch('index.php?entryPoint=GetWebhookNotifications', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (result.notifications && result.notifications.length > 0) {
                // Show popup for each notification
                result.notifications.forEach(notification => {
                    showWebhookPopup(notification);
                    
                    // Broadcast notification to other tabs
                    webhookChannel.postMessage({
                        type: 'new_notification',
                        notification: notification
                    });
                });
            }
        } catch (error) {
            console.error('Error checking webhook notifications:', error);
        }
    }
    
    /**
     * Listen for notifications from other tabs
     */
    webhookChannel.onmessage = function(event) {
        if (event.data.type === 'new_notification') {
            // Show popup when receiving notification from another tab
            showWebhookPopup(event.data.notification);
        }
    };
    
    /**
     * Start polling for notifications
     */
    function startPolling() {
        // Check immediately on load
        checkForNotifications();
        
        // Then check every POLL_INTERVAL
        setInterval(checkForNotifications, POLL_INTERVAL);
        
        console.log('ClearlyIP webhook notification polling started (every ' + (POLL_INTERVAL/1000) + ' seconds)');
    }
    
    // Start polling when page is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startPolling);
    } else {
        startPolling();
    }
    
})();