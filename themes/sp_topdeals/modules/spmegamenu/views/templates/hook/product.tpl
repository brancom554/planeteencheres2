{if !empty($products)}
{assign var='itempage' value=4}
{assign var='count' value=0}
<div class="block_content">
	{$spproduct=array_chunk($products,$itempage)}
		{foreach from=$spproduct item=products name=mypLoop}
			<ul class="product-miniature">
				{foreach from=$products item=product name=products}
					<li class="ajax_block_product product_block {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
						<div class="product-container" itemscope itemtype="http://schema.org/Product">
							<div class="left-block">
								<div class="product-image-container">
									<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
										<img class=" img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
									</a>

									{if isset($product.discount_type) && $product.discount_type === 'percentage'}
							 			<span class="discount-percentage">{$product.discount_percentage} <strong>{l s='OFF'}</strong></span>
									{/if}
								</div>
							</div>
							<div class="right-block">
								<div class="product-info">
										<h5 class="product-title" itemprop="name">
											<a href="{$product.link}">{$product.name|truncate:50:'...'}</a>
										</h5>
										<div class="product-price-and-shipping" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
											<link itemprop="availability" href="https://schema.org/InStock"/>
											<meta itemprop="priceCurrency" content="{$currency.iso_code}">
										  	{if isset($product.has_discount) && $product.has_discount }
												{hook h='displayProductPriceBlock' product=$product type="old_price"}
												<span class="regular-price">{$product.regular_price}</span>
										  	{/if}
										  	<span itemprop="price" {if isset($product.price_amount)}content="{$product.price_amount}" {/if} class="price">
										  		{if isset($currency.sign) && $currency.sign}{$currency.sign}{/if}
										  		{$product.price}
										  	</span>

										  	{hook h='displayProductPriceBlock' product=$product type="before_price"}
										  	{hook h='displayProductPriceBlock' product=$product type='unit_price'}
										  	{hook h='displayProductPriceBlock' product=$product type='weight'}
										</div>
								</div>
							</div>
						</div>
					</li>
				{/foreach}
			</ul>	
		{/foreach}
</div>
{/if}