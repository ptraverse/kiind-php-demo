$(document).ready(function () {
	
	var client = new ZeroClipboard( document.getElementById("copy-button") );
	client.on( "ready", function( readyEvent ) {
	  client.on( "aftercopy", function( event ) {
	    $('#copied-message').css('display','block');
	  } );
	} );
		
	$('#copy-button').css('display','none');
	
	$('#create_link').click( function () {
		$('#copy-button').css('display','inline');
		$('#share-div').css('display','block');
	});
	
	$('[data-toggle="popover"]').popover({		
		trigger: 'hover',
        	'placement': 'bottom'
	});
});