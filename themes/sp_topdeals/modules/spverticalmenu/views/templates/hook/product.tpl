{if !empty($products)}
{assign var='count' value=0}
<div class="block_content">
	{$spproduct=array_chunk($products,$col_product)}
		{foreach from=$spproduct item=products name=mypLoop}
			<ul class="products_block row">
				{foreach from=$products item=product name=products}
							<li class="ajax_block_product product_block  col-xs-12 col-sm-6 col-md-{12/$col_product} {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
								<div class="product-container" itemscope itemtype="http://schema.org/Product">
									<div class="left-block">
										<div class="product-image-container">
											<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
												<img class=" img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
											</a>
										</div>
									</div>
									<div class="right-block">
										<h5 itemprop="name">
											{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
											<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
												{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
											</a>
										</h5>
										{hook h='displayProductListReviews' product=$product}
									</div>
								</div>
							</li>
				{/foreach}
			</ul>	
		{/foreach}
</div>
{/if}