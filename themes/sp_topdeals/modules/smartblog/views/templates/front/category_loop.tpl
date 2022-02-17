{assign var="options" value=null}
    {$options.id_post = $post.id_post}
    {$options.slug = $post.link_rewrite}
{assign var="catlink" value=null}
    {$catlink.id_category = $post.id_category}
    {$catlink.slug = $post.cat_link_rewrite}



<div class="sdsarticleItem col-lg-6 col-md-6 col-sm-12 clearfix">
    <div id="smartblogpost-{$post.id_post}">
            <div class="articleContent">
                <a title="{$post.meta_title}" class="imageFeaturedLink" href='{smartblog::GetSmartBlogLink('smartblog_post',$options)}'>
                    {assign var="activeimgincat" value='0'}
                    {$activeimgincat = $smartshownoimg} 
                    {if ($post.post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                        <img alt="{$post.meta_title}" src="{$modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg" class="imageFeatured">
                    {/if}
                </a>
                <div class="sdsarticle-text">
                    <div class="info-info">
	                    <div class="date_added"> 
	                        <span class="d" itemprop="dateCreated">{$post.created|date_format:"d"}</span>
	                        <span>/</span>
	                        <span class="m" itemprop="dateCreated">{$post.created|date_format:"M"}</span>
	                        <span class="y" itemprop="dateCreated">{$post.created|date_format:"Y"}</span>
	                    </div>
                        <div class="sdsarticleHeader">
                            <h3 class='sdsarticleTitle'>
                                <a title="{$post.meta_title}" href='{smartblog::GetSmartBlogLink('smartblog_post',$options)}'>
                                    {$post.meta_title}
                                </a>
                            </h3>
                        </div><!--end sdsarticleHeader -->

                        <div class="sdsarticleDescription">
                            <div class="clearfix">
                                {$post.short_description|truncate:110:'...'|escape:'htmlall':'UTF-8'}
                           </div>
                        </div>

                        <div class="sdsarticle-info">
                            <!--<i class="fa fa-user" aria-hidden="true"></i> &nbsp;-->
                            <span>Post by</span>
                            <span itemprop="author" class="author"> 
                                {if $smartshowauthorstyle != 0}
                                    {$post.firstname}{$post.lastname}
                                {else}
                                    Admin
                                {/if}
                            </span>
                            &nbsp; / &nbsp;
                            <span class="comment">
                                <!--<i class="fa fa-comments"></i>-->
                                &nbsp;
                                <a title="{$post.totalcomment} Comments" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}#articleComments">
                                    {$post.totalcomment} {l s='Comments' mod='smartblog'}
                                </a>
                            </span>
                            <!--
                                <div class="sdsarticleMeta">
                                        <span class="metaTag">
                                            <i class="fa fa-tags"></i>
                                            <a href="{smartblog::GetSmartBlogLink('smartblog_category',$catlink)}">
                                                {if $title_category != ''}
                                                    {$title_category}
                                                {else}
                                                    {$post.cat_name}
                                                {/if}
                                            </a>
                                        </span>
                                        {if $smartshowviewed ==1}
                                            <span class="metaView">
                                                <i class="fa fa-eye"></i>
                                                {l s='Views' d='Shop.Theme.Actions'} ({$post.viewed})
                                            </span>
                                        {/if}
                                </div>
                            -->
                        </div>
                        <!--<h3>
                            <a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="more">
                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                {l s='Read More' mod='smartblog'} 
                            </a>
                        </h3>-->
                    </div>
                </div>
            </div>
   </div>
</div>