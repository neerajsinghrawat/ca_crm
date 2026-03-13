<?php
require_once('include/MVC/View/views/view.detail.php');

class ContactsViewDetail extends ViewDetail
{
    function display()
    {
        $popupHtml = '';
        if (!empty($this->bean->call_transcription_c)) {
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

        // Print popup HTML once at the end of the page
        echo $popupHtml;
    }
}
