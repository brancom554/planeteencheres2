<?php
/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/ProductCommentCriterion.php');

if (empty($_GET['id_lang']) === false &&
	isset($_GET['id_product']) === true)
{
	$criterions = ProductCommentCriterion::get($_GET['id_lang']);
	if ((int)($_GET['id_product']))
		$selects = ProductCommentCriterion::getByProduct($_GET['id_product'], $_GET['id_lang']);
	echo '<select name="id_product_comment_criterion[]" id="id_product_comment_criterion" multiple="true" style="height:100px;width:360px;">';
	foreach ($criterions as $criterion)
	{
		echo '<option value="'.(int)($criterion['id_product_comment_criterion']).'"';
		if (isset($selects) === true && sizeof($selects))
		{
			foreach ($selects as $select)
				if ($select['id_product_comment_criterion'] == $criterion['id_product_comment_criterion'])
					echo ' selected="selected"';
		}
		echo '>'.htmlspecialchars($criterion['name'], ENT_COMPAT, 'UTF-8').'</option>';
	}
	echo '</select>';
}