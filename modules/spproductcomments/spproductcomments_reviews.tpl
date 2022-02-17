{*
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *}
 

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
	<span class="span-review-main">{$nbComments} {l s='Review(s)' d='Shop.Theme.Global'}</span>
</div>
