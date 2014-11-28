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
			},
			gift_id: {
				required: true,
				min: 1
			},
			gift_amount: {
				required: true,
				number: true
			},
			clicks: {
				required: true,
				number: true,
				min: 1
			}
		},
		submitHandler: function(form) {		
			form.submit();
		}
	});
	
	$('#campaign_create_form').change(function () {
		var long_url = $('#long_url').val();
		var gift_amount = $('#gift_amount').val();
		var clicks = $('#clicks').val();
		$('[data-toggle="popover"]').attr('data-content','By clicking Create, you are authorizing a gift card of $'+gift_amount+' to be given out once '+clicks+' clicks to '+long_url+' have been achieved through quidprize.com.');
	});	
	
	
	$('[data-toggle="popover"]').popover({		
		trigger: 'hover',
        	'placement': 'bottom'
	});
	
});