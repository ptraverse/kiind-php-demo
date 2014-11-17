
$(document).ready(function () {
	
	jQuery.validator.setDefaults({
		debug: true,
		success: "valid"
	});
	
	$("#new_user_form").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 4
			},
			confirm_password: {
				required: true,
				equalTo: "#password"
			}
		}		
	});
	
	$("#register").click(function() {
		if ($("#new_user_form").valid()) {
			var e = $("#email").val();
			var p = $("#password").val();			
			console.log('ValidClicked');
			$('#loading_gif').css('display','inline');
			$.ajax({
				url: "register_ajax.php?e="+e+"&p="+p,			
				type: "GET",							
				success: function(data){						
					var json = JSON.parse(data);					
					$("#new_user_info").html("");	
					if (json.error>'') {
						$("#new_user_info").html('');							
						$("#new_user_info").append(json.error);							
						$("#new_user_info").css("border","2px solid red");
					}
					else {					
						$("#new_user_info").html('');	
						$("#new_user_info").append(json.message);
						var border_color = "2px solid "+json.color;
						$("#new_user_info").css("border",border_color);										
					}					
					$("#loading_gif").css("display","none");
				},
				error: function(err){
					console.log(err);
					alert("error!");										
				}			
			});
		}
		else {
			console.log('invalidClicked');
		}		
		return false;
	});
	
	
});