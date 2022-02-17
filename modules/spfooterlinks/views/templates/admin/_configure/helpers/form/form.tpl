{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'file_lang'}
		<div class="content_text">
			<div class="row content_row hidden cleafix" style="padding-bottom:5px">
				<div class="col-lg-2">{l s='Text - Link' d='spfooterlinks'}</div>
				{foreach from=$languages item=language}			
					{if $languages|count > 1}
						<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
					{/if}
						<div class="col-lg-3">
							<div class="input-group">
								<input id="{$input.name}_text_{$language.id_lang}" type="text" name="{$input.name}[text][{$language.id_lang}][]"/>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="input-group">
								<input id="{$input.name}_link_{$language.id_lang}" type="text" name="{$input.name}[link][{$language.id_lang}][]"/>
							</div>
						</div>
					{if $languages|count > 1}
						<div class="col-lg-2">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
								{$language.iso_code}
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{foreach from=$languages item=lang}
								<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
								{/foreach}
							</ul>
						</div>
					{/if}
					{if $languages|count > 1}
						</div>
					{/if}
				{/foreach}
				
				<div class="col-lg-1">
					<a class="remove_row">
						<i class="material-icons pull-left">remove_circle_outline</i>	
					</a>
				</div>				
			</div>			
			{if isset($fields_value['content']) && $fields_value['content']}
				{foreach from=$fields_value['content']['link'][{$language.id_lang}] item=link key=k}
				{if $fields_value['content']['text'][{$language.id_lang}][{$k}] || $link}
					<div class="row content_row cleafix" style="padding-bottom:5px">
						<div class="col-lg-2">{l s='Text - Link' d='spfooterlinks'}</div>
						{foreach from=$languages item=language}			
							{if $languages|count > 1}
								<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
							{/if}
								<div class="col-lg-3">
									<div class="input-group">
										<input  type="text" name="{$input.name}[text][{$language.id_lang}][]" value="{$fields_value['content']['text'][{$language.id_lang}][{$k}]}"/>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="input-group">
										<input type="text" name="{$input.name}[link][{$language.id_lang}][]" value="{$fields_value['content']['link'][{$language.id_lang}][{$k}]}"/>
									</div>
								</div>
							{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
											<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
							{/if}
							{if $languages|count > 1}
								</div>
							{/if}
						{/foreach}
						
						<div class="col-lg-1">
							<a class="remove_row">
								<i class="material-icons pull-left" style="cursor: pointer;">remove_circle_outline</i>	
							</a>
						</div>				
					</div>
				{/if}
				{/foreach}			
			{/if}
		</div>
		<a class="add_row">
			<i class="material-icons pull-left" style="cursor: pointer;">add_circle_outline</i>	
		</a>
		<script>
		$(document).ready(function(){	
			_eventClick();
			_eventRemove();
		});
		
		function _eventClick(){
			$( ".add_row" ).click(function() {
				var html = $(".content_text div").first().clone().removeClass('hidden').appendTo( ".content_text" );
				_eventRemove();
			});
			
		}
		
		function _eventRemove(){
			$( ".remove_row" ).click(function() {
				$(this).closest('.content_row').remove();
			});				
		}
		
		</script>		
	{/if}
	{$smarty.block.parent}
{/block}
