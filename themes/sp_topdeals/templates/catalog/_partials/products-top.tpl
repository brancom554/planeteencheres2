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
<div id="js-product-list-top" class="js-product-list products-selection clearfix">
	{block name='grid-list'}
		{include file='catalog/_partials/miniatures/grid-list.tpl'}
	{/block}
	
	{block name='sort_by'}
		{include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
	{/block}
	
	<!--{if !empty($listing.rendered_facets)}
		<div class="hidden-lg-down filter-button">
		  <button id="search_filter_toggler" class="btn btn-secondary">
			{l s='Filter' d='Shop.Theme.Actions'}
		  </button>
		</div>
	{/if}-->

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
