{capture name=path}<li class="depth1"><a href="{smartblog::GetSmartBlogLink('smartblog')}">{l s='All Blog News' mod='smartblog'}</a></li>{$meta_title}{/capture}
<div id="content">
   <div itemtype="#" itemscope="" id="sdsblogArticle" class="blog-post">
  
      <div itemprop="articleBody">
            <div id="lipsum" class="articleContent">
                    {assign var="activeimgincat" value='0'}
                    {$activeimgincat = $smartshownoimg} 
                    {if ($post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                       <img src="{$modules_dir}/smartblog/images/{$post_img}.jpg" alt="{$meta_title}">
                    {/if}
             </div>
			
			<div class="article-title">{$meta_title}</div>
			 <div class="article-info">
				<span class="date" itemprop="dateCreated">{$post.created|date_format:"%d. %B %Y"}</span>
				<!--<span itemprop="author" class="author"><i class="fa fa-user"></i> {if $smartshowauthor ==1} {if $smartshowauthorstyle != 0}{$post.firstname}{$post.lastname}{else}{$post.lastname}{$post.firstname}{/if}</span>{/if}
				 {assign var="catOptions" value=null}
							{$catOptions.id_category = $id_category}
							{$catOptions.slug = $cat_link_rewrite}
				<span itemprop="articleSection" class="cat"><i class="fa fa-folder-open"></i> <a href="{smartblog::GetSmartBlogLink('smartblog_category',$catOptions)}">{$title_category}</a></span>
				 -->
				<a title="{if {$countcomment} < 1 } 0 Comment {else} {$countcomment} Comment(s) {/if}" href="">
					{if $countcomment > 1}
						{$countcomment} {l s='Comments' mod='smartblog'}
					{else}
						{$countcomment} {l s='Comment' mod='smartblog'}
					{/if}</a>
			</div>
            <div class="sdsarticle-des">
               {$content}
            </div>
			<div class="bgr_tag">
				{if $tags != ''}
					<div class="sdstags-update">
						<span class="tags"><b class="title_tag">{l s='Tags:' mod='smartblog'} </b> 
							{foreach from=$tags item=tag}
								{assign var="options" value=null}
								{$options.tag = $tag.name}
								<a title="tag" href="{smartblog::GetSmartBlogLink('smartblog_tag',$options)}">{$tag.name},</a>
							{/foreach}
						</span>
					</div>
			   {/if}
			   <div class="social_blog">
					<div class="title_social_blog">Share This:</div>
					<ul>
						<li class="social_icon icon_fb"><a href="https://www.facebook.com/MagenTech" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li class="social_icon icon_tw"><a href="https://twitter.com/magentech" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li class="social_icon icon_g"><a href="https://plus.google.com/u/0/+SmartAddons-Joomla-Magento-WordPress/posts" title="Google"><i class="fa fa-google-plus"></i></a></li>
						<li class="social_icon icon_dri"><a href="#" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
						<li class="social_icon icon_in"><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
					</ul>
			   </div>
		   </div>
      </div>
     
	 
      <div class="sdsarticleBottom">
        {$HOOK_SMART_BLOG_POST_FOOTER}
      </div>
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
{if Configuration::get('smartenablecomment') == 1}
{if $comment_status == 1}
<div class="smartblogcomments" id="respond">
    
    <h4 class="comment-reply-title" id="reply-title">{l s="LEAVE YOUR COMMENTS"  mod="smartblog"} <small style="float:right;">
                <a style="display: none;" href="/wp/sellya/sellya/this-is-a-post-with-preview-image/#respond" 
                   id="cancel-comment-reply-link" rel="nofollow">{l s="Cancel Reply"  mod="smartblog"}</a>
            </small>
        </h4>
		<div id="commentInput">
            <form action="" method="post" id="commentform">
				<div class="input fl">
					<input type="text" tabindex="1" placeholder="Name" class="inputName form-control grey" value="" name="name">																	
				</div>
				<div class="input fr">
					<input type="text" tabindex="2" placeholder="Email" class="inputMail form-control grey" value="" name="mail">
				</div>
		
			<div class="clearfix content">
				<textarea tabindex="4" placeholder="Comment" class="inputContent form-control grey" rows="8" cols="50" name="comment"></textarea>
			</div>
	{if Configuration::get('smartcaptchaoption') == '1'}
		<div class="capcha">
			
			<span class="required">*</span> <b>{l s="Type Code" mod="smartblog"}</b> </br>
			<img src="{$modules_dir}smartblog/classes/CaptchaSecurityImages.php?width=100&height=40&characters=5">
			<input type="text" tabindex="" value="" name="smartblogcaptcha" class="smartblogcaptcha form-control grey">
			
		</div>
	{/if}
	
                 <input type='hidden' name='comment_post_ID' value='1478' id='comment_post_ID' />
                  <input type='hidden' name='id_post' value='{$id_post}' id='id_post' />

                <input type='hidden' name='comment_parent' id='comment_parent' value='0' />

      
        <div class="submit">
            <input type="submit" name="addComment" id="submitComment" class="bbutton btn btn-default button-medium" value="Send">
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
			} );
		} );
		
 




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
{/if}
{if isset($smartcustomcss)}
    <style>
        {$smartcustomcss}
    </style>
{/if}
