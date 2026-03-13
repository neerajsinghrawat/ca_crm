 $(document).ready(function () {

    var tabs = [0,1,2,3,4,5,6];
    tabs.forEach(function(i){
        $('#top-panel-' + i).removeClass('in show');
        $('a[href="#top-panel-' + i + '"]')
            .addClass('collapsed')
            .attr('aria-expanded','false');
    });
});

function requestAppraisal(leadId){
    if(!confirm('Send appraisal request to customer?')) return;

    $.ajax({
        url: 'index.php?module=Leads&action=requestAppraisal',
        type: 'POST',
        data: { lead_id: leadId },
        success: function(){
            alert('Appraisal request sent successfully.');
        }
    });
}
