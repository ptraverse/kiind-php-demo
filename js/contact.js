$(document).ready(function () {
	
	$("#contact_form").validate({
		rules: {
			email: {
				required: true,	
				email: true
			},
			contact_message: {
				required: true
			}
		},
		submitHandler: function(form) {
			
			var email = $('#email').val();
			var contact_message = $('#contact_message').val();
			
			$.ajax({
				type: "GET",
				url: "/ajax/contact.ajax.php",
				data: {
					email: email,
					contact_message: contact_message
				},
				success: function(msg){
					console.log('email sent!');
					$('#send').attr('disabled','disabled');
					$('#response').html(msg);
					$('#response').addClass("alert");
					$('#response').addClass("alert-black");
					$('#response').attr("role","alert");					
				},
				error: function(err){
					console.log("error!");
				}
			}).done(function(){
				console.log("done!");
			});
			 
			return false; //to prevent browser submit
		}
	});
	
});