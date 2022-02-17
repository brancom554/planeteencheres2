<div {if isset($SP_moreinfo) && $SP_moreinfo == 'tab'} class="tab-pane{if !$product.description} in active{/if}"  {/if} id="product-details">

    {*{block name='product_features'}
      {if $product.features}
        <section class="product-features">
          <dl class="data-sheet">
            {foreach from=$product.features item=feature}
              <dt class="name">{$feature.name}</dt>
              <dd class="value">{$feature.value}</dd>
            {/foreach}
          </dl>
        </section>
      {/if}
    {/block}*}
    
    {if isset($SP_product_sku) && $SP_product_sku}
        {block name='product_reference'}
            {if isset($product.reference_to_display)}
                <div class="product-reference">
                    <label class="label">{l s='Reference:' d='Shop.Theme.Catalog'} </label>
                    <span itemprop="sku">{$product.reference_to_display}</span>
                </div>
            {/if}
        {/block}
    {/if}

    {block name='product_quantities'}
        {if $product.show_quantities}
            <div class="product-quantities">
                <label class="label">{l s='In stock:' d='Shop.Theme.Catalog'}</label>
                <span>{$product.quantity} {$product.quantity_label}</span>
            </div>
        {/if}
    {/block}

    {block name='product_availability_date'}
        {if $product.availability_date}
            <div class="product-availability-date">
                <label>{l s='Availability date:' d='Shop.Theme.Catalog'} </label>
                <span>{$product.availability_date}</span>
            </div>
        {/if}
    {/block}

    {block name='product_out_of_stock'}
        <div class="product-out-of-stock">
            {hook h='actionProductOutOfStock' product=$product}
        </div>
    {/block}
    
    {block name='product_condition'}
      {if $product.condition}
        <div class="product-condition">
          <label class="label">{l s='Condition' d='Shop.Theme.Catalog'} </label>
          <link itemprop="itemCondition" href="{$product.condition.schema_url}"/>
          <span>{$product.condition.label}</span>
        </div>
      {/if}
    {/block}
    
    {if isset($SP_product_shortdesc) && $SP_product_shortdesc}
        {block name='product_description_short'}
            <div id="product-description-short-{$product.id}" class="product-short-description" itemprop="description">{$product.description_short nofilter}</div>
        {/block}
    {/if}

    {* if product have specific references, a table will be added to product details section *}
    {block name='product_specific_references'}
      {if isset($product.specific_references)}
        <section class="product-features">
          <h3 class="h6">{l s='Specific References' d='Shop.Theme.Catalog'}</h3>
            <dl class="data-sheet">
              {foreach from=$product.specific_references item=reference key=key}
                <dt class="name">{l s=$key d='Shop.Theme.Catalog'}</dt>
                <dd class="value">{$reference}</dd>
              {/foreach}
            </dl>
        </section>
      {/if}
    {/block}

									
							 
									   
																					   
																				 
												 
			  
		   
			
</div>
