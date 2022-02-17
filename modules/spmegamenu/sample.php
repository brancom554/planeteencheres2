<?php

if (!defined('_PS_VERSION_'))
	exit;
$ps_root_dir=str_replace("\\","/",__PS_BASE_URI__);

//spmegamenu
$samples['spmegamenu'] = 
	"INSERT INTO `"._DB_PREFIX_."spmegamenu` (`id_spmegamenu`, `id_spmegamenu_group`, `id_parent`, `value`, `type`, `width`, `menu_class`, `show_title`, `show_sub_title`, `sub_menu`, `sub_width`, `group`, `type_submenu`, `lesp`, `cat_subcategories`, `sp_lesp`, `position`, `active`) VALUES
(1, 1, 0, '', '', '', '', 1, 1, '', '', 0, 0, 0, 0, 1, 1, 1),
(2, 1, 1, 'a:1:{s:8:\"category\";s:1:\"3\";}', 'category', '', 'mega_type1', 1, 1, 'yes', '100%', 0, 0, 0, 0, 2, 0, 1),
(3, 1, 1, 'a:1:{s:8:\"category\";s:2:\"14\";}', 'category', '', 'mega_type2 product-style', 1, 1, 'yes', '75%', 0, 0, 0, 0, 2, 1, 1),
(7, 1, 2, 'a:4:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '25%', '', 0, 1, 'no', '', 1, 0, 0, 8, 3, 0, 1),
(8, 1, 2, 'a:4:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '25%', '', 0, 1, 'no', '', 1, 0, 0, 4, 3, 1, 1),
(9, 1, 2, 'a:4:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '25%', '', 0, 1, 'no', '', 1, 0, 0, 12, 3, 2, 1),
(10, 1, 2, 'a:5:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"5\";s:6:\"limit3\";s:1:\"5\";s:7:\"showimg\";s:3:\"yes\";s:12:\"showimgchild\";s:2:\"no\";}', 'html', '', 'col-md-6 ver-img-1', 0, 0, 'no', '', 1, 0, 0, 0, 2, 4, 1),
(12, 1, 3, 'a:4:{s:6:\"limit1\";s:2:\"10\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '28%', 'sm_megamenu_firstcolumn', 0, 0, 'yes', '', 1, 0, 0, 14, 3, 0, 1),
(20, 1, 1, '', 'url', '', 'css_type blog', 1, 1, 'no', '180px', 0, 0, 0, 0, 2, 3, 1),
(21, 1, 1, 'a:1:{s:3:\"cms\";s:1:\"4\";}', 'cms', '', '', 1, 1, 'no', '', 0, 0, 0, 0, 2, 4, 1),
(22, 1, 1, 'a:1:{s:8:\"category\";s:1:\"1\";}', 'url', '', 'css_type3 contact', 1, 0, 'yes', '180px', 0, 0, 0, 0, 2, 5, 1),
(43, 1, 39, '', 'url', '', '', 1, 1, 'no', '', 1, 0, 0, 0, 3, 11, 1),
(55, 0, 1, '', 'url', '', '', 1, 1, 'yes', '', 1, 0, 0, 0, 2, 23, 1),
(56, 1, 2, 'a:4:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '25%', '', 0, 1, 'no', '', 1, 0, 0, 13, 3, 3, 1),
(57, 1, 3, 'a:2:{s:4:\"type\";s:7:\"special\";s:5:\"limit\";s:1:\"2\";}', 'productlist', '70%', 'two hidden-md-down', 1, 1, 'no', '', 1, 0, 0, 0, 3, 1, 1),
(78, 1, 1, 'a:1:{s:8:\"category\";s:2:\"13\";}', 'category', '', 'css_type', 1, 1, 'yes', '', 1, 0, 0, 0, 2, 2, 1),
(79, 1, 78, 'a:4:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '', '', 0, 1, 'yes', '', 1, 0, 0, 104, 3, 0, 1),
(80, 1, 78, 'a:4:{s:6:\"limit1\";s:1:\"0\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '', '', 0, 1, 'no', '', 1, 0, 0, 105, 3, 1, 1),
(81, 1, 78, 'a:4:{s:6:\"limit1\";s:1:\"0\";s:6:\"limit2\";s:1:\"0\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '', '', 0, 0, 'no', '', 1, 0, 0, 107, 3, 2, 1),
(112, 1, 2, 'a:5:{s:6:\"limit1\";s:1:\"5\";s:6:\"limit2\";s:1:\"5\";s:6:\"limit3\";s:1:\"5\";s:7:\"showimg\";s:3:\"yes\";s:12:\"showimgchild\";s:2:\"no\";}', 'html', '', 'col-md-6 ver-img-1', 0, 1, 'no', '', 1, 0, 0, 0, 2, 5, 1),
(117, 1, 78, 'a:4:{s:6:\"limit1\";s:1:\"4\";s:6:\"limit2\";s:1:\"4\";s:7:\"showimg\";s:2:\"no\";s:12:\"showimgchild\";s:2:\"no\";}', 'subcategories', '', '', 0, 0, 'yes', '', 1, 0, 0, 170, 4, 3, 1);";

//spmegamenu_group
$samples['spmegamenu_group'] = 
	"INSERT INTO `"._DB_PREFIX_."spmegamenu_group` (`id_spmegamenu_group`, `hook`, `params`, `status`, `position`) VALUES
(1, 'displayMenu', '', 1, 1);";

//spmegamenu_group_lang
$samples['spmegamenu_group_lang'] = 
	"INSERT INTO `"._DB_PREFIX_."spmegamenu_group_lang` (`id_spmegamenu_group`, `id_lang`, `title`, `content`) VALUES
(1, _ID_LANG_, 'Sp Mega Menu', NULL),
(3, _ID_LANG_, 'Sp Mega Menu', NULL),
(4, _ID_LANG_, 'Sp Mega Menu', NULL),
(5, _ID_LANG_, 'Sp Mega Menu', NULL),
(6, _ID_LANG_, 'Sp Mega Menu', NULL),
(7, _ID_LANG_, 'Sp Mega Menu', NULL),
(8, _ID_LANG_, 'Sp Mega Menu', NULL);";

//spmegamenu_group_shop
$samples['spmegamenu_group_shop'] = 
	"INSERT INTO `"._DB_PREFIX_."spmegamenu_group_shop` (`id_spmegamenu_group`, `id_shop`) VALUES
(1, _ID_SHOP_),
(2, _ID_SHOP_);";
	
//spmegamenu_lang
$samples['spmegamenu_lang'] =  
	"INSERT INTO `"._DB_PREFIX_."spmegamenu_lang` (`id_spmegamenu`, `id_lang`, `title`, `label`, `short_description`, `sub_title`, `html`, `url`) VALUES
(1, _ID_LANG_, 'Root', NULL, NULL, NULL, '', ''),
(2, _ID_LANG_, 'Shop', '', '', '', '', '#'),
(3, _ID_LANG_, 'Features', '', '', '', '', '#'),
(7, _ID_LANG_, 'Fashion', '', '', '', '', ''),
(8, _ID_LANG_, 'Sport', '', '', '', '', ''),
(9, _ID_LANG_, 'Travel & Vacation', '', '', '', '', ''),
(10, _ID_LANG_, 'Image 1', NULL, NULL, NULL, '<p><img src=\"".$ps_root_dir."/themes/sp_topdeals/assets/img/cms/image-thum-1.jpg\" width=\"540\" height=\"220\" alt=\"\" /></p>', ''),
(12, _ID_LANG_, 'Features', '', '', '', '', ''),
(20, _ID_LANG_, 'Blog', '', '', '', '', 'index.php?fc=module&module=smartblog&controller=category'),
(21, _ID_LANG_, 'About us', '', '', '', '', 'index.php?controller=contact'),
(22, _ID_LANG_, 'Contact', '', '', '', '', 'index.php?controller=contact'),
(43, _ID_LANG_, 'Blog Listing Large Image', NULL, NULL, NULL, '', 'index.php?fc=module&module=smartblog&controller=category?SP_blogStyle=blog-large_image'),
(55, _ID_LANG_, 'alo', NULL, NULL, NULL, '', '#'),
(56, _ID_LANG_, 'Digital & Electronics', '', '', '', '', ''),
(57, _ID_LANG_, 'Best Seller', '', '', '', '', ''),
(78, _ID_LANG_, 'Electronics', '', '', '', '', 'index.php?fc=module&module=smartblog&controller=category'),
(79, _ID_LANG_, 'Mobiles', '', '', '', '', ''),
(80, _ID_LANG_, 'Headphone', '', '', '', '', ''),
(81, _ID_LANG_, 'Laptop', '', '', '', '', ''),
(112, _ID_LANG_, 'Image 2', NULL, NULL, NULL, '<p><img src=\"".$ps_root_dir."/themes/sp_topdeals/assets/img/cms/image-thum-2.jpg\" width=\"540\" height=\"220\" alt=\"\" /></p>', ''),
(117, _ID_LANG_, 'Phasellus ut nisi', '', '', '', '', '');";

//spmegamenu_shop
$samples['spmegamenu_shop'] =
	"INSERT INTO `"._DB_PREFIX_."spmegamenu_shop` (`id_spmegamenu`, `id_shop`) VALUES
(1, _ID_SHOP_),
(2, _ID_SHOP_),
(3, _ID_SHOP_),
(7, _ID_SHOP_),
(8, _ID_SHOP_),
(9, _ID_SHOP_),
(10, _ID_SHOP_),
(12, _ID_SHOP_),
(20, _ID_SHOP_),
(21, _ID_SHOP_),
(22, _ID_SHOP_),
(43, _ID_SHOP_),
(55, _ID_SHOP_),
(56, _ID_SHOP_),
(57, _ID_SHOP_),
(78, _ID_SHOP_),
(79, _ID_SHOP_),
(80, _ID_SHOP_),
(81, _ID_SHOP_),
(112, _ID_SHOP_),
(117, _ID_SHOP_);";
	
$ids_group = Shop::getTree();
$list = [];
if ($ids_group){
	foreach($ids_group as $idg){
		if (!empty($idg['shops'])){
			foreach($idg['shops'] as $id_shop){
				array_push($list,$id_shop['id_shop']);	
			}
		}
		
	}
}
if (!empty($list)){
	foreach ($samples as $sample){
		if(!empty($sample)){
			$datas = preg_split('#;\s*[\r\n]+#', $sample);
			 foreach ($datas as $sql) {
				 if(!empty($sql)) {
					 if (strstr($sql,"_ID_SHOP_")){
						 foreach($list as $id_shop){	
							$_sql_shop = str_replace( '_ID_SHOP_', $id_shop, $sql );	
							Db::getInstance()->execute($_sql_shop);
							
						}
					}
					elseif( strstr($sql,"_ID_LANG_") ){	
						$languages = Language::getLanguages(false);
						foreach ($languages as $lang) {	
							$str = str_replace( '_ID_LANG_', (int) $lang["id_lang"], $sql );
							Db::getInstance()->execute(($str));
						}
					}else{
						Db::getInstance()->execute(($sql));
					}
				}
			}
		} 
	}	
}