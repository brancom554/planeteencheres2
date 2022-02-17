
<div class="smartblogcat-inner large_image">
	{foreach from=$postcategory item=post}
		<div itemtype="#" itemscope="" class="sdsarticleCat clearfix">
			<div id="smartblogpost-{$post.id_post}">
			<div class="articleContent">
			{assign var="options" value=null}
									{$options.id_post = $post.id_post} 
									{$options.slug = $post.link_rewrite}
				  <a itemprop="url" title="{$post.meta_title}" class="imageFeaturedLink" href='{smartblog::GetSmartBlogLink('smartblog_post',$options)}'>
							{assign var="activeimgincat" value='0'}
							{$activeimgincat = $smartshownoimg} 
							{if ($post.post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
					  <img itemprop="image" alt="{$post.meta_title}" src="{$modules_dir}/smartblog/images/{$post.post_img}.jpg" class="imageFeatured">
							{/if}
				  </a>
				  <div class="content-info"> 
					 
					  <div class="info"> 
						<div class="sdsarticleHeader">
							 {assign var="options" value=null}
												{$options.id_post = $post.id_post} 
												{$options.slug = $post.link_rewrite}
												<div class="sdstitle_block"><a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.meta_title}</a></div>
								 {assign var="options" value=null}
											{$options.id_post = $post.id_post}
											{$options.slug = $post.link_rewrite}
								   {assign var="catlink" value=null}
												{$catlink.id_category = $post.id_category}
												{$catlink.slug = $post.cat_link_rewrite}
							 
						</div>
						
						<div class="sdsarticle-info">
						<!--<span itemprop="author" class="author"><i class="fa fa-user"></i> {if $smartshowauthor ==1} {if $smartshowauthorstyle != 0}{$post.firstname}{$post.lastname}{else}{$post.lastname}{$post.firstname}{/if}</span>{/if}
						{$catlink.id_category = $post.id_category}
						{$catlink.slug = $post.cat_link_rewrite}
						{if isset($post.title_category) && !empty($post.title_category)}
							<span class="title_cateblog"><a  href="{smartblog::GetSmartBlogLink('smartblog_category',$catlink)}"><i class="fa fa-folder-open"></i>{$post.title_category}</a></span>
						{/if}-->
						<span class="date" itemprop="dateCreated">{$post.created|date_format:"%B %d, %Y"}</span>
						<span class="comment"> <a 
							title="Comment" 
							href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}#articleComments">
							{if $post.totalcomment > 1}
								{$post.totalcomment} {l s='Comments' mod='smartblog'}
							{else}
								{$post.totalcomment} {l s='Comment' mod='smartblog'}
							{/if}
						</a></span>
						</div>
						
						<!--<div class="date_added">{$post.created} </div>-->
						<div class="sdsarticle-des">
							  <span itemprop="description"><div id="lipsum">
							{$post.short_description|truncate:340:''}</div></span>
						</div>
						<!--<div class="read-more">
							<a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="more">{l s='Read more' mod='smartblog'}</a>	 
						</div>-->
					</div>
				</div>
			</div>
			   
		   </div>
		</div>
	{/foreach}
</div>