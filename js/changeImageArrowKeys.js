$(document).keydown(function(e) {
	switch(e.which) {
		case 37: // left
			if ( $( ".prevImg" ).length ) {
				document.location = $(".prevImg").attr('href');
			}
			//previous image
		break;

		case 39: // right
			if ( $( ".nextImg" ).length ) {
				document.location = $(".nextImg").attr('href');
			}
			//next image
		break;

		default: return; // exit this handler for other keys
	}
	e.preventDefault(); // prevent the default action (scroll / move caret)
});

//Convert to emoji
$(document).ready(function() {
	$(".convert-emoji").each(function() {
		var original = $(this).html();
		// use .shortnameToImage if only converting shortnames (for slightly better performance)
		var converted = emojione.toImage(original);
		$(this).html(converted);
	});
});