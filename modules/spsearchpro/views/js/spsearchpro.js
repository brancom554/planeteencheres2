/* global $ */
$(document).ready(function () {
	$( ".spr-container" ).each(function() {
			var $element = $('#'+$(this).attr('id'));
			var $searchWidget = $element;
			var $searchBox    = $searchWidget.find('input[type=text]');
			var searchURL     = $searchWidget.attr('data-module_link');
    		
			$.widget('prestashop.psBlockSearchAutocomplete', $.ui.autocomplete, {
				_renderItem: function (ul, product) {
					console.log(product);
					var _img_pl = prestashop.urls.base_url+'modules/spsearchpro/views/img/nophoto.jpg';
					if (typeof product.cover !== 'undefined' && product.cover !== null){
						if(typeof product.cover['small'] !== 'undefined' && typeof product.cover['small']['url'] !== 'undefined'){
							_img_pl = product.cover['small']['url'];
						}
					}
					return $("<li>")
						.append($("<a>")
							.append($("<span>").html('<img src="'+_img_pl+'"/>').addClass("images")) 
							.append($("<span>").html(product.category_name).addClass("category"))
							.append($("<span>").html(' > ').addClass("separator"))
							.append($("<span>").html(product.name).addClass("product"))
						).appendTo(ul)
					;
				}
			});

			$searchBox.psBlockSearchAutocomplete({
				source: function (query, response) {
					$.post(searchURL, {
						s: query.term,
						resultsPerPage: 10,
						cat_id: $("select[class=spr_select]", $element).val(),
					}, null, 'json')
					.then(function (resp) {
						response(resp.products);
					})
					.fail(response);
				},
				select: function (event, ui) {
					var url = ui.item.url;
					window.location.href = url;
				},
			});
	});	
});
 

 