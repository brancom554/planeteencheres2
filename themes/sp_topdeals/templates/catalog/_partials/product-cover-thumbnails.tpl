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
<div class="images-container {if isset($SP_product_thumbtype) && $SP_product_thumbtype == 'true'} vertical-thumbnails {else} horizontal-thumbnails {/if}">
	{if isset($SP_product_thumbtype) && $SP_product_thumbtype == 'true'}
		{block name='product_images'}
			<div class="js-qv-mask mask">
				<ul class="product-images js-qv-product-images" data-thumb="{$SP_product_thumb}" data-thumbtype="{$SP_product_thumbtype}">
					{foreach from=$product.images item=image}
						<li class="thumb-container">
							<img  class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
							  data-image-medium-src="{$image.bySize.medium_default.url}"
							  data-image-large-src="{$image.bySize.large_default.url}"
							  src="{$image.bySize.small_default.url}"
							  alt="{$image.legend}"
							  title="{$image.legend}" itemprop="image">
						</li>
					{/foreach}
				</ul>
			</div>
		{/block}
	{/if}
	
	{block name='product_cover'}
		<div class="product-cover" data-productzoom="{$SP_productZoom}" data-productzoomtype="{((!empty($SP_productZoomType)) ? $SP_productZoomType : 'window')}">
			{if $product.cover.bySize.large_default.url}
		    <img class="js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image" >
		    {else}
		    {assign var="src" value={Context::getContext()->link->getImageLink($product.link_rewrite, $product.id_image, 'large_default')|escape:'html':'UTF-8'}}
		                <img class="js-qv-product-cover" src="{$src|escape:'html':'UTF-8'}"
		                  alt="{$product.name|escape:'html':'UTF-8'}" style="width:100%;" itemprop="image" >
		   {/if}
		   <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
				<i class="material-icons zoom-in">&#xE8FF;</i>
			</div>
			{block name='product_flags'}
                <div class="product-flags">
                  {foreach from=$product.flags item=flag}
                    <span class="product-flag {$flag.type}-label">{$flag.label}</span>
                  {/foreach}
					{if $product.has_discount}
						{if $product.discount_type === 'percentage'}
						  <span class="discount discount-percentage">{l s='- %percentage%' d='Shop.Theme.Catalog' sprintf=['%percentage%' => $product.discount_percentage_absolute]}</span>
						{else}
						  <span class="discount discount-amount">{l s='- %amount%' d='Shop.Theme.Catalog' sprintf=['%amount%' => $product.discount_amount]}</span>
						{/if}
					{/if}
                </div>
              {/block}
		</div>
	{/block}
	
	{if isset($SP_product_thumbtype) && $SP_product_thumbtype == 'false'}
		{block name='product_images'}
			<div class="js-qv-mask mask">
				<ul class="product-images js-qv-product-images" data-thumb="{$SP_product_thumb}" data-thumbtype="{$SP_product_thumbtype}">
					{foreach from=$product.images item=image}
						<li class="thumb-container">
							<img  class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
							  data-image-medium-src="{$image.bySize.medium_default.url}"
							  data-image-large-src="{$image.bySize.large_default.url}"
							  src="{$image.bySize.small_default.url}"
							  alt="{$image.legend}"
							  title="{$image.legend}" itemprop="image">
						</li>
					{/foreach}
				</ul>
			</div>
		{/block}
	{/if}

</div>