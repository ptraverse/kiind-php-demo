
$(document).ready(function () {
	
	jQuery.validator.setDefaults({
		debug: true,
		success: "valid"
	});
	
	$("#login_form").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 4
			}			
		}		
	});
	
	$("#login_btn").click(function() {
		if ($("#login_form").valid()) {
			var e = $("#email").val();
			var p = $("#password").val();						
			$('#loading_gif').css('display','inline');
			$.ajax({
				url: "login_ajax.php?e="+e+"&p="+p,			
				type: "GET",							
				success: function(data){						
					var json = JSON.parse(data);					
					$("#login_info").html("");	
					if (json.error>'') {
						$("#login_info").html('');							
						$("#login_info").append(json.error);							
						$("#login_info").css("border","2px solid red");
					}
					else {						
						if (json.color=="green") {
							window.location.replace("/");
						} else {
							$("#login_info").html('');	
							$("#login_info").append(json.message);
							var border_color = "2px solid "+json.color;
							$("#login_info").css("border",border_color);
						}
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