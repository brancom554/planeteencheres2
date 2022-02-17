<?php
/**
 * package SP Listing Tabs
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

include_once ( '../../config/config.inc.php' );
include_once ( '../../init.php' );
include_once ( 'splistingtabs.php' );
$context = Context::getContext ();
$splistingtabs = new SpListingTabs();
echo $splistingtabs->ajaxCall();