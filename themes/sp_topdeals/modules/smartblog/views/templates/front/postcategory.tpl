{extends file=$layout}
{block name='content'}
    <section id="main" class="smartBlogPage">
        {block name='page_header_container'}
            {if $title_category != ''}<h2 class="smartBlogCatTitle">{$title_category}</h2>{/if}
        {/block}    
        {block name='page_content_container'}
            <section id="content" class="page-content">
                {if $postcategory == ''}
                    {if $title_category != ''}
                         <div class="alert alert-danger">{l s='No Post in Category' d='Shop.Theme.Actions'}</div>
                    {else}
                         <div class="alert alert-danger">{l s='No Post in Blog' d='Shop.Theme.Actions'}</div>
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
                    <div id="smartblogcat" class="clearfix">
                        <div class="row">
                            {foreach from=$postcategory item=post}
                                {include file="module:smartblog/views/templates/front/category_loop.tpl" postcategory=$postcategory}
                            {/foreach}
                        </div>
                    </div>
                    {if !empty($pagenums)}
                            <div class="post-page">
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
                                    <!--
                                    <div class="results">
                                        {l s="Showing" d="Shop.Theme"} {if $limit_start!=0}{$limit_start}{else}1{/if} {l s="to" d="Shop.Theme"} {if $limit_start+$limit >= $total}{$total}{else}{$limit_start+$limit}{/if} {l s="of" d="Shop.Theme"} {$total} ({$c} {l s="Pages" d="Shop.Theme"})
                                    </div>
                                    -->
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