
$(function () {
    $("#invoice_date").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $("#due_date").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $(".btn-collapse").click(function(e) {
        $('#tuition_fee').val(0);
        $('#sub_total').val(0);
        $('#commission_amount').val(0);
        $('#tuition_fee_gst').val(0);
        $('#commission_percent').val(0);
        reset_value();
        e.preventDefault();
        var $this = $(this);
        var parentHead = $this.parent();
        parentHead.parent().find(".panel-body").slideToggle( "slow", function() {
            parentHead.toggleClass('collapsed');
            if(!parentHead.hasClass('collapsed')){


                $this.html('<i class="fa fa-minus-circle"></i> Remove');


            }
            else
                $this.html('<i class="fa fa-plus-circle"></i> Add');
        });
    });

    $(".btn-collapse-incentive").click(function(e) {
        $('#incentive').val(0);
        $('#incentive_gst').val(0);
        reset_value();
        e.preventDefault();
        var $this = $(this);
        var parentHead = $this.parent();
        parentHead.parent().find(".panel-body").slideToggle( "slow", function() {
            parentHead.toggleClass('collapsed');
            if(!parentHead.hasClass('collapsed'))
            {

                $this.html('<i class="fa fa-minus-circle"></i> Remove');

            }
            else
                $this.html('<i class="fa fa-plus-circle"></i> Add');
        });
    });

    var total_commission=0;
    var total_gst=0;

    $('#tuition_fee, #enrollment_fee, #material_fee, #coe_fee, #other_fee').keyup(function() {
        var tuitionFee = parseFloat($('#tuition_fee').val());
        var enrollmentFee = parseFloat($('#enrollment_fee').val());
        var materialFee = parseFloat($('#material_fee').val());
        var coeFee = parseFloat($('#coe_fee').val());
        var otherFee = parseFloat($('#other_fee').val());
        var subTotal = parseFloat(tuitionFee + enrollmentFee + materialFee + coeFee + otherFee);
        $('#sub_total').val(subTotal);
        reset_value();
    });

    $('#commission_percent, #subTotal,#commissionAmount,#incentive').keyup(function() {
        reset_value();
    });

    $('#gst_checker_incentive').click(function(){
        if($(this).is(":checked")) // "this" refers to the element that fired the event
        {
            $('#incentive_gst').val(parseFloat($('#incentive').val()/10));
        }
        else
        {
            $('#incentive_gst').val(0);

        }
        gst_change();

    });

    $('#gst_checker_tuition_fee').click(function(){
        if($(this).is(":checked")) // "this" refers to the element that fired the event
        {

            $('#tuition_fee_gst').val(parseFloat($('#commission_amount').val()/10));
        }
        else
        {
            $('#tuition_fee_gst').val(0);

        }
        gst_change();
    });


    function gst_change(){
        var commissionPercent = parseFloat($('#commission_percent').val());
        var tuition_fee = parseFloat($('#tuition_fee').val());
        var commissionAmount = parseFloat(commissionPercent / 100 * tuition_fee);
        var tuition_fee_gst=parseFloat($('#tuition_fee_gst').val());

        var incentive = parseFloat($('#incentive').val());
        var incentive_gst = parseFloat($('#incentive_gst').val()); //10% of commission amount

        total_commission=commissionAmount+incentive;
        total_gst=tuition_fee_gst+incentive_gst;
        final_total=total_commission+total_gst;
        payable_to_college=$('#sub_total').val()-final_total;
        $('#total_commission').val(total_commission.toFixed(2));
        $('#total_gst').val(total_gst.toFixed(2));
        $('#final_total').val(final_total.toFixed(2));
        $('#payable_to_college').val(payable_to_college.toFixed(2));
    }

    function reset_value(){
        var commissionPercent = parseFloat($('#commission_percent').val());
        var tuition_fee = parseFloat($('#tuition_fee').val());
        var commissionAmount = parseFloat(commissionPercent / 100 * tuition_fee);
        $('#commission_amount').val(commissionAmount.toFixed(2));

        if($('#gst_checker_tuition_fee').is(":checked")) // "this" refers to the element that fired the event
        {
            var tuition_fee_gst=commissionAmount/10;

        }
        else
        {
            tuition_fee_gst=0;

        }
        $('#tuition_fee_gst').val(tuition_fee_gst.toFixed(2));


        var incentive = parseFloat($('#incentive').val());

        if($('#gst_checker_incentive').is(":checked")) // "this" refers to the element that fired the event
        {
            var incentive_gst = incentive /10; //10% of commission amount

        }
        else
        {
            var incentive_gst=0;
        }
        $('#incentive_gst').val(incentive_gst.toFixed(2));

        total_commission=commissionAmount+incentive;
        total_gst=tuition_fee_gst+incentive_gst;
        final_total=total_commission+total_gst;
        payable_to_college=$('#sub_total').val()-final_total;
        $('#total_commission').val(total_commission.toFixed(2));
        $('#total_gst').val(total_gst.toFixed(2));
        $('#final_total').val(final_total.toFixed(2));
        $('#payable_to_college').val(payable_to_college.toFixed(2));
    }
});