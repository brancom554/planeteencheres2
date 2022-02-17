<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Verticalmenu extends ObjectModel
{
	public $id;
    public $id_spverticalmenu;
    public $id_parent = 1;
	public $value;
    public $width;
	public $sub_menu;
	public $sub_width;
    public $type;
	public $type_submenu;
    public $show_title = 1;
	public $show_sub_title = 1;
    public $sp_lesp;
    public $active = 1;
	public $group = 0;
    public $position;
    public $url;
    public $menu_class;
	public $icon;
	public $cat_subcategories;
	public $id_spverticalmenu_group;
    // Lang
    public 	$title;
	public 	$label;
	public 	$short_description;
	public 	$sub_title;
    public 	$html;
    public 	$id_shop = '';
	private $user_groups;
	private $page_name = '';
	/**
	 * @see ObjectModel::$definition
	 */
 public static $definition = array(
        'table' => 'spverticalmenu',
        'primary' => 'id_spverticalmenu',
        'multilang' => true,
        'fields' => array(
            'id_parent' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'width' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'sub_menu' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'sub_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
            'value' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'type_submenu' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'show_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'show_sub_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sp_lesp' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'group' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position' => array('type' => self::TYPE_INT),
            'menu_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'cat_subcategories' => array('type' => self::TYPE_INT),
			'id_spverticalmenu_group' => array('type' => self::TYPE_INT),
            //Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
			'label' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
			'short_description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
			'sub_title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
            'html' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
        ),
    );

	public function add($autodate = true,$null_values = false)
	{
		$id_shop = Context::getContext()->shop->id;
		$parent = new Verticalmenu($this->id_parent);
		$this->sp_lesp = $parent->sp_lesp + 1;
		$res = parent::add($autodate,$null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'spverticalmenu_shop` (`id_shop`, `id_spverticalmenu`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function update($null_values = false)
	{
		$id_shop = Context::getContext()->shop->id;
		$parent = new Verticalmenu($this->id_parent);
		$this->sp_lesp = $parent->sp_lesp + 1;
		parent::update($null_values);
	}
	
	public function delete()
	{
		$res = true;
		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'spverticalmenu_shop`
			WHERE `id_spverticalmenu` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}

	public function getChildren($id_spverticalmenu = null, $id_lang = null, $id_shop = null, $active = false,$id_spverticalmenu_group = false) {
        if (!$id_lang)
            $id_lang = Context::getContext()->language->id;
        if (!$id_shop)
            $id_shop = Context::getContext()->shop->id;
        $sql = ' SELECT m.*, ml.title,ml.sub_title, ml.html, ml.url, ml.short_description, ml.label
					FROM ' . _DB_PREFIX_ . 'spverticalmenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'spverticalmenu_lang ml ON m.id_spverticalmenu = ml.id_spverticalmenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'spverticalmenu_shop ms ON m.id_spverticalmenu = ms.id_spverticalmenu AND ms.id_shop = ' . (int) ($id_shop);
        if ($id_spverticalmenu != null) {
            $sql .= ' WHERE id_parent=' . (int) $id_spverticalmenu;
        }
		if ($active)
            $sql .= ' AND m.`active`=1 ';
		if($id_spverticalmenu_group)	
			$sql .= ' AND m.`id_spverticalmenu_group`='.(int)$id_spverticalmenu_group;
			
        $sql .= ' ORDER BY `position` ';
		
        return Db::getInstance()->executeS($sql);
    }		
	
	public function getTree($id_parent, $sp_lesp) {
            $id_lang       = Context::getContext()->language->id;
			$id_shop       = Context::getContext()->shop->id;
			$id_spverticalmenu_group = (int)Tools::getValue('id_spverticalmenu_group');
			$menus         	= $this->getChildren($id_parent, $id_lang,$id_shop,false,$id_spverticalmenu_group);
			$current 		= AdminController::$currentIndex.'&configure=spverticalmenu&token='.Tools::getAdminTokenLite('AdminModules').'';	
			$output = '';
            if($sp_lesp == 1)
			$output .= '<div class="spmenu" id="spverticalmenu">';
			
			$output .= '<ol class="sp_lesp'.$sp_lesp.' spmenu-list">';
            foreach ($menus as $menu) {
                $slc = Tools::getValue('id_spverticalmenu') == $menu['id_spverticalmenu']?"selected":"";
				$disable = ($menu['active'] && $menu['active'] == 1) ? '' : 'disable';
                $output .='<li id="list_' . $menu['id_spverticalmenu'] . '" class="'.$slc.' spmenu-item " data-id="' . $menu['id_spverticalmenu'] . '">
				<div class="spmenu-handle"></div>
				<div class="spmenu-content">
						<div class="col-md-6">
							<h4 class="pull-left">
								#'.$menu['id_spverticalmenu'].' - '.$menu['title'].'
							</h4>
						</div>						
						<div class="col-md-6">
							<div class="btn-group-action pull-right">
								'.$this->displayStatus($menu['id_spverticalmenu'], $menu['active'],(int)Tools::getValue('id_spverticalmenu_group')).'
								<a class="btn btn-default"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spverticalmenu&id_spverticalmenu='.$menu['id_spverticalmenu'].'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group').'">
									<i class="icon-edit"></i>
									Edit
								</a>
								<a class="btn btn-default btn-danger remove-menu"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spverticalmenu&delete_id_spverticalmenu='.$menu['id_spverticalmenu'].'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group').'">
									<i class="icon-trash"></i>
									Delete
								</a>
								<a class="btn btn-default duplicate-menu"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spverticalmenu&duplicate_id_spverticalmenu='.$menu['id_spverticalmenu'].'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group').'">
									<i class="icon-copy"></i>
									Duplicate
								</a>								
							</div>						
						</div>
				</div>';
				$chil = $this->getCategoryChild($menu['id_spverticalmenu']);
                if ($menu['id_spverticalmenu'] != $id_parent && count($chil) > 0)
                    $output .= $this->getTree($menu['id_spverticalmenu'], $sp_lesp + 1);
                $output .= '</li>';
            }

            $output .= '</ol>';
			
			if($sp_lesp == 1)
				$output .= '</div>';
				
            return $output;
    } 
	
	public function displayStatus($id_spverticalmenu, $active,$id_spverticalmenu_group)
	{
		$title = ((int)$active == 0 ? 'Disabled' : 'Enabled');
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure=spverticalmenu
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_spverticalmenu='.(int)$id_spverticalmenu.'&editMenugroup&id_spverticalmenu_group='.(int)$id_spverticalmenu_group.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';

		return $html;
	}
	
	public function updatePositions($lists,$sp_lesp,$id_parent){
		if($lists){
			foreach ($lists as $position => $list)
			{
				$res = Db::getInstance()->execute('
					UPDATE `'._DB_PREFIX_.'spverticalmenu` SET `position` = '.(int)$position.',`sp_lesp` = '.(int)$sp_lesp.',`id_parent` = '.(int)$id_parent.'
				WHERE `id_spverticalmenu` = '.(int)$list['id']
				);
				if(isset($list['children']) && $list['children']){
					$sp_lesp++;
					$this->updatePositions($list['children'],$sp_lesp,$list['id']);
				}
			}
		}
	} 
	


	public function renderSubMenu($id_spverticalmenu,$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group=0,$short_description=null){
		$output = '';
			if ($id_spverticalmenu != $id_parent){
				$parent = new Verticalmenu($id_spverticalmenu);
				$output .= '<div class="dropdown-menu" '.$style_sub.'>';
					$output .= $this->getVermegamenu($id_spverticalmenu, $sp_lesp + 1,$id_spverticalmenu_group);
					if(isset($short_description) && $short_description){
						$output .= '<div class="short_description clearfix">';
							$output .= $short_description;
						$output .= '</div>';
					}	
				$output .= '</div>';
			 }
		return 	$output;
	}	
	
	public static function deleteMenu($idspverticalmenu){
		$object = new Verticalmenu((int)$idspverticalmenu);
		if($object->delete()){
			self::deleteChildren($idspverticalmenu);
		}	
	}
	
	public static function deleteChildren($idspverticalmenu){
		$childrens =  self::getCategoryChild($idspverticalmenu);
		if($childrens){
			foreach($childrens as $children)
				self::deleteMenu($children['id_spverticalmenu']);
		}
	}
	
	
	public static function getCategoryChild($id_spverticalmenu){
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$sql = ' SELECT m.*, ml.title, ml.sub_title , ml.html, ml.url
					FROM ' . _DB_PREFIX_ . 'spverticalmenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'spverticalmenu_lang ml ON m.id_spverticalmenu = ml.id_spverticalmenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'spverticalmenu_shop ms ON m.id_spverticalmenu = ms.id_spverticalmenu AND ms.id_shop = ' . (int) ($id_shop).'
							WHERE m.id_parent = ' . (int) ($id_spverticalmenu);			
		return Db::getInstance()->executeS($sql);					
	}



	public function getmaxPositonMenu(){
		$sql = ' SELECT MAX(position) as max
					FROM ' . _DB_PREFIX_ . 'spverticalmenu';
		$max =  Db::getInstance()->getRow($sql);
		return $max['max'] + 1;	
	}
	
	public static function getAssociatedIdsShop($id_spverticalmenu)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_shop`
			FROM `'._DB_PREFIX_.'spverticalmenu_shop` hs
			WHERE hs.`id_spverticalmenu` = '.(int)$id_spverticalmenu
		);

		if (!is_array($result))
			return false;

		$return = array();

		foreach ($result as $id_shop)
			$return[] = (int)$id_shop['id_shop'];

		return $return;
	}
	
	public function getVermegamenu($id_parent, $sp_lesp,$id_spverticalmenu_group=null){
		global $link, $cookie;
		$this->user_groups = (Context::getContext()->customer->isLogged() ?
            Context::getContext()->customer->getGroups() : array(Configuration::get('PS_UNIDENTIFIED_GROUP')));
		$module    = new spverticalmenu();
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$menus      = $this->getChildren($id_parent, $id_lang,$id_shop,true,$id_spverticalmenu_group);
		$current	=	'';
		$output = '';
		$grower = '';
		if($menus ){
		if($sp_lesp ==1 )
			$output = '<ul class="nav navbar-nav  menu sp_lesp level-'.$sp_lesp.'">';
		else
			$output ='<ul class="level-'.$sp_lesp.'">';
			foreach ($menus as $menu) {
			$class = 'item-'.$sp_lesp.' ';
			if($menu['menu_class'])
				$class .= $menu['menu_class'];
				
			$chil = $this->getCategoryChild($menu['id_spverticalmenu']);

			if(count($chil) > 0){
				$class .= " parent";
				$grower = '<span class="grower close"> </span>';
			}
			else
				$grower = '';
			if($menu['group'] == 1 )
				$class .= " group";	
			$style = '';
			$style_sub = '';
			$label = '';
			$data_sub = '';
			if($menu['width'])	
				$style = 'style="width:'.$menu['width'].'"';	
			if($menu['sub_menu'] == 'yes' && $menu['sub_width']){
				if( preg_match("#%#", $menu['sub_width']) ){
					$menu['sub_width'] = str_replace( "%", "", $menu['sub_width']);
					$data_sub = 'data-subwidth="'.$menu['sub_width'].'"';
				}
				else
					$style_sub = 'style="width:'.$menu['sub_width'].'"';
			}	
			if(isset($menu['label']) && $menu['label'])	
				$label = $menu['label'];	
			$config = unserialize($menu['value']);		
			switch ($menu['type'])
			{
				case 'subcategories':
					if(!(empty($menu['cat_subcategories']))){
					$limit = (isset($config['limit1']) && $config['limit1']) ? (int)$config['limit1'] : 4;
                    $output .= $this->generateCategoriesMenu(Category::getNestedCategories($menu['cat_subcategories'], $id_lang, false, $this->user_groups),0,$class,$style,$menu);
                    }
					break;
				case 'category':
						if($this->page_name == 'category' && (Tools::getValue('category') == $config['category']))
							$class = $class.' active';
						if (Validate::isLoadedObject($category = new Category($config['category'], $id_lang))) {
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
							<a href="'.Tools::HtmlEntitiesUTF8($link->getCategoryLink((int) $category->id, $category->link_rewrite, $id_lang)).'" title="'.$category->name.'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';						
								$output .=	$label.Tools::safeOutput($menu['title']);	
							$output .= '</a>';
								if($menu['show_sub_title'] == 1 && $menu['sub_title'])
									$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
								if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
									$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
							$output .= $grower;	
							$output .= '</li>'.PHP_EOL;
						}
					break;
				case 'product':
					if($this->page_name == 'product' && (Tools::getValue('id_product') == $config['product']))
							$class = $class.' active';
					$product = new Product((int)$config['product'], true, (int)$id_lang);
					if (!is_null($product->id))
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
							<a href="'.Tools::HtmlEntitiesUTF8($product->getLink()).'" title="'.$product->name.'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';					
								$output .=	$label.Tools::safeOutput($menu['title']);	
							$output .= '</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					break;
				
				case 'productlist':	
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>';
						$limit = (isset($config['limit']) && $config['limit']) ? (int)$config['limit'] : 4;
						$col = (isset($config['col']) && $config['col']) ? (int)$config['col'] : 4;
							if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";
							if( $config['type']){ 
								$products = array();	
								switch ( $config['type'] ) {
									case 'new':
										 $products = Product::getNewProducts((int) Context::getContext()->language->id, 0, $limit);
										break;
									case 'featured':
										$category = new Category(Context::getContext()->shop->getCategory(), (int)(Context::getContext()->language->id) );
										$products = $category->getProducts((int)(Context::getContext()->language->id), 1, $limit);
										break;
									case 'bestseller':
										$products = ProductSale::getBestSales((int)(Context::getContext()->language->id), 0, $limit,'date_add');
										break;	
									case 'special': 
										 $products = Product::getPricesDrop((int)(Context::getContext()->language->id), 0, $limit,false);
										break;		
								}
								$module = new spverticalmenu();
								$output .= 	$module->renderProductList($products,$col);
							}
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
						$output .= '</li>';
					
					break;	
				
				case 'cms':
					if( preg_match("#CMS#", $config['cms']) ){ 
						$config['cms'] = str_replace( "CMS", "", $config['cms']);
						$cms = CMS::getLinks((int)$id_lang, array($config['cms']));
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
							<a href="'.Tools::HtmlEntitiesUTF8($cms[0]['link']).'" title="'.Tools::safeOutput($cms[0]['meta_title']).'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';						
								$output .=	$label.Tools::safeOutput($menu['title']);		
							$output .= '</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					}
					elseif( preg_match("#CAT#", $config['cms']) ){ 
						$config['cms'] = str_replace( "CAT", "", $config['cms']);
						$category = new CMSCategory((int)$config['cms'], (int)$id_lang);
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
							<a href="'.Tools::HtmlEntitiesUTF8($category->getLink()).'" title="'.$category->name.'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';					
								$output .=	$label.Tools::safeOutput($menu['title']);	
							$output .= '</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					}					
					break;

				case 'manufacture':
					if($config['manufacture'] != 0){
						if($this->page_name == 'manufacture' && (Tools::getValue('id_manufacture') == $config['manufacture']))
								$class = $class.' sfHover';
						$manufacturer = new Manufacturer((int)$config['manufacture'], (int)$id_lang);
						if (!is_null($manufacturer->id))
						{
							if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
								$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
							else
								$manufacturer->link_rewrite = 0;
							$link = new Link;
							$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
								<a href="'.Tools::HtmlEntitiesUTF8($link->getManufacturerLink((int)$manufacturer->id, $manufacturer->link_rewrite)).'" title="'.Tools::safeOutput($manufacturer->name).'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';						
									$output .=	$label.Tools::safeOutput($menu['title']);	
								$output .= '</a>';
								if($menu['show_sub_title'] == 1 && $menu['sub_title'])
									$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
								if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
									$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
							$output .= $grower;	
							$output .= '</li>'.PHP_EOL;
						}
					}else{
						$col_li = '';
						$col = (isset($config['col']) && $config['col']) ? $config['col'] : 1;
						$ipage = 12/$col;
						$col_li = 'class="col-sm-'.$ipage.'"';
						$link = new Link;
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'><a href="'.$link->getPageLink('manufacturer').'" title="'.$module->l('All manufacturers').'">'.$module->l('All manufacturers').'</a>';
						if($menu['show_title'] == 1)
									$output .= '<span class="menu-title">'.$menu['title']."</span>";	
						$output .= '<ul>'.PHP_EOL;
						$manufacturers = Manufacturer::getManufacturers();
						foreach ($manufacturers as $key => $manufacturer)
							$output .= '<li '.$col_li.'><a href="'.$link->getManufacturerLink((int)$manufacturer['id_manufacturer'], $manufacturer['link_rewrite']).'" title="'.Tools::safeOutput($manufacturer['name']).'">'.Tools::safeOutput($manufacturer['name']).'</a></li>'.PHP_EOL;
						$output .= '</ul>';						
					}					
					break;

				case 'supplier':
					if($config['supplier'] != 0){
						if($this->page_name == 'supplier' && (Tools::getValue('id_supplier') == $config['supplier']))
								$class = $class.' sfHover';
						$supplier = new Supplier((int)$config['supplier'], (int)$id_lang);
						if (!is_null($supplier->id))
						{
							$link = new Link;
							$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
								<a href="'.Tools::HtmlEntitiesUTF8($link->getSupplierLink((int)$supplier->id, $supplier->link_rewrite)).'" title="'.$supplier->name.'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';					
									$output .=	$label.Tools::safeOutput($menu['title']);	
								$output .= '</a>';
								if($menu['show_sub_title'] == 1 && $menu['sub_title'])
									$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
								if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
									$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group);
								$output .= $grower;	
							$output .= '</li>'.PHP_EOL;
						}
					}else{
						$link = new Link;
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'><a href="'.$link->getPageLink('supplier').'" title="'.$module->l('All suppliers').'">'.$module->l('All suppliers').'</a>';
						if($menu['show_title'] == 1)
									$output .= '<span class="menu-title">'.$menu['title']."</span>";
						$output .= '<ul>'.PHP_EOL;
						$suppliers = Supplier::getSuppliers();
						foreach ($suppliers as $key => $supplier)
							$output .= '<li><a href="'.$link->getSupplierLink((int)$supplier['id_supplier'], $supplier['link_rewrite']).'" title="'.Tools::safeOutput($supplier['name']).'">'.Tools::safeOutput($supplier['name']).'</a></li>'.PHP_EOL;
						$output .= '</ul>';						
					}
					break;

				case 'url':
						$output .= '<li class="'.$class.'" '.$style.' '.$data_sub.'>
							<a href="'.Tools::HtmlEntitiesUTF8($menu['url']).'" title="'.Tools::safeOutput($menu['title']).'">';
								if(isset($menu['icon']) && !empty($menu['icon']))
									$output .= '<i class="'.$menu['icon'].'"></i>';
									$output .=	$label.'<span class="sp_megamenu_title">'.Tools::safeOutput($menu['title']).'</span>';	
							$output .= '</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spverticalmenu'],$id_parent,$sp_lesp,$style_sub,$id_spverticalmenu_group,$menu['short_description']);
							else	
								if(isset($menu['short_description']) && $menu['short_description']){
									$output .= '<div class="short_description">';
										$output .= $menu['short_description'];
									$output .= '</div>';
								}	
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					break;
				case 'html':	
						$output .= '<li class="'.$class.'" '.$style.' >';
							if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";
							if( $menu['html']){   
								$output .= '<div class="menu-content">'.$menu['html'].'</div>'; 
							}
						$output .= '</li>';
					
					break;	
			}
        }
		$output .= '</ul>';	
		}
		
		
		return $output;
	}

    protected function getCMSCategories($recursive = false, $parent = 1, $id_lang = false, $id_shop = false)
    {
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $join_shop = '';
        $where_shop = '';

        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $join_shop = ' INNER JOIN `'._DB_PREFIX_.'cms_category_shop` cs
			ON (bcp.`id_cms_category` = cs.`id_cms_category`)';
            $where_shop = ' AND cs.`id_shop` = '.(int)$id_shop.' AND cl.`id_shop` = '.(int)$id_shop;
        }

        if ($recursive === false) {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `'._DB_PREFIX_.'cms_category` bcp'.
                $join_shop.'
				INNER JOIN `'._DB_PREFIX_.'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
				AND bcp.`id_parent` = '.(int)$parent.
                $where_shop;

            return Db::getInstance()->executeS($sql);
        } else {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `'._DB_PREFIX_.'cms_category` bcp'.
                $join_shop.'
				INNER JOIN `'._DB_PREFIX_.'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
				AND bcp.`id_parent` = '.(int)$parent.
                $where_shop;

            $results = Db::getInstance()->executeS($sql);
            foreach ($results as $result) {
                $sub_categories = $this->getCMSCategories(true, $result['id_cms_category'], (int)$id_lang);
                if ($sub_categories && count($sub_categories) > 0) {
                    $result['sub_categories'] = $sub_categories;
                }
                $categories[] = $result;
            }

            return isset($categories) ? $categories : false;
        }
    }	
	
	public function getCMSOptions($parent = 0, $depth = 1, $id_lang = false, $id_shop = false)
    {
        $result = array();
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang, (int)$id_shop);

        $spacer = str_repeat('&nbsp;', 5 * (int)$depth);
		if($categories)
			foreach ($categories as $category) {
				$row['name'] = $category['name'];
				$row['value'] = 'CAT'.$category['id_cms_category'];
				$result[] = $row;
				$pages = $this->getCMSPages((int)$category['id_cms_category'], false, (int)$id_lang, (int)$id_shop);
				if($pages)
					foreach ($pages as $page) {
						$cms['name'] = $spacer.$page['meta_title'];
						$cms['value'] = 'CMS'.$page['id_cms'];
						$result[] = $cms;
					}
			}

        return $result;
    }	


    protected function getCMSPages($id_cms_category, $id_lang = false, $id_shop = false)
    {
        $id_shop = ($id_shop !== false) ? (int)$id_shop : (int)Context::getContext()->shop->id;
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

        $where_shop = '';
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $where_shop = ' AND cl.`id_shop` = '.(int)$id_shop;
        }

        $sql = 'SELECT c.`id_cms`, cl.`meta_title`, cl.`link_rewrite`
			FROM `'._DB_PREFIX_.'cms` c
			INNER JOIN `'._DB_PREFIX_.'cms_shop` cs
			ON (c.`id_cms` = cs.`id_cms`)
			INNER JOIN `'._DB_PREFIX_.'cms_lang` cl
			ON (c.`id_cms` = cl.`id_cms`)
			WHERE c.`id_cms_category` = '.(int)$id_cms_category.'
			AND cs.`id_shop` = '.(int)$id_shop.'
			AND cl.`id_lang` = '.(int)$id_lang.
            $where_shop.'
			AND c.`active` = 1
			ORDER BY `position`';

        return Db::getInstance()->executeS($sql);
    }	
		
	
	protected function generateCategoriesMenu($categories, $is_children = 0,$class=null,$style=null,$menu=array(),$rep = 0)
    {
		
        $html = '';
		$rep++;	
		$context = Context::getContext();
		$id_lang    = Context::getContext()->language->id;
		$config = unserialize($menu['value']);
		
        foreach ($categories as $key => $category) {
            if ($category['level_depth'] > 1) {
                $cat = new Category($category['id_category']);
                $link = Tools::HtmlEntitiesUTF8($cat->getLink());
            } else {
                $link = $this->context->link->getPageLink('index');
            }

            /* Whenever a category is not active we shouldnt display it to customer */
            if ((bool)$category['active'] === false) {
                continue;
            }
			
			$str_class = '';
			$grower = '';
			$childrens = array();
            if (isset($category['children']) && !empty($category['children'])) {			
				$check = 1;			
				if(isset($config['limit'.$rep])){
					foreach($category['children'] as $key=>$children){
						if($check <= $config['limit'.$rep])
							$childrens[$key] = $children;
						$check ++ ;
					}	
				}
				else
					$childrens = $category['children'];
			}
			
			if($this->page_name == 'category' && (Tools::getValue('id_category') == $config['category']))
				$class = $class.' sfHoverForce';
				
			if($childrens){	
				if(strpos( $class, 'parent' ) === false)
					$class .= ' parent';
					$grower .= '<span class="grower close"> </span>';
			}	
			
			$str_class = 'class="'.$class.'"';
            $html .= '<li '.$str_class.' '.$style.' >';
            $html .= '<a href="'.$link.'" title="'.$category['name'].'">';
				if(isset($menu['icon']) && $menu['icon'] && $rep == 1)
					$html .=	'<i class="'.$menu['icon'].'"></i>';				
			$html .= $category['name'];
			$html .= '</a>';
			if (isset($config) && $config['showimgchild'] == 'yes' && $rep >1) {
			$subcate = new Category($category['id_category'], $id_lang);	
				$html .= '<div><img src="'. $context->link->getCatImageLink($subcate->link_rewrite, $subcate->id_image, 'category_default')
					.'" alt="'.Tools::SafeOutput($category['name']).'" title="'
					.Tools::SafeOutput($category['name']).'" class="imgm" /></div>';				
			}

			if($childrens){	
				$html .= '<div class="dropdown-menu"><ul>';					
				$html .= $this->generateCategoriesMenu($childrens, 1,null,null,$menu,$rep);
				if (isset($config) && $config['showimg'] == 'yes' && $rep <=1) {
					$cate = new Category($category['id_category'], $id_lang);
						$html .= '<li class="category-thumbnail">';
								$html .= '<div><img src="'. $context->link->getCatImageLink($cate->link_rewrite, $cate->id_image, 'category_default')
								.'" alt="'.Tools::SafeOutput($category['name']).'" title="'
								.Tools::SafeOutput($category['name']).'" class="imgm" /></div>';
						$html .= '</li>';
				}
				$html .= '</ul></div>';
				$html .= $grower;
			}
			
            $html .= '</li>';
        }
		
        return $html;
    }
}