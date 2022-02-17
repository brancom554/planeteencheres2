<?php
/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

require_once(dirname(__FILE__).'../../../config/config.inc.php');
require_once(dirname(__FILE__).'../../../init.php');

$method = Tools::getValue('method');
$product_id = Tools::getValue('id');
$shop_id = Tools::getValue('shop', 1);
$lang_id = Tools::getValue('lang', 1);
$id_customer = Tools::getValue('id_customer', 0);

function submitCommeent()
{

}

?>