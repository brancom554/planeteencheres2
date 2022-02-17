{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="category-products">
      <div class="title">
        <h3 class="title-block">{l s='Related Items' mod='ps_categoryproducts'}</h3>
      </div>
      <section>
          <h5 class="quantity">
            {if $products|@count == 1}
              {l s='%s other product in the same category:' sprintf=[$products|@count] d='Modules.Categoryproducts.Shop'}
            {else}
              {l s='%s other products in the same category:' sprintf=[$products|@count] d='Modules.Categoryproducts.Shop'}
            {/if}
          </h5>
          <div class="related-product clearfix">
              {foreach from=$products item="product"}

                  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
                      <div class="product-container">
                        <div class="left-block">
                        <div class="product-image">
                          {block name='product_thumbnail'}
                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                              {if $product.cover.bySize.home_default.url}
								<img class="img_1" src = "{$product.cover.bySize.home_default.url}" alt = "{$product.cover.legend}" data-full-size-image-url = "{$product.cover.large.url}">
								{else}
									{assign var="src" value={$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}}
									<img src="{$src|escape:'html':'UTF-8'}" alt="{$product.legend|escape:'html':'UTF-8'}"/>
								{/if}
                              {if isset($SP_secondimg) && $SP_secondimg == 1}
                                {hook h="displaySecondImage" id_product=$product.id_product link_rewrite=$product.link_rewrite}
                              {/if}
                            </a>
                          {/block}
                          {if isset($SP_catProductLabel) && $SP_catProductLabel == 1 }
                            {block name='product_flags'}
                              <div class="product-flags">
                              {foreach from=$product.flags item=flag}
                                <span class="{$flag.type}-label">{$flag.label}</span>
                              {/foreach}
                              </div>
                            {/block}
                          {/if}
						
                        <div class="button-container">
                            {if isset($SP_catProductQuickview) && $SP_catProductQuickview == 1 }
                                <a href="#" class="quick-view" data-link-action="quickview" title = "{l s='Quick View' mod='ps_categoryproducts'}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            {/if}
                            <div class="cart_content">
                              {if $product.availability == 'available'}
                                <a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='ps_categoryproducts'}">
                                  <span class="text">{l s='Add to cart' mod='ps_categoryproducts'}</span>
                                </a>
                              {elseif $product.availability == 'last_remaining_items'}
                                <a href="#" class="ajax-add-to-cart product-btn cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='ps_categoryproducts'}">
                                  <span class="text">{l s='Add to cart' mod='ps_categoryproducts'}</span>
                                </a>
                              {else}
                                <span class="no-product cart-button" data-id-product="{$product.id_product}" data-minimal-quantity="1" title = "{l s='Add to cart' mod='ps_categoryproducts'}">
                                  <span class="text">{l s='Out of Stock' mod='ps_categoryproducts'}</span>
                                </span>
                              {/if}
                            </div>
                      </div>
                        </div>
                      </div><!-- left-block-->
                          <div class="product-info">
                              {if isset($SP_catProductTitle) && $SP_catProductTitle == 1}
                                {block name='product_name'}
                                  <h5 class="product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:50:'...'}</a></h5>
                                {/block}
                              {/if}
                              {if isset($SP_catProductColor) && $SP_catProductColor == 1 }
                                {block name='product_variants'}
                                  {if $product.main_variants}
                                    {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
                                  {/if}
                                {/block}
                              {/if}
                              {if isset($SP_catProductDes) && $SP_catProductDes == 1}
                                  {block name='product_description_short'}
                                  <div class="product-description-short" itemprop="description">{$product.description_short|truncate:80:'...' nofilter}</div>
                                  {/block}
                              {/if}
                              {if isset($SP_catProductStock) && $SP_catProductStock == 1 }
                                  {block name='product_availability'}
                                  {if $product.show_availability}
                                    {* availability may take the values "available" or "unavailable" *}
                                    <span class='product-availability {$product.availability}'>{$product.availability_message}</span>
                                  {/if}
                                  {/block}
                              {/if}

                          <div class="price-off clearfix">
                                <div class="price-left">
                                  {if isset($SP_catProductPrice) && $SP_catProductPrice == 1 }
                                    {block name='product_price_and_shipping'}
                                      {if $product.show_price}
                                        <div class="product-price-and-shipping"
                                          itemprop="offers"
                                                  itemscope
                                                  itemtype="https://schema.org/Offer"
                                                  >
                                                  <link itemprop="availability" href="https://schema.org/InStock"/>
                                                  <meta itemprop="priceCurrency" content="{$currency.iso_code}">
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
                                  {/if}
                                </div>
                                <div class="price-right">
                                    {if $product.discount_type === 'percentage'}
                                      <span class="discount-percentage">{$product.discount_percentage} <strong>OFF</strong></span>
                                    {/if}
                                </div>
                            </div>
                          </div>
                      </div>
                  </article>

              {/foreach}
          </div>
      </section>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.related-product').owlCarousel({
      pagination: false,
      center: false,
      nav: true,
      mouseDrag: false,
      loop: true,
      margin: 30,
      navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
      dots: false,
      slideBy: 1,
      autoplay: false,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      autoplaySpeed: 800,
      startPosition: 0, 
      responsive:{
        0:{
          items:1
        },
        480:{
          items:2
        },
        768:{
          items:2
        },
        992:{
          items:3
        },
        1200:{
          items:3
        }
      }
    });
  });
</script>
