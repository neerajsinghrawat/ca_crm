<?php
require_once('include/MVC/View/views/view.list.php');

class ac_dealersViewList extends ViewList
{
    public function display()
    {
        parent::display();

        echo <<<HTML
<script>
(function() {
    var btn = document.createElement('input');
    btn.type = 'button';
    btn.className = 'button';
    btn.value = 'Create Wholesale Deal';
    btn.style.margin = '0 0 10px 0';
    btn.onclick = function() {
        window.open('index.php?module=ac_dealers&action=createWholesaleDealPopup', 'createWholesaleDeal', 'width=1200,height=700,resizable=yes,scrollbars=yes');
    };

    var container = document.getElementById('pagination') || document.querySelector('.listViewBody');
    if (container && container.parentNode) {
        container.parentNode.insertBefore(btn, container);
    }
})();
</script>
HTML;
    }
}
