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
{block name='content'}
    <section id="main">
        {block name='product_list_header'}
            <h2 class="h2">{$listing.label}</h2>
        {/block}
        {if $SP_catProductTitle == 0}{assign var='hiddenProductTitle' value='hide-producttitle'}{else}{assign var='hiddenProductTitle' value='displayTitle'}{/if}
        {if $SP_catProductDes == 0}{assign var='hiddenProductDesc' value='hide-productdesc'}{else}{assign var='hiddenProductDesc' value=''}{/if}
        {if $SP_catProductQuickview == 0}{assign var='hiddenProductQuickView' value='hide-productquickview'}{else}{assign var='hiddenProductQuickView' value=''}{/if}
        {if $SP_catProductPrice == 0}{assign var='hiddenProductPrice' value='hide-productprice'}{else}{assign var='hiddenProductPrice' value=''}{/if}
        {if $SP_catProductLabel == 0}{assign var='hiddenProductLabel' value='hide-productlabel'}{else}{assign var='hiddenProductLabel' value=''}{/if}
        {if $SP_catProductColor == 0}{assign var='hiddenProductColor' value='hide-productcolor'}{else}{assign var='hiddenProductColor' value=''}{/if}
        {if $SP_catProductStock == 0}{assign var='hiddenProductStock' value='hide-productstock'}{else}{assign var='hiddenProductStock' value=''}{/if}
        {if $SP_catProductCounter == 0}{assign var='hiddenProductCounter' value='hide-productcounter'}{else}{assign var='hiddenProductCounter' value=''}{/if}
        <section id="products" class="{$hiddenProductTitle} {$hiddenProductDesc} {$hiddenProductQuickView} 
                                        {$hiddenProductPrice} {$hiddenProductLabel} {$hiddenProductColor} 
                                        {$hiddenProductStock} {$hiddenProductCounter}">
            {if $listing.products|count}
                {block name='product_list_top'}
                    {include file='catalog/_partials/products-top.tpl' listing=$listing}
                {/block}
                {block name='product_list_active_filters'}
                    <div id="" class="hidden-sm-down">
                        {$listing.rendered_active_filters nofilter}
                    </div>
                {/block}
                <div id="">
                    {block name='product_list'}
                        {include file='catalog/_partials/products.tpl' listing=$listing}
                    {/block}
                </div>
                {block name='product_list_bottom'}
                    {include file='catalog/_partials/products-bottom.tpl' listing=$listing}
                {/block}
            {else}
                <h5 class="h5">{l s='There are no products.' d='Shop.Theme.Global'}</h5>
            {/if}
        </section>
    </section>
{/block}
