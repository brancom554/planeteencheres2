{**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<article class="product-miniature js-product-miniature col-lg-{math equation = "12/{if isset($module_column)}{$module_column}{else}{if isset($SP_gridProduct)}{$SP_gridProduct}{else}3{/if}{/if}"} col-md-6 col-sm-6 col-xs-12" data-sp_gridproduct="{math equation = "12/{if isset($SP_gridProduct)}{$SP_gridProduct}{else}3{/if}"}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
  	<div class="product-container">
  		<div class="left-block">
			<div class="product-image">
				{block name='product_thumbnail'}
					<a href="{$product.url}" class="thumbnail product-thumbnail">
						{if $product.cover.bySize.home_default.url}
							<img class="img_1" src = "{$product.cover.bySize.home_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
						{else}
							{assign var="src" value={Context::getContext()->link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}}
	                        <img src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}"/>
						{/if}
						{hook h="displaySecondImage" id_product=$product.id_product link_rewrite=$product.link_rewrite}
					</a>
				{/block}
				{block name='product_flags'}
				  	<div class="product-flags">
						{foreach from=$product.flags item=flag}
							<span class="{$flag.type}-label">{$flag.label}</span>
						{/foreach}
				  	</div>
				{/block}
			</div>

			<div class="button-quick-view">
				<a href="#" class="quick-view" data-link-action="quickview" title = "{l s='Quick View'}">
					<i class="fa fa-eye" aria-hidden="true"></i>
				</a>
			</div>

			<div class="button-container">
				<a href="#" class="quick-view" data-link-action="quickview" title = "{l s='Quick View'}">
					<i class="fa fa-eye" aria-hidden="true"></i>
				</a>
			    <div class="cart_content">
					{if $product.availability == 'available'}
						<a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart'}">
							<span class="text">{l s='Add to cart'}</span>
						</a>
					{elseif $product.availability == 'last_remaining_items'}
						<a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart'}">
							<span class="text">{l s='Add to cart'}</span>
						</a>
					{else}
						<span class="no-product cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart'}">
							<span class="text">{l s='Out of Stock'}</span>
						</span>
					{/if}
				</div>
			</div>

		</div><!-- left-block-->
	    <div class="product-info right-block">
			{block name='product_name'}
				<h5 class="product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:55:'...'}</a></h5>
			{/block}

			{block name='product_reviews'}
				{hook h='displayProductListReviews' product=$product}
			{/block}

			{block name='product_variants'}
				{if $product.main_variants}
					{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
				{/if}
			{/block}

			{block name='product_availability'}
				{if $product.show_availability}
					{* availability may take the values "available" or "unavailable" *}
					<span class='product-availability {$product.availability}'>{$product.availability_message}</span>
				{/if}
			{/block}

			<div class="price-off clearfix">
				<div class="price-left">
				  	{block name='product_price_and_shipping'}
						{if $product.show_price}
							<div class="product-price-and-shipping" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				                <link itemprop="availability" href="https://schema.org/InStock"/>
		            			<meta itemprop="priceCurrency" content="{Context::getContext()->currency->iso_code}">
		            			<span itemprop="price" content="{$product.price_amount}" class="price">{$product.price}</span>
								{if $product.has_discount}
									{hook h='displayProductPriceBlock' product=$product type="old_price"}
									<span class="regular-price">{$product.regular_price}</span>
								{/if}
								{hook h='displayProductPriceBlock' product=$product type="before_price"}
								{hook h='displayProductPriceBlock' product=$product type='unit_price'}
								{hook h='displayProductPriceBlock' product=$product type='weight'}
							</div>
						{/if}
				    {/block}
			    </div>
			    <div class="price-right">
					{if $product.discount_type === 'percentage'}
						<span class="discount-percentage">{$product.discount_percentage} <strong>OFF</strong></span>
					{/if}
			    </div>
		    </div>

			{block name='product_description_short'}
				<div class="product-description-short" itemprop="description">{$product.description_short|truncate:200:'...' nofilter}</div>
			{/block}

	    </div>
  	</div>
</article>