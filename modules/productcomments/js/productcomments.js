/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 
function fnSubmitNewMessage() {
	url_options = '?';
    if (!productcomments_url_rewrite) {
    	url_options = '&';
    }

	var url = productcomments_controller_url.replace(/&amp;/g, "&");
	$.ajax({
		url: url + url_options + 'action=add_comment&secure_key=' + secure_key + '&rand=' + new Date().getTime(),
		data: $('#comment-form').serialize(),
		type: 'POST',
		headers: { "cache-control": "no-cache" },
		dataType: "json",
		beforeSend: function() {
			$('#iloading-icon').css('display', 'inline-block');
		},
		success: function(data) {
			if (data.result) {
				if (data.html == '') {
					document.getElementById('comment-form').scrollIntoView();
					$('#productcomment-modal').modal('hide');
					$('#productcomment-modal-success').modal('show');
					
				} else {
					$('#productcomment-modal').modal('hide');
					$('#productcomment-modal-success').modal('show');
					document.getElementById('product_comments_block_tab').scrollIntoView();
					$('#product_comments_block_tab').prepend(data.html);

					$('#comment_title').val('');
					$('#content').val('');
				}
			} else {
				$('#comment-form-wrap_error').css('display', 'block');
				$('#comment-form-wrap_error ul').html('');
				$.each(data.errors, function(index, value) {
					$('#comment-form-wrap_error ul').append('<li>'+value+'</li>');
				});
				document.getElementById('comment-form').scrollIntoView();
				$('#comment-form-wrap_error').slideDown('slow');
			}
			$('#iloading-icon').css('display', 'none');
		},
		error: function() {
			$('#iloading-icon').css('display', 'none');
		}
	});
}
function icloseClick(e) {
	/*$(e).parent().css('display', 'none');*/
	$(e).parent().fadeToggle("slow");
}
function iFnLike(e) {
	var id_product_comment = $(e).data('id-product-comment');
	var is_usefull = $(e).data('is-usefull');
	var count = $(e).find('.count-ilike').text();

	var url = productcomments_controller_url.replace(/&amp;/g, "&");
	$.ajax({
		url: url + '?rand=' + new Date().getTime(),
		data: {
			id_product_comment: id_product_comment,
			action: 'comment_is_usefull',
			value: is_usefull
		},
		type: 'POST',
		headers: { "cache-control": "no-cache" },
		success: function(result){
			
		}
	});
}
function iFnReport(e) {
	if (confirm(confirm_report_message)) {
		var idProductComment = $(e).data('id-product-comment');
		var parent = $(e).parent();
		var url = productcomments_controller_url.replace(/&amp;/g, "&");
		$.ajax({
			url: url + '?rand=' + new Date().getTime(),
			data: {
				id_product_comment: idProductComment,
				action: 'report_abuse'
			},
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				parent.fadeOut('slow', function() {
					parent.remove();
				});
			}
		});
	}
}

function productcommentRefreshPage()
{
    window.location.reload();
}