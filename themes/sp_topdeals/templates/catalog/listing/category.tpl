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
{extends file='catalog/listing/product-list.tpl'}

{block name='product_list_header'}
    <div class="block-category card card-block hidden-sm-down">
		{if isset($SP_categoryImage) && $SP_categoryImage}
			{if $category.image.large.url} 
				<div class="category-cover">
				  <img src="{$category.image.large.url}" alt="{$category.image.legend}">
				</div>
			{/if}
		{/if}

		{if isset($SP_categoryDes) && $SP_categoryDes}
			{if $category.description}
				<div id="category-description" class="text-muted">{$category.description nofilter}</div>
			{/if}
		{/if}

		{if isset($SP_categoryTitle) && $SP_categoryTitle}
			<h1 class="h1">{$category.name}</h1>
		{/if}
    </div>
	
    <div class="text-xs-center hidden-md-up">
      <h1 class="h1">{$category.name}</h1>
    </div>
	
	
	{block name='subcategories'}
		{if isset($SP_subCategory) && $SP_subCategory}
			<div class="block-subcategory">
				<h3 class="subcategory-heading">{l s='Subcategories'}</h3>
				<div class="row">
				
				{if isset($subcategories)}	
				{foreach from=$subcategories item=subcategory}
					<div class="{if $SP_subCategory == 1 && isset($SP_gridSubCategory)} col-md-{12/$SP_gridSubCategory}  {else} col-md-12 {/if} col-xs-6">
						<div class="subcategories-box">
							{if isset($SP_subCategoryImage) && $SP_subCategoryImage}
								<div class="subcategory-image">
									<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}" title="{$subcategory.name|escape:'html':'UTF-8'}" class="img">
									{if $subcategory.id_image}
										<img class="replace-2x" src="{$link->getCatImageLink($subcategory.link_rewrite, $subcategory.id_image)}" alt="" />
									{else}
										<img class="replace-2x" src="{$img_cat_dir}default-medium_default.jpg" alt=""  />
									{/if}
									</a>
								</div>
							{/if}
							
							{if isset($SP_subCategoryTitle) && $SP_subCategoryTitle}
								<h4 class="subcategory-name">
									<a  href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}">
										{$subcategory.name|truncate:25:'...'|escape:'html':'UTF-8'|truncate:350}
									</a>
								</h4>
							{/if}
							
							{if isset($SP_subCategoryDes) && $SP_subCategoryDes}
								<div class="subcategory-desc">{$subcategory.description nofilter}</div>
							{/if}
						</div>
					</div>
				{/foreach}
				{/if}
				</div>
			</div>
		{/if}
	{/block}
	
{/block}

