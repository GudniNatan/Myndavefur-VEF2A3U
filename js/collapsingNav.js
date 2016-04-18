$(document).ready(function() {
	$("nav ul").toggleClass("hideList");
	$(".sammieCont").toggleClass("hidden");

	$(".sammieCont").click(function() {
		$("nav ul").toggleClass("hideList");
		$(".sammie").toggleClass('open');
		$(this).toggleClass("sammieContClick");
	});
});