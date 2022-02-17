{*
 * Classic theme doesn't use this subtemplate, feel free to do whatever you need here.
 * This template is generated at each ajax calls.
 * See ProductListingFrontController::getAjaxProductSearchVariables()
 *}
<div id="js-product-list-bottom" class="products-selection clearfix">
	<!--
		<div class="hidden-sm-down total-products">
			 {if $listing.products|count > 1}
				{l s='There are %product_count% products.' d='Shop.Theme.Catalog' sprintf=['%product_count%' => $listing.products|count]}
			{else}
				{l s='There is %product_count% product.' d='Shop.Theme.Catalog' sprintf=['%product_count%' => $listing.products|count]}
			{/if}
		</div>
		
		{block name='sort_by'}
			{include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
		{/block}
	-->

    {block name='pagination'}
    	{if $listing.pagination.total_items > $listing.products|count}
        	{include file='_partials/pagination.tpl' pagination=$listing.pagination}
        {/if}
    {/block}
	
	{if !empty($listing.rendered_facets)}
		<div class="hidden-md-up filter-button">
		  <button id="search_filter_toggler" class="btn btn-secondary">
			{l s='Filter' d='Shop.Theme.Actions'}
		  </button>
		</div>
	{/if}

	<div class="text-xs-center showing">
		{l s='Show' d='Shop.Theme.Catalog' sprintf=[
		'%from%' => $listing.pagination.items_shown_from
		]}
		<span>{l s='%to% ' d='Shop.Theme.Catalog' sprintf=[
		'%to%' => $listing.pagination.items_shown_to
		]}</span>
		{l s='Items of' d='Shop.Theme.Catalog' sprintf=[
		'%to%' => $listing.pagination.items_shown_to
		]}
		<span>{l s='%total% item(s)' d='Shop.Theme.Catalog' sprintf=[
		'%total%' => $listing.pagination.total_items
		]}</span>
	</div>
</div>
