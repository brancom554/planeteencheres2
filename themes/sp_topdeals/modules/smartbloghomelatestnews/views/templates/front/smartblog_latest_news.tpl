<div class="block lastestnews">
	<h3 class='title_blog'>
		{l s='Lastest from Blog' mod='smartbloghomelatestnews'}
	</h3>
    <ul class="lastest_posts">
        {if isset($view_data) AND !empty($view_data)}
            {assign var='i' value=1}
            {foreach from=$view_data item=post}
     
                    {assign var="options" value=null}
                    {$options.id_post = $post.id}
                    {$options.slug = $post.link_rewrite}
                    <li class="post clearfix">
						<div class="post-inner clearfix">
							<div class="post_image">
								 <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}"><img alt="{$post.title}" class="feat_img" src="{$modules_dir}smartblog/images/{$post.post_img}-home-small.jpg"></a>
							</div>
							<div class="post_content">
								<div class="info-info">
									<div class="sdsarticleHeader">
										<h5><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h5>
									</div>
									<div class="sdsarticle-info">
										<span>by</span>
										<span class="author">
											{if $post.smartshowauthorstyle != 0}
												{$post.firstname}{$post.lastname}
											{/if}
										</span>
										&nbsp;&nbsp;&nbsp;&nbsp;
								 		<div class="date_added">
								 			<i class="fa fa-calendar" aria-hidden="true"></i>
											<span class="d">{$post.date_added|date_format:"%d"}</span>
											<span class="m">{$post.date_added|date_format:"%b"}</span>
											<span class="m">{$post.date_added|date_format:"%Y"}</span>
									 	</div>
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

<!--<script>// <![CDATA[
	jQuery(document).ready(function($) {
			$('.lastest_posts').owlCarousel({
				pagination: false,
				center: false,
				nav: true,
				loop: true,
				dots: false,
				margin: 30,
				navText: [ '<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>' ],
				slideBy: 1,
				autoplay: true,
				autoplayTimeout: 2500,
				autoplayHoverPause: true,
				autoplaySpeed: 800,
				startPosition: 0, 
				responsive:{
					0:{
						items:1
					},
					481:{
						items:2
					},
					768:{
						items:2
					},
					992:{
						items:3
					},
					1200:{
						items:3
					}
				}
			});
		});

	// ]]></script>
	-->