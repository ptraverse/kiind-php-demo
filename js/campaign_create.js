$(document).ready(function () {
	
	jQuery.validator.setDefaults({
		debug: true,
		success: "valid"
	});
	
	$("#campaign_create_form").validate({
		rules: {
			short_name: {
				required: true				
			},
			long_url: {
				required: true,
				url: true
			}
		},
		submitHandler: function(form) {		
			form.submit();
		}
	});
	
});