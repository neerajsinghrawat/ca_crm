<?php
require_once('modules/Leads/views/view.convertlead.php');

class CustomViewConvertLead extends ViewConvertLead
{
    public function display()
    {
        parent::display();

        echo "<script>
        $(document).ready(function(){

            var first = $('[name=\"Contactsfirst_name\"]').val();
            var last  = $('#Contactslast_name').val();
            var contactName = (first ? first : '') + ' ' + (last ? last : '');

            if($('#Accountsname').length && $('#Accountsname').val() == ''){
                $('#Accountsname').val(contactName);
            }

            // Old function backup
            var old_check_form = window.check_form;

            // Override check_form (ConvertLead save uses this)
            window.check_form = function(formname){

                if(formname == 'ConvertLead'){
                    var mobile = $('input[name=\"Contactsphone_mobile\"]').val();
                    var first = $('input[name=\"Contactsfirst_name\"]').val();

                    if(!mobile || $.trim(mobile) == ''){
                        alert('Mobile phone is required!');
                        $('input[name=\"Contactsphone_mobile\"]').focus();
                        return false;
                    }
                    if(!first || $.trim(first) == ''){
                        alert('First Name is required!');
                        $('input[name=\"Contactsfirst_name\"]').focus();
                        return false;
                    }
                }

                // run original validation also
                if(typeof old_check_form === 'function'){
                    return old_check_form(formname);
                }

                return true;
            };

        });
        </script>";

    }
}
