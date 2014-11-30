$(document).ready(function () {
	
	var counter_start = 3;
	var t = new Date();
	t.setSeconds(t.getSeconds() + 3);
	
	$('#counter').countdown(t).on('update.countdown', function(event) {
		$(this).html(event.strftime('<span>%-S</span>...'));
	}).on('finish.countdown', function(event) {
		//TODO Execute Redirect
		$(this).append(event.strftime('<br>FINISHED!'));
	});
	
});