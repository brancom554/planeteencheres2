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
            <div class="moduletable clearfix {$moduleclass_sfx|escape:'html':'UTF-8'} {$class_hook|escape:'html':'UTF-8'}">
				<div class="spmostviewed-heading col-md-2 col-sm-3 col-xs-4">
					{if isset($items->title_module[$id_lang]) && $items->params.display_title_module}
						<h3>
							{$items->title_module[$id_lang]|escape:'html':'UTF-8'}
						</h3>
					{/if}
				</div>
                {$_list = $items->products}
                {if isset($_list) && $_list}
                    {math equation='rand()' assign='rand'}
                    {assign var='randid' value="now"|strtotime|cat:$rand}
                    {assign var="tag_id" value="sp_countdownproduct_{$items->id_spmostviewed}_{$randid}"}
					{assign var='count_item' value=count($_list)}
					{assign var='item_row' value=$items->params.item_row}
                    <div id="{$tag_id|escape:'html':'UTF-8'}" class="sp-mostviewed sp-preload col-md-10 col-sm-9 col-xs-8 clearfix" 
						{foreach from=$items->params item=param key=k} 
							{if !is_array($param)}
								data-{$k} = "{$param}" 
							{/if}
						{/foreach} >
                        <div class="sp-loading"></div>
                        <div id="spmostviewed-slider-{$items->id_spmostviewed}" class="spmostviewed-slider">
							{foreach $_list as $product key=k}
								{if $item_row == 1}
									<div class="content-item">	
								{else}	
									{if (($k+1) % $item_row) == 1}
										<div class="content-item">								
									{/if}
								{/if}
									<div class="item">	
										<div class="product-description">												
											{if $items->params.display_name == 1}
											  {block name='product_name'}
												<h3 class="product-title"><a href="{$product.link}">{$product.name|truncate:$items->params.name_maxlength:''}</a></h3>
											  {/block}
											{/if}  
											{if $items->params.display_description}
											  {block name='product_description_short'}
												<div class="product-description-short" itemprop="description">{$product.description_short|truncate:$items->params.description_maxlength nofilter}</div>
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
												  {foreach from=$product.flags item=flag key = j}
													{if $j=='new'}	
														{if $items->params.display_new}	
														<li class="{$flag.type}">{$flag.label}</li>
														{/if}
													{elseif $j=='sale'}
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


										<div class="product-number-views">{$product.counter_viewed} <span>{l s='Viewed' mod='spmostviewed'}</span></div>

										</div>

										<div class="product-container">
											{block name='product_thumbnail'}
											  <a href="{$product.link}" class="thumbnail product-thumbnail">
					                              	{if $product.cover.bySize.home_default.url}
														<img class="img_1" src = "{$product.cover.bySize.home_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
													{else}
														{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}}
														<img src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}"/>
													{/if}
											  </a>
											{/block}
											
										</div>	


									</div>	
								{if $item_row == 1}
									</div>	
								{else}	
									{if (($k+1) % $item_row) == 0 || (($k+1) == $count_item)}
										</div>								
									{/if}	
								{/if}								
							{/foreach}
                        </div>
                    </div>
                {else}
                    {l s='Has no content to show in module Sp Most Viewed' mod='spmostviewed'}
                {/if}
            </div>

    {/foreach}
{/if}
<!-- /SP Slider -->
