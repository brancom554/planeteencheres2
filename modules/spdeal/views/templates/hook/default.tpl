{*
 * @package SP Deal
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}

<!-- SP Slider -->
{if isset($list) && !empty($list)}
    {foreach from=$list item=items}
        {assign var="moduleclass_sfx" value=( isset( $items->params.moduleclass_sfx ) ) ?  $items->params.moduleclass_sfx : ''}
        {assign var="class_hook" value=($items->params.hook == 'displayTop')?' displayTop':''}
        <div class="moduletable {$moduleclass_sfx|escape:'html':'UTF-8'} {$class_hook|escape:'html':'UTF-8'}">
            {if isset($items->title_module[$id_lang]) && $items->params.display_title_module}
                <h3 class="module-tilte">
                    {$items->title_module[$id_lang]|escape:'html':'UTF-8'}
                </h3>
            {/if}
            {$_list = $items->products}
            {if isset($_list) && $_list}
                {math equation='rand()' assign='rand'}
                {assign var='randid' value="now"|strtotime|cat:$rand}
                {assign var="tag_id" value="sp_deal_{$items->id_spdeal}_{$randid}"}
                <div id="{$tag_id|escape:'html':'UTF-8'}" class="sp-deal sp-preload" >
                    <div class="sp-loading"></div>
                    <div id="spdeal-slider-{$items->id_spdeal}" class="spdeal-slider product-listing">
                        {foreach $_list as $product}
                            {if isset($product.specialPriceToDate)}
							<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">		
                                <div class="product-container">
									<div class="row">
										<div class="col-sm-6 col-md-12 col-lg-6">
											<div class="product-image">
												{block name='product_thumbnail'}
												  	<a href="{$product.link}" class="thumbnail product-thumbnail">
												  		{assign var="imageSize" value=($items->params.image_size != 'none') ? $items->params.image_size : 'home_default'}
												  		{if $product.cover.bySize.$imageSize.url}
															<img src = "{$product.cover.bySize.$imageSize.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
														{else}
															{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, $items->params.image_size)|escape:'html':'UTF-8'}}
	                                                        <img src="{$src|escape:'html':'UTF-8'}"
	                                                             alt="{$product.legend|escape:'html':'UTF-8'}"/>
														{/if}
														{if isset($SP_secondimg)}
															{hook h="displaySecondImage" id_product=$product.id_product link_rewrite=$product.link_rewrite}
														{/if}
												  	</a>
												{/block}
												{if $items->params.display_new || $items->params.display_sale }	
												  	{block name='product_flags'}
														<div class="product-flags">
															{foreach from=$product.flags item=flag key = k}
																{if $k=='new'}	
																	{if $items->params.display_new}	
																	<span class="{$flag.type}-label">{$flag.label}</span>
																	{/if}
																{elseif $k=='sale'}
																	{if $items->params.display_sale}	
																	<span class="{$flag.type}-label">{$flag.label}</span>
																	{/if}
																{else}
																	<span class="{$flag.type}-label">{$flag.label}</span>
																{/if}
															{/foreach}
															{if $product.discount_type === 'percentage'}
															  <span class="discount-percentage">{$product.discount_percentage}</span>
															{/if}
														</div>
												  	{/block}
												{/if}
												{if $items->params.display_quickview}	
													<a href="#" class="quick-view" data-link-action="quickview">
														<i class="material-icons search">&#xE8B6;</i>
													</a>
												{/if}
											</div>
										</div>
										<div class="col-sm-6 col-md-12 col-lg-6">
											<div class="product-info">
												{if isset($product.specialPriceToDate)}
													<div class="item-time">
														<div class="label-timer">{l s='Hurry Up! Offer ends in:' d='Shop.Theme.Actions'}</div>
														<div class="item-timer product_time_{$items->id_spdeal|escape:'html':'UTF-8'}_{$product.id_product|escape:'html':'UTF-8'}"></div>
														<script type="text/javascript">
															//<![CDATA[
															listdeal.push("product_time_{$items->id_spdeal|escape:'quotes':'UTF-8'}_{$product.id_product|escape:'quotes':'UTF-8'}|{$product.specialPriceToDate|date_format:"%Y/%m/%d %H:%M:%S"|escape:'quotes':'UTF-8'}");
															//]]>
														</script>
													</div>
												{/if}
												{if $items->params.display_name == 1}
												  	{block name='product_name'}
														<h5 class="product-title" itemprop="name"><a href="{$product.link}">{$product.name|truncate:$items->params.name_maxlength:'...'}</a></h5>
												  	{/block}
												{/if} 
												{if $items->params.display_variant}
												  	{block name='product_variants'}
														{if $product.main_variants}
														  	{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
														{/if}
												  	{/block}
												{/if} 
												{if $items->params.display_availability}
												  	{block name='product_availability'}
														{if $product.show_availability}
														  	{* availability may take the values "available" or "unavailable" *}
														  	<span class='product-availability {$product.availability}'>{$product.availability_message}</span>
														{/if}
												  	{/block}
												{/if}
												{if $items->params.display_description}
												  	{block name='product_description_short'}
														<div class="product-description" itemprop="description">
															{$product.description_short|strip_tags:'UTF-8'|truncate:$items->params.description_maxlength:'...'}
														</div>
												  	{/block}
												{/if}
												{if $items->params.display_price}	
												  	{block name='product_price_and_shipping'}
														<div class="product-price-and-shipping" 
															itemprop="offers"
                											itemscope
                											itemtype="https://schema.org/Offer"
                											>
            												<link itemprop="availability" href="https://schema.org/InStock"/>
                											<meta itemprop="priceCurrency" content="{$currency.iso_code}">
														  	{if $product.has_discount}
																{hook h='displayProductPriceBlock' product=$product type="old_price"}
																<span class="regular-price">{$product.regular_price}</span>
														  	{/if}
														  	{hook h='displayProductPriceBlock' product=$product type="before_price"}
														  	<span itemprop="price" content="{$product.price_amount}" class="price">{$product.price}</span>
														  	{hook h='displayProductPriceBlock' product=$product type='unit_price'}
														  	{hook h='displayProductPriceBlock' product=$product type='weight'}
														</div>
												  	{/block}
												{/if}
											  	{block name='product_list_actions'}
													<div class="product-list-actions">
														{if $items->params.display_addtocart}
														  	{if $product.add_to_cart_url}
															  	<a
																class = "add-to-cart btn btn-primary"
																href  = "{$product.add_to_cart_url}"
																rel   = "nofollow"
																data-id-product="{$product.id_product}"
																data-id-product-attribute="{$product.id_product_attribute}"
																data-link-action="add-to-cart"
																title = "{l s='Add to cart' d='Shop.Theme.Actions'}"
															  >{l s='Add to cart' d='Shop.Theme.Actions'}</a>
														  	{/if}
														{/if}
													  	{hook h='displayProductListFunctionalButtons' product=$product}
													</div>
											  	{/block}
											</div>
										</div>
									</div>
                            	</div>
							</article>	
                            {/if}
                        {/foreach}
                    </div>
                </div>
	        	<script type="text/javascript">
					jQuery(document).ready(function ($) {
						;(function (element) {
						var $element = $(element),
							$dealslider = $("#spdeal-slider-{$items->id_spdeal}", $element),
							_delay = '{$items->params.delay|escape:"html":"UTF-8"}',
							_duration = '{$items->params.duration|escape:"html":"UTF-8"}',
							_effect = '{$items->params.effect|escape:"html":"UTF-8"}';	
						$dealslider.on("initialized.owl.carousel", function () {
							var $item_active = $(".spdeal-item.active", $element);
							if ($item_active.length > 1 && _effect != "none") {
								_getAnimate($item_active);
							}
							else {
								var $item = $(".spdeal-item", $element);
								$item.css("opacity", "1");
								$item.css("filter", "alpha(opacity = 100)");
							}
						});

						$dealslider.owlCarousel({
							margin: {$items->params.margin|escape:"html":"UTF-8"},
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
							//dotClass: "spdeal-dot",
							//dotsClass: "spdeal-dots",
							//themeClass: 'spdeal-theme',
							//baseClass: 'spdeal-carousel',
							//itemClass: 'spdeal-item',
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

						$dealslider.on("translate.owl.carousel", function (e) {
							var $item_active = $(".spdeal-item.active", $element);
							_UngetAnimate($item_active);
							_getAnimate($item_active);
						});

						$dealslider.on("translated.owl.carousel", function (e) {
							var $item_active = $(".spdeal-item.active", $element);
							var $item = $(".spdeal-item", $element);
							
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
							$dealslider.removeClass("extra-animate");
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
									$dealslider.addClass("extra-animate");
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
						
					   var _timer = 0;
						$(window).load(function () {
							if (_timer) clearTimeout(_timer);
							_timer = setTimeout(function () {
								$(".sp-loading", $element).remove();
								$element.removeClass("sp-preload");
							}, 1000);
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
									out += "<div class='time-item time-day'>" + "<div class='num-time'>" + days + "</div>" + "<div class='name-time'>" + ((days == 1) ? "{l s='Day' mod='spdeal'}" : "{l s='Days' mod='spdeal'}") + "</div>" + "</div> ";
								}
								if (hours != 0) {
									out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + "<div class='name-time'>" + ((hours == 1) ? "{l s='Hour' mod='spdeal'}" : "{l s='Hours' mod='spdeal'}") + "</div>" + "</div>";
								}
								out += "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + "<div class='name-time'>" + ((mins == 1) ? "{l s='Min' mod='spdeal'}" : "{l s='Mins' mod='spdeal'}") + "</div>" + "</div>";
								out += "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + "<div class='name-time'>" + ((secs == 1) ? "{l s='Sec' mod='spdeal'}" : "{l s='Secs' mod='spdeal'}") + "</div>" + "</div>";
								out = out.substr(0, out.length - 2);
								$("." + id).html(out);

								 setTimeout(function () {
									 CountDown(date, id);
								 }, 1000);
							}
						}

						if (listdeal.length > 0) {
							for (var i = 0; i < listdeal.length; i++) {
								var arr = listdeal[i].split("|");
								if (arr[1].length) {
									var data = new Date(arr[1]);
									CountDown(data, arr[0]);
								}
							}
						}					

					})("#{$tag_id|escape:'html':'UTF-8'}");
				});					
	            </script>
            {/if}
        </div>
	{/foreach}
{else}
        {l s='Has no content to show in module Sp Deal' mod='spdeal'}
{/if}
<!-- /SP Slider -->