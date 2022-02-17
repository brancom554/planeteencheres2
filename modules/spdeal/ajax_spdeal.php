<?php
/**
 * package SP Deal
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

include_once ( '../../config/config.inc.php' );
include_once ( '../../init.php' );
include_once ( 'spdeal.php' );
$context = Context::getContext ();
$spdeal = new SpDeal();
$items = array();
if (!Tools::isSubmit ('secure_key') || Tools::getValue ('secure_key') != $spdeal->secure_key || !Tools::getValue ('action'))
	die( 1 );
if (Tools::getValue ('action') == 'updateSlidesPosition' && Tools::getValue ('item'))
{
	$items = Tools::getValue ('item');
	$pos = array();
	$success = true;
	foreach ($items as $position => $item)
	{
		$success = Db::getInstance ()->execute ('
			UPDATE `'._DB_PREFIX_.'spdeal` SET `ordering` = '.(int)$position.'
			WHERE `id_spdeal` = '.(int)$item);
		$pos[] = $position;
	}

	if (!$success)
		die( Tools::jsonEncode (array(
			'error' => 'Update Fail'
		)) );
	die( Tools::jsonEncode (array(
		'success' => 'Update Success !',
		'error'   => false
	)) );
}