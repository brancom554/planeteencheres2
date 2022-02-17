{*
 * @package SP Banner
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}


{if isset($list) && !empty($list)}
    {foreach from=$list item=item}
        {assign var="moduleclass_sfx" value=( isset( $item.params.moduleclass_sfx ) ) ?  $item.params.moduleclass_sfx : ''}
		{assign var="effect_sfx" value=( isset( $item.banner_effect ) ) ?  $item.banner_effect : ''}
        {math equation='rand()' assign='rand'}
        {assign var='randid' value="now"|strtotime|cat:$rand}
        {assign var="uniqued" value="sp_banner_{$item.id_spbanner}_{$randid}"}
        <div class="{$moduleclass_sfx|escape:'html':'UTF-8'} {$effect_sfx|escape:'html':'UTF-8'}  spbanner">
            {if isset($item.params.display_title_module) && $item.params.display_title_module && !empty($item.title_module)}
                <h3>
                    {$item.title_module|escape:'html':'UTF-8'}
                </h3>
            {/if}
			{if isset($item.image)}
			<a href="{if $item.banner_link}{$item.banner_link|escape:'htmlall':'UTF-8'}{else}{if isset($force_ssl) && $force_ssl}{$urls.base_url_ssl}{else}{$urls.base_url}{/if}{/if}" title="{$item.title_module|escape:'htmlall':'UTF-8'}">			
				<img class="img-responsive" src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`spbanner/images/`$item.image|escape:'htmlall':'UTF-8'`")}" alt="{$item.title_module|escape:'html':'UTF-8'}" title="{$item.title_module|escape:'html':'UTF-8'}"/>
			</a> 
			{/if}	
            {if isset($item.content) && !empty($item.content)}
                <div>
                   {$item.content}
                </div>
            {/if}
        </div>
    {/foreach}
{/if}
