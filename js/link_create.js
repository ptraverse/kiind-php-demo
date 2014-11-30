$(document).ready(function () {
	
	var client = new ZeroClipboard( document.getElementById("copy-button") );
	client.on( "ready", function( readyEvent ) {
	  client.on( "aftercopy", function( event ) {
	    $('#copied-message').css('display','block');
	  } );
	} );
		
	$('#copy-button').css('display','none');
	
	$('#create_link').click( function () {
		
		var link_id = $('#link_id').val();
		var user_id = $('#user_id').val();
		
		$.ajax({
			type: "GET",
			url: "/ajax/link_create.ajax.php",
			data: {
				link_id: link_id,
				user_id: user_id				
			},
			success: function(msg){
				console.log('success!');
				console.log(msg);
			},
			error: function(err){
				console.log("error!");
			}
		}).done(function(){
			console.log("done!");
		});	
		
		
		$('#copy-button').css('display','inline');
		$('#share-div').css('display','block');
	});
	
	$('[data-toggle="popover"]').popover({		
		trigger: 'hover',
        	'placement': 'bottom'
	});
	
});