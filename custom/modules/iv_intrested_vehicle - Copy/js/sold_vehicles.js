function loadSoldVehicles(type){

    $.ajax({
        url: "index.php?module=iv_intrested_vehicle&action=getSoldVehicles&type="+type,
        success:function(res){
            $("#soldVehicleTable").html(res);
        }
    });

}

$(document).ready(function(){

    var paymentType = form_of_payment;
    //alert(paymentType);
    if(paymentType == "lease"){
        loadSoldVehicles("lease");
    }

    if(paymentType == "finance"){
        loadSoldVehicles("finance");
    }

});
function openUpdatePopup(){

    var ids = [];

    $(".listview-checkbox:checked").each(function(){
        ids.push($(this).val());
    });

    if(ids.length == 0){
        alert("Please select record");
        return;
    }

    // finance fields show/hide
    if(form_of_payment == "finance"){
        $("#finance_fields").show();
    }else{
        $("#finance_fields").hide();
    }

    // SINGLE RECORD → AUTO FILL
    if(ids.length == 1){

        $.ajax({

            url:"index.php?module=iv_intrested_vehicle&action=getVehicleData",

            type:"POST",

            data:{ id: ids[0] },

            dataType:"json",

            success:function(res){

                $("#trim_c").val(res.trim_c);
                $("#miles_per_year").val(res.miles_per_year);
                if(res.start_date){
                    var date = res.start_date.split(" ")[0]; 
                    $("#start_date").val(date);
                }
                //$("#start_date").val(res.start_date);
                $("#monthly_payments_c").val(res.monthly_payments_c);
                $("#bank_c").val(res.bank_c);
                $("#month_c").val(res.month_c);

            }

        });

    }else{

        // MULTIPLE → CLEAR FIELDS
        $("#updateVehicleModal input").val("");

    }

    $("#updateVehicleModal").modal("show");

}

function saveVehicleUpdate(){

    var ids = [];

    $(".listview-checkbox:checked").each(function(){
        ids.push($(this).val());
    });

    $.ajax({

        url:"index.php?module=iv_intrested_vehicle&action=updateVehicleFields",

        type:"POST",

        data:{

            ids:ids,

            trim_c:$("#trim_c").val(),
            miles_per_year:$("#miles_per_year").val(),
            start_date:$("#start_date").val(),
            end_date:$("#end_date").val(),
            monthly_payments_c:$("#monthly_payments_c").val(),
            bank_c:$("#bank_c").val(),
            month_c:$("#month_c").val()

        },

        success:function(){

            $("#updateVehicleModal").modal("hide");
            alert("Updated Successfully");
            location.reload();

        }

    });

}

function calculateEndDate() {
    var startDateVal = document.getElementById('start_date').value;
    var termMonths   = document.getElementById('trim_c').value;

    if (startDateVal && termMonths) {
        var startDate = new Date(startDateVal);
        startDate.setMonth(startDate.getMonth() + parseInt(termMonths));

        // Format to YYYY-MM-DD for date input
        var yyyy = startDate.getFullYear();
        var mm   = String(startDate.getMonth() + 1).padStart(2, '0');
        var dd   = String(startDate.getDate()).padStart(2, '0');

        document.getElementById('end_date').value = yyyy + '-' + mm + '-' + dd;
    } else {
        document.getElementById('end_date').value = '';
    }
}
