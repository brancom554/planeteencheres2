/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

function getProductCriterionForm()
{
	if (document.forms)
		return (document.forms['product_criterion_form']);
	else
		return (document.product_criterion_form);
}

function getProductCriterion(path, id_product, id_lang)
{
	$.get(path + 'productcommentscriterion.php', { id_product: id_product, id_lang: id_lang },
	function(data){
		document.getElementById('product_criterions').innerHTML = data;
	});
}
