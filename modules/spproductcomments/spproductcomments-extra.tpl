{*
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}

{if (!$quickview && (($nbComments == 0 && $too_early == false && ($logged || $allow_guests)) || ($nbComments != 0)))}
<div id="spproduct_comments_block_extra">

		{if $nbComments != 0}
		<div class="comments_note">
			<span  class="average">{l s='Average grade' d='Shop.Theme.Global'}</span>
			<div class="star_content clearfix">
			{section name="i" start=0 loop=5 step=1}
				{if $averageTotal le $smarty.section.i.index}
					<i class="icon-star1" aria-hidden="true"></i>
				{else}
					<i class="icon-star1 icon-star1-active" aria-hidden="true"></i>
				{/if}
			{/section}
			</div>
		</div>
		{/if}

			{if $nbComments != 0}
				<div class="comments_advices">
					<a class="nb-comments" href="#idTab5">{$nbComments} {l s='Reviews' d='Shop.Theme.Global'}</a>
					{if ($too_early == false AND ($logged OR $allow_guests))}
						<a class="open-comment-form" href="#" data-toggle="modal" data-target="#productcomment-modal" >{l s='Write a review' d='Shop.Theme.Global'}</a>
					{/if}
				</div>
			{else}
				<div class="comments_note">
					<div class="star_content clearfix">
							{section name="i" start=0 loop=5 step=1}
								{if $averageTotal le $smarty.section.i.index}
									<i class="icon-star1" aria-hidden="true"></i>
								{else}
									<i class="icon-star1 icon-star1-active" aria-hidden="true"></i>
								{/if}
							{/section}
					</div>
				</div>
				<div class="comments_advices">
					<a class="nb-comments" href="#idTab5">0 {l s='Reviews' d='Shop.Theme.Global'}</a>
					{if ($too_early == false AND ($logged OR $allow_guests))}
						<a class="open-comment-form" href="#" data-toggle="modal" data-target="#productcomment-modal" >{l s='Write a review' d='Shop.Theme.Global'}</a>
					{/if}
				</div>
			{/if}
		











</div>
{/if}
<!--  /Module SPProductComments -->
