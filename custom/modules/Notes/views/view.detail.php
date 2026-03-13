<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/MVC/View/views/view.detail.php';

class NotesViewDetail extends ViewDetail
{
function display()
{ 
    global $current_user, $db, $log;
    
    parent::display();
    $recordId = htmlspecialchars($this->bean->parent_id, ENT_QUOTES, 'UTF-8');
    $lead = BeanFactory::getBean('Leads', $this->bean->parent_id);
    $phone = '';
    if (!empty($lead->phone_mobile)) {
        $phone = $lead->phone_mobile;
    } elseif (!empty($lead->phone_work)) {
        $phone = $lead->phone_work;
    }
    $this->bean->name = $this->bean->name.' ('.$phone.')';
    $recordname = $this->bean->name;

echo <<<HTML
<style>
/* Overlay + popup */
#chatPopupOverlay {
    display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); z-index:99998;
}
#chatPopupBox {
    display:none; position:fixed; top:15%; left:50%; transform:translate(-50%,0);
    width:560px; max-width:95%; background:#fff; padding:16px; border-radius:8px;
    box-shadow:0 8px 28px rgba(0,0,0,0.2); z-index:99999;
}
#chatHistory { 
    max-height:340px; overflow:auto; padding:10px; 
    border:1px solid #eee; background:#fafafa; 
    margin-bottom:10px; border-radius:6px; 
    white-space:normal; word-wrap:break-word; 
}
.chat-row { margin-bottom:10px; display:flex; clear:both; }
.chat-bubble { padding:8px 12px; border-radius:12px; max-width:78%; box-shadow:0 2px 6px rgba(0,0,0,0.03); }
.chat-me { margin-left:auto; background:#534d64; color:#fff; text-align:right; }
.chat-them { margin-right:auto; background:#f1f1f1; color:#111; text-align:left; }
.chat-meta { font-size:11px; color:#999; margin-top:6px; }

#chatSendBtn, #chatCancelBtn { padding:8px 16px; border-radius:4px; border:none; cursor:pointer; }
#chatSendBtn { background:#534d64; color:#fff; }
#chatCancelBtn { background:#999; color:#fff; }

#openChatBtnNew { 
    position:fixed; right:20px; bottom:90px; 
    z-index:99999; background:#534d64; color:#fff; 
    border:none; padding:10px 14px; font-weight:bold; 
    border-radius:6px; cursor:pointer; 
}
@media (max-width:600px){
    #chatPopupBox { width:92%; top:10%; } 
    #chatHistory { max-height:260px; } 
}
</style>

<button id="openChatBtnNew">SMS</button>

<div id="chatPopupOverlay"></div>

<div id="chatPopupBox" role="dialog" aria-modal="true" aria-labelledby="chatPopupTitle">
    <h3 id="chatPopupTitle" style="margin-top:0;margin-bottom:8px;">{$recordname}</h3>

    <div id="chatHistory">
        <div style="color:#666;">Loading SMS history…</div>
    </div>

    <textarea id="chatMessage" style="width:100%;height:90px;border:1px solid #ddd;padding:8px;border-radius:6px;" placeholder="Type your message..."></textarea>
    <br><br>
    <button id="chatSendBtn">Send</button>
    <button id="chatCancelBtn">Cancel</button>
    <div id="chatStatus" style="margin-top:10px;font-weight:bold;"></div>
</div>


<script>
jQuery(function($){

    var leadId = '{$recordId}';

    var \$overlay = $('#chatPopupOverlay'),
        \$popup = $('#chatPopupBox'),
        \$openBtn = $('#openChatBtnNew'),
        \$sendBtn = $('#chatSendBtn'),
        \$cancelBtn = $('#chatCancelBtn'),
        \$statusDiv = $('#chatStatus'),
        \$historyDiv = $('#chatHistory'),
        \$textarea = $('#chatMessage');

    function esc(s){
        return String(s || '').replace(/[&<>"']/g, function(m){
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
        });
    }

    function formatDate(dt){
        var d = new Date(dt);
        return isNaN(d.getTime()) ? dt : d.toLocaleString();
    }

    function renderItems(items){
        \$historyDiv.empty();
        if(!items || items.length === 0){
            \$historyDiv.html('<div style="color:#666;">No SMS yet.</div>');
            return;
        }
        items.forEach(function(it){
            var who = (it.direction === 'outbound' || it.direction === 'out') ? 'You' : (it.from || 'Lead');
            var cls = (it.direction === 'outbound' || it.direction === 'out') ? 'chat-me' : 'chat-them';

            var row = '<div class="chat-row">'+
                        '<div class="chat-bubble '+cls+'">'+
                            '<div>'+ esc(it.body).replace(/\\n/g,'<br>') +'</div>'+
                            '<div class="chat-meta">'+ esc(who)+' • '+ esc(formatDate(it.date)) +'</div>'+
                        '</div>'+
                      '</div>';

            \$historyDiv.append(row);
        });

        \$historyDiv.scrollTop(\$historyDiv.prop("scrollHeight"));
    }

    function fetchHistory(){
        \$historyDiv.html('<div style="color:#666;">Loading SMS history…</div>');

        $.get('index.php', { entryPoint:'chat_fetch', lead_id:leadId })
        .done(function(resp){
            var data = resp;
            if(typeof resp === 'string'){ try{ data = JSON.parse(resp); }catch(e){ data={success:false}; } }

            if(data.success) renderItems(data.items || []);
            else \$historyDiv.html('<div style="color:red;">Error: '+esc(data.error || "")+'</div>');
        })
        .fail(function(){
            \$historyDiv.html('<div style="color:red;">Network error</div>');
        });
    }

    function openPopup(){
        \$overlay.show();
        \$popup.show();
        \$statusDiv.empty();
        \$textarea.val('').focus();
        fetchHistory();
    }

    function closePopup(){
        \$overlay.hide();
        \$popup.hide();
    }

    // OPEN
    \$openBtn.on('click', openPopup);

    // CLOSE
    \$cancelBtn.on('click', closePopup);
    \$overlay.on('click', function(e){
        if(e.target === this) closePopup();
    });

    // ESC key
    $(document).on('keydown', function(e){
        if(e.key === 'Escape') closePopup();
    });

    // SEND
    \$sendBtn.on('click', function(){
        var msg = \$.trim(\$textarea.val());
        if(!msg){
            \$statusDiv.css('color','red').text('Please type a message.');
            return;
        }

        \$sendBtn.prop('disabled',true).text('Sending...');
        \$statusDiv.text('');

        $.post('index.php?entryPoint=chat_save', { lead_id:leadId, message:msg })
        .done(function(resp){
            var data = resp;
            if(typeof resp === 'string'){ try{ data = JSON.parse(resp); }catch(e){ data={success:false}; } }

            if(data.success){
                \$statusDiv.css('color','green').text('Message sent successfully!');
                \$textarea.val('');
                setTimeout(fetchHistory, 500);
            } else {
                \$statusDiv.css('color','red').text(data.error || 'Error sending message.');
            }
        })
        .fail(function(){
            \$statusDiv.css('color','red').text('Network error.');
        })
        .always(function(){
            \$sendBtn.prop('disabled',false).text('Send');
        });
    });

});
</script>
HTML;
}

}
