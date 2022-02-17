{*
 * @package SP Footer Links
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}
{if isset($list) && !empty($list)}
    {foreach from=$list item=item}
        {assign var="moduleclass_sfx" value=( isset( $item.params.moduleclass_sfx ) ) ?  $item.params.moduleclass_sfx : ''}
        {math equation='rand()' assign='rand'}
        {assign var='randid' value="now"|strtotime|cat:$rand}
        {assign var="uniqued" value="sp_customhtml_{$item.id_spfooterlinks}_{$randid}"}
        <div class="{$uniqued|escape:'html':'UTF-8'}
		{$moduleclass_sfx|escape:'html':'UTF-8'}  spfooterlinks">
            {if isset($item.params.display_title_module) && $item.params.display_title_module && !empty($item.title_module)}
                <h4 class="title-footer">
                    {$item.title_module|escape:'html':'UTF-8'}
                </h4>
            {/if}
			{if isset($item.content) && $item.content}
				<ul class="links">
					{foreach from=$item['content']['link'][{$id_lang}] item=link key=k}
						{if $item['content']['text'][{$id_lang}][{$k}] || $link}
							{if !empty($item['content']['text'][$id_lang]) && !empty($link)}
								{assign var="text_link" value=$item['content']['text'][{$id_lang}][{$k}]}
								<li>
									<a href="{$link}">{$text_link}</a>
								</li>
							{/if}
						{/if}
					{/foreach}
				</ul>
			{/if}		
        </div>
    {/foreach}
{/if}