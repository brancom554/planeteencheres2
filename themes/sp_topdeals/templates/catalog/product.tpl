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
{extends file=$layout}
{block name='head_seo' prepend}
  	<link rel="canonical" href="{$product.canonical_url}">
{/block}
{block name='head' append}
	<meta property="og:type" content="product">
	<meta property="og:url" content="{$urls.current_url}">
	<meta property="og:title" content="{$page.meta.title}">
	<meta property="og:site_name" content="{$shop.name}">
	<meta property="og:description" content="{$page.meta.description}">
	<meta property="og:image" content="{$product.cover.large.url}">
	<meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
	<meta property="product:pretax_price:currency" content="{$currency.iso_code}">
	<meta property="product:price:amount" content="{$product.price_amount}">
	<meta property="product:price:currency" content="{$currency.iso_code}">
	{if isset($product.weight) && ($product.weight != 0)}
		<meta property="product:weight:value" content="{$product.weight}">
		<meta property="product:weight:units" content="{$product.weight_unit}">
	{/if}
{/block}

{block name='content'}
	
<section id="main" itemscope itemtype="https://schema.org/Product" class="product-page">
	
    <meta itemprop="url" content="{$product.url}">
    <div class="row">
	    <div class="main-product clearfix">	
			<div class="col-lg-6 col-sm-12 col-xs-12 pb-left-column">
				{block name='page_content_container'}
				  	<section class="page-content" id="content">
						{block name='page_content'}
						  	{block name='product_cover_tumbnails'}
								{include file='catalog/_partials/product-cover-thumbnails.tpl'}
						  	{/block}
						{/block}
				  	</section>
				{/block}
			</div>	
	        <div class="col-lg-6 col-sm-12 col-xs-12 pb-right-column">

				{assign var="date_now" value=$smarty.now|date_format:'%Y/%m/%d %H:%M:%S'}
				{if isset($product.specific_prices)}
					{if isset($product.specific_prices.to) && $product.specific_prices.to}
						{assign var="date_to" value=$product.specific_prices.to|date_format:'%Y/%m/%d %H:%M:%S'}
						{if $date_to >= $date_now}
							<div class="countdown">
								<div class="item-timer" data-timer="{$date_to}"
								data-day="{l s='D : ' d='Shop.Theme.Catalog'}"
								data-days="{l s='D : ' d='Shop.Theme.Catalog'}"
								data-hour="{l s='H : ' d='Shop.Theme.Catalog'}"
								data-hours="{l s='H : ' d='Shop.Theme.Catalog'}"
								data-min="{l s='M : ' d='Shop.Theme.Catalog'}"
								data-mins="{l s='M : ' d='Shop.Theme.Catalog'}"
								data-sec="{l s='S' d='Shop.Theme.Catalog'}"
								data-secs="{l s='S' d='Shop.Theme.Catalog'}"
								></div>
							</div>
						{/if}
					{/if}
				{/if}	

	          	{block name='page_header_container'}
		            {block name='page_header'}
		              	<h1 class="product-name" itemprop="name">{block name='page_title'}{$product.name}{/block}</h1>
		            {/block}
	          	{/block}
				
				{block name='product_reviews'}
					{hook h='displaySPProductComment' product=$product}
				{/block}
				
				{block name='product_details'}
                   {include file='catalog/_partials/product-details.tpl'}																																																																		
                {/block}
				
				{if $product.is_customizable && count($product.customizations.fields)}
					{block name='product_customization'}
						{include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
					{/block}
				{/if}

	         	<div class="product-actions">
			  		{block name='product_buy'}
						<form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
				  			<input type="hidden" name="token" value="{$static_token}">
				  			<input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
				  			<input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id">
				  			{block name='product_variants'}
								{include file='catalog/_partials/product-variants.tpl'}
				  			{/block}
				  			{block name='product_pack'}
								{if $packItems}
					  				<section class="product-pack">
										<h3 class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</h3>
										{foreach from=$packItems item="product_pack"}
						  					{block name='product_miniature'}
												{include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack}
						  					{/block}
										{/foreach}
									</section>
								{/if}
				  			{/block}
				  			{block name='product_discounts'}
								{include file='catalog/_partials/product-discounts.tpl'}
				  			{/block}

							{block name='product_prices'}
								{include file='catalog/_partials/product-prices.tpl'}
							{/block}

				  			{block name='product_add_to_cart'}
								{include file='catalog/_partials/product-add-to-cart.tpl'}
				  			{/block}
				  			{block name='product_refresh'}
								<input class="product-refresh ps-hidden-by-js" name="refresh" type="submit" value="{l s='Refresh' d='Shop.Theme.Actions'}">
				  			{/block}
						</form>
			  		{/block}
				</div>
				<div class="share-share">
					{if isset($SP_share_buttons) && $SP_share_buttons}
						{hook h='displayProductButtons' product=$product}
					{/if}
				</div>
	      	</div>
	    </div>

	 	<div class="col-xs-12">
			{block name='product_moreinfo'}
				<div class="product-moreinfo">
					{include file='catalog/_partials/product-moreinfo.tpl'}
				</div>
			{/block}
		</div>
	</div>
    {block name='product_accessories'}
      	{if $accessories}
	        <section class="product-accessories clearfix">
	          	<h3 class="h5 text-uppercase">{l s='You might also like' d='Shop.Theme.Catalog'}</h3>
	          	<div class="products">
		            {foreach from=$accessories item="product_accessory"}
		              	{block name='product_miniature'}
		                	{include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory}
		              	{/block}
		            {/foreach}
	          	</div>
	        </section>
      	{/if}
    {/block}
	{block name='product_footer'}
  		{hook h='displayFooterProduct' product=$product category=$category}
	{/block}
	{block name='product_images_modal'}
  		{include file='catalog/_partials/product-images-modal.tpl'}
	{/block}
	{block name='page_footer_container'}
      	<footer class="page-footer">
	        {block name='page_footer'}
          		<!-- Footer content -->
        	{/block}
      	</footer>
	{/block}
</section>
{/block}
