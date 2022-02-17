<div class="images-container {if isset($SP_product_thumbtype) && $SP_product_thumbtype == 'true'} vertical-thumbnails {else} horizontal-thumbnails {/if}">
	{if isset($SP_product_thumbtype) && $SP_product_thumbtype == 'true'}
		{block name='product_images'}
			<div class="js-qv-mask mask">
				<ul class="product-images js-qv-product-images">
					{foreach from=$product.images item=image}
						<li class="thumb-container">
							<img  class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
							  data-image-medium-src="{$image.bySize.medium_default.url}"
							  data-image-large-src="{$image.bySize.large_default.url}"
							  src="{$image.bySize.home_default.url}"
							  alt="{$image.legend}"
							  title="{$image.legend}" itemprop="image">
						</li>
					{/foreach}
				</ul>
			</div>
			
		{/block}
	{/if}
	
	{block name='product_cover'}
		<div class="product-cover">
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
							  src="{$image.bySize.home_default.url}"
							  alt="{$image.legend}"
							  title="{$image.legend}" itemprop="image">
						</li>
					{/foreach}
				</ul>
			</div>
		{/block}
	{/if}

</div>

<script type="text/javascript">
	$(document).ready( function(){
		function _forProductDetail () {
			if ($('.product-images').length){
				if($('.product-images').hasClass('slick-initialized')) {
					$('.product-images').unslick();
				}
				$('.product-images').slick({
					slidesToShow: parseInt($('.product-images').attr('data-thumb')),
					slidesToScroll: 1,
					vertical: $('.product-images').attr('data-thumbtype') == "false" ? false : true,
					infinite: false,
					arrows: true,
					responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 4,
					  }
					},
					{
					  breakpoint: 992,
					  settings: {
						slidesToShow: 3,
					  }
					},
					{
					  breakpoint: 768,
					  settings: {
						slidesToShow: 3,
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 3,
					  }
					},
					{
					  breakpoint: 479,
					  settings: {
						slidesToShow: 1,
					  }
					},
					]
				});
			}
			$('.product-images').slick('getSlick').reinit();
		}
		
		var _interval = setInterval(function() {
		if($('.quickview.in').is(':visible')) {
			clearInterval(_interval);
				_forProductDetail();
			}    
		}, 100);
	});
</script>
