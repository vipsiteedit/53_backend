$(document).ready(function() {
	$('body').on('click', '.buttonSend[name="GoTo1"]', function() {
		yaCounter43258594.reachGoal('contact');
		return true;
	});

	$('body').on('click', '.buttonSend.addcart', function() {
		yaCounter43258594.reachGoal('kupit');
		return true;
	});

	$('body').on('click', '.buttonSend[name="place_order"]', function() {
		yaCounter43258594.reachGoal('order');
		return true;
	});
});