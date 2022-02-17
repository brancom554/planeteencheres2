{*
 * package   SP Count Product
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}
 
	<script type="text/javascript">
		var listcountdown = [];
	</script>

	{if isset($list) && $list}
        {foreach from=$list item=items}
            {if !empty($items->products)}
				{$_list = $items->products}
                {assign var="moduleclass_sfx" value=( isset( $items->params.moduleclass_sfx ) ) ?  $items->params.moduleclass_sfx : ''}
                {math equation='rand()' assign='rand'}
                {assign var='randid' value="now"|strtotime|cat:$rand}
                {assign var="uniqued" value="sp_countdown_product_{$items->id_spcountdownproduct}_{$randid}"}
				<div class="moduletable clearfix {$moduleclass_sfx|escape:'html':'UTF-8'}">
                    {if $items->params.display_title_module}
                        <h3 class="title">
                            {$items->title_module[$id_lang]|escape:'html':'UTF-8' nofilter}
                        </h3>
                    {/if}
                    <div id="{$uniqued|escape:'html':'UTF-8'}" class="sp-countdown-sliders"					
						{foreach from=$items->params item=param key=k} 
							data-{$k} = "{$param}" 
						{/foreach}					
					>
	                        <div class="pds-items-detail col-xs-12 col-md-10">
								{foreach from=$_list  item=product key =k}
									<div class="pds-item-detail">
										<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
										<div class="pds-item-inner-detail">
										<div class="row">
													<div class="product-content-slider col-xs-12 col-md-12">
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12">
															<div class="product-item-bg">
																<div class="row">
																	<div class="pds-content product-item product-detail col-xs-12 col-sm-6 col-md-5 col-lg-5">
																			{if isset($product.specialPriceToDate) && $product.specialPriceToDate != 'ulimited'}
																				<div class="item-time">
																				<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
																					<div class="item-timer product_time_{$items->id_spcountdownproduct|escape:'html':'UTF-8'}_{$product.id_product|escape:'html':'UTF-8'}"></div>
																					<script type="text/javascript">
																						//<![CDATA[
																						listcountdown.push("product_time_{$items->id_spcountdownproduct|escape:'quotes':'UTF-8'}_{$product.id_product|escape:'quotes':'UTF-8'}|{$product.specialPriceToDate|date_format:"%Y/%m/%d %H:%M:%S"|escape:'quotes':'UTF-8'}");
																						//]]>
																					</script>
																				</div>
																			{else}
																				<label>{l s='Ulimited'}</label>
																			{/if}

																			<div class="product-description">												
																				{if $items->params.display_name == 1}
																				{block name='product_name'}
																					<div class="pds-title">
																						<a href="{$product.link}" {$product._target nofilter}>{$product.title nofilter}</a>
																					</div>
																				{/block}
																				{/if}  
																				{block name='product_reviews'}
																				  {hook h='displayProductListReviews' product=$product}
																				{/block}
																				{if $items->params.display_price}	
																					{if $product.show_price}
																						<div class="item-price">
																							{hook h='displayProductPriceBlock' product=$product type="before_price"}
																							{if $product.has_discount}
																								{hook h='displayProductPriceBlock' product=$product type="old_price"}
																								<span class="regular-price">{$product.regular_price}</span>
																							 {/if}
																						  	<span itemprop="price" class="price">{$product.price}</span>
																						  	{hook h='displayProductPriceBlock' product=$product type='unit_price'}
																						  	{hook h='displayProductPriceBlock' product=$product type='weight'}
																						</div>
																					{/if}
																				{/if}

																				{if isset($product.features) && $product.features}
																					<div class="pds-products-infor">	
																						<div class="additional-attributes-wrapper table-wrapper">
																							<div class="data additional-attributes">
																								{foreach from=$product.features  item=feature}
																									<div class="table-des">
																										<div class="col label">{$feature.name}</div>
																										<div class="col value" data-fn="{$feature.name}">{$feature.value}</div>
																									</div>
																								{/foreach}
																							</div>
																						</div>
																					</div>	
																				{/if}

																				{if $items->params.display_description}
																				  	{block name='product_description_short'}
																						<div class="product-description" itemprop="description">{$product.description_short|truncate:100 nofilter}</div>
																				  	{/block}
																				{/if}

																		   	 	{if $items->params.display_addtocart}
																					{if $product.availability == 'available'}
																						<a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' d='Shop.Theme.Actions'}">
																							<span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
																						</a>
																					{elseif $product.availability == 'last_remaining_items'}
																						<a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' d='Shop.Theme.Actions'}">
																							<span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
																						</a>
																					{else}
																						<span class="no-product cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' d='Shop.Theme.Actions'}">
																							<span class="text">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
																						</a>
																					{/if}
																				{/if}

																				<div class="highlighted-informations{if !$product.main_variants} no-variants{/if}" title = "{l s='Quick View' d='Shop.Theme.Actions'}">
																				  	<a href="#" class="quick-view" data-link-action="quickview">
																						<i class="fa fa-eye" aria-hidden="true"></i>
																						<!--{l s='Quick view' d='Shop.Theme.Actions'}-->
																				  	</a>
																				</div>
																			</div>											
																	</div>	

																	<div class="pb-left-column col-xs-12 col-sm-6 col-md-7 col-lg-7">
																		{block name='product_thumbnail'}
																			  <a href="{$product.link}" {$product._target nofilter}  class="thumbnail product-thumbnail">
																				{if $product.cover.bySize.large_default.url}
																					<img class="img_1" src = "{$product.cover.bySize.large_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
																				{else}
																					{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, 'large_default')|escape:'html':'UTF-8'}}
																					<img src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}"/>
																				{/if}
																			  </a>
																		{/block}
																		{if $items->params.display_new || $items->params.display_sale }	
																			{block name='product_flags'}
																				<div class="product-flags">
																				  	{foreach from=$product.flags item=flag key = j}
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
																					{if $product.has_discount}
																					  {if $product.discount_type === 'percentage'}
																							<span class="discount-percentage">{$product.discount_percentage}</span>
																					  {/if}
																					{/if}
																				</div>
																			{/block}
																		{/if}		
																	</div>

																</div>	
															</div>
														</div>
													</div>	
												</div>
											</div><!-- end row -->									
										</div>
										</article>
									</div>	
								{/foreach}
	                        </div>
							<div class="thumb-image col-xs-12 col-md-2">
								<div class="pds-items">
									{foreach from=$_list  item=product key =k}
										<div class="pds-item cf">
											<div class="pds-item-inner">
												<div class="product-content-slider-thumb">
													{assign var="src" value=($items->params.image_size != 'none') ? {$link->getImageLink($product.link_rewrite, $product.id_image, $items->params.image_size)|escape:'html':'UTF-8'} :  {$link->getImageLink($product.link_rewrite, $product.id_image)|escape:'html':'UTF-8'}}
														{if $product.cover.bySize.small_default.url}
															<img class="products-image-thumb" src = "{$product.cover.bySize.small_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
														{else}
															{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}}
															<img class="products-image-thumb" src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}" width="{$product.cover.bySize.home_default.width}" height="{$product.cover.bySize.home_default.height}"/>
														{/if}
												</div>	
											</div>
										</div>
									{/foreach}
								</div>	
							</div>	
                    </div>
                </div>	
			{else}
				{l s='Has no content to show In Module Sp Countdown Product' d='Shop.Theme.Actions'}
			{/if}	
        {/foreach}
    {else}
        {l s='Has no content to show In Module Sp Countdown Product' d='Shop.Theme.Actions'}
    {/if}