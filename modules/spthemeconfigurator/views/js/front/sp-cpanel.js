 
$(document).ready(function(){
	 /* Begin: Show hide cpanel */  
	var ua = navigator.userAgent,
    event = (ua.match(/iPad/i)) ? "touchstart" : "click";
	widthC = $('#sp-cpanel').width()+40; 
	
	$("#sp-cpanel_btn").bind(event, function(event) {
		$(this).animate({left:"-50px"},function(){
			$("#sp-cpanel").animate({left:"0px"},400);
		  });
	});
	
	$(".sp-cpanel-close").bind(event, function(event) {
		$("#sp-cpanel").animate({left:-widthC},400,function(){
			$("#sp-cpanel_btn").animate({left:"0px"},850);
		 });
	});
	
	//Layout Box
	$('[name*="layoutStyle"]').on('change', function (){
		var $typelayout = $(this).val();
		addLayoutBox($typelayout);
	});
	
	//Pattern Box
	$('.img-pattern').on('click', function (){
		var $pattern = $(this).data('pattern');
		addPattern($pattern);
		
	});
});

function addPattern($pattern){
	$('body').stripClass('pattern').addClass('pattern'+$pattern);
}

function addLayoutBox($layoutbox){
	$('body').stripClass('layout-').addClass($layoutbox);
}

$.fn.stripClass = function (partialMatch, endOrBegin) {
	// <summary>
	// The way removeClass should have been implemented -- accepts a partialMatch (like "btn-") to search on and remove
	// </summary>
	var x = new RegExp((!endOrBegin ? "\\b" : "\\S+") + partialMatch + "\\S*", 'g');
	// http://stackoverflow.com/a/2644364/1037948
	this.attr('class', function (i, c) {
		if (!c) return;
		return c.replace(x, '');
	});
	return this;
};