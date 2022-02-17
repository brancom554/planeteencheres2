{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- Block Newsletter module -->
<div id="newsletter_block_home">
	<div class="row">
		<div class="col-md-6">
			<div class="title-block">
				<h3>{l s='NEED HELP? CALL OUR AWARD-WINNING' d='Shop.Theme'}</h3>
				<p>{l s='SUPPORT TEAM 24/7 AT (844) 555-8386' d='Shop.Theme'}</p>
			</div>
		</div>
		<div class="col-md-6">
			<div class="block_content clearfix">
				<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
					<div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}" >
						<div class="input">
							<input class="inputNew grey newsletter-input" size="80" id="newsletter-input" type="text" name="email"  placeholder="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{else}{l s='Enter your email' mod='spblocknewsletter'}{/if}" />
						</div>
						<button type="submit" name="submitNewsletter" class="btn btn-default button button-small">
							{l s='Subscribe' d='Shop.Theme'}
						</button>
						<input type="hidden" name="action" value="0" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Block Newsletter module-->
