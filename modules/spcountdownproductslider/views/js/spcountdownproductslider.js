jQuery(document).ready(function ($) {
	$( ".sp-countdownproductslider" ).each(function() {
		var $element = $(this),
			$countdownproductslider =  $('.spcountdownproductslider-slider' ,$element),
			_delay = $element.attr('data-delay'),
			_duration = $element.attr('data-duration'),
			_effect = $element.attr('data-effect');
			
			var _interval = setInterval(function() {
			if(document.readyState === 'complete') {
				clearInterval(_interval);
					$(".sp-loading", $element).remove();
					$element.removeClass("sp-preload");
					_runScript();
				}    
			}, 100);
			function _runScript () {
				$countdownproductslider.on("initialized.owl.carousel", function () {
					var $item_active = $(".spcountdownproductslider-item.active", $element);
					if ($item_active.length > 1 && _effect != "none") {
						_getAnimate($item_active);
					}
					else {
						var $item = $(".spcountdownproductslider-item", $element);
						$item.css("opacity", "1");
						$item.css("filter", "alpha(opacity = 100)");
					}
				});
				$countdownproductslider.owlCarousel({
					autoplay: ($element.attr('data-autoplay') && $element.attr('data-autoplay') == 1) ? true : false,
					autoplayTimeout: ($element.attr('data-autoplay_timeout')) ? $element.attr('data-autoplay_timeout') : 2000 ,
					autoplaySpeed: ($element.attr('data-autoplaySpeed')) ? $element.attr('data-autoplaySpeed') : 500,
					smartSpeed: 500,
					autoplayHoverPause: ($element.attr('data-autoplayHoverPause') &&  $element.attr('data-autoplayHoverPause') == 1) ? true : false,
					startPosition: ($element.attr('data-startPosition')) ? $element.attr('data-startPosition') : 1,
					mouseDrag: ($element.attr('data-mouseDrag') &&  $element.attr('data-mouseDrag') == 1) ? true : false,
					touchDrag: ($element.attr('data-touchDrag') &&  $element.attr('data-touchDrag') == 1) ? true : false,
					pullDrag: ($element.attr('data-pullDrag') &&  $element.attr('data-pullDrag') == 1) ? true : false,
					dots: ($element.attr('data-dots') &&  $element.attr('data-dots') == 1) ? true : false,
					autoWidth: false,
					dotClass: "spcountdownproductslider-dot",
					dotsClass: "spcountdownproductslider-dots",
					themeClass: 'spcountdownproductslider-theme',
					baseClass: 'spcountdownproductslider-carousel',
					itemClass: 'spcountdownproductslider-item',
					nav: ($element.attr('data-nav') &&  $element.attr('data-nav') == 1) ? true : false,
					loop: ($element.attr('data-loop') &&  $element.attr('data-loop') == 1) ? true : false,
					navText: ["&#139;", "&#155;"],
					navClass: ["owl-prev", "owl-next"],
					responsive:{
						0:{
						  items:$element.attr('data-nb_column4')// In this configuration 1 is enabled from 0px up to 479px screen size 
						},
						480:{
						  items:$element.attr('data-nb_column3') // In this configuration 1 is enabled from 0px up to 767px screen size 
						},	
						768:{
						  items:$element.attr('data-nb_column2') // In this configuration 1 is enabled from 0px up to 1199px screen size 
						},	
						1200:{
						  items:$element.attr('data-nb_column1') // In this configuration 1 is enabled from 0px up to 1200px screen size 
						},												
					}
				});

				$countdownproductslider.on("translate.owl.carousel", function (e) {
					var $item_active = $(".spcountdownproductslider-item.active", $element);
					_UngetAnimate($item_active);
					_getAnimate($item_active);
				});

				$countdownproductslider.on("translated.owl.carousel", function (e) {
					var $item_active = $(".spcountdownproductslider-item.active", $element);
					var $item = $(".spcountdownproductslider-item", $element);
					
					_UngetAnimate($item);

					if ($item_active.length > 1 && _effect != "none") {
						_getAnimate($item_active);
					} else {
						$item.css("opacity", "1");
						$item.css("filter", "alpha(opacity = 100)");
					}
				});

				function _getAnimate($el) {
					if (_effect == "none") return;
					//if ($.browser.msie && parseInt($.browser.version, 10) <= 9) return;
					$countdownproductslider.removeClass("extra-animate");
					$el.each(function (i) {
						var $_el = $(this);
						$(this).css({
							"-webkit-animation": _effect + " " + _duration + "ms ease both",
							"-moz-animation": _effect + " " + _duration + "ms ease both",
							"-o-animation": _effect + " " + _duration + "ms ease both",
							"animation": _effect + " " + _duration + "ms ease both",
							"-webkit-animation-delay": +i * _delay + "ms",
							"-moz-animation-delay": +i * _delay + "ms",
							"-o-animation-delay": +i * _delay + "ms",
							"animation-delay": +i * _delay + "ms",
							"opacity": 1
						}).animate({
							opacity: 1
						});

						if (i == $el.size() - 1) {
							$countdownproductslider.addClass("extra-animate");
						}
					});
				}

				function _UngetAnimate($el) {
					$el.each(function (i) {
						$(this).css({
							"animation": "",
							"-webkit-animation": "",
							"-moz-animation": "",
							"-o-animation": "",
							"opacity": 0
						});
					});
				}
				
			  
				
				
				function CountDown(date, elem) {
					var dateNow = new Date(),
						amount = date.getTime() - dateNow.getTime(),
						lb_day = elem.attr('data-day'),
						lb_days = elem.attr('data-days'),
						lb_hour = elem.attr('data-hour'),
						lb_hours = elem.attr('data-hours'),
						lb_min = elem.attr('data-min'),
						lb_mins = elem.attr('data-mins'),
						lb_sec = elem.attr('data-sec'),
						lb_secs = elem.attr('data-secs');
					if (amount < 0 && $("#" + id).length) {
						elem.html("Now!");
					} else {
						days = 0;
						hours = 0;
						mins = 0;
						secs = 0;
						out = "";
						amount = Math.floor(amount / 1000);
						days = Math.floor(amount / 86400);
						amount = amount % 86400;
						hours = Math.floor(amount / 3600);
						amount = amount % 3600;
						mins = Math.floor(amount / 60);
						amount = amount % 60;
						secs = Math.floor(amount);
						if (days != 0) {
							out += "<div class='time-item time-day'>" + "<div class='num-time'>" + days + "</div>" + "<div class='name-time'>" + ((days == 1) ? lb_day : lb_days )+ "</div>" + "</div> ";
						}
						if (hours != 0) {
							out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + "<div class='name-time'>" + ((hours == 1) ? lb_hour : lb_hours) + "</div>" + "</div>";
						}
						out += "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + "<div class='name-time'>" + ((mins == 1) ? lb_min : lb_mins )+ "</div>" + "</div>";
						out += "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + "<div class='name-time'>" + ((secs == 1) ? lb_sec : lb_secs) + "</div>" + "</div>";
						out = out.substr(0, out.length - 2);
						elem.html(out);

						setTimeout(function () {
							CountDown(date, elem);
						}, 1000);
					}
				}

				if ($('.spcountdownproductslider-time .item-timer').length ) {
					$('.spcountdownproductslider-time .item-timer').each(function(){
						var _data_timer = $(this).attr('data-timer');
						var data = new Date(_data_timer);
							CountDown(data, $(this));
					});
				}	
			}		
	});
});	

 