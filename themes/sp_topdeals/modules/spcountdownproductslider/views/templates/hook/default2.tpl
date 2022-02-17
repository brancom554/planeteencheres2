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
			{assign var="date_from" value=( isset( $items->params.date_from ) ) ?  $items->params.date_from : ''}
            <div class="moduletable  {$moduleclass_sfx|escape:'html':'UTF-8'} {$class_hook|escape:'html':'UTF-8'}">
				<div class="spcountdownproductslider-heading clearfix">
					{if isset($items->title_module[$id_lang]) && $items->params.display_title_module}
						<h3 class="block-title">
							{$items->title_module[$id_lang]|escape:'html':'UTF-8'}
						</h3>
					{/if}
					{if $date_from}
						<div class="spcountdownproductslider-time">
							<div class="item-timer" data-timer="{$date_from|date_format:'%Y/%m/%d %H:%M:%S'|escape:'quotes':'UTF-8'}" 
									data-day="{l s='Day :' d='Shop.Theme.Actions'}"
									data-days="{l s='Days :' d='Shop.Theme.Actions'}"
									data-hour="{l s=' :' d='Shop.Theme.Actions'}"
									data-hours="{l s=' :' d='Shop.Theme.Actions'}"
									data-min="{l s=' :' d='Shop.Theme.Actions'}"
									data-mins="{l s=' :' d='Shop.Theme.Actions'}"
									data-sec="{l s='' d='Shop.Theme.Actions'}"
									data-secs="{l s='' d='Shop.Theme.Actions'}"
								></div>
						</div>
					{/if}
				</div>
                {$_list = $items->products}
                {if isset($_list) && $_list}
                    {math equation='rand()' assign='rand'}
                    {assign var='randid' value="now"|strtotime|cat:$rand}
                    {assign var="tag_id" value="sp_countdownproduct_{$items->id_spcountdownproductslider}_{$randid}"}
                    <div id="{$tag_id|escape:'html':'UTF-8'}" class="sp-countdownproductslider sp-preload" 
						{foreach from=$items->params item=param key=k} 
							{if !is_array($param)}
								data-{$k} = "{$param}" 
							{/if}
						{/foreach} >
                        <div class="sp-loading"></div>
                        <div id="spcountdownproductslider-slider-{$items->id_spcountdownproductslider}" class="spcountdownproductslider-slider">
							{foreach $_list as $product}
							<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">		
								<div class="item thumbnail-container product-container">
										{block name='product_thumbnail'}
											<div class="product-image">
												<a href="{$product.link}" class="thumbnail product-thumbnail">
					                              	{if $product.cover.bySize.home_default.url}
														<img class="img_1" src = "{$product.cover.bySize.home_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
													{else}
														{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}}
														<img src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}"/>
													{/if}
													{if $SP_secondimg}
														{hook h="displaySecondImage" id_product=$product.id_product link_rewrite=$product.link_rewrite}	
													{/if}
												</a>

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
													</div>
												  {/block}
												{/if}	

												{if $product.discount_type === 'percentage'}
												  <span class="discount-percentage">{$product.discount_percentage} <strong>{l s='OFF' d='Shop.Theme.Actions'}</strong></span>
												{/if}

												{if $items->params.display_quickview}	
												<div class="quick-view-wrapper">	
													<a href="#" class="quick-view" data-link-action="quickview" title = "{l s='Quick View' d='Shop.Theme.Actions'}">
														<i class="fa fa-eye" aria-hidden="true"></i>
												  	</a>
												  </div>
												{/if}

											</div>
										{/block}
										<div class="product-description product-info">
											{if $items->params.display_name == 1}
												{block name='product_name'}
													<h5 class="product-title" itemprop="name"><a href="{$product.link}">{$product.name}</a></h5>
												{/block}
											{/if}  
											{block name='product_reviews'}
												{hook h='displayProductListReviews' product=$product}
											{/block}
											{if $items->params.display_description}
											  	{block name='product_description_short'}
													<div class="product-description-short" itemprop="description">{$product.description_short nofilter}</div>
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

											<div class="highlighted-informations{if !$product.main_variants} no-variants{/if}">
												{if $items->params.display_variant}
												  	{block name='product_variants'}
														{if $product.main_variants}
														  	{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
														{/if}
												  	{/block}
												{/if}  
											</div>

		
											{if $items->params.display_price}	
											  	{block name='product_price_and_shipping'}
													<div class="product-price-and-shipping">
													  	<span itemprop="price" class="price">{$product.price}</span>
													  	{if $product.has_discount}
															{hook h='displayProductPriceBlock' product=$product type="old_price"}
															<span class="regular-price">{$product.regular_price}</span>
													  	{/if}
													  	{hook h='displayProductPriceBlock' product=$product type="before_price"}
													  	{hook h='displayProductPriceBlock' product=$product type='unit_price'}
													  	{hook h='displayProductPriceBlock' product=$product type='weight'}
													</div>
											  	{/block}
											{/if}
											
											{if $items->params.display_addtocart}
											<div class="cart_content">
												
						                            {if $product.availability == 'available'}
						                                <a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='spextraslider'}">
						                                  <span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
						                                </a>
						                              {elseif $product.availability == 'last_remaining_items'}
						                                <a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='spextraslider'}">
						                                  <span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
						                                </a>
						                              {else}
						                                <span class="no-product cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='spextraslider'}">
						                                  <span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
						                                </span>
						                            {/if}
												  
										  	</div>
										  	{/if}
										  	

										</div>
									</div>
							</article>		
							{/foreach}
                        </div>
                    </div>
       
                {else}
                    {l s='Has no content to show in module SP Countdown Products Slider' d='Shop.Theme.Actions'}
                {/if}
            </div>

    {/foreach}
{/if}
<!-- /SP Slider -->