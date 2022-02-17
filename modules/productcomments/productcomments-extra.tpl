{*
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}

{if (!$quickview && (($nbComments == 0 && $too_early == false && ($logged || $allow_guests)) || ($nbComments != 0)))}
<div id="product_comments_block_extra">
	{if $nbComments != 0}
	<div class="comments_note">
		<span>{l s='Average grade' mod='productcomments'}&nbsp</span>
		<div class="star_content clearfix">
		{section name="i" start=0 loop=5 step=1}
			{if $averageTotal le $smarty.section.i.index}
				<i class="fa fa-star" aria-hidden="true"></i>
			{else}
				<i class="fa fa-star" aria-hidden="true" style="color:#FFCC00;"></i>
			{/if}
		{/section}
		</div>
	</div>
	{/if}

	<div class="comments_advices">
		{if $nbComments != 0}
		<a href="#idTab5">{l s='Read user reviews' mod='productcomments'} ({$nbComments})</a><br/>
		{/if}
		{if ($too_early == false AND ($logged OR $allow_guests))}
		<a class="open-comment-form" href="#" data-toggle="modal" data-target="#productcomment-modal" >{l s='Write your review' mod='productcomments'}</a>
		{/if}
	</div>
</div>
{/if}
<!--  /Module SPProductComments -->
