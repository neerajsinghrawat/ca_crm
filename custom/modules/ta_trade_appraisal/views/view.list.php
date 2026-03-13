<?php
require_once('include/MVC/View/views/view.list.php');

class ta_trade_appraisalViewList extends ViewList
{
    public function display()
    {
        parent::display();

        echo <<<HTML
<script>
function openSendAppraisalPopup() {

    var html = `
    <div id="sendAppraisalModal" style="
        position:fixed;
        top:0;left:0;
        width:100%;height:100%;
        background:rgba(0,0,0,0.5);
        z-index:9999;">

      <div style="
        background:#fff;
        width:400px;
        margin:120px auto;
        padding:20px;
        border-radius:8px;">

        <h4>Send Appraisal</h4>

        <label>Email</label>
        <input type="email" id="send_email" class="form-control">

        <label style="margin-top:10px;">Phone</label>
        <input type="text" id="send_phone" class="form-control">

        <div style="margin-top:15px;text-align:right;">
          <button class="btn btn-secondary" onclick="closeSendPopup()">Cancel</button>
          <button class="btn btn-primary" onclick="sendAppraisal()">Send</button>
        </div>

      </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', html);
}

function closeSendPopup() {
    var el = document.getElementById('sendAppraisalModal');
    if (el) el.remove();
}
function sendAppraisal() {

    var email = document.getElementById('send_email').value.trim();
    var phone = document.getElementById('send_phone').value.trim();

    
    if (email === '' && phone === '') {
        alert('Please enter Email or Phone number.');
        return false;
    }

    
    if (email !== '') {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }
    }

    
    if (phone !== '') {
        phone = phone.replace(/\D+/g, '');
        if (phone.length < 10) {
            alert('Please enter a valid phone number.');
            return false;
        }
    }

    $.ajax({
        url: 'index.php?module=Leads&action=requestAppraisal',
        type: 'POST',
        data: {
            lead_email: email,
            lead_phone_number: phone
        },
        success: function () {
            alert('Appraisal request sent successfully.');
            closeSendPopup();
        },
        error: function () {
            alert('Something went wrong. Please try again.');
        }
    });
}
</script>
HTML;
    }
}
