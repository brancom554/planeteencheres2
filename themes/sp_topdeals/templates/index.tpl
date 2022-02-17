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
{extends file='page.tpl'}
{block name='page_content_container'}
	{if isset($SP_contentStyle)}
		{if $SP_contentStyle == 'content-v1'}
			
			{include file="_partials/content/content-v1.tpl"}
			<div class="clearfix"></div>
		{elseif $SP_contentStyle == 'content-v2'}
			{include file="_partials/content/content-v2.tpl"}
			<div class="clearfix"></div>
		{elseif $SP_contentStyle == 'content-v3'}
			{include file="_partials/content/content-v3.tpl"}
			<div class="clearfix"></div>
		{elseif $SP_contentStyle == 'content-v4'}
			{include file="_partials/content/content-v4.tpl"}
			<div class="clearfix"></div>
		{elseif $SP_contentStyle == 'content-v5'}
			{include file="_partials/content/content-v5.tpl"}
			<div class="clearfix"></div>
		{/if}
	{else}
		{include file="_partials/content/content-v1.tpl"}
	{/if}
{/block}