{*
 * @package SP Listing Tabs
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}
{if !isset($items_params)}
    {assign var="items_params" value=$items->params}
{/if}

{if !empty($child_items)}
    {if !isset($kk)}
        {assign var="kk" value="0"}
    {/if}
    {counter start=$kk skip=1 print=false name=count assign="count"}
    {foreach $child_items as $product}
        {counter name=count}
<div class="ltabs-item new-ltabs-item">
<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">		
  <div class="thumbnail-container">
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
	
	{if $items_params.display_name == 1}
      {block name='product_name'}
        <h1 class="h3 product-title" itemprop="name"><a href="{$product.link}">{$product.name|truncate:30:'...'}</a></h1>
      {/block}
	{/if}  
	{if $items_params.display_description}
      {block name='product_description_short'}
        <div class="product-description-short" itemprop="description">{$product.description_short nofilter}</div>
      {/block}
	{/if}
      {block name='product_list_actions'}
        <div class="product-list-actions">
		{if $items_params.display_addtocart}
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
	{if $items_params.display_price}	
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
	{if $items_params.display_new || $items_params.display_sale }	
      {block name='product_flags'}
        <ul class="product-flags">
          {foreach from=$product.flags item=flag key = k}
			{if $k=='new'}	
				{if $items_params.display_new}	
				<li class="{$flag.type}">{$flag.label}</li>
				{/if}
			{elseif $k=='sale'}
				{if $items_params.display_sale}	
				<li class="{$flag.type}">{$flag.label}</li>
				{/if}
			{else}
				<li class="{$flag.type}">{$flag.label}</li>
			{/if}
          {/foreach}
        </ul>
      {/block}
	{/if}	
	{if $items_params.display_availability}
      {block name='product_availability'}
        {if $product.show_availability}
          {* availability may take the values "available" or "unavailable" *}
          <span class='product-availability {$product.availability}'>{$product.availability_message}</span>
        {/if}
      {/block}
	{/if}
    </div>
    <div class="highlighted-informations{if !$product.main_variants} no-variants{/if}">
	{if $items_params.display_quickview}	
	<a
        href="#"
        class="quick-view"
        data-link-action="quickview"
      >
        <i class="material-icons search">&#xE8B6;</i> {l s='Quick view' d='Shop.Theme.Actions'}
      </a>
	{/if}
	{if $items_params.display_variant}
      {block name='product_variants'}
        {if $product.main_variants}
          {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
        {/if}
      {/block}
	{/if}  
    </div>

		</div>
	</article>
</div>
        {assign var="clear" value="clr1"}
        {if ($count %2 == 0)}
            {$clear = $clear|cat:' clr2'}
        {/if}
        {if ($count %3 == 0)}
            {$clear = $clear|cat:' clr3'}
        {/if}
        {if ($count %4 == 0)}
            {$clear = $clear|cat:' clr4'}
        {/if}
        {if ($count %5 == 0)}
            {$clear = $clear|cat:' clr5'}
        {/if}
        {if ($count %6 == 0)}
            {$clear = $clear|cat:' clr6'}
        {/if}
        {if $condition == false}
            <div class="{$clear|escape:'html':'UTF-8'}"></div>
        {/if}
    {/foreach}
{/if}

