<?php
/**
 * package   SP Search Pro
 *
 * @version 1.1.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

include_once ( '../../config/config.inc.php' );
include_once ( '../../init.php' );
include_once ( 'spsearchpro.php' );
$context = Context::getContext ();
$spsearchpro = new SpSearchPro();
$items = array();
if (!Tools::isSubmit ('secure_key') || Tools::getValue ('secure_key') != $spsearchpro->secure_key || !Tools::getValue ('action'))
	die( 1 );

if (Tools::getValue ('action') == 'updateSlidesPosition' && Tools::getValue ('item'))
{
	$items = Tools::getValue ('item');
	$pos = array();
	$success = true;

	foreach ($items as $position => $item)
	{
		$success = Db::getInstance ()->execute ('
			UPDATE `'._DB_PREFIX_.'spsearchpro` SET `ordering` = '.(int)$position.'
			WHERE `spsearchpro` = '.(int)$item);
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