/**
 * Custom Alert Component
 * Shows styled notification messages
 */

function showCustomAlert(message, type = 'success') {
    // Create alert container if it doesn't exist
    let container = document.getElementById('custom-alert-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-alert-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10000;
            max-width: 400px;
        `;
        document.body.appendChild(container);
    }
    
    // Create alert element
    const alert = document.createElement('div');
    alert.className = 'custom-alert custom-alert-' + type;
    
    // Set colors based on type
    const colors = {
        success: { bg: '#28a745', border: '#1e7e34' },
        error: { bg: '#dc3545', border: '#bd2130' },
        info: { bg: '#17a2b8', border: '#117a8b' }
    };
    
    const color = colors[type] || colors.info;
    
    alert.style.cssText = `
        background: ${color.bg};
        color: white;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 5px;
        border-left: 5px solid ${color.border};
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        animation: slideIn 0.3s ease-out;
        position: relative;
        font-size: 14px;
        line-height: 1.5;
    `;
    
    // Add message
    alert.innerHTML = `
        <div style="padding-right: 30px;">${message.replace(/\n/g, '<br>')}</div>
        <button onclick="this.parentElement.remove()" style="
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            line-height: 20px;
        ">×</button>
    `;
    
    // Add to container
    container.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alert.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// Add CSS animation
if (!document.getElementById('custom-alert-styles')) {
    const style = document.createElement('style');
    style.id = 'custom-alert-styles';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

