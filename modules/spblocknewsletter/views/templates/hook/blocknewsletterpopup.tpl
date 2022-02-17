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
<div id="newsletter_block_popup">
	
	<div class="block_content clearfix">
		<div class="close"><i class="fa fa-times"></i></div>
		<div class="content-inner">
			<p class="icon-email"></p>
			<h3 class="title">{l s='Newsletter' mod='spblocknewsletter'}</h3>
			<p>
				{l s='Subscribe to the Styleshop mailing list to receive updates on new arrivals, special offers and other discount information.' mod='spblocknewsletter'}
			</p>
			<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post" id="newsletter-validate-detail-popup">
				<div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}" >
					<input class="inputNew grey newsletter-input" size="80" id="newsletter-inputpopup" type="text" name="email"  placeholder="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{else}{l s='Sign up for your email ...' mod='spblocknewsletter'}{/if}" />
					<button type="submit" name="submitNewsletter" class="btn btn-default button button-small">
						<i class="fa fa-paper-plane"></i>
					</button>
					<input type="hidden" name="action" value="0" />
				</div>
			</form>
			<div class="msg">
				<input type="checkbox" class="ckmsg"/>
				<label class="check_lable">Don't show this popup again</label>
			</div>
			<div class="social">
				<div class="title_social">{l s='follow us' mod='spblocknewsletter'}</div>
				<ul>
						<li class="social_icon icon_fb"><a href="https://www.facebook.com/MagenTech" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li class="social_icon icon_tw"><a href="https://twitter.com/magentech" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li class="social_icon icon_g"><a href="https://plus.google.com/u/0/+SmartAddons-Joomla-Magento-WordPress/posts" title="Google"><i class="fa fa-google-plus"></i></a></li>
						<li class="social_icon icon_dri"><a href="#" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
						<li class="social_icon icon_in"><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
					</ul>
			</div>
		</div>
	</div>
</div>
<!-- /Block Newsletter module-->
{strip}
{if isset($msg) && $msg}
{addJsDef msg_newsl=$msg|@addcslashes:'\''}
{/if}
{if isset($nw_error)}
{addJsDef nw_error=$nw_error}
{/if}
{addJsDefL name=placeholder_blocknewsletter}{l s='Your Email' mod='blocknewsletter' js=1}{/addJsDefL}
{if isset($msg) && $msg}
	{addJsDefL name=alert_blocknewsletter}{l s='Newsletter : %1$s' sprintf=$msg js=1 mod="blocknewsletter"}{/addJsDefL}
{/if}
{/strip}

<script type="text/javascript">
// <![CDATA[
	 $(document).ready(function($){
		$(".close").click(function(){
			$('#newsletter_block_popup').fadeOut('medium');
		});
	  
		$('.ckmsg').off('click').on('click', function(e){
			var  c = 'checked', isChecked = $("input.ckmsg").is(":" + c);
			var _checked = $("input.ckmsg:checked").length;
			var options = {};
			options.expires = 1; 
			if (_checked) {
				$.cookie('sp_news_letter',1, options);
			}else{
				$.cookie('sp_news_letter',null);
			}
		});
	  
		$('.check_lable').off('click').on('click', function(e){
			e.preventDefault();
			var  c = 'checked', isChecked = $("input.ckmsg").is(":" + c);
			isChecked ?  $("input.ckmsg").attr('checked', false) : $("input.ckmsg").attr('checked', true);
			var _checked = $("input.ckmsg:checked").length;
			_checked ?  $('.msg  span').addClass('checked') :  $('.msg  span').removeClass('checked', 'checked');
			var options = {};
				options.expires = 1; 
			if (_checked) {
				$.cookie('sp_news_letter',1, options);
			}else{
				$.cookie('sp_news_letter',null);
			}
		});
	 });
// ]]>
</script>