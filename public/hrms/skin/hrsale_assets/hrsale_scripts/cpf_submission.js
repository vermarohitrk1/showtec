$(document).ready(function() {

    // Month & Year
    $('.month_year').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat:'yy-mm',
        yearRange: '1970:' + new Date().getFullYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").addClass('hide-calendar');
        },
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
            $(this).datepicker('widget').removeClass('hide-calendar');
            $(this).datepicker('widget').hide();
        }
    });
    
    var cpf_table = $('#cpf_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+"/cpf_submission_list/",
            type : 'GET'
        },
        "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();          
        }
    });

    $("#cpf_submission_form").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=cpf_submission&type=cpf_submission&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
                    $('.save').prop('disabled', false);
				} else {
					//toastr.clear();
					$('#hrload-img').hide();
					// toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
                    $('.save').prop('disabled', false);
                    cpf_table.api().ajax.reload(function(){ 
                        //toastr.clear();
                        //$('#hrload-img').hide();
                        toastr.success(JSON.result);
                        $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                    }, true);
                    $('.add-form').removeClass('in');
				}
			},
			error: function (eData) {
				console.log(eData);
			}
		});
	});

});