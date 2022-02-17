{*
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}
 
<script type="text/javascript">
var productcomments_controller_url = '{$productcomments_controller_url}';
var confirm_report_message = '{l s='Are you sure that you want to report this comment?' d='productcomments' js=1}';
var secure_key = '{$secure_key}';
var productcomments_url_rewrite = '{$productcomments_url_rewriting_activated}';
var productcomment_added = '{l s='Your comment has been added!' d='productcomments' js=1}';
var productcomment_added_moderation = '{l s='Your comment has been submitted and will be available once approved by a moderator.' d='productcomments' js=1}';
var productcomment_title = '{l s='New comment' d='productcomments' js=1}';
var productcomment_ok = '{l s='OK' d='productcomments' js=1}';
var moderation_active = {$moderation_active};
</script>

{if isset($product) && $product}
<div id="productcomment-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="SpProductComment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       <h4 class="title"><i class="fa fa-comments" aria-hidden="true"></i> {l s='Write your review' d='productcomments'}</h4>
      </div>
	<div class="modal-body">
		<div id="comment-form-wrap">
			<form id="comment-form" action="#">
			<div class="row">
			{if isset($product) && $product}
				<div class="product clearfix  col-xs-12 col-sm-6">
					<div class="product-inner">
					<img src="{$productcomment_cover_image}" height="{$mediumSize.height}" width="{$mediumSize.width}" alt="{$product->name|escape:'html':'UTF-8'}" />
					<div class="product_desc">
						<p class="product_name">
							<strong>{$product->name}</strong>
						</p>
						{$product->description_short nofilter}
					</div>
					</div>
				</div>
			{/if}
			<div class="comment-form-wrap_content col-xs-12 col-sm-6">
				<div id="comment-form-wrap_error" class="alert alert-error" style="display: none;">
					<span title="{l s='Hide' d='ioutfit'}" class="iclose-btn  pull-right" onclick="icloseClick(this)"><i class="fa fa-times" aria-hidden="true"></i></span>
					<ul></ul>
				</div>
				{if $criterions|@count > 0}
					<ul id="criterions_list">
					{foreach from=$criterions item='criterion'}
						<li>
							<label>{$criterion.name|escape:'html':'UTF-8'}</label>
							<div class="stars">
								<input class="star-1" id="star-1-{$criterion.id_product_comment_criterion|round}" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />
								<label class="star-1" for="star-1-{$criterion.id_product_comment_criterion|round}">1</label>
								<input class="star-2" id="star-2-{$criterion.id_product_comment_criterion|round}" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />
								<label class="star-2" for="star-2-{$criterion.id_product_comment_criterion|round}">2</label>
								<input class="star-3" id="star-3-{$criterion.id_product_comment_criterion|round}" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" />
								<label class="star-3" for="star-3-{$criterion.id_product_comment_criterion|round}">3</label>
								<input class="star-4" id="star-4-{$criterion.id_product_comment_criterion|round}" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" />
								<label class="star-4" for="star-4-{$criterion.id_product_comment_criterion|round}">4</label>
								<input class="star-5" id="star-5-{$criterion.id_product_comment_criterion|round}" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" checked="checked" />
								<label class="star-5" for="star-5-{$criterion.id_product_comment_criterion|round}">5</label>
								<span></span>
							</div>
						</li>
					{/foreach}
					</ul>
				{/if}
				<div style="clear: both;"></div>
				<label for="comment_title">{l s='Title for your review' d='productcomments'} <sup class="required">*</sup></label>
				<input id="comment_title" class=" form-control" name="title" type="text" value=""/>

				<label for="content">{l s='Your review' d='productcomments'} <sup class="required">*</sup></label>
				<textarea id="content" name="content" class=" form-control"></textarea>

				{if $allow_guests == true && !$logged}
				<label>{l s='Your name' d='productcomments'} <sup class="required">*</sup></label>
				<input id="commentCustomerName" class=" form-control" name="customer_name" type="text" value=""/>
				{/if}

				<div id="comment-form-wrap_footer">
					<input id="id_product_comment_send" class="iinput form-control" name="id_product" type="hidden" value='{$id_product_comment_form}' />
					<p class="fl"><sup class="required">*</sup> <small>{l s='Required fields' d='productcomments'}</small></p>
					<p class="fr">
						<a class="btn btn-info" href="javascript:void(0)" id="submitNewMessage" onclick="fnSubmitNewMessage()"><i id="iloading-icon" class="fa fa-circle-o-notch fa-spin fa-fw" style="display: none;"></i> {l s='Send' d='productcomments'}</a>
					</p>
					<div style="clear: both;"></div>
				</div>
			</div>
			</div>
		</form><!-- /end comment-form-wrap_content -->
	</div>
	</div>
	</div>
	</div>
</div>
<div id="productcomment-modal-success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="SpProductComment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       <h4 class="title"><i class="fa fa-comments" aria-hidden="true"></i> {l s='New comment' d='productcomments'}</h4>
      </div>
		<div class="modal-body">
			<div id="comment-form-wrap_success"  >
				<p class="alert alert-success">
				{if $is_comments_moderate}
					{l s="You are sent a comment success. The administrator will review and approve your comment. Thank you!" d='productcomments'}
				{else}
					{l s="You are sent a comment success. Thank you!" d='productcomments'}
				{/if}	
				</p>
				<p class="submit" id="comment-form-wrap_success-reload" style="text-align:right; padding-bottom: 0"><button type="submit" class="button btn btn-info"  value="true" onclick="productcommentRefreshPage()"><span>OK</span></button></p>
			</div>
		</div>
	</div>
  </div>
</div>

{/if}

<div style="clear: both;"></div>
<div id="idTab5" style="margin-top: 2rem;">
	<div id="product_comments_block_tab">
	{if $comments}
		{foreach from=$comments item=comment}
			{if $comment.content}
			<div class="comment clearfix">
				<span class="circle">
					<img class="iavatar" title="avatar" alt="avatar" src="{$site_url}/modules/productcomments/img/user.png" />
				</span>
				<div class="star_content clearfix">
					<span class="author">{$comment.customer_name|escape:'html':'UTF-8'}</span>
					<div class="metadata  pull-right">
						<div class="date ">{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</div>
						<div class="rating">
							{section name="i" start=0 loop=5 step=1}
								{if $comment.grade le $smarty.section.i.index}
									<i class="fa fa-star" aria-hidden="true"></i>
								{else}
									<i class="fa fa-star" aria-hidden="true" style="color:#FFCC00;"></i>
								{/if}
							{/section}
						</div>
					</div>
					<div class="text">
						<span class="title_block">{$comment.title}:</span>
						<p>{$comment.content|escape:'html':'UTF-8'|nl2br}</p>
						<div>
							{if $comment.total_advice > 0}
								<div class="div-people-like">{l s='%1$d out of %2$d people found this review useful.' sprintf=[$comment.total_useful,$comment.total_advice] d='productcomments'}</div>
							{/if}
							{if $logged}
								<div class="text-bottom">
								{if !$comment.customer_advice}
								<span class="usefulness_btn" onclick="iFnLike(this)" data-is-usefull="1" data-id-product-comment="{$comment.id_product_comment}">{l s='Like' d='productcomments'}</span>
								<span class="usefulness_btn" onclick="iFnLike(this)" data-is-usefull="0" data-id-product-comment="{$comment.id_product_comment}">{l s='Dislike' d='productcomments'}</span>
								{/if}
								{if !$comment.customer_report}
								<span class="report_btn  pull-right" onclick="iFnReport(this)" data-id-product-comment="{$comment.id_product_comment}">{l s='Report' d='productcomments'}</span>
								{/if}
								</div>
							{/if}
						</div>
					</div>
				</div>
			</div>
			{/if}
		{/foreach}
        {if (!$too_early AND ($logged OR $allow_guests))}
		<p class="align_center ialign_center">
			<a class="btn btn-info" id="new_comment_tab_btn"  href="#" data-toggle="modal" data-target="#productcomment-modal">{l s='Write your review' d='productcomments'}</a>
		</p>
        {/if}
	{else}
		{if (!$too_early AND ($logged OR $allow_guests))}
		<p class="align_center">
			<a id="new_comment_tab_btn" class="open-comment-form" href="#" data-toggle="modal" data-target="#productcomment-modal">{l s='Be the first to write your review' d='productcomments'} !</a>
		</p>
		{else}
		<p class="align_center hide">{l s='No customer reviews for the moment.' d='productcomments'}</p>
		{/if}
	{/if}	
	</div>
</div>
