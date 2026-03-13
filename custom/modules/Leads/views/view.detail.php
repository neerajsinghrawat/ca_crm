<?php
require_once('include/MVC/View/views/view.detail.php');

class LeadsViewDetail extends ViewDetail
{
    function display()
    {
        global $current_user, $db, $log;
        $popupHtml = '';
        if (!empty($this->bean->call_transcription_c)) {
            $this->bean->call_transcription_c = html_entity_decode($this->bean->call_transcription_c, ENT_QUOTES, 'UTF-8');
            $fullDesc = nl2br(htmlspecialchars($this->bean->call_transcription_c, ENT_QUOTES));
            $shortDesc = mb_strimwidth($this->bean->call_transcription_c, 0, 100, "...");

            // Replace description with short text + read more link
            $this->bean->call_transcription_c = nl2br(htmlspecialchars($shortDesc, ENT_QUOTES)) .
                " <a href='javascript:void(0);' onclick=\"showDescriptionPopup()\">Read more</a>";

            // Popup HTML + script (print later, outside of bean)
            $popupHtml = "
                <div id='descPopup' style='display:none; position:fixed; top:20%; left:30%; width:40%; 
                    background:#fff; border:1px solid #666; padding:15px; z-index:1000; box-shadow:0 0 10px #333;'>
                    <div style='text-align:right;'>
                        <a href='javascript:void(0);' onclick=\"document.getElementById('descPopup').style.display='none'\">Close</a>
                    </div>
                    <div style='max-height:500px; overflow:auto;'>$fullDesc</div>
                </div>
                <script>
                    function showDescriptionPopup(){
                        document.getElementById('descPopup').style.display = 'block';
                    }
                </script>
            ";
        }

        parent::display();
        $recordId = htmlspecialchars($this->bean->id, ENT_QUOTES, 'UTF-8');
        $lead = BeanFactory::getBean('Leads', $this->bean->id);
        $phone = '';
        if (!empty($this->bean->phone_mobile)) {
            $phone = $this->bean->phone_mobile;
        } elseif (!empty($this->bean->phone_work)) {
            $phone = $this->bean->phone_work;
        }
        
        
        $isSmsServiceOn = (!empty($this->bean->is_sms_service_on) && $this->bean->is_sms_service_on == '1') ? 1 : 0;
        $smsComposerHtml = '';

        if ($isSmsServiceOn) {
            $smsComposerHtml = '
                <div class="chat-input-wrapper">
                    <textarea id="chatMessage" style="width:100%;height:90px;border:1px solid #ddd;padding:8px;border-radius:6px;" placeholder="Type your message..."></textarea>

                    <button type="button" id="attachBtn" title="Attach image">➕</button>
                    <input type="file" id="chatImage" accept="image/*" multiple style="display: none;">
                </div>

                <div id="imagePreview"></div>
                <br><br>
                <button id="chatSendBtn">Send</button>

                <input type="hidden" id="chatapprovalStatus" value="2">
            ';
        } else {
            $product_name_c='';
            $assigned_user_name='Status Salesperson';
            if (isset($this->bean->product_name_c) && !empty($this->bean->product_name_c)) {
               $product_name_c=$this->bean->product_name_c;
            }
            
            if(!empty($this->bean->assigned_user_id)){
                $userBean = BeanFactory::getBean('Users', $this->bean->assigned_user_id);
                if($userBean){
                    $assigned_user_name = trim($userBean->first_name . ' ' . $userBean->last_name);
                }
            }
            
             $message = "Thank you for reaching out to Status Auto Group regarding the. ".$product_name_c." To receive text messages from ".$assigned_user_name.", please reply YES.To stop messages at any time, reply StatusSTOP";
            $smsComposerHtml = '
                <div style="color:red;font-weight:bold;margin:10px 0;">
                    SMS service off. Right now waiting user approval.
                </div>
                <br><br>
                <div class="chat-input-wrapper" style="display: none;">
                    <textarea id="chatMessageN" style="width:100%;height:90px;border:1px solid #ddd;padding:8px;border-radius:6px;">'.$message.'</textarea>
                </div>
                <button id="chatSendBtnN">Send Approval message</button>
                <input type="hidden" id="chatapprovalStatus" value="1">
            ';
        }


        $recordname = ' ('.$phone.')';
        echo '<script src="custom/modules/Leads/js/request_appraisal.js"></script>';
        echo '<script src="custom/modules/Leads/js/todo.js"></script>';
        echo '<link rel="stylesheet" type="text/css" href="custom/modules/Leads/css/todoandchat.css">';
        echo <<<HTML
        <button id="openChatBtnNew">SMS</button>

        <div id="chatPopupOverlay"></div>

        <div id="chatPopupBox" role="dialog" aria-modal="true" aria-labelledby="chatPopupTitle">
            <h3 id="chatPopupTitle" style="margin-top:0;margin-bottom:8px;">SMS History {$recordname}</h3>

            <div id="chatHistory">
                <div style="color:#666;">Loading SMS history…</div>
            </div>

            
            {$smsComposerHtml}
            <button id="chatCancelBtn">Cancel</button>
            <div id="chatStatus" style="margin-top:10px;font-weight:bold;"></div>
        </div>
        
        
        <div id="todoPopupOverlay"></div>

        <div id="todoPopupBox" role="dialog" aria-modal="true" aria-labelledby="todoPopupTitle">
            <h3 id="todoPopupTitle" style="margin-top:0;margin-bottom:8px;">TO-DO History {$recordname}</h3>

            <div id="todoHistory">
                <div style="color:#666;">Loading TO-DO history…</div>
            </div>

            <div class="chat-input-wrapper">
                <textarea id="chatMessageToDO" style="width:100%;height:90px;border:1px solid #ddd;padding:8px;border-radius:6px;" placeholder="Type your To-Do..."></textarea>

            </div>

            <br><br>
            <button id="todoSendBtn">ADD TO-DO</button>
            <button id="todoCancelBtn">Cancel</button>
            <div id="todoStatus" style="margin-top:10px;font-weight:bold;"></div>
        </div>

        <script>
        $(document).ready(function () {

            var params = new URLSearchParams(window.location.search);
            var openSms = params.get('opensms');
            if(!openSms && window.location.hash){
                var hash = window.location.hash;

                if(hash.indexOf('opensms=1') !== -1){
                    openSms = '1';
                }
            }
            if (openSms === '1') {
                $('#openChatBtnNew').trigger('click');                    
            }

        });
        (function(){

            var overlay = document.getElementById('chatPopupOverlay');
            var popup   = document.getElementById('chatPopupBox');
            var openBtn = document.getElementById('openChatBtn');
            var openChatBtnNew = document.getElementById('openChatBtnNew');
            var sendBtn = document.getElementById('chatSendBtn');
            var sendBtnN = document.getElementById('chatSendBtnN');
            var cancelBtn = document.getElementById('chatCancelBtn');
            var statusDiv = document.getElementById('chatStatus');
            var historyDiv = document.getElementById('chatHistory');
            var textarea = document.getElementById('chatMessage');
            var textareaN = document.getElementById('chatMessageN');
            var refreshTimer = null;
            var leadId = '{$recordId}';
            var intrested_pl_leadId = encodeURIComponent(window.currentTodoParent);
            var attachBtn = document.getElementById('attachBtn');
            var imageInput = document.getElementById('chatImage');
            var imagePreview = document.getElementById('imagePreview');


            // Store selected images manually
            var selectedImages = [];
            if(attachBtn){
                attachBtn.onclick = function () {
                    imageInput.click();
                };

            }
            if(imageInput){
                imageInput.addEventListener('change', function () {
                    Array.from(this.files).forEach(function (file) {
                        selectedImages.push(file);
                    });

                    imageInput.value = ''; // reset input
                    renderPreviews();
                });
            }
            function renderPreviews() {
                imagePreview.innerHTML = '';

                selectedImages.forEach(function (file, index) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'preview-item';

                    var img = document.createElement('img');
                    img.src = URL.createObjectURL(file);

                    var remove = document.createElement('span');
                    remove.className = 'remove-img';
                    remove.innerHTML = '✕';
                    remove.onclick = function () {
                        selectedImages.splice(index, 1);
                        renderPreviews();
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(remove);
                    imagePreview.appendChild(wrapper);
                });
            }

            function esc(s) {
                return String(s || '').replace(/[&<>"']/g, function(m){
                    return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m];
                });
            }

            function formatDate(dt) {
                if (!dt) return '';
                var d = new Date(dt);
                if (!isNaN(d.getTime())) return d.toLocaleString();
                return dt;
            }

            // Lightweight sanitizer that allows only a whitelist of tags & attributes.
            // NOTE: This is a simple sanitizer (not a full library). For best security, consider using a tested lib (e.g. DOMPurify server-side or client-side).
            function sanitizeAllowList(html) {
                if (!html) return '';
                // Remove script/style tags and their content
                html = html.replace(/<\\s*(script|style)[^>]*>[\\s\\S]*?<\\s*\\/\\s*\\1\\s*>/gi, '');

                var allowedTags = {
                    'a': ['href','target','title','rel','style'],
                    'img': ['src','alt','title','width','height','style'],
                    'p': ['style'],
                    'div': ['style'],
                    'br': [],
                    'b': [],
                    'strong': [],
                    'em': [],
                    'u': [],
                    'span': ['style']
                };

                // Replace tags, keeping only allowed ones and whitelisted attrs
                return html.replace(/<\\s*\\/?\\s*([a-z0-9]+)([^>]*)>/gi, function(match, tagName, attrText){
                    tagName = tagName.toLowerCase();
                    var isClosing = /^\\s*\\//.test(match);
                    if (!allowedTags.hasOwnProperty(tagName)) {
                        return ''; // strip unknown tag entirely
                    }
                    if (isClosing) {
                        return '</' + tagName + '>';
                    }
                    var allowedAttrs = allowedTags[tagName];
                    if (!attrText || allowedAttrs.length === 0) {
                        return '<' + tagName + '>';
                    }
                    var attrs = [];
                    attrText.replace(/([a-zA-Z0-9\\-:_]+)(?:\\s*=\\s*(?:"([^"]*)"|'([^']*)'|([^>\\s]+)))?/g, function(m, name, v1, v2, v3){
                        var val = v1 || v2 || v3 || '';
                        name = name.toLowerCase();
                        if (allowedAttrs.indexOf(name) !== -1) {
                            // block javascript: URIs
                            if ((name === 'href' || name === 'src') && /^\\s*javascript:/i.test(val)) {
                                return;
                            }
                            // basic safe-encoding of quotes
                            val = val.replace(/"/g, '&quot;');
                            attrs.push(name + '="' + val + '"');
                        }
                    });
                    return '<' + tagName + (attrs.length ? ' ' + attrs.join(' ') : '') + '>';
                });
            }

            /*function renderItems(items) {
                historyDiv.innerHTML = '';
                if (!items || items.length === 0) {
                    historyDiv.innerHTML = '<div style="color:#666;">No SMS yet.</div>';
                    return;
                }
                items.forEach(function(it){
                    var row = document.createElement('div');
                    row.className = 'chat-row';
                    var bubble = document.createElement('div');
                    var cls = (it.direction === 'outbound' || it.direction === 'out') ? 'chat-me' : 'chat-them';
                    bubble.className = 'chat-bubble ' + cls;
                    
                    var body = document.createElement('div');
                    
                    var html = it.body || "";
                    
                    html = html.replace(/>\s+</g, '><');  // remove whitespace between tags

                    var safeHtml = sanitizeAllowList(html);
                    body.innerHTML = safeHtml;
                    body.querySelectorAll("a").forEach(function(a){
                        a.setAttribute("target", "_blank");
                        a.setAttribute("rel", "noopener noreferrer");
                    });
                    //var safeHtml = sanitizeAllowList(it.body || '').replace(/\\r?\\n/g, '<br>');
                    //body.innerHTML = safeHtml;
                    bubble.appendChild(body);

                    var meta = document.createElement('div');
                    meta.className = 'chat-meta';
                    var who = (it.direction === 'outbound' || it.direction === 'out') ? 'You' : (it.from || 'Lead');
                    meta.innerHTML = esc(who) + ' • ' + esc(formatDate(it.date || ''));
                    bubble.appendChild(meta);

                    row.appendChild(bubble);
                    historyDiv.appendChild(row);
                });
                //historyDiv.scrollTop = historyDiv.scrollHeight;
                var isNearBottom = (historyDiv.scrollHeight - historyDiv.scrollTop - historyDiv.clientHeight) < 80;
                if (isNearBottom) {
                    historyDiv.scrollTop = historyDiv.scrollHeight;
                }
            }*/
            var lastItemCount = 0; // track count messages 

            function renderItems(items) {
                if (!items || items.length === 0) {
                    historyDiv.innerHTML = '<div style="color:#666;">No SMS yet.</div>';
                    lastItemCount = 0;
                    return;
                }

                var isNearBottom = (historyDiv.scrollHeight - historyDiv.scrollTop - historyDiv.clientHeight) < 80;
                var hasNewMessages = items.length > lastItemCount;

                historyDiv.innerHTML = '';
                items.forEach(function(it){
                    var row = document.createElement('div');
                    row.className = 'chat-row';
                    var bubble = document.createElement('div');
                    var cls = (it.direction === 'outbound' || it.direction === 'out') ? 'chat-me' : 'chat-them';
                    bubble.className = 'chat-bubble ' + cls;
                    
                    var body = document.createElement('div');
                    var html = it.body || "";
                    html = html.replace(/>\s+</g, '><');
                    var safeHtml = sanitizeAllowList(html);
                    body.innerHTML = safeHtml;
                    body.querySelectorAll("a").forEach(function(a){
                        a.setAttribute("target", "_blank");
                        a.setAttribute("rel", "noopener noreferrer");
                    });
                    bubble.appendChild(body);

                    var meta = document.createElement('div');
                    meta.className = 'chat-meta';
                    var who = (it.direction === 'outbound' || it.direction === 'out') ? 'You' : (it.from || 'Lead');
                    meta.innerHTML = esc(who) + ' • ' + esc(formatDate(it.date || ''));
                    bubble.appendChild(meta);

                    row.appendChild(bubble);
                    historyDiv.appendChild(row);
                });

                // WhatsApp wala logic
                if (isNearBottom || lastItemCount === 0) {
                    // User bottom first time load scroll karo
                    historyDiv.scrollTop = historyDiv.scrollHeight;
                    hideNewMsgBtn();
                } else if (hasNewMessages) {
                    // show button
                    showNewMsgBtn();
                }

                lastItemCount = items.length;
            }

            // "New Message ↓" button functions
            function showNewMsgBtn() {
                var btn = document.getElementById('newMsgBtn');
                if (!btn) {
                    btn = document.createElement('div');
                    btn.id = 'newMsgBtn';
                    btn.innerHTML = `
                        <span style="display:flex;align-items:center;gap:7px;">
                            <span style="display:inline-flex;align-items:center;justify-content:center;
                                background:rgba(255,255,255,0.25);border-radius:50%;width:22px;height:22px;font-size:13px;">
                                ↓
                            </span>
                            <span>New Message</span>
                        </span>
                    `;
                    btn.style.cssText = `
                        position: absolute;
                        bottom: 170px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: linear-gradient(135deg, #075E54, #128C7E);
                        color: #fff;
                        padding: 10px 22px;
                        border-radius: 25px;
                        cursor: pointer;
                        font-size: 13px;
                        font-weight: 600;
                        font-family: inherit;
                        z-index: 999;
                        box-shadow: 0 4px 15px rgba(7,94,84,0.45);
                        white-space: nowrap;
                        letter-spacing: 0.3px;
                        border: 1px solid rgba(255,255,255,0.15);
                        animation: popIn 0.25s cubic-bezier(0.175,0.885,0.32,1.275);
                    `;
                    btn.onclick = function() {
                        historyDiv.scrollTop = historyDiv.scrollHeight;
                        hideNewMsgBtn();
                    };
                    document.getElementById('chatPopupBox').appendChild(btn);
                }
                btn.style.display = 'block';
            }

            function hideNewMsgBtn() {
                var btn = document.getElementById('newMsgBtn');
                if (btn) btn.style.display = 'none';
            }

            // button hide scroll down
            historyDiv.addEventListener('scroll', function() {
                var isNearBottom = (historyDiv.scrollHeight - historyDiv.scrollTop - historyDiv.clientHeight) < 80;
                if (isNearBottom) hideNewMsgBtn();
            });
            // fetch latest history from server (chat_fetch endpoint)
            function fetchHistory(cb) {
                console.log('cb');
                console.log(cb);
                if (historyDiv.innerHTML.trim() === '') {
                    historyDiv.innerHTML = '<div style="color:#666;">Loading SMS history…</div>';
                }
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'index.php?entryPoint=chat_fetch&lead_id=' + encodeURIComponent(leadId), true);
                xhr.onload = function(){
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            console.log('resp');
                            console.log(resp.is_sms_service_on);
                            console.log(typeof resp.is_sms_service_on);
                            if (resp && resp.is_sms_service_on == 1) {
                                var chatapprovalStatus = $('#chatapprovalStatus').val();
                                if (chatapprovalStatus == 1) {
                                    var url = window.location.href;

                                    if(url.indexOf('opensms=1') === -1){
                                        if(url.indexOf('?') > -1){
                                            url += '&opensms=1';
                                        }else{
                                            url += '?opensms=1';
                                        }
                                    }

                                    window.location.href = url;
                                    location.reload();
                                }
                            }
                            if (resp && resp.success) {
                                renderItems(resp.items || []);
                                if (typeof cb === 'function') cb(null, resp.items || []);
                            } else {
                                historyDiv.innerHTML = '<div style="color:red;">Error loading history: ' + (resp && resp.error ? resp.error : '') + '</div>';
                                if (typeof cb === 'function') cb(new Error(resp && resp.error ? resp.error : 'error'));
                            }
                        } catch (e) {
                            historyDiv.innerHTML = '<div style="color:red;">Unexpected response</div>';
                            console.error('chat_fetch parse error', e, xhr.responseText);
                            if (typeof cb === 'function') cb(e);
                        }
                    } else {
                        historyDiv.innerHTML = '<div style="color:red;">Network error: ' + xhr.status + '</div>';
                        if (typeof cb === 'function') cb(new Error('HTTP ' + xhr.status));
                    }
                };
                xhr.onerror = function(){
                    historyDiv.innerHTML = '<div style="color:red;">Network error</div>';
                    if (typeof cb === 'function') cb(new Error('network'));
                };
                xhr.send();
            }

            
            

            // Open popup — fetch latest messages
            openBtn && (openBtn.onclick = function() {
                overlay.style.display = 'block';
                popup.style.display = 'block';
                statusDiv.innerHTML = '';
                if (textarea) textarea.value = '';
                fetchHistory();
                if (textarea) textarea.focus();
                refreshTimer = setInterval(fetchHistory, 3000);
            });

            openChatBtnNew.onclick = function() {
                overlay.style.display = 'block';
                popup.style.display = 'block';
                statusDiv.innerHTML = '';
                if (textarea) textarea.value = '';
                fetchHistory(function() {
                    historyDiv.scrollTop = historyDiv.scrollHeight;
                });
                if (textarea) textarea.focus();
                refreshTimer = setInterval(fetchHistory, 3000);
            };

            

            // close
            cancelBtn.onclick = overlay.onclick = function() {
                overlay.style.display = 'none';
                popup.style.display = 'none';
                clearInterval(refreshTimer);
                refreshTimer = null;
            };
            // close
            

            // send message
            if (sendBtn) {
                sendBtn.onclick = function() {
                    var msg = textarea.value.trim();
                    if (!msg) {
                        statusDiv.style.color = 'red';
                        statusDiv.innerHTML = 'Please type a message.';
                        textarea.focus();
                        return;
                    }

                    sendBtn.disabled = true;
                    sendBtn.innerHTML = 'Sending...';
                    statusDiv.innerHTML = ''; 

                    var formData = new FormData();
                    formData.append('lead_id', leadId); // leadId must exist
                    formData.append('message', msg);
                    //console.log('selectedImages===>');
                    //console.log(selectedImages);
                    selectedImages.forEach(function (file) {
                        formData.append('images[]', file);
                    });

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'index.php?entryPoint=chat_save', true);
                    //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        sendBtn.disabled = false;
                        sendBtn.innerHTML = 'Send';

                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp && resp.success) {
                                selectedImages = [];
                                imagePreview.innerHTML = '';
                                statusDiv.style.color = 'green';
                                statusDiv.innerHTML = 'Message sent successfully!';
                                setTimeout(function() { fetchHistory(); }, 500);
                                textarea.value = '';
                            } else {
                                statusDiv.style.color = 'red';
                                statusDiv.innerHTML = (resp && resp.error) ? resp.error : 'Error sending message.';
                                console.error('chat_save response:', xhr.responseText);
                            }
                        } catch (e) {
                            statusDiv.style.color = 'red';
                            statusDiv.innerHTML = 'Server error.';
                            console.error('chat_save parse error', e, xhr.responseText);
                        }
                    };

                    xhr.onerror = function() {
                        sendBtn.disabled = false;
                        sendBtn.innerHTML = 'Send';
                        statusDiv.style.color = 'red';
                        statusDiv.innerHTML = 'Network error.';
                    };

                    xhr.send(formData);
                    /*var params = 'lead_id=' + encodeURIComponent(leadId) + '&message=' + encodeURIComponent(msg);
                    xhr.send(params);*/
                };
            }

            

        if (sendBtnN) {
            sendBtnN.onclick = function() {
                var msg = textareaN.value.trim();
                if (!msg) {
                    statusDiv.style.color = 'red';
                    statusDiv.innerHTML = 'Please type a message.';
                    textareaN.focus();
                    return;
                }

                sendBtnN.disabled = true;
                sendBtnN.innerHTML = 'Sending...';
                statusDiv.innerHTML = ''; 

                var formData = new FormData();
                formData.append('lead_id', leadId); // leadId must exist
                formData.append('message', msg);
                formData.append('approval_message', 'approval_message');
                //console.log('selectedImages===>');
                //console.log(selectedImages);
                selectedImages.forEach(function (file) {
                    formData.append('images[]', file);
                });

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php?entryPoint=chat_save', true);
                //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    sendBtnN.disabled = false;
                    sendBtnN.innerHTML = 'Send Approval message';

                    try {
                        var resp = JSON.parse(xhr.responseText);
                        if (resp && resp.success) {
                            statusDiv.style.color = 'green';
                            statusDiv.innerHTML = 'Message sent successfully!';
                            setTimeout(function() { fetchHistory(); }, 500);
                            //textarea.value = '';
                        } else {
                            statusDiv.style.color = 'red';
                            statusDiv.innerHTML = (resp && resp.error) ? resp.error : 'Error sending message.';
                            console.error('chat_save response:', xhr.responseText);
                        }
                    } catch (e) {
                        statusDiv.style.color = 'red';
                        statusDiv.innerHTML = 'Server error.';
                        console.error('chat_save parse error', e, xhr.responseText);
                    }
                };

                xhr.onerror = function() {
                    sendBtnN.disabled = false;
                    sendBtnN.innerHTML = 'Send Approval message';
                    statusDiv.style.color = 'red';
                    statusDiv.innerHTML = 'Network error.';
                };

                xhr.send(formData);
                /*var params = 'lead_id=' + encodeURIComponent(leadId) + '&message=' + encodeURIComponent(msg);
                xhr.send(params);*/
            };
        }

        })();
        </script>
        HTML;

        // Print popupHtml if exists (call after main HTML so popup markup exists once)
        if (!empty($popupHtml)) {
            echo $popupHtml;
        }
    }
}
