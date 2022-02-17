{*
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}
 
<tr class="comparison_header">
	<td>
		{l s='Comments' mod='productcomments'}
	</td>
	{section loop=$list_ids_product|count step=1 start=0 name=td}
		<td></td>
	{/section}
</tr>

{foreach from=$grades item=grade key=grade_id}
<tr>
	{cycle values='comparison_feature_odd,comparison_feature_even' assign='classname'}
	<td class="{$classname}">
		{$grade}
	</td>

	{foreach from=$list_ids_product item=id_product}
		{assign var='tab_grade' value=$product_grades[$grade_id]}
		<td  width="{$width}%" class="{$classname} comparison_infos ajax_block_product" align="center">
		{if isset($tab_grade[$id_product]) AND $tab_grade[$id_product]}
			{section loop=6 step=1 start=1 name=average}
				<input class="auto-submit-star" disabled="disabled" type="radio" name="{$grade_id}_{$id_product}_{$smarty.section.average.index}" {if isset($tab_grade[$id_product]) AND $tab_grade[$id_product]|round neq 0 and $smarty.section.average.index eq $tab_grade[$id_product]|round}checked="checked"{/if} />
			{/section}
		{else}
			-
		{/if}
		</td>
	{/foreach}
</tr>				
{/foreach}

	{cycle values='comparison_feature_odd,comparison_feature_even' assign='classname'}
<tr>
	<td  class="{$classname} comparison_infos">{l s='Average' mod='productcomments'}</td>
{foreach from=$list_ids_product item=id_product}
	<td  width="{$width}%" class="{$classname} comparison_infos" align="center" >
	{if isset($list_product_average[$id_product]) AND $list_product_average[$id_product]}
		{section loop=6 step=1 start=1 name=average}
			<input class="auto-submit-star" disabled="disabled" type="radio" name="average_{$id_product}" {if $list_product_average[$id_product]|round neq 0 and $smarty.section.average.index eq $list_product_average[$id_product]|round}checked="checked"{/if} />
		{/section}	
	{else}
		-
	{/if}
	</td>	
{/foreach}
</tr>

<tr>
	<td  class="{$classname} comparison_infos">&nbsp;</td>
	{foreach from=$list_ids_product item=id_product}
	<td  width="{$width}%" class="{$classname} comparison_infos" align="center" >
			{if isset($product_comments[$id_product]) AND $product_comments[$id_product]}
		<a href="#" rel="#comments_{$id_product}" class="cluetip">{l s='view comments' mod='productcomments'}</a>
		<div style="display:none" id="comments_{$id_product}"> 
		{foreach from=$product_comments[$id_product] item=comment}	
			<div class="comment">
				<div class="customer_name">
				{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}
						{$comment.customer_name|escape:'html':'UTF-8'}.
				</div> 
				{$comment.content|escape:'html':'UTF-8'|nl2br}
			</div>
			<br />
		{/foreach}
		</div>
	{else}
		-
	{/if}
	</td>	
{/foreach}
</tr>