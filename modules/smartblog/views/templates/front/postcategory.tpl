{extends file=$layout}
{block name='content'}
    <section id="main">
        {block name='page_header_container'}
            <h2 class="smartBlogCatTitle">{$title_category}</h2>
        {/block}    
        {block name='page_content_container'}
            <section id="content" class="page-content">
                {if $postcategory == ''}
                    {if $title_category != ''}
                         <p class="error">{l s='No Post in Category' mod='smartblog'}</p>
                    {else}
                         <p class="error">{l s='No Post in Blog' mod='smartblog'}</p>
                    {/if}
                {else}
                    {if $smartdisablecatimg == '1'}
                        {assign var="activeimgincat" value='0'}
                        {$activeimgincat = $smartshownoimg} 
                        {if $title_category != ''}        
                           {foreach from=$categoryinfo item=category}
                            <div id="sdsblogCategory">
                               {if ($cat_image != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                                   <img alt="{$category.meta_title}" src="{$modules_dir}/smartblog/images/category/{$cat_image}-home-default.jpg" class="imageFeatured">
                               {/if}
                                {$category.description}
                            </div>
                             {/foreach}  
                        {/if}
                    {/if}
                    <div id="smartblogcat" class="block">
                        {foreach from=$postcategory item=post}
                            {include file="module:smartblog/views/templates/front/category_loop.tpl" postcategory=$postcategory}
                        {/foreach}
                    </div>
                    {if !empty($pagenums)}
                        <div class="row">
                            <div class="post-page col-md-12">
                                <div class="col-md-6">
                                    <ul class="pagination">
                                        {for $k=0 to $pagenums}
                                            {if $title_category != ''}
                                                {assign var="options" value=null}
                                                {$options.page = $k+1}
                                                {$options.id_category = $id_category}
                                                {$options.slug = $cat_link_rewrite}
                                            {else}
                                                {assign var="options" value=null}
                                                {$options.page = $k+1}
                                            {/if}
                                            {if ($k+1) == $c}
                                                <li><span class="page-active">{$k+1}</span></li>
                                            {else}
                                                    {if $title_category != ''}
                                                        <li><a class="page-link" href="{smartblog::GetSmartBlogLink('smartblog_category_pagination',$options)}">{$k+1}</a></li>
                                                    {else}
                                                        <li><a class="page-link" href="{smartblog::GetSmartBlogLink('smartblog_list_pagination',$options)}">{$k+1}</a></li>
                                                    {/if}
                                            {/if}
                                       {/for}
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="results">{l s="Showing" mod="smartblog"} {if $limit_start!=0}{$limit_start}{else}1{/if} {l s="to" mod="smartlatestnews"} {if $limit_start+$limit >= $total}{$total}{else}{$limit_start+$limit}{/if} {l s="of" mod="smartblog"} {$total} ({$c} {l s="Pages" mod="smartblog"})</div>
                                </div>
                            </div>
                        </div> 
                    {/if}
                {/if}
                {if isset($smartcustomcss)}
                    <style>
                        {$smartcustomcss}
                    </style>
                {/if}
            </section>
        {/block}
        {block name='page_footer_container'}
            
        {/block}
    </section>
{/block}