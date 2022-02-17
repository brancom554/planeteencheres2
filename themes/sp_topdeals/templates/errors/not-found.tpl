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
<section id="content" class="page-content page-not-found">
		<div class="content">
			<h1 class="title-404">Oops <span>404</span> page !</h1>
			<p>It's looking like you may have taken a wrong turn.Don't worry...it happens to the best of us.</p>
			<p>If you want go back to my store. Please in put the box below</p>
			<form action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="post" class="std">
				<fieldset>
					<div>
						<input id="search_query" name="search_query" type="text" class="form-control grey" placeholder="What were you looking for ?" />
						<button type="submit" name="Submit" value="OK" class="btn btn-default button button-small">SUBSCRIBE</button>
					</div>
				</fieldset>
			</form>
			<div>
				<a class="backtohome" href="{$urls.base_url}" title="{l s='Home'}">{l s='Back to Home'} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
			</div>
		</div>
</section>
