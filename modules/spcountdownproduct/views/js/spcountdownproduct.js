/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

jQuery(document).ready(function ($) {
	$( ".sp-countdown-sliders" ).each(function() {
						var $element = $(this);
						var sync1 = $(".pds-items-detail",$element),
							sync2 = $(".pds-items",$element);
							pds_items = $(".pds-items",$element);
						sync1.slick({
							autoplay: ($element.data("autoplay") && $element.data("autoplay") == 1 ) ? true : false,
							slidesToShow: 1,
							slidesToScroll: 1,
							arrows: false,
							fade: true,
							swipe : ($element.data("touchdrag") && $element.data("touchdrag") == 1 ) ? true : false,
							draggable : ($element.data("mousedrag") && $element.data("mousedrag") == 1 ) ? true : false,
							initialSlide: $element.data("startposition"),
							asNavFor: pds_items,
						});
						sync2.slick({
							autoplay: ($element.data("autoplay") && $element.data("autoplay") == 1 ) ? true : false,
							slidesToShow: $element.data("nb_column1"),
							slidesToScroll: $element.data("slideby"),
							infinite: ($element.data("loop") && $element.data("loop") == 1 ) ? true : false,
							initialSlide: $element.data("startposition"),
							speed: $element.data("speed"),
							autoplaySpeed: $element.data("autoplayspeed"),
							asNavFor: sync1,
							pauseOnHover: ($element.data("autoplayhoverpause") && $element.data("autoplayhoverpause") == 1 ) ? true : false,
							focusOnSelect: true,
							vertical : true,
							arrows: ($element.data("nav") && $element.data("nav") == 1 ) ? true : false,
							pdsIdSliders: $element,
							swipe :  ($element.data("touchdrag") && $element.data("touchdrag") == 1 ) ? true : false,
							draggable : ($element.data("mousedrag") && $element.data("mousedrag") == 1 ) ? true : false,
							responsive: [
								{
									breakpoint: 1199,
									settings: {
										slidesToShow: $element.data("nb_column2"),
										slidesToScroll: $element.data("slideby"),
										infinite: true,
										dots: ($element.data("dots") && $element.data("dots") == 1 ) ? true : false
									}
								},
								{
									breakpoint: 991,
									settings: {
										slidesToShow: $element.data("nb_column2"),
										slidesToScroll: $element.data("slideby"),
										infinite: true,
										dots: ($element.data("dots") && $element.data("dots") == 1 ) ? true : false,
										vertical : true,
									}
								},
								{
									breakpoint: 767,
									settings: {
										slidesToShow: $element.data("nb_column2"),
										slidesToScroll: $element.data("slideby"),
										infinite: true,
										dots: ($element.data("dots") && $element.data("dots") == 1 ) ? true : false	,
										vertical : false,	
									}
								},
								{
									breakpoint: 479,
									settings: {
										slidesToShow: $element.data("nb_column2"),
										slidesToScroll: $element.data("slideby"),
										infinite: true,
										dots: ($element.data("dots") && $element.data("dots") == 1 ) ? true : false	,
										vertical : false,	
									}
								},
								{
									breakpoint: 320,
									settings: {
										slidesToShow: $element.data("nb_column2"),
										slidesToScroll: $element.data("slideby"),
										infinite: true,
										dots: ($element.data("dots") && $element.data("dots") == 1 ) ? true : false	,
										vertical : false,	
									}
								}
							]
						});
						
						data = new Date(2013, 10, 26, 12, 00, 00);
						function CountDown(date, id) {
							dateNow = new Date();
							amount = date.getTime() - dateNow.getTime();
							if (amount < 0 && $("#" + id).length) {
								$("." + id).html("Now!");
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
									out += "<div class='time-item time-day'>" + "<div class='num-time'>" + days + "</div>" + "<div class='name-time'>" + ((days == 1) ? "Day" : "Days") + "</div>" + "</div> ";
								}
								if (hours != 0) {
									out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + "<div class='name-time'>" + ((hours == 1) ? "Hour" : "Hours") + "</div>" + "</div>";
								}
								out += "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + "<div class='name-time'>" + ((mins == 1) ? "Min" : "Mins") + "</div>" + "</div>";
								out += "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + "<div class='name-time'>" + ((secs == 1) ? "Sec" : "Secs") + "</div>" + "</div>";
								out = out.substr(0, out.length - 2);
								$("." + id).html(out);

								setTimeout(function () {
									CountDown(date, id);
								}, 1000);
							}
						}

						if (listcountdown.length > 0) {
							for (var i = 0; i < listcountdown.length; i++) {
								var arr = listcountdown[i].split("|");
								if (arr[1].length) {
									var data = new Date(arr[1]);
									CountDown(data, arr[0]);
								}
							}
						}	
	});
});
