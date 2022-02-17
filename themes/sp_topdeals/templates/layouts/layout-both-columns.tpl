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
<!doctype html>
	<html lang="{$language.iso_code}">
  	<head>
    	{block name='head'}
      		{include file='_partials/head.tpl'}
    	{/block}
  	</head>
  	{if $SP_secondimg == 0}{assign var='hiddenProductSecondImage' value='hide-productsecondimage'}{else}{assign var='hiddenProductSecondImage' value=''}{/if}
  	<body id="{$page.page_name}" class="{$page.body_classes|classnames}	{$SP_layoutStyle} {$hiddenProductSecondImage} {$SP_productZoomType}">
    	{hook h='displayAfterBodyOpeningTag'}
    	<main>
      		{block name='product_activation'}
        		{include file='catalog/_partials/product-activation.tpl'}
      		{/block}
       		<header id="header">
				{if isset($SP_headerStyle)}
					{include file="_partials/header/$SP_headerStyle.tpl"}
				{else}
					{include file="_partials/header/header-v1.tpl"}
				{/if}
      		</header>
      		{block name='notifications'}
        		{include file='_partials/notifications.tpl'}
      		{/block}
      		<section id="wrapper">
				{if $page.page_name == 'index'}
						{block name="left_column"}
							<div id="left-column" class="col-xs-12 col-md-4 col-lg-3">
								{hook h="displayLeftColumn"}
							</div>
						{/block}
						{block name="content_wrapper"}
							<div id="content-wrapper" class="left-column col-xs-12 col-md-8 col-lg-9">
								{block name="content"}
										<p>Hello world! This is HTML5 Boilerplate.</p>
								{/block}
							</div>
						{/block}
					  	{block name="right_column"}
							<div id="right-column" class="col-xs-12 col-md-4 col-lg-3">
								{hook h="displayRightColumn"}
							</div>
					  	{/block}

				{elseif $page.page_name == 'module-smartblog-category'}
						<div class="container">
							{block name='breadcrumb'}
								{include file='_partials/breadcrumb.tpl'}
							{/block}
							<div class="row">
									<div id="left-column" class="col-xs-12 col-md-4 col-lg-3">
											{hook h="displayLeftColumn"}
									</div>
									<div id="content-wrapper" class="left-column col-xs-12 col-md-8 col-lg-9">
										{block name="content"}
												<p>Hello world! This is HTML5 Boilerplate.</p>
										{/block}
									</div>
							</div>
						</div>
					{elseif $page.page_name == 'module-smartblog-details'}
						<div class="container">
							{block name='breadcrumb'}
								{include file='_partials/breadcrumb.tpl'}
							{/block}
							<div class="row">
									<div id="left-column" class="col-xs-12 col-md-4 col-lg-3">
											{hook h="displayLeftColumn"}
									</div>
									<div id="content-wrapper" class="left-column col-xs-12 col-md-8 col-lg-9">
										{block name="content"}
												<p>Hello world! This is HTML5 Boilerplate.</p>
										{/block}
									</div>
							</div>
						</div>
					{else}
						<div class="container">
							{block name='breadcrumb'}
								{include file='_partials/breadcrumb.tpl'}
							{/block}
							<div class="row">
								{block name="left_column"}
									<div id="left-column" class="col-xs-12 col-md-4 col-lg-3">
										{if $page.page_name == 'product'}
											{hook h='displayLeftColumn'}
										{else}
											{hook h="displayLeftColumn"}
										{/if}
									</div>
								{/block}
								{block name="content_wrapper"}
									<div id="content-wrapper" class="left-column col-xs-12 col-md-8 col-lg-9">
										{block name="content"}
												<p>Hello world! This is HTML5 Boilerplate.</p>
										{/block}
									</div>
								{/block}
							  	{block name="right_column"}
									<div id="right-column" class="col-xs-12 col-md-4 col-lg-3">
										{if $page.page_name == 'product'}
											{hook h='displayLeftColumn'}
										{else}
											{hook h="displayRightColumn"}
										{/if}
									</div>
							  	{/block}
							</div>
						</div>
				{/if}
	      	</section>
	      	<footer id="footer">
				{if isset($SP_footerStyle)}
					{include file="_partials/footer/$SP_footerStyle.tpl"}
				{else}
					{include file="_partials/footer/footer-v1.tpl"}
				{/if}
	      	</footer>
	    </main>
		{block name='javascript_bottom'}
		  {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
		{/block}
    	{hook h='displayBeforeBodyClosingTag'}
    	{if $SP_showCpanel}
			{include file="_partials/sp-cpanel.tpl"}
		{/if}
		{hook h='displayNewLetterPopup'}
  	</body>
</html>
