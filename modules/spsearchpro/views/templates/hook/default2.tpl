{*
 * package   SP Search Pro
 *
 * @version 1.1.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}

{if isset($list) && !empty($list)}
    {if isset($list) && !empty($list)}
        {foreach from=$list item=items}
            {assign var="moduleclass_sfx" value=( isset( $items->params.moduleclass_sfx ) ) ?  $items->params.moduleclass_sfx : ''}
            {assign var="tag_id" value="sp_search_pro_{$items->id_spsearchpro}"}
            <div class="spSearchPro {$moduleclass_sfx|escape:'html':'UTF-8'}">
                {if $items->params.display_title_module}
                    <div class="title-module-search-pro">
                        {$items->title_module[$id_lang]|escape:'html':'UTF-8'}
                    </div>
                {/if}
				{if $items->params.display_box_select}
                    {assign var="display_box_select" value=" show-box"}
                {else}
                    {assign var="display_box_select" value=" hidden-box"}
                {/if}
                {$category = $items->category}
                <div id="{$tag_id|escape:'html':'UTF-8'}" class="spr-container spr-preload"
					data-id_lang = "{$id_lang}"
					data-module_link = "{$search_controller_url}"
					data-basedir = "{$baseDir}"
					{foreach from=$items->params item=param key=k} 
						data-{$k} = "{$param}" 
					{/foreach}
				>
                    {*<div class="spr-loading"></div>*}
                    <form class="sprsearch-form {$display_box_select|escape:'html':'UTF-8'}" method="get" action="{$search_controller_url}">
							<input type="hidden" name="controller" value="search">
							<div class="spr_selector">
								{if $items->params.display_box_select == 1}
								<div class="spr_selector">
									<label class="fa fa-angle-down"></label>
									<span class="searchproLabel">{l s='All Categories' mod='spsearchpro'}</span>
									{$category nofilter}
								</div>
								{/if}
							</div>
						<div class="content-search">	
                            <input class="spr-query" type="text" name="s"
                                   value="{$search_string}"
                                   placeholder="{l s='Search Product...' mod='spsearchpro'}"/>
                            <button value="{l s='Search' mod='spsearchpro'}" class="spr-search-button" type="submit" name="spr_submit_search">
                                <i class="fa fa-search"></i>
                            </button>
						</div>
                    </form>
                </div>
            </div>
        {/foreach}
    {else}
        {l s='Has no content to show! In Module SP Search Pro' d='Shop.Theme'}
    {/if}
{/if}


