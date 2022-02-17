<?php

/**
 * @package SP Theme Configurator
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.magentech.com
 */


include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('spthemeconfigurator.php');

$context = Context::getContext();
$spthemeconfigurator = new spthemeconfigurator();
$action = Tools::getValue('action');


switch ($action) {
    case 'loadImageSources':
         /* Quick Image Viewer on Product Thumbnails */
        $pid = Tools::getValue('pid');
        $linkRewrite = Tools::getValue('linkRewrite');
        $id_lang = $context->language->id;
        $output = '';

        $product = new Product($pid, true, $id_lang);
        $productImages = $product->getImages($context->language->id);
        $productLink = $product->getLink();

        foreach ($productImages as $productImage)
        {
            if ($productImage['cover'] == 0) {
                $output .= '<a class="item-image-link img-wrapper" href="'.$productLink.'">';
                $output .= '<img class="lazyOwl" data-src="';
                $output .= $context->link->getImageLink($linkRewrite, $pid.'-'.$productImage['id_image'], 'atmn_normal');
                $output .= '" /></a>';
            }
        }

        die(Tools::jsonEncode($output));
        break;
	case 'compilescss':
		$scssDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/sass/';
		$cssDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/css/';
		$themeColor = Tools::getValue('color1');
		$themeColor2 = Tools::getValue('color2');
		$themeColor = strtolower($themeColor);
		$themeCssName = 'theme-' . str_replace("#", "", $themeColor) . '.css';
		
		require "scssphp/scss.inc.php";
		require "scssphp/compass/compass.inc.php";
		
		$scss = new scssc();
		new scss_compass($scss);

		$scss->setFormatter('scss_formatter_compressed');
		$scss->addImportPath($scssDir);
		
		$variables = '$color1: '.$themeColor.';';
		$variables2 = '$color2: '.$themeColor2.';';
		$string_sass = $variables. $variables2 . file_get_contents($scssDir . "theme.scss");
		$string_css = $scss->compile($string_sass);
		
		file_put_contents($cssDir . $themeCssName, $string_css);
		die(Tools::jsonEncode(array()));
		break;
		
   
    default:
        break;
}