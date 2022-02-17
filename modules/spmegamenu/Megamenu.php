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

class Megamenu extends ObjectModel
{
	public $id;
    public $id_spmegamenu;
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
	public $id_spmegamenu_group;
	public $group = 0;
    public $position;
    public $url;
    public $menu_class;
	public $limit_product = 4;
	public $cat_subcategories;
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
        'table' => 'spmegamenu',
        'primary' => 'id_spmegamenu',
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
			'cat_subcategories' => array('type' => self::TYPE_INT),
			'id_spmegamenu_group' => array('type' => self::TYPE_INT),
            'menu_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
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
		$parent = new Megamenu($this->id_parent);
		$this->sp_lesp = $parent->sp_lesp + 1;
		$res = parent::add($autodate,$null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'spmegamenu_shop` (`id_shop`, `id_spmegamenu`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function update($null_values = false)
	{
		$id_shop = Context::getContext()->shop->id;
		$parent = new Megamenu($this->id_parent);
		$this->sp_lesp = $parent->sp_lesp + 1;
		parent::update($null_values);
	}
	
	public function delete()
	{
		$res = true;
		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'spmegamenu_shop`
			WHERE `id_spmegamenu` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}
	
	public function getChildren($id_spmegamenu = null, $id_lang = null, $id_shop = null, $active = false,$id_spmegamenu_group = false) {
        if (!$id_lang)
            $id_lang = Context::getContext()->language->id;
        if (!$id_shop)
            $id_shop = Context::getContext()->shop->id;
        $sql = ' SELECT m.*, ml.title,ml.sub_title, ml.html, ml.url, ml.short_description, ml.label
					FROM ' . _DB_PREFIX_ . 'spmegamenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'spmegamenu_lang ml ON m.id_spmegamenu = ml.id_spmegamenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'spmegamenu_shop ms ON m.id_spmegamenu = ms.id_spmegamenu AND ms.id_shop = ' . (int) ($id_shop);
        if ($id_spmegamenu != null) {
            $sql .= ' WHERE id_parent=' . (int) $id_spmegamenu;
        }
		if ($active)
            $sql .= ' AND m.`active`=1 ';
		if($id_spmegamenu_group)	
			$sql .= ' AND m.`id_spmegamenu_group`='.(int)$id_spmegamenu_group;
			
        $sql .= ' ORDER BY `position` ';
        return Db::getInstance()->executeS($sql);
    }
	
	
	public function getTree($id_parent, $sp_lesp) {
            $id_lang       = Context::getContext()->language->id;
			$id_shop       = Context::getContext()->shop->id;
			$id_spmegamenu_group = (int)Tools::getValue('id_spmegamenu_group');
			$menus         	= $this->getChildren($id_parent, $id_lang,$id_shop,false,$id_spmegamenu_group);
			$current 		= AdminController::$currentIndex.'&configure=spmegamenu&token='.Tools::getAdminTokenLite('AdminModules').'';	
			$output = '';
            if($sp_lesp == 1)
			$output .= '<div class="spmenu" id="spmegamenu">';
			
			$output .= '<ol class="sp_lesp'.$sp_lesp.' spmenu-list">';
            foreach ($menus as $menu) {
                $slc = Tools::getValue('id_spmegamenu') == $menu['id_spmegamenu']?"selected":"";
				$disable = ($menu['active'] && $menu['active'] == 1) ? '' : 'disable';
                $output .='<li id="list_' . $menu['id_spmegamenu'] . '" class="'.$slc.' spmenu-item " data-id="' . $menu['id_spmegamenu'] . '">
				<div class="spmenu-handle"></div>
				<div class="spmenu-content">
						<div class="col-md-6">
							<h4 class="pull-left">
								#'.$menu['id_spmegamenu'].' - '.$menu['title'].'
							</h4>
						</div>						
						<div class="col-md-6">
							<div class="btn-group-action pull-right">
								'.$this->displayStatus($menu['id_spmegamenu'], $menu['active']).'
								<a class="btn btn-default"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spmegamenu&id_spmegamenu='.$menu['id_spmegamenu'].'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group').'">
									<i class="icon-edit"></i>
									Edit
								</a>
								<a class="btn btn-default btn-danger remove-menu"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spmegamenu&delete_id_spmegamenu='.$menu['id_spmegamenu'].'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group').'">
									<i class="icon-trash"></i>
									Delete
								</a>
								<a class="btn btn-default duplicate-menu"
									href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spmegamenu&duplicate_id_spmegamenu='.$menu['id_spmegamenu'].'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group').'">
									<i class="icon-copy"></i>
									Duplicate
								</a>								
							</div>						
						</div>
				</div>';
				$chil = $this->getCategoryChild($menu['id_spmegamenu']);
                if ($menu['id_spmegamenu'] != $id_parent && count($chil) > 0)
                    $output .= $this->getTree($menu['id_spmegamenu'], $sp_lesp + 1);
                $output .= '</li>';
            }

            $output .= '</ol>';
			
			if($sp_lesp == 1)
				$output .= '</div>';
				
            return $output;
    }   
	
	public function displayStatus($id_spmegamenu, $active)
	{
		$title = ((int)$active == 0 ? 'Disabled' : 'Enabled');
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$id_spmegamenu_group = (int)Tools::getValue('id_spmegamenu_group');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure=spmegamenu
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_spmegamenu='.(int)$id_spmegamenu.'&editMenugroup&id_spmegamenu_group='.(int)$id_spmegamenu_group.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';

		return $html;
	}
	
	public function updatePositions($lists,$sp_lesp,$id_parent){
		if($lists){
			foreach ($lists as $position => $list)
			{
				$res = Db::getInstance()->execute('
					UPDATE `'._DB_PREFIX_.'spmegamenu` SET `position` = '.(int)$position.',`sp_lesp` = '.(int)$sp_lesp.',`id_parent` = '.(int)$id_parent.'
				WHERE `id_spmegamenu` = '.(int)$list['id']
				);
				if(isset($list['children']) && $list['children']){
					$sp_lesp++;
					$this->updatePositions($list['children'],$sp_lesp,$list['id']);
				}
			}
		}
	} 
	


	public function renderSubMenu($id_spmegamenu,$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group=0,$short_description=null){
		$output = '';
			if ($id_spmegamenu != $id_parent){
				$parent = new Megamenu($id_spmegamenu);
				$output .= '<div class="dropdown-menu" '.$style_sub.'>';
					$output .= $this->getMegamenu($id_spmegamenu, $sp_lesp + 1,$id_spmegamenu_group);
					if(isset($short_description) && $short_description){
						$output .= '<div class="short_description clearfix">';
							$output .= $short_description;
						$output .= '</div>';
					}	
				$output .= '</div>';
			 }
		return 	$output;
	}	
	
	public static function deleteMenu($idspmegamenu){
		$object = new Megamenu((int)$idspmegamenu);
		if($object->delete()){
			self::deleteChildren($idspmegamenu);
		}	
	}
	
	public static function deleteChildren($idspmegamenu){
		$childrens =  self::getCategoryChild($idspmegamenu);
		if($childrens){
			foreach($childrens as $children)
				self::deleteMenu($children['id_spmegamenu']);
		}
	}
	
	
	public static function getCategoryChild($id_spmegamenu){
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$sql = ' SELECT m.*, ml.title, ml.sub_title , ml.html, ml.url
					FROM ' . _DB_PREFIX_ . 'spmegamenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'spmegamenu_lang ml ON m.id_spmegamenu = ml.id_spmegamenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'spmegamenu_shop ms ON m.id_spmegamenu = ms.id_spmegamenu AND ms.id_shop = ' . (int) ($id_shop).'
							WHERE m.id_parent = ' . (int) ($id_spmegamenu);			
		return Db::getInstance()->executeS($sql);					
	}



	public function getmaxPositonMenu(){
		$sql = ' SELECT MAX(position) as max
					FROM ' . _DB_PREFIX_ . 'spmegamenu';
		$max =  Db::getInstance()->getRow($sql);
		return $max['max'] + 1;	
	}
	
	public static function getAssociatedIdsShop($id_spmegamenu)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_shop`
			FROM `'._DB_PREFIX_.'spmegamenu_shop` hs
			WHERE hs.`id_spmegamenu` = '.(int)$id_spmegamenu
		);

		if (!is_array($result))
			return false;

		$return = array();

		foreach ($result as $id_shop)
			$return[] = (int)$id_shop['id_shop'];

		return $return;
	}
	
	public function getMegamenu($id_parent, $sp_lesp,$id_spmegamenu_group=null){
		global $link, $cookie;
		$this->page_name = Dispatcher::getInstance()->getController();
		$output = '';
		$module    	= new spmegamenu();
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$menus      = $this->getChildren($id_parent, $id_lang,$id_shop,true,$id_spmegamenu_group);
		$current	=	'';
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
				
			$chil = $this->getCategoryChild($menu['id_spmegamenu']);

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
			if($menu['width'])	
				$style = 'style="width:'.$menu['width'].'"';	
			if($menu['sub_menu'] == 'yes' && $menu['sub_width'])	
				$style_sub = 'style="width:'.$menu['sub_width'].'"';	
			if(isset($menu['label']) && $menu['label'])	
				$label = $menu['label'];	
			$config = unserialize($menu['value']);		
			switch ($menu['type'])
			{
				case 'subcategories':
					$min_depth = 10;
					foreach (Category::getNestedCategories($menu['cat_subcategories'], $id_lang, false, $this->user_groups) as  $category) {
						if($category['level_depth'] <= $min_depth)
							$min_depth = $category['level_depth'];
					}		
					$output .= $this->generateCategoriesMenu(Category::getNestedCategories($menu['cat_subcategories'], $id_lang, false, $this->user_groups),0,$class,$style,$menu,$min_depth);
					break;
				case 'category':
						if($this->page_name == 'category' && (Tools::getValue('id_category') == $config['category']))
							$class = $class.' active';
						if (Validate::isLoadedObject($category = new Category($config['category'], $id_lang))) {
							$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($link->getCategoryLink((int) $category->id, $category->link_rewrite, $id_lang)).'" title="'.$menu['title'].'">'.$label.''.$menu['title'].'</a>';
								if($menu['show_sub_title'] == 1 && $menu['sub_title'])
									$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
								if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
							$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
							$output .= $grower;	
							$output .= '</li>'.PHP_EOL;
						}
					break;
				case 'product':
					$product = new Product((int)$config['product'], true, (int)$id_lang);
					if (!is_null($product->id))
						$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($product->getLink()).'" title="'.$product->name.'">'.$product->name.'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					break;
				
				case 'productlist':	
						$output .= '<li class="'.$class.'" '.$style.'>';
						$limit = (isset($config['limit']) && $config['limit']) ? (int)$config['limit'] : 4;
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
										 $products = $special = Product::getPricesDrop((int)(Context::getContext()->language->id), 0, $limit,false);
										break;		
								}
								$module = new spmegamenu();
								$output .= 	$module->renderProductList($products);
							}
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
						$output .= '</li>';
					
					break;	
				
				case 'cms':
					if($this->page_name == 'cms' && (Tools::getValue('id_cms') == $config['cms']))
							$class = $class.' active';
					$cms = CMS::getLinks((int)$id_lang, array($config['cms']));
					if (count($cms))
						$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($cms[0]['link']).'" title="'.Tools::safeOutput($menu['title']).'">'.$label.' '.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
						$output .= $grower;		
						$output .= '</li>'.PHP_EOL;
					break;

				// Case to handle the option to show all Manufacturers
				case 'all_manufacture':
					$link = new Link;
					$output .= '<li class="'.$class.'" '.$style.'><a href="'.$link->getPageLink('manufacturer').'" title="'.$module->l('All manufacturers').'">'.$module->l('All manufacturers').'</a>';
					if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";	
					$output .= '<ul>'.PHP_EOL;
					$manufacturers = Manufacturer::getManufacturers();
					foreach ($manufacturers as $key => $manufacturer)
						$output .= '<li><a href="'.$link->getManufacturerLink((int)$manufacturer['id_manufacturer'], $manufacturer['link_rewrite']).'" title="'.Tools::safeOutput($manufacturer['name']).'">'.Tools::safeOutput($manufacturer['name']).'</a></li>'.PHP_EOL;
					$output .= '</ul>';
					break;

				case 'manufacture':
					if($this->page_name == 'manufacturer' && (Tools::getValue('id_manufacturer') == $config['manufacture']))
							$class = $class.' active';
					$manufacturer = new Manufacturer((int)$config['manufacture'], (int)$id_lang);
					if (!is_null($manufacturer->id))
					{
						if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
							$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
						else
							$manufacturer->link_rewrite = 0;
						$link = new Link;
						$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($link->getManufacturerLink((int)$config['manufacture'], $manufacturer->link_rewrite)).'" title="'.Tools::safeOutput($menu['title']).'">'.$label.' '.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
						$output .= $grower;	
						$output .= '</li>'.PHP_EOL;
					}
					break;

				// Case to handle the option to show all Suppliers
				case 'all_supplier':
					$link = new Link;
					$output .= '<li class="'.$class.'" '.$style.'><a href="'.$link->getPageLink('supplier').'" title="'.$module->l('All suppliers').'">'.$module->l('All suppliers').'</a>';
					if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";
					$output .= '<ul>'.PHP_EOL;
					$suppliers = Supplier::getSuppliers();
					foreach ($suppliers as $key => $supplier)
						$output .= '<li><a href="'.$link->getSupplierLink((int)$supplier['id_supplier'], $supplier['link_rewrite']).'" title="'.Tools::safeOutput($supplier['name']).'">'.Tools::safeOutput($supplier['name']).'</a></li>'.PHP_EOL;
					$output .= '</ul>';
					break;

				case 'supplier':
					if($this->page_name == 'supplier' && (Tools::getValue('id_supplier') == $config['supplier']))
						$class = $class.' active';
					$supplier = new Supplier((int)$config['supplier'], (int)$id_lang);
					if (!is_null($supplier->id))
					{
						$link = new Link;
						$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($link->getSupplierLink((int)$config['supplier'], $supplier->link_rewrite)).'" title="'.$menu['title'].'">'.$label.' '.$menu['title'].'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group);
							$output .= $grower;	
						$output .= '</li>'.PHP_EOL;
					}
					break;

				case 'url':
						$output .= '<li class="'.$class.'" '.$style.'><a href="'.Tools::HtmlEntitiesUTF8($menu['url']).'" title="'.Tools::safeOutput($menu['title']).'">'.$label.' '.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-subtitle">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->renderSubMenu($menu['id_spmegamenu'],$id_parent,$sp_lesp,$style_sub,$id_spmegamenu_group,$menu['short_description']);
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
						$output .= '<li class="'.$class.'" '.$style.'>';
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
	
	private function getCMSMenuItems($parent, $depth = 1, $id_lang = false)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

		if ($depth > 3)
			return;

		$categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang);
		$pages = $this->getCMSPages((int)$parent);

		if (count($categories) || count($pages))
		{
			$output .= '<ul>';

			foreach ($categories as $category)
			{
				$cat = new CMSCategory((int)$category['id_cms_category'], (int)$id_lang);
				
				$output .= '<li>';
				$output .= '<a href="'.Tools::HtmlEntitiesUTF8($cat->getLink()).'">'.$category['name'].'</a>';
				$this->getCMSMenuItems($category['id_cms_category'], (int)$depth + 1);
				$output .= '</li>';
			}

			foreach ($pages as $page)
			{
				$cms = new CMS($page['id_cms'], (int)$id_lang);
				$links = $cms->getLinks((int)$id_lang, array((int)$cms->id));

				$selected = ($this->page_name == 'cms' && ((int)Tools::getValue('id_cms') == $page['id_cms'])) ? ' class="sfHoverForce"' : '';
				$output .= '<li '.$selected.'>';
				$output .= '<a href="'.$links[0]['link'].'">'.$cms->meta_title.'</a>';
				$output .= '</li>';
			}

			$output .= '</ul>';
		}
	}	
	
	protected function generateCategoriesMenu($categories, $is_children = 0,$class=null,$style=null,$menu=array(),$min_depth)
    {
		
        $html = '';
		$context = Context::getContext();
		$id_lang    = Context::getContext()->language->id;
		$config = unserialize($menu['value']);
        foreach ($categories as $key => $category) {
			$rep = $category['level_depth'] - $min_depth + 1;
            if ($category['level_depth'] > 1) {
                $cat = new Category($category['id_category']);
                $link = Tools::HtmlEntitiesUTF8($cat->getLink());
            } else {
                $link = $context->link->getPageLink('index');
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
				if(isset($config['limit'.$rep]) &&  (int)$config['limit'.$rep] >= 0){
					foreach($category['children'] as $key=>$children){
						if($check <= $config['limit'.$rep])
							$childrens[$key] = $children;
						$check ++ ;
					}	
				}
				else
					$childrens = $category['children'];
			}
			
			if($this->page_name == 'category' && (Tools::getValue('id_category') == $category['id_category']))
				$class = $class.' active';
				
			if($childrens){	
				if(strpos( $class, 'parent' ) === false)
					$class .= ' parent';
					$grower .= '<span class="grower close"> </span>';
			}	
			
			$str_class = 'class="'.$class.'"';
            $html .= '<li '.$str_class.' '.$style.' >';
            $html .= '<a href="'.$link.'" title="'.$category['name'].'">'.$category['name'].'</a>';
			if (isset($config) && $config['showimgchild'] == 'yes' && $rep >1) {
			$subcate = new Category($category['id_category'], $id_lang);	
				$html .= '<div><img src="'. $context->link->getCatImageLink($subcate->link_rewrite, $subcate->id_image, 'category_default')
					.'" alt="'.Tools::SafeOutput($category['name']).'" title="'
					.Tools::SafeOutput($category['name']).'" class="imgm" /></div>';				
			}

			if($childrens){	
				$html .= '<div class="dropdown-menu"><ul>';					
				$html .= $this->generateCategoriesMenu($childrens, 1,null,null,$menu,$min_depth);
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