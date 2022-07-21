$(document).ready(function(){
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

	$("#efiling_details").submit(function(e){
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
			data: obj.serialize()+"&is_ajax=3&data=efiling_details&type=efiling_details&form="+action,
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
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			},
			error: function (eData) {
				console.log(eData);
			}
		});
	});
	
});