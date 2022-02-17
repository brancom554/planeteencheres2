{*
 * @package SP Listing Tabs
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}
<div class="ltabs-tabs-wrap">
    <span class="ltabs-tab-selected"></span>
    <span class="ltabs-tab-arrow">&#9660;</span>
    <ul class="ltabs-tabs cf">
        {foreach $_list as $tab}
            {assign var="tab_sel" value=(isset($tab['sel']) && $tab['sel'] == 'sel')?'  tab-sel tab-loaded' : ''}
            {assign var="tab_all" value=($tab['id_category'] == '*')?' tab-all':''}
            {assign var="active_content" value=($tab['id_category'] == '*')?'all':$tab['id_category'] }
            {if $items->params.filter_type == 'categories'}
                <li class="ltabs-tab {$tab_sel|escape:'html':'UTF-8'} {$tab_all|escape:'html':'UTF-8'}"
                    data-category-id="{$tab['id_category']|escape:'html':'UTF-8'}"
                    data-active-content=".items-category-{$active_content|escape:'html':'UTF-8'}">
                    {if $items->params.display_icon == 1}
                        {if $tab['id_category'] != '*' }
                            {if $tab.image}
                                <div class="ltabs-tab-img">
                                    {assign var="src" value=($items->params.cat_image_size != 'none') ? {$link->getCatImageLink($tab.link_rewrite, $tab.id_category, $items->params.cat_image_size)|escape:'html':'UTF-8'} :  {$link->getCatImageLink($tab.link_rewrite, $tab.id_category)|escape:'html':'UTF-8'}}
                                    <img src="{$src}" alt="{$tab['name']|escape:'html':'UTF-8'}"/>
                                </div>
                            {/if}
                        {else}
                            <div class="ltabs-tab-img">
                                <img class="cat-all" src="{$urls.base_url|escape:'html':'UTF-8'}/modules/splistingtabs/views/img/icon-catall.png"
                                     title="{$tab['name']|escape:'html':'UTF-8'}" alt="{$tab['name']|escape:'html':'UTF-8'}"
                                     style="width: 36px; height:77px;"/>
                            </div>
                        {/if}
                    {/if}
                    <span class="ltabs-tab-label">
                        {$tab['name']|escape:'html':'UTF-8'}
					</span>
                </li>
            {else}
                <li class="ltabs-tab {$tab_sel|escape:'html':'UTF-8'}"
                    data-category-id="{$tab['id_category']|escape:'html':'UTF-8'}"
                    data-active-content=".items-category-{$active_content|escape:'html':'UTF-8'}">
					<span class="ltabs-tab-label">
                        {$tab['name']|escape:'html':'UTF-8'}
			        </span>
                </li>
            {/if}
        {/foreach}
    </ul>
</div>
