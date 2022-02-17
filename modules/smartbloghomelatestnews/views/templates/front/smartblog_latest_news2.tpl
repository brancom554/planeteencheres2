<div class="block lastestnews">
    <h3 class='title_block'>{l s='Lastet blogs' mod='smartbloghomelatestnews'}</h3>
    <ul class="lastest_posts">
        {if isset($view_data) AND !empty($view_data)}
            {assign var='i' value=1}
            {foreach from=$view_data item=post}
               
                    {assign var="options" value=null}
                    {$options.id_post = $post.id}
                    {$options.slug = $post.link_rewrite}
                    <li class="post">
						<div class="post-inner">
							<div class="post_image">
								 <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}"><img alt="{$post.title}" class="feat_img" src="{$modules_dir}smartblog/images/{$post.post_img}-home-default.jpg"></a>
								 <div class="date_added">
									<span class="month">{$post.date_added|date_format:"%b"}</span>
									<span class="day">{$post.date_added|date_format:"%d"}</span>
								 </div>
							</div>
							
							<div class="post_content">
								
								<div class="content-right">
									<div class="post_title"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title|truncate:20:''|escape:'htmlall':'UTF-8'}</a></div>
									
									<div class="desc">
										{$post.short_description|truncate:100:'...'|escape:'htmlall':'UTF-8'}
									</div>
									<div class="post-info">
										<!--<span class="author">
											<i class="fa fa-user"></i> {if $post.smartshowauthor ==1} {if $post.smartshowauthorstyle != 0}{$post.firstname}{$post.lastname}{/if}{/if}
										</span>
										<span class="view">
											<i class="fa fa-eye"></i> {$post.viewed} {if $post.viewed > 1} {l s='Views' mod='smartbloghomelatestnews'} {else} {l s='View' mod='smartbloghomelatestnews'} {/if}
										</span>-->
										<span class="comment">
											{if $post.countcomment < 10 || $post.countcomment >= 1}
												0{$post.countcomment}<i class="fa fa-comments"></i>
											{else}
												{$post.countcomment}<i class="fa fa-comments"></i>
											{/if}
										</span>
										<a class="readmore" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{l s='View more' mod='smartbloghomelatestnews'}</a>
									</div>
									
								</div>
							</div>
						</div>
                        
                        
                    </li>
                
                {$i=$i+1}
            {/foreach}
        {/if}
     </ul>
</div>

<script>// <![CDATA[
	jQuery(document).ready(function($) {
			$('.lastest_posts').owlCarousel({
				pagination: false,
				center: false,
				nav: true,
				loop: false,
				dots: false,
				margin: 30,
				navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
				slideBy: 1,
				autoplay: false,
				autoplayTimeout: 2500,
				autoplayHoverPause: true,
				autoplaySpeed: 800,
				startPosition: 0,
				responsive:{
					0:{
						items:1
					},
					480:{
						items:2
					},
					768:{
						items:2
					},
					1200:{
						items:3
					}
				}
			});
		});

	// ]]></script>
