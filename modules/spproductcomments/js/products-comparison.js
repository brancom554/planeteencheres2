/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 
$(document).ready(function() 
{
	$('input.star').rating();
	$('.auto-submit-star').rating();
	$('a.cluetip').cluetip({
		local:true,
		cursor: 'pointer',
		cluetipClass: 'comparison_comments',
		dropShadow: false,
		dropShadowSteps: 0,
		showTitle: false,
		tracking: true,
		sticky: false,
		mouseOutClose: true,
	    width: 450,
		fx: {             
	    	open:       'fadeIn',
	    	openSpeed:  'fast'
		}
	}).css('opacity', 0.8);
	
	$('a[href=#idTab5]').click(function(){
		$('*[id^="idTab"]').addClass('block_hidden_only_for_screen');
		$('div#idTab5').removeClass('block_hidden_only_for_screen');

		$('ul#more_info_tabs a[href^="#idTab"]').removeClass('selected');
		$('a[href="#idTab5"]').addClass('selected');
	});
});

function closeCommentForm()
{
	$('#sendComment').slideUp('fast');
	$('input#addCommentButton').fadeIn('slow');
}