$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

    $(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('constant');
		var profile_block = $(this).data('constant-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#constant_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
	
	$('#annual_value_field').hide();
	$('#furnished_field').hide();
	$('#rent_paid_field').hide();
	$('#accommodation_type').on('change', function() {
		var act = this.value;
		if(act == 'owned') {
			$('#annual_value_field').show();
			$('#furnished_field').show();
			$('#rent_paid_field').hide();
		}else if(act == 'rented') {
			$('#annual_value_field').hide();
			$('#furnished_field').hide();
			$('#rent_paid_field').show();
		}else {
			$('#annual_value_field').hide();
			$('#furnished_field').hide();
			$('#rent_paid_field').hide();
		}
	});

	$('.cont_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '-6:' + (new Date().getFullYear() + 1),
	});

	var xin_table_accommodation = $('#xin_table_accommodation').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getaccommodation/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	var xin_table_employee_accommodation = $('#xin_table_employee_accommodation').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getemployeeaccommodation/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	
	var xin_table_utility = $('#xin_table_utility').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getemployeeutility/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	var xin_table_driver = $('#xin_table_driver').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getemployeedriver/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	var xin_table_housekeeping = $('#xin_table_housekeeping').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getemployeehousekeeping/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	var xin_table_hotel_accommodation = $('#xin_table_hotel_accommodation').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getEmployeeHotelAccommodation/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	var xin_table_other_benefit = $('#xin_table_other_benefit').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employeebenefits/getEmployeeOtherBenefits/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('#accommodation_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=accommodation_form&type=accommodation_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_accommodation.api().ajax.reload(function(){ 
						//toastr.clear();
						//$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#accommodation_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	jQuery(".aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('.employee_ajax').html(data);
		});
	});

	jQuery("#aj_accommodation").change(function(){
		jQuery.get(base_url+"/get_accommodation/"+jQuery(this).val(), function(data, status) {
			if(data.result != '') {
				var address = data.result.address_line_1 + ' ' + data.result.address_line_2;
				
				const date_from = new Date(data.result.period_from);
				const df_ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date_from);
				const df_mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(date_from);
				const df_da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date_from);
				
				
				const date_to = new Date(data.result.period_to);
				const dt_ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date_to);
				const dt_mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(date_to);
				const dt_da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date_to);
				
				jQuery('#address').val(address);
				jQuery('#accommodation_period').val(`${df_da} ${df_mo} ${df_ye}` + ' - ' + `${dt_da} ${dt_mo} ${dt_ye}`);
			}
			
		});
	});

	$('#accommodation_employee_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=accommodation_employee_form&type=accommodation_employee_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_employee_accommodation.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#accommodation_employee_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	//Add new options
    $('#utilityCont').on('click', '.utAddbtn', function() {
        var optDiv = $('#utilityDiv'),
            utlContainer = $('#utilityCont'),
            childLength = utlContainer.children().length;
		// console.log(promFmContainer.children().length);
		
		utlContainer.find('[data-plugin="select_hrm"]').select2('destroy');
		var optDivClone = optDiv.clone();
		optDivClone.attr('id', 'utilityDiv'+childLength);
		optDivClone.removeClass('mt-3');
        optDivClone.find('.utAdd .utAddbtn').remove();
        optDivClone.find("input[type='text']").val("");
        //promFmClone.find('.pFmAdd').attr('class', '.pFmAdd_'+childLength);
        optDivClone.find('.utAdd .form-group').append('<button class="btn icon-btn btn-xs waves-effect waves-light btn-danger opDel" id="opDel_'+childLength+'">Delete <span class="fa fa-minus"></span></a>');
		utlContainer.append(optDivClone);
		utlContainer.find('[data-plugin="select_hrm"]').select2();
        return false;
    });

    //Remove options
    $('#utilityCont').on('click', '.opDel', function() {
        var DelId = $(this).attr('id').replace('opDel_', '');
        $(this).parents('#utilityDiv'+DelId).remove();
        //console.log('#pFm_'+DelId);
        return false;
	});
	
	$('#benefit_utilities_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=benefit_utilities_form&type=benefit_utilities_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_utility.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#benefit_utilities_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	$('#benefit_driver_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=benefit_driver_form&type=benefit_driver_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_driver.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#benefit_driver_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	//Add new options
    $('#houseKeepingCont').on('click', '.utAddbtn', function() {
        var optDiv = $('#housekeepingDiv'),
            utlContainer = $('#houseKeepingCont'),
            childLength = utlContainer.children().length;
		// console.log(promFmContainer.children().length);
		
		utlContainer.find('[data-plugin="select_hrm"]').select2('destroy');
		var optDivClone = optDiv.clone();
		optDivClone.attr('id', 'housekeepingDiv'+childLength);
		optDivClone.removeClass('mt-3');
        optDivClone.find('.utAdd .utAddbtn').remove();
        optDivClone.find("input[type='text']").val("");
        //promFmClone.find('.pFmAdd').attr('class', '.pFmAdd_'+childLength);
        optDivClone.find('.utAdd .form-group').append('<button class="btn icon-btn btn-xs waves-effect waves-light btn-danger opDel" id="opDel_'+childLength+'">Delete <span class="fa fa-minus"></span></a>');
		utlContainer.append(optDivClone);
		utlContainer.find('[data-plugin="select_hrm"]').select2();
        return false;
    });

    //Remove options
    $('#houseKeepingCont').on('click', '.opDel', function() {
        var DelId = $(this).attr('id').replace('opDel_', '');
        $(this).parents('#housekeepingDiv'+DelId).remove();
        //console.log('#pFm_'+DelId);
        return false;
	});

	$('#benefit_housekeeping_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=benefit_housekeeping_form&type=benefit_housekeeping_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_housekeeping.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#benefit_housekeeping_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	$('#benefit_hotel_accommodation_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=benefit_hotel_accommodation_form&type=benefit_hotel_accommodation_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_hotel_accommodation.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#benefit_hotel_accommodation_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

	//Add new options
    $('#otherBenefitCont').on('click', '.utAddbtn', function() {
        var optDiv = $('#otherBenefitDiv'),
            utlContainer = $('#otherBenefitCont'),
            childLength = utlContainer.children().length;
		// console.log(promFmContainer.children().length);
		
		utlContainer.find('[data-plugin="select_hrm"]').select2('destroy');
		var optDivClone = optDiv.clone();
		optDivClone.attr('id', 'otherBenefitDiv'+childLength);
		optDivClone.removeClass('mt-3');
        optDivClone.find('.utAdd .utAddbtn').remove();
        optDivClone.find("input[type='text']").val("");
        //promFmClone.find('.pFmAdd').attr('class', '.pFmAdd_'+childLength);
        optDivClone.find('.utAdd .form-group').append('<button class="btn icon-btn btn-xs waves-effect waves-light btn-danger opDel" id="opDel_'+childLength+'">Delete <span class="fa fa-minus"></span></a>');
		utlContainer.append(optDivClone);
		utlContainer.find('[data-plugin="select_hrm"]').select2();
        return false;
    });

    //Remove options
    $('#otherBenefitCont').on('click', '.opDel', function() {
        var DelId = $(this).attr('id').replace('opDel_', '');
        $(this).parents('#otherBenefitDiv'+DelId).remove();
        //console.log('#pFm_'+DelId);
        return false;
	});

	$('#other_benefit_form').submit(function(e) {
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), 
			action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		// console.log(obj);
		$('#hrload-img').show();
		toastr.info(processing_request);

		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=other_benefit_form&type=other_benefit_form&form="+action,
			cache: false,
			success: function (JSON) {
				console.log(JSON);
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_other_benefit.api().ajax.reload(function(){ 
						//toastr.clear();
						$('#hrload-img').hide();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#other_benefit_form')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			},
			error: function(eData) {
				console.log(eData);
			}
		});
	});

});