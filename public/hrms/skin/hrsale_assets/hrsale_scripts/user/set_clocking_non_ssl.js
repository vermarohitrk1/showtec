$(document).ready(function(){
	var lat = "";
    var lng = "";
    var accuracy = "";
	var locationFound = false;
	var gps_support = false;
	var gps_status = false;

    if(navigator.geolocation){
		gps_support = true;
		
        navigator.geolocation.getCurrentPosition(function positionSuccess(loc){
            lat = loc.coords.latitude;
            lng = loc.coords.longitude;
            accuracy = loc.coords.accuracy;
			locationFound = true;
			gps_status = true;               
        }, function(error) {
			toastr.error('Geolocation is required for clock in and clock out');
		});
    }else{
        locationFound = true;
    }

	/* Clock In/Out */
	$("#set_clocking").submit(function(e){
		e.preventDefault();
		
		if(gps_support && !gps_status) {
			toastr.error('Geolocation is required for clock in and clock out. Turn on GPS');
			return;	
		}

		var clock_state = '';
		var obj = $(this), action = obj.attr('name');
		if(lat == '' && lng == '') {
			lat = 1;
			lng = 1;
		}

		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=set_clocking&latitude="+lat+"&longitude="+lng+"&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					toastr.success(JSON.result);
					window.location = '';
				}
			}
		});
	});

});