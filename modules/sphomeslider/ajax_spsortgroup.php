<?php
/**
 * package SP sp homeslider
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

include_once ( '../../config/config.inc.php' );
include_once ( '../../init.php' );
include_once ( 'sphomeslider.php' );
$context = Context::getContext ();
$home_slider = new sphomeslider();
$items = array();
if (!Tools::isSubmit ('secure_key') || Tools::getValue ('secure_key') != $home_slider->secure_key || !Tools::getValue ('action'))
	die( 1 );
if (Tools::getValue ('action') == 'updateGroupPosition' && Tools::getValue ('item'))
{
	$items = Tools::getValue ('item');
	$pos = array();
	$success = true;
	foreach ($items as $position => $item)
	{
		$success &= Db::getInstance ()->execute ('
			UPDATE `'._DB_PREFIX_.'sphomeslider_groups` SET `position` = '.(int)$position.'
			WHERE `id_sphomeslider_groups` = '.(int)$item);
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