jQuery.noConflict();

jQuery(function(){
	jQuery(".blink-title").typed({
		strings: ["Learn Javascript.", "Learn HTML.", "Learn CSS.", "Learn AngularJS."],
		typeSpeed: 0
  	});
	
	jQuery("#colorval").keyup(function(){
		var cval = jQuery("#colorval").val();
		jQuery("#example").css("color", cval);
	});
});