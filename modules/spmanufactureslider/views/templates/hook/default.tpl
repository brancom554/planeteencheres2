{*
 * package   SP Manufacture Slider
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}

<!-- SP Manufacture Slider -->
{if isset($list) && !empty($list)}
    {foreach from=$list item=items}
        {assign var="moduleclass_sfx" value=( isset( $items->params.moduleclass_sfx ) ) ?  $items->params.moduleclass_sfx : ''}
        <div class="moduletable  {$moduleclass_sfx|escape:'html':'UTF-8'}">
            {if $items->params.display_title_module}
                <h3 class="module-tilte">
                    {$items->title_module[$id_lang]|escape:'html':'UTF-8'}
                </h3>
            {/if}
            {assign var="params" value=$items->params}

            {$_list = $items->products}
            {if isset($_list) && $_list}


                {math equation='rand()' assign='rand'}
                {assign var='randid' value="now"|strtotime|cat:$rand}
                {assign var="tag_id" value="sp_manu_slider_{$items->id_spmanufactureslider}_{$randid}"}
                <div id="{$tag_id|escape:'html':'UTF-8'}" class="sp-manu-slider sp-preload">
                    <div class="sp-loading"></div>

					<div id="spmanufactureslider-{$items->id_spmanufactureslider}" class="spmanufactureslider">
						{foreach from=$_list item=manufacturer name=manufacturer_lists}

							{assign var="myfile" value="img/m/{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}.jpg"}
							{if file_exists($myfile)}
								{if $params.manu_image_size == 'none'}
									{assign var="src" value="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}.jpg"}
								{else}
									{assign var="src" value="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}-{$params.manu_image_size}.jpg"}
								{/if}
								<div class="item">
									<div class="item-wrap">
										{if $smarty.foreach.manufacturer_lists.iteration <= 20}
											<div class="item-img item-height">
												<div class="item-img-info">
													<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" {$manufacturer._target}
													   title="{$manufacturer.name|escape:'html':'UTF-8'}">
														<img src="{$src|escape:'html':'UTF-8'}"
															 class="logo_manufacturer"
															 title="{$manufacturer.name|escape:'html':'UTF-8'}"
															 alt="{$manufacturer.name|escape:'html':'UTF-8'}"/>
													</a>
												</div>
											</div>
										{/if}
									</div>
								</div>
							{/if}
						{/foreach}
					</div>
                </div>

                <script type="text/javascript">
                    //<![CDATA[
                    jQuery(document).ready(function ($) {
                        ;
                        (function (element) {
                            var $element = $(element);
                            var _timer = 0;
                            $(window).load(function () {
                                if (_timer) clearTimeout(_timer);
                                _timer = setTimeout(function () {
                                    $element.removeClass("sp-preload");
                                    $(".sp-loading", $element).remove();
                                }, 1000);
                            });

							$manufacturer = $("#spmanufactureslider-{$items->id_spmanufactureslider}", $element),
							_delay = '{$items->params.delay|escape:"html":"UTF-8"}',
							_duration = '{$items->params.duration|escape:"html":"UTF-8"}',
							_effect = '{$items->params.effect|escape:"html":"UTF-8"}';	

							$manufacturer.on("initialized.owl.carousel", function () {
								var $item_active = $(".spmanufactureslider-item.active", $element);
								if ($item_active.length > 1 && _effect != "none") {
									_getAnimate($item_active);
								}
								else {
									var $item = $(".spmanufactureslider-item", $element);
									$item.css("opacity", "1");
									$item.css("filter", "alpha(opacity = 100)");
								}
							});

							$manufacturer.owlCarousel({
								autoplay: {(isset($items->params.autoplay) && $items->params.autoplay ==1) ? 'true' : 'false' },
								autoplayTimeout: {$items->params.autoplay_timeout|escape:"html":"UTF-8"},
								autoplaySpeed: {$items->params.autoplaySpeed|escape:"html":"UTF-8"},
								smartSpeed: 500,
								autoplayHoverPause: {(isset($items->params.autoplayHoverPause) && $items->params.autoplayHoverPause ==1) ? 'true' : 'false' },
								startPosition: {$items->params.startPosition|escape:"html":"UTF-8"},
								mouseDrag: {(isset($items->params.mouseDrag) && $items->params.mouseDrag ==1) ? 'true' : 'false' },
								touchDrag: {(isset($items->params.touchDrag) && $items->params.touchDrag ==1) ? 'true' : 'false' },
								pullDrag: {(isset($items->params.pullDrag) && $items->params.pullDrag ==1) ? 'true' : 'false' },
								dots: {$items->params.dots|escape:"html":"UTF-8"},
								autoWidth: false,
								//dotClass: "spmanufactureslider-dot",
								//dotsClass: "spmanufactureslider-dots",
								//themeClass: 'spmanufactureslider-theme',
								//baseClass: 'spmanufactureslider-carousel',
								//itemClass: 'spmanufactureslider-item',
								nav: {(isset($items->params.nav) && $items->params.nav ==1) ? 'true' : 'false' },
								loop: {(isset($items->params.loop) && $items->params.loop ==1) ? 'true' : 'false' },
								navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
								navClass: ["owl-prev", "owl-next"],
								responsive:{
									0:{
									  items:{$items->params.nb_column4} // In this configuration 1 is enabled from 0px up to 479px screen size 
									},
									480:{
									  items:{$items->params.nb_column3} // In this configuration 1 is enabled from 0px up to 767px screen size 
									},	
									768:{
									  items:{$items->params.nb_column2} // In this configuration 1 is enabled from 0px up to 1199px screen size 
									},	
									1200:{
									  items:{$items->params.nb_column1} // In this configuration 1 is enabled from 0px up to 1200px screen size 
									},												
								}
							});

						$manufacturer.on("translate.owl.carousel", function (e) {
							var $item_active = $(".spmanufactureslider-item.active", $element);
							_UngetAnimate($item_active);
							_getAnimate($item_active);
						});

						$manufacturer.on("translated.owl.carousel", function (e) {
							var $item_active = $(".spmanufactureslider-item.active", $element);
							var $item = $(".spmanufactureslider-item", $element);
							
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
							$manufacturer.removeClass("extra-animate");
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
									$manufacturer.addClass("extra-animate");
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

                        })("#{$tag_id|escape:'html':'UTF-8'}")

                    });
                    //]]>
                </script>
            {else}
                {l s='Has no content to show!' mod='spmanufactureslider'}
            {/if}

        </div>
    {/foreach}
{/if}
<!-- /SP Slider -->