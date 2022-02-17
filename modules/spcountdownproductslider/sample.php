<?php

if (!defined('_PS_VERSION_'))
	exit;
$path = dirname( _PS_ADMIN_DIR_ );
 
include_once( $path. '/config/config.inc.php');
include_once( $path.'/init.php');

//spcountdownproductslider
$samples['spcountdownproductslider'] = 
	"INSERT INTO `"._DB_PREFIX_."spcountdownproductslider` (`id_spcountdownproductslider`, `hook`, `params`, `active`, `ordering`) VALUES
(1, 9, 'a:45:{s:9:\"id_spcountdownproductslider\";i:1;s:6:\"active\";i:1;s:4:\"hook\";s:11:\"displayHome\";s:15:\"moduleclass_sfx\";s:0:\"\";s:20:\"display_title_module\";s:1:\"1\";s:6:\"target\";s:6:\"_blank\";s:15:\"display_control\";i:1;s:10:\"nb_column1\";s:1:\"4\";s:10:\"nb_column2\";s:1:\"3\";s:10:\"nb_column3\";s:1:\"2\";s:10:\"nb_column4\";s:1:\"1\";s:6:\"catids\";s:9:\"2,3,4,5,7\";s:18:\"ordering_direction\";s:3:\"ASC\";s:17:\"products_ordering\";s:4:\"name\";s:12:\"count_number\";i:6;s:10:\"image_size\";s:12:\"home_default\";s:12:\"display_name\";i:1;s:14:\"name_maxlength\";i:50;s:19:\"display_description\";i:1;s:21:\"description_maxlength\";i:50;s:13:\"display_price\";i:1;s:16:\"display_wishlist\";i:0;s:15:\"display_compare\";i:0;s:17:\"display_addtocart\";i:0;s:14:\"display_quickview\";i:1;s:11:\"display_new\";i:1;s:12:\"display_sale\";i:1;s:10:\"start_countdownproduct\";i:0;s:6:\"scroll\";i:1;s:8:\"autoplay\";s:1:\"0\";s:16:\"autoplay_timeout\";s:4:\"2000\";s:5:\"delay\";s:3:\"500\";s:13:\"autoplaySpeed\";s:3:\"500\";s:8:\"duration\";s:3:\"700\";s:6:\"effect\";s:7:\"flipInY\";s:18:\"autoplayHoverPause\";s:1:\"1\";s:13:\"startPosition\";s:1:\"0\";s:9:\"mouseDrag\";s:1:\"1\";s:9:\"touchDrag\";s:1:\"1\";s:8:\"pullDrag\";s:1:\"1\";s:4:\"dots\";s:1:\"1\";s:3:\"nav\";s:1:\"1\";s:4:\"loop\";s:1:\"1\";s:10:\"title_countdownproduct\";a:3:{i:1;b:0;i:2;b:0;i:3;b:0;}s:17:\"cat_readmore_text\";a:3:{i:1;b:0;i:2;b:0;i:3;b:0;}}', 1, 1);";
//spcountdownproductslider_lang
$samples['spcountdownproductslider_lang'] = 
	"INSERT INTO `"._DB_PREFIX_."spcountdownproductslider_lang` (`id_spcountdownproductslider`, `id_lang`, `title_module`) VALUES
(1, "._ID_LANG_.", 'SP Countdown Products Slider');";
//spcountdownproductslider_shop
$samples['spcountdownproductslider_shop'] = 
	"INSERT INTO `"._DB_PREFIX_."spcountdownproductslider_shop` (`id_spcountdownproductslider`, `id_shop`, `active`) VALUES
(1,"._ID_SHOP_.", 1);";

foreach ($samples as $sample){
	if($sample){
		$datas = str_replace( '_ID_SHOP_', (int)Context::getContext()->shop->id, $sample );	
		$datas = preg_split('#;\s*[\r\n]+#', $datas);	
		foreach ($datas as $sql) {
			if($sql){
				if( strstr($sql,"_ID_LANG_") ){	
					$languages = Language::getLanguages(true, Context::getContext()->shop->id);
					foreach ($languages as $lang) {	
						$str = str_replace( '_ID_LANG_', (int) $lang["id_lang"], $sql );
						Db::getInstance()->execute(($str));
					}
				}
				else
					Db::getInstance()->execute($sql);
			}
		}
	}
}	


