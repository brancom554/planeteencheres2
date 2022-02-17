{*
 * @package   SP Extra Slider
 * @version   1.0.1
 *
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}
<!-- SP Extra Slider -->
{if isset($list) && !empty($list)}
    {foreach from=$list item=items}
        {assign var="moduleclass_sfx" value=( isset( $items->params.moduleclass_sfx ) ) ?  $items->params.moduleclass_sfx : ''}
        <div class="moduletable  {$moduleclass_sfx|escape:'html':'UTF-8'}">
            {if isset($items->title_module[$id_lang]) && $items->params.display_title_module}
                <h3 class="module-tilte">
                    {$items->title_module[$id_lang]|escape:'html':'UTF-8'}
                </h3>
            {/if}
            {$_list = $items->products}
            {if isset($_list) && $_list}
                {math equation='rand()' assign='rand'}
                {assign var='randid' value="now"|strtotime|cat:$rand}
                {assign var="tag_id" value="sp_extra_slider_{$items->id_spextraslider}_{$randid}"}
                {assign var="cls_btn_page" value=($items->params.button_page == 'top')?'buttom-type1':'button-type2'}
                {assign var="button_prev" value=($items->params.button_page == 'top')?'&#171;' : '&#139;'}
                {assign var="button_next" value=($items->params.button_page == 'top')?'&#187;' : '&#155;'}
                {assign var="language_site" value=($items->language_site == 'true')?'true':'false'}
                {*//effect*}
                {assign var="margin" value=($items->params.margin >= 0)?$items->params.margin:5}
                {assign var="slideBy" value=($items->params.slideBy >= 0)?$items->params.slideBy:1}
                {assign var="autoplay" value=($items->params.autoplay == 1)?'true':'false'}
                {assign var="autoplay_timeout" value=($items->params.autoplay_timeout > 0)?$items->params.autoplay_timeout:2000}
                {assign var="autoplay_hover_pause" value=($items->params.autoplay_hover_pause == 1)?'true':'false'}
                {assign var="autoplaySpeed" value=($items->params.autoplaySpeed >0)?$items->params.autoplaySpeed:2000}
                {assign var="smartSpeed" value=($items->params.smartSpeed > 0)?$items->params.smartSpeed:2000}
                {assign var="startPosition" value=($items->params.startPosition >= 0)?$items->params.startPosition:0}
                {assign var="mouseDrag" value=($items->params.mouseDrag == 1)?'true':'false'}
                {assign var="touchDrag" value=($items->params.touchDrag == 1)?'true':'false'}
                {assign var="pullDrag" value=($items->params.pullDrag == 1)?'true':'false'}
                {assign var="dots" value=($items->params.dots == 1)?'true':'false'}
                {assign var="dotsSpeed" value=($items->params.dotsSpeed >0)?$items->params.dotsSpeed:100}
                {assign var="nav" value=($items->params.nav == 1)?'true':'false'}
                {assign var="navSpeed" value=($items->params.navspeed >0)?$items->params.navspeed:100}
                {assign var="btn_prev" value=($items->params.button_page == 'top')?'&#171;':'&#139;'}
                {assign var="btn_next" value=($items->params.button_page == 'top')?'&#187;':'&#155;'}
                {assign var="btn_type" value=($items->params.button_page == 'top')?'button-type1':'button-type2'}
                {assign var="class_respl" value="preset01-"|cat:$items->params.nb_column1|cat:' preset02-'|cat:$items->params.nb_column2|cat:' preset03-'|cat:$items->params.nb_column3|cat:' preset04-'|cat:$items->params.nb_column4}
                {$_list = $items->products}
                {if isset($_list) && $_list}
	                <div id="{$tag_id|escape:'html':'UTF-8'}"
	                 	class="sp-extraslider {$cls_btn_page|escape:'html':'UTF-8'} {$class_respl|escape:'html':'UTF-8'}
	                  	{$btn_type|escape:'html':'UTF-8'}">
	                    <div class="extraslider-inner product-listing" data-effect="{$items->params.effect|escape:'html':'UTF-8'}">
	                        {assign var="count_item" value=count($_list)}
	                        {assign var="nb_rows" value=$items->params.nb_rows}
	                        {counter start=0 skip=1 print=false name=count assign="count"}
	                        {foreach $_list as $product}
	                            {counter name=count}
	                            {if $count % $nb_rows == 1 || $nb_rows == 1}
	                                <div class="item">
	                            {/if}
								<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">		
		                            <div class="item-wrap {$items->params.layout|escape:'html':'UTF-8'}">
		                                <div class="product-container">
											<div class="product-image">
												{block name='product_thumbnail'}
												  	<a href="{$product.link}" class="thumbnail product-thumbnail">
														<img src = "{$product.cover.bySize.home_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
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
													<a href="#" class="quick-view" data-link-action="quickview" >
														<i class="material-icons search">&#xE8B6;</i>
													</a>
												{/if}
											</div>
											<div class="product-info">
												{if $items->params.display_name == 1}
												  	{block name='product_name'}
														<h5 class="product-title" itemprop="name"><a href="{$product.link}">{$product.name|truncate:30:'...'}</a></h5>
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
														<div class="product-description" itemprop="description">{$product.description_short nofilter}</div>
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
																<a class = "add-to-cart btn btn-primary" rel   = "nofollow" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" data-link-action="add-to-cart" title = "{l s='Add to cart' d='Shop.Theme.Actions'}">
																	{l s='Add to cart' d='Shop.Theme.Actions'}
																</a>
															 {/if}
														{/if}  
														{hook h='displayProductListFunctionalButtons' product=$product}
													</div>
											  {/block}
											</div>
		                                </div>
		                            </div>
								</article>	
	                            {if $count % $nb_rows == 0 || $count == $count_item}
	                                </div>
	                            {/if}
	                        {/foreach}
	                    </div>
	                </div>
            	{/if}
                <script type="text/javascript">
                    //<![CDATA[
                    jQuery(document).ready(function ($) {
						;(function (element) {
							var $element = $(element),
									$extraslider = $(".extraslider-inner", $element),
									_delay = {$items->params.delay|escape:"html":"UTF-8"},
									_duration = {$items->params.duration|escape:"html":"UTF-8"},
									_effect = "{$items->params.effect|escape:"html":"UTF-8"}";

							$extraslider.on("initialized.owl.carousel", function () {
								var $item_active = $(".owl-item.active", $element);
								if ($item_active.length > 1 && _effect != "none") {
									_getAnimate($item_active);
								}
								else {
									var $item = $(".owl-item", $element);
									{literal}
									$item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
									{/literal}
								}

								{if $items->params.dots == 1}
									if ($(".owl-dot", $element).length < 2) {
										$(".owl-prev", $element).css("display", "none");
										$(".owl-next", $element).css("display", "none");
										$(".owl-dot", $element).css("display", "none");
									}
								{/if}

								{if $items->params.button_page == top}
									$(".owl-controls", $element).insertBefore($extraslider);
									$(".owl-dots", $element).insertAfter($(".owl-prev", $element));
								{else}
									$(".owl-nav", $element).insertBefore($extraslider);
									$(".owl-controls", $element).insertAfter($extraslider);
								{/if}

							});

							$extraslider.owlCarousel({
								margin: {$margin|escape:"html":"UTF-8"},
								slideBy: {$slideBy|escape:"html":"UTF-8"},
								autoplay: {$autoplay|escape:"html":"UTF-8"},
								autoplay_hover_pause: {$autoplay_hover_pause|escape:"html":"UTF-8"},
								autoplay_timeout: {$autoplay_timeout|escape:"html":"UTF-8"},
								autoplaySpeed: {$autoplaySpeed|escape:"html":"UTF-8"},
								smartSpeed: {$smartSpeed|escape:"html":"UTF-8"},
								startPosition: {$startPosition|escape:"html":"UTF-8"},
								mouseDrag: {$mouseDrag|escape:"html":"UTF-8"},
								touchDrag:{$touchDrag|escape:"html":"UTF-8"},
								pullDrag:{$pullDrag|escape:"html":"UTF-8"},
								autoWidth: false,
								responsive: {
									0: {literal}{{/literal}items:1{literal}}{/literal},
									480: {literal}{{/literal}items:{$items->params.nb_column4|escape:"html":"UTF-8"}{literal}}{/literal},
									768: {literal}{{/literal}items:{$items->params.nb_column3|escape:"html":"UTF-8"}{literal}}{/literal},
									992: {literal}{{/literal}items:{$items->params.nb_column2|escape:"html":"UTF-8"}{literal}}{/literal},
									1200: {literal}{{/literal}items: {$items->params.nb_column1|escape:"html":"UTF-8"}{literal}}{/literal}
								},
								dotClass: "owl-dot",
								dotsClass: "owl-dots",
								dots: {$dots|escape:"html":"UTF-8"},
								dotsSpeed:{$dotsSpeed|escape:"html":"UTF-8"},
								nav: {$nav|escape:"html":"UTF-8"},
								loop: true,
								navSpeed: {$navSpeed|escape:"html":"UTF-8"},
								navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
								navClass: ["owl-prev", "owl-next"]
								{*rtl: {$language_site}*}
							});

							$extraslider.on("translate.owl.carousel", function (e) {
								{if $items->params.dots == 1}
									if ($(".owl-dot", $element).length < 2) {
										$(".owl-prev", $element).css("display", "none");
										$(".owl-next", $element).css("display", "none");
										$(".owl-dot", $element).css("display", "none");
									}
								{/if}
								
								var $item_active = $(".owl-item.active", $element);
								_UngetAnimate($item_active);
								_getAnimate($item_active);
							});

							$extraslider.on("translated.owl.carousel", function (e) {
							
								{if $items->params.dots == 1}
									if ($(".owl-dot", $element).length < 2) {
										$(".owl-prev", $element).css("display", "none");
										$(".owl-next", $element).css("display", "none");
										$(".owl-dot", $element).css("display", "none");
									}
								{/if}
								
								var $item_active = $(".owl-item.active", $element);
								var $item = $(".owl-item", $element);

								_UngetAnimate($item);

								if ($item_active.length > 1 && _effect != "none") {
									_getAnimate($item_active);
								} else {
									{literal}
										 $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
									{/literal}
								}
							});

							function _getAnimate($el) {
								if (_effect == "none") return;
								//if ($.browser.msie && parseInt($.browser.version, 10) <= 9) return;
								$extraslider.removeClass("extra-animate");
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
										$extraslider.addClass("extra-animate");
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

							if (extradeal.length > 0) {
								for (var i = 0; i < extradeal.length; i++) {
									var arr = extradeal[i].split("|");
									if (arr[1].length) {
										var data = new Date(arr[1]);
										CountDown(data, arr[0]);
									}
								}
							}							

						})("#{$tag_id|escape:'html':'UTF-8'}");
					});
                    //]]>
                </script>
            {else}
                {l s='Has no content to show!' mod='spextraslider'}
            {/if}
        </div>
    {/foreach}
{/if}
<!-- /SP Extra Slider -->