jQuery(document).ready(function ($) {
	
	$('.sp-mostviewed').each(function() {
		var $element = $(this),
			$spmostviewed = $(".spmostviewed-slider", $element);
			
			var _interval = setInterval(function() {
			if(document.readyState === 'complete') {
				clearInterval(_interval);
					$(".sp-loading", $element).remove();
					$element.removeClass("sp-preload");
					_runScript();
				}    
			}, 100);
			function _runScript() {
				console.log($spmostviewed);
				$spmostviewed.owlCarousel({
					autoplay:($element.attr('data-autoplay') && $element.attr('data-autoplay') == 1) ? true : false,
					autoplayTimeout: ($element.attr('data-autoplay_timeout')) ? $element.attr('data-autoplay_timeout') : 2000,
					autoplaySpeed: ($element.attr('data-autoplaySpeed')) ? $element.attr('data-autoplaySpeed') : 500,
					smartSpeed: 500,
					autoplayHoverPause: ($element.attr('data-autoplayHoverPause') && $element.attr('data-autoplayHoverPause') == 1) ? true : false ,
					startPosition: ($element.attr('data-startPosition')) ? $element.attr('data-startPosition') : 1,
					mouseDrag: ($element.attr('data-mouseDrag') && $element.attr('data-mouseDrag') == 1) ? true : false ,
					touchDrag: ($element.attr('data-touchDrag') && $element.attr('data-touchDrag') == 1) ? true : false ,
					autoWidth: false,
					dotClass: "spmostviewed-dot",
					dotsClass: "spmostviewed-dots",
					themeClass: 'spmostviewed-theme',
					baseClass: 'spmostviewed-carousel',
					itemClass: 'spmostviewed-item',
					nav: ($element.attr('data-nav') && $element.attr('data-nav') == 1) ? true : false,
					loop: ($element.attr('data-loop') && $element.attr('data-loop') == 1) ? true : false,
					navText: ["Next", "Prev"],
					navClass: ["owl-prev", "owl-next"],
					responsive:{
						0:{
						  items: $element.attr('data-nb_column4')
						},
						480:{
						  items: $element.attr('data-nb_column3') 
						},	
						768:{
						  items: $element.attr('data-nb_column2')
						},	
						1200:{
						  items: $element.attr('data-nb_column1') 
						},												
					}
				});
			}
		});
	});					
