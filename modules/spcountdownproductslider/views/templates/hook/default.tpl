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
						<h3>
							{$items->title_module[$id_lang]|escape:'html':'UTF-8'}
						</h3>
					{/if}
					{if $date_from}
						<div class="spcountdownproductslider-time">
							<div class="item-timer" data-timer="{$date_from|date_format:'%Y/%m/%d %H:%M:%S'|escape:'quotes':'UTF-8'}" 
								data-day="{l s='Day' mod='spcountdownproductslider'}"
								data-days="{l s='Days' mod='spcountdownproductslider'}"
								data-hour="{l s='Hour' mod='spcountdownproductslider'}"
								data-hours="{l s='Hours' mod='spcountdownproductslider'}"
								data-min="{l s='Min' mod='spcountdownproductslider'}"
								data-mins="{l s='Mins' mod='spcountdownproductslider'}"
								data-sec="{l s='Sec' mod='spcountdownproductslider'}"
								data-secs="{l s='Secs' mod='spcountdownproductslider'}"
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
								<div class="item">
										{block name='product_thumbnail'}
										  <a href="{$product.link}" class="thumbnail product-thumbnail">
											<img
											  src = "{$product.cover.bySize.home_default.url}"
											  alt = "{$product.cover.legend}"
											  data-full-size-image-url = "{$product.cover.large.url}"
											>
										  </a>
										{/block}
										<div class="product-description">
										
										{if $items->params.display_name == 1}
										  {block name='product_name'}
											<h1 class="h3 product-title" itemprop="name"><a href="{$product.link}">{$product.name|truncate:30:'...'}</a></h1>
										  {/block}
										{/if}  
										{if $items->params.display_description}
										  {block name='product_description_short'}
											<div class="product-description-short" itemprop="description">{$product.description_short nofilter}</div>
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
										{if $items->params.display_price}	
										  {block name='product_price_and_shipping'}
											<div class="product-price-and-shipping">
											  {if $product.has_discount}
												{hook h='displayProductPriceBlock' product=$product type="old_price"}

												<span class="regular-price">{$product.regular_price}</span>
												{if $product.discount_type === 'percentage'}
												  <span class="discount-percentage">{$product.discount_percentage}</span>
												{/if}
											  {/if}

											  {hook h='displayProductPriceBlock' product=$product type="before_price"}

											  <span itemprop="price" class="price">{$product.price}</span>

											  {hook h='displayProductPriceBlock' product=$product type='unit_price'}

											  {hook h='displayProductPriceBlock' product=$product type='weight'}
											</div>
										  {/block}
										{/if}
										{if $items->params.display_new || $items->params.display_sale }	
										  {block name='product_flags'}
											<ul class="product-flags">
											  {foreach from=$product.flags item=flag key = k}
												{if $k=='new'}	
													{if $items->params.display_new}	
													<li class="{$flag.type}">{$flag.label}</li>
													{/if}
												{elseif $k=='sale'}
													{if $items->params.display_sale}	
													<li class="{$flag.type}">{$flag.label}</li>
													{/if}
												{else}
													<li class="{$flag.type}">{$flag.label}</li>
												{/if}
											  {/foreach}
											</ul>
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
										</div>
										<div class="highlighted-informations{if !$product.main_variants} no-variants{/if}">
										{if $items->params.display_quickview}	
										<a
											href="#"
											class="quick-view"
											data-link-action="quickview"
										  >
											<i class="material-icons search">&#xE8B6;</i> {l s='Quick view' d='Shop.Theme.Actions'}
										  </a>
										{/if}
										{if $items->params.display_variant}
										  {block name='product_variants'}
											{if $product.main_variants}
											  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
											{/if}
										  {/block}
										{/if}  
										</div>
								</div>
							</article>		
							{/foreach}
                        </div>
                    </div>
       
                {else}
                    {l s='Has no content to show in module SP Countdown Products Slider' mod='spcountdownproductslider'}
                {/if}
            </div>

    {/foreach}
{/if}
<!-- /SP Slider -->