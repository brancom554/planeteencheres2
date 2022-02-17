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
													   
                    <form class="sprsearch-form {$display_box_select|escape:'html':'UTF-8'}" method="get" action="{$search_controller_url}">
							<input type="hidden" name="controller" value="search">
							{if $items->params.display_box_select == 1}
							<div class="spr_selector">
												   
								  
								<label class="fa fa-sort-desc"></label>
								{*<span class="searchproLabel">{l s='All Categories' d='Shop.Theme.Actions'}</span>*}
								{$category nofilter}
			  
			 
							</div>
							{/if}
						<div class="content-search">	
                            <input class="spr-query" type="text" name="s"
                                   value="{$search_string}"
                                   placeholder="{l s='Enter your search...' d='Shop.Theme.Actions'}"/>
						</div>
						<button value="{l s='Search' d='Shop.Theme.Actions'}" class="spr-search-button" type="submit" name="spr_submit_search">
							<i class="fa fa-search"></i>						
							{l s='Search' d='Shop.Theme.Actions'}		
						</button>
                    </form>
                </div>
            </div>
        {/foreach}
    {else}
        {l s='Has no content to show! In Module SP Search Pro' d='Shop.Theme.Actions'}
    {/if}
{/if}


