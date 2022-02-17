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
<link href="{$urls.css_url}fonts/font-awesome.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$urls.css_url}sp_lib/owl.carousel.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$urls.css_url}sp_lib/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
{foreach $stylesheets.external as $stylesheet}
  	<link rel="stylesheet" href="{$stylesheet.uri}" type="text/css" media="{$stylesheet.media}">
{/foreach}
{foreach $stylesheets.inline as $stylesheet}
  	<style>
    	{$stylesheet.content}
  	</style>
{/foreach}
