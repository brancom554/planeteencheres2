
{extends file=$layout}
{block name='content'}
	<div id="content">
	   	<div id="sdsblogArticle" class="blogArticle" itemscope itemtype="http://schema.org/NewsArticle">
	   		<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article" content="mainEntityOfPage" />
	   		<meta itemprop="datePublished" content="{$post.created}"/>
		    <meta itemprop="dateModified" content="{$post.created}"/>
		    <div class="hidden-xs-up" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
		            <img alt="logo" src="{$shop.logo}"/>
		            <meta itemprop="url" content="{$shop.logo}">
		            {if isset($logo_image_width) && $logo_image_width}<meta itemprop="width" content="{$logo_image_width}">{/if}
		            {if isset($logo_image_height) && $logo_image_height}<meta itemprop="height" content="{$logo_image_height}">{/if}
		        </div>
		    </div>


	   		<div class="ariticleImage articleContent">
	   			<div class="articleImageContent" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
	                {assign var="activeimgincat" value='0'}
	                {$activeimgincat = $smartshownoimg}
	               	<img src="{$modules_dir}/smartblog/images/{$post_img}-single-default.jpg" alt="{$meta_title}">
			        <meta itemprop="url" content="{$modules_dir}/smartblog/images/{$post_img}-single-default.jpg">
				</div>
	   		</div>

			<div class="article-main">

		   		<div class="articleMeta sdsarticle-text">
	                <div class="date_added"> 
	                    <span class="d" itemprop="dateCreated">{$post.created|date_format:"d"}</span>
	                    <span>/</span>
	                    <span class="m" itemprop="dateCreated">{$post.created|date_format:"M"}</span>
	                    <span class="y" itemprop="dateCreated">{$post.created|date_format:"Y"}</span>
	                </div>
		   			<h1 class="articleTitle sdstitle_block title" itemprop="headline">{$meta_title}</h1>
				    <div class="metaComment article-info">
					 	{assign var="catOptions" value=null} 

					 	{$catOptions.id_category = $id_category}

						{$catOptions.slug = $cat_link_rewrite}

						<!--<i class="fa fa-user" aria-hidden="true"></i> &nbsp;-->

						<span>Post By:</span>

						<span class="author">
							{if $smartshowauthorstyle != 0}
								{$firstname} {$lastname}
							{else}
								Admin
							{/if}
						</span>

					 	&nbsp; / &nbsp;

				    	<span class="comment" title="{if {$countcomment} < 1 } 0 Comment {else} {$countcomment} Comment(s) {/if}" href="">
							{if $countcomment != 0}
								{$countcomment} {l s='Comment(s)' d='Shop.Theme.Actions'}
							{else}
								0 {l s='Comment' d='Shop.Theme.Actions'}
							{/if}
						</span>

						<!--
						<span class="viewed">
							{if $post.viewed > 1}
								{$post.viewed} {l s='Views' mod='smartblog'}
							{else}
								{$post.viewed} {l s='View' mod='smartblog'}
							{/if}
							<i class="fa fa-eye"></i> 
						</span>
						-->
				    </div>
		   		</div>

		   		<div class="sdsarticle-des" itemprop="description">
		   			{$content nofilter}
		   		</div>
				<div class="sharing-buttons">
					<!--<h5>{l s='Share' mod='smartblog'}</h5>-->
					<div class="buttons">
						<a href="https://www.facebook.com/SmartAddons.page" class="facebook"><i class="fa fa-facebook"></i> Facebook</a>
						<a href="https://twitter.com/smartaddons" class="twitter"><i class="fa fa-twitter"></i> Twitter</a>
						<a href="https://plus.google.com/u/0/+SmartAddons-Joomla-Magento-WordPress/posts" class="google"><i class="fa fa-google-plus"></i> Google Plus</a>
						<a href="#" class="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i> Tumblr</a>
					</div>
				</div>
			</div>
		</div>

      	<div class="articleBottom">
        	{$HOOK_SMART_BLOG_POST_FOOTER}
      	</div>

		{if $countcomment != ''}
		<div id="articleComments">
		        <h3>{l s=' Comments' mod='smartblog'} {if $countcomment != ''}({$countcomment}){else}{l s='0' mod='smartblog'}{/if}<span></span></h3>
		        <div id="comments">      
		            <div class="commentList">
		                  {$i=1}
		                {foreach from=$comments item=comment}
		                       {include file="./comment_loop.tpl" childcommnets=$comment}
		                  {/foreach}
		            </div>
		        </div>
		</div>
		 {/if}
	</div>

	<!--{if Configuration::get('smartenablecomment') == 1}
		{if $comment_status == 1}
			<div class="smartblogcomments" id="respond">
			    <h4 class="comment-reply-title" id="reply-title">
			    	{l s="Comments"  d='Shop.Theme.Actions'} <small style="float:right;">
			            <a style="display: none;" href="#respond" 
			                   id="cancel-comment-reply-link" class="remove" rel="nofollow">{l s="Cancel Reply"  d='Shop.Theme.Actions'}</a></small>
			    </h4>
				<div id="commentInput">
	            	<form action="/" method="post" id="commentform">
	            		<div class="row">
							<div class="col-xs-12 col-sm-6 input name fl">
								<input type="text" tabindex="1" placeholder="Name" class="inputName form-control grey" value="" name="name">																	
							</div>
							<div class="col-xs-12 col-sm-6 input email fr">
								<input type="text" tabindex="2" placeholder="Email" class="inputMail form-control grey" value="" name="mail">
							</div>
						</div>
						<div class="clearfix content">
							<textarea tabindex="4" placeholder="Your Comment" class="inputContent form-control grey" rows="8" cols="50" name="comment"></textarea>
						</div>
						<!--{if Configuration::get('smartcaptchaoption') == '1'}
							<div class="capcha">
								<div class="capchalabel">
									<span class="required">*</span> <b>{l s="Type Code" d='Shop.Theme.Actions'}</b> <br />
									<img alt="captcha" src="{$modules_dir}smartblog/classes/CaptchaSecurityImages.php?width=100&height=40&characters=5">
								</div>
								<input type="text" value="" name="smartblogcaptcha" class="smartblogcaptcha form-control grey">
							</div>
						{/if}
	                 	<input type='hidden' name='comment_post_ID' value='1478' id='comment_post_ID' />
	                  	<input type='hidden' name='id_post' value='{$id_post}' id='id_post' />
	                	<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
	        			<div class="submit">
	            			<input type="submit" name="addComment" id="submitComment" class="button btn btn-default button-medium" value="{l s='Send Us' d='Shop.Theme.Actions'}">
						</div>
	        		</form>
				</div>
			</div>
			<script type="text/javascript">
				$('#submitComment').bind('click',function(event) {
					event.preventDefault();

					var data = { 'action':'postcomment', 
						'id_post':$('input[name=\'id_post\']').val(),
						'comment_parent':$('input[name=\'comment_parent\']').val(),
						'name':$('input[name=\'name\']').val(),
						'website':$('input[name=\'website\']').val(),
						'smartblogcaptcha':$('input[name=\'smartblogcaptcha\']').val(),
						'comment':$('textarea[name=\'comment\']').val(),
						'mail':$('input[name=\'mail\']').val() };
					$.ajax( {
					  	url: baseDir + 'modules/smartblog/ajax.php',
					  	data: data,

					  	dataType: 'json',

					  	beforeSend: function() {
							$('.success, .warning, .error').remove();
							$('#submitComment').attr('disabled', true);
							$('#commentInput').before('<div class="attention"><img src="http://321cart.com/sellya/catalog/view/theme/default/image/loading.gif" alt="" />Please wait!</div>');


						},
						complete: function() {
							$('#submitComment').attr('disabled', false);
							$('.attention').remove();

						},
						success: function(json) {
							if (json['error']) {

								$('#commentInput').before('<div class="warning">' + '<i class="icon-warning-sign icon-lg"></i>' + json['error']['common'] + '</div>');

								if (json['error']['name']) {
									$('.inputName').after('<span class="error">' + json['error']['name'] + '</span>');

								}
								if (json['error']['mail']) {
									$('.inputMail').after('<span class="error">' + json['error']['mail'] + '</span>');

								}
								if (json['error']['comment']) {
									$('.inputContent').after('<span class="error">' + json['error']['comment'] + '</span>');
								}
								if (json['error']['captcha']) {
									$('.smartblogcaptcha').after('<span class="error">' + json['error']['captcha'] + '</span>');
								}
							}
							if (json['success']) {
								$('input[name=\'name\']').val('');
								$('input[name=\'mail\']').val('');
								$('input[name=\'website\']').val('');
								$('textarea[name=\'comment\']').val('');
						 		$('input[name=\'smartblogcaptcha\']').val('');
								$('#commentInput').before('<div class="success">' + json['success'] + '</div>');
								setTimeout(function(){
									$('.success').fadeOut(300).delay(450).remove();
								},2500);
							}
						}


					});
				});
	    		var addComment = {
					moveForm : function(commId, parentId, respondId, postId) {
						var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');
						if ( ! comm || ! respond || ! cancel || ! parent )
							return;
						t.respondId = respondId;
						postId = postId || false;
						if ( ! t.I('wp-temp-form-div') ) {
							div = document.createElement('div');
							div.id = 'wp-temp-form-div';
							div.style.display = 'none';
							respond.parentNode.insertBefore(div, respond);
						}

						comm.parentNode.insertBefore(respond, comm.nextSibling);
						if ( post && postId )
							post.value = postId;
						parent.value = parentId;
						cancel.style.display = '';
						cancel.onclick = function() {
							var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);
							if ( ! temp || ! respond )
								return;
							t.I('comment_parent').value = '0';
							temp.parentNode.insertBefore(respond, temp);
							temp.parentNode.removeChild(temp);
							this.style.display = 'none';
							this.onclick = null;
							return false;
						};
						try { t.I('comment').focus(); }
							catch(e) {}
							return false;
					},
					I : function(e) {
						return document.getElementById(e);
					}

				};

			</script>
		{/if}
	{/if}-->

	{if !empty($smartcustomcss)}
	    <style>
	        {$smartcustomcss}
	    </style>
	{/if}

{/block}