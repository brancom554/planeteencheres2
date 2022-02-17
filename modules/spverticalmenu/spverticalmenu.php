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
*	Developer tunghv
*  @author MagenTech 
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/	

/**
 * @since   1.5.0
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'spverticalmenu/Verticalmenu.php');
include_once(_PS_MODULE_DIR_.'spverticalmenu/VerticalGroup.php');

class spverticalmenu extends Module
{
	protected $_html = '';
	private $default_hook = array('displayVertical', 'displayVertical2', 'displayVertical3');	
	public function __construct()
	{
		$this->name = 'spverticalmenu';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'MagenTech';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

        $this->displayName = $this->l('Sp Vertical Megamenu');
        $this->description = $this->l('Adds a new Vertical mega menu to the top of your e-commerce website.');
		$this->ps_versions_compliancy = array('min' => '1.6.0.4', 'max' => _PS_VERSION_);
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayVertical') &&
			$this->registerHook('displayVertical2') &&
			$this->registerHook('displayVertical3') &&
            $this->registerHook('actionObjectCategoryUpdateAfter') &&
            $this->registerHook('actionObjectCategoryDeleteAfter') &&
            $this->registerHook('actionObjectCategoryAddAfter') &&
            $this->registerHook('actionObjectCmsUpdateAfter') &&
            $this->registerHook('actionObjectCmsDeleteAfter') &&
            $this->registerHook('actionObjectCmsAddAfter') &&
            $this->registerHook('actionObjectSupplierUpdateAfter') &&
            $this->registerHook('actionObjectSupplierDeleteAfter') &&
            $this->registerHook('actionObjectSupplierAddAfter') &&
            $this->registerHook('actionObjectManufacturerUpdateAfter') &&
            $this->registerHook('actionObjectManufacturerDeleteAfter') &&
            $this->registerHook('actionObjectManufacturerAddAfter') &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('actionObjectProductDeleteAfter') &&
            $this->registerHook('actionObjectProductAddAfter') &&
            $this->registerHook('categoryUpdate') &&
            $this->registerHook('actionShopDataDuplication'))
		{
			foreach ($this->default_hook as $hook)
			{
				if (!$this->registerHook ($hook))
					return false;
			}	
			/* Creates tables */
			$res = $this->createTables();
			/* Adds samples */
			if ($res)
				include_once( dirname(__FILE__).'/sample.php');
				
			return (bool)$res;
		}

		return false;
	}
	
	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();
			return (bool)$res;
		}

		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* spverticalmenu */
		$res = (bool)Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spverticalmenu_group` (
			`id_spverticalmenu_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`hook` varchar(20) NOT NULL, 
			`params` text NOT NULL DEFAULT \'\' ,
			`status` tinyint(1) NOT NULL DEFAULT \'1\',
			`position` int(10) unsigned NOT NULL,
			PRIMARY KEY (`id_spverticalmenu_group`)) ENGINE=InnoDB default CHARSET=utf8');
		$res &= Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spverticalmenu_group_shop` (
			`id_spverticalmenu_group` int(10) unsigned NOT NULL,
			`id_shop` int(10) unsigned NOT NULL, 
			PRIMARY KEY (`id_spverticalmenu_group`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$res &= Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spverticalmenu_group_lang (
			`id_spverticalmenu_group` int(10) unsigned NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`title` varchar(255) NOT NULL DEFAULT \'\',
			`content` text,
			PRIMARY KEY (`id_spverticalmenu_group`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');		
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spverticalmenu` (
			  `id_spverticalmenu` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_spverticalmenu_group` int(10) unsigned NOT NULL,			  
			  `id_parent` int(11) NOT NULL,
			  `value` varchar(255) NOT NULL,
			  `type` varchar(20) NOT NULL,
			  `width` varchar(25) NOT NULL,
			  `menu_class` varchar(25) NOT NULL,
			  `icon` varchar(25) NOT NULL,
			  `show_title` tinyint(1) NOT NULL,
			  `show_sub_title` tinyint(1) NOT NULL,			  
			  `sub_menu` varchar(25) NOT NULL,
			  `sub_width` varchar(25) NOT NULL,
			  `group` tinyint(1) NOT NULL,
			  `type_submenu` tinyint(1) NOT NULL DEFAULT 1,
			  `lesp` int(11) NOT NULL,
				`cat_subcategories` int(11) NOT NULL,
			  `sp_lesp` int(11) NOT NULL,
			  `position` int(11) NOT NULL,
			  `active` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id_spverticalmenu`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* spverticalmenu lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spverticalmenu_lang` (
			  `id_spverticalmenu` int(11) NOT NULL,
			  `id_lang` int(11) NOT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `label` varchar(255) DEFAULT NULL,
			  `short_description` varchar(255) DEFAULT NULL,
			  `sub_title` varchar(255) DEFAULT NULL,
			  `html` text NOT NULL,
			  `url` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_spverticalmenu`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
		');

		/* menus shop */
		$res &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spverticalmenu_shop` (
			  `id_spverticalmenu` int(11) NOT NULL,
			  `id_shop` int(11) NOT NULL,
			  PRIMARY KEY (`id_spverticalmenu`,`id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$menus = $this->getMenus();
		foreach ($menus as $menu)
		{
			$to_del = new Verticalmenu($menu['id_spverticalmenu']);
			$to_del->delete();
		}

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS 
				`'._DB_PREFIX_.'spverticalmenu`, 
				`'._DB_PREFIX_.'spverticalmenu_lang`,
				`'._DB_PREFIX_.'spverticalmenu_shop`,
				`'._DB_PREFIX_.'spverticalmenu_group`,
				`'._DB_PREFIX_.'spverticalmenu_group_shop`,
				`'._DB_PREFIX_.'spverticalmenu_group_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();

		/* Validate & process */
		if (Tools::isSubmit('submitMenu') || Tools::isSubmit('delete_id_spverticalmenu') || Tools::isSubmit('duplicate_id_spverticalmenu') ||
			Tools::isSubmit('changeStatus') || Tools::getValue('savePosition') || Tools::isSubmit('submitConfigMenu') || Tools::isSubmit('saveAndStayGroup')
			|| Tools::isSubmit('saveGroupMenu') || Tools::isSubmit('changeStatusMenuGroup') ||  Tools::isSubmit('duplicateMenuGroup') || Tools::isSubmit('deleteMenuGroup')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
				$this->_html .= $this->initForm();
				if(Tools::isSubmit('id_spverticalmenu_group')){
					$this->_html .= $this->renderAddForm();
					$this->_html .= $this->renderList();
				}
			}
			else
				$this->_html .= $this->renderAddForm();

			$this->clearCache();
		}
		elseif(Tools::isSubmit('addMenuGroup') || Tools::isSubmit('editMenugroup'))
		{
			$this->_html .= $this->initForm();
			if(Tools::isSubmit('editMenugroup')){
				$this->_html .= $this->renderAddForm();
				$this->_html .= $this->renderList();
			}
		}		
		else // Default viewport
		{
			$this->_html .= $this->displayForm();
		}

		return $this->_html;
	}

	protected function _postValidation()
	{
		$errors = array();

		if (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_spverticalmenu')))
				$errors[] = $this->l('Invalid menu');
		}
		/* Validation for menu */
		elseif (Tools::isSubmit('submitMenu'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_menu')) || (Tools::getValue('active_menu') != 0 && Tools::getValue('active_menu') != 1))
				$errors[] = $this->l('Invalid menu state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid menu position.');
			/* If edit : checks id_spverticalmenu */
			if (Tools::isSubmit('id_spverticalmenu'))
			{

				//d(var_dump(Tools::getValue('id_spverticalmenu')));
				if (!Validate::isInt(Tools::getValue('id_spverticalmenu')) && !$this->menuExists(Tools::getValue('id_spverticalmenu')))
					$errors[] = $this->l('Invalid menu ID');
			}
			if (Tools::getValue('type') == 'product')
				if (!Validate::isInt(Tools::getValue('type_product[product]')))
					$errors[] = $this->l('Invalid Product ID');
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The URL is too long.');
				if (Tools::strlen(Tools::getValue('short_description_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The short description is too long.');	
				if (Tools::strlen(Tools::getValue('label_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The  label is too long.');						
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title is not set.');
			if (Tools::getValue('type') == 'url')
				if (Tools::strlen(Tools::getValue('url_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The url is not set.');
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_spverticalmenu') && (!Validate::isInt(Tools::getValue('delete_id_spverticalmenu')) || !$this->menuExists((int)Tools::getValue('delete_id_spverticalmenu'))))
			$errors[] = $this->l('Invalid menu ID');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	protected function _postProcess()
	{
		$errors = array();
		$shop_context = Shop::getContext();
		if (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_spverticalmenu'))
		{
			$menu = new Verticalmenu((int)Tools::getValue('id_spverticalmenu'));
			if ($menu->active == 0)
				$menu->active = 1;
			else
				$menu->active = 0;
			$res = $menu->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group'));
		}
		elseif (Tools::isSubmit('changeStatusMenuGroup') && Tools::getValue('id_spverticalmenu_group'))
		{
			$menugroup = new VerticalGroup((int)Tools::getValue('id_spverticalmenu_group'));
			if ($menugroup->status == 0)
				$menugroup->status = 1;
			else
				$menugroup->status = 0;
				
			$res = $menugroup->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}	
		elseif (Tools::isSubmit('duplicateMenuGroup') && Tools::isSubmit('id_spverticalmenu_group'))
		{
			$menugroup = new VerticalGroup((int)Tools::getValue('id_spverticalmenu_group'));
			$id_spverticalmenu_group = Tools::getValue('id_spverticalmenu_group');
			$menugroup->status = 0;
			$menugroup->id = null;
			
			if($menugroup->add()){
				$menus = $this->getIdMenuByGroup($id_spverticalmenu_group,true);
				if($menus){
					foreach($menus as $menu){
						$new_menu = new Verticalmenu((int)$menu['id_spverticalmenu']);
						$new_menu->id = null;
						$new_menu->id_parent = 1;
						$new_menu->id_spverticalmenu_group = $menugroup->id;
						$new_menu->position = $new_menu->getmaxPositonMenu();
						$id_parent = (int)$menu['id_spverticalmenu'];
						if($new_menu->add())
							$this->duplicateParentMenu($id_parent,$new_menu->id,$menugroup->id);
					}
				}
			}
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}	
		elseif (Tools::isSubmit('deleteMenuGroup'))
		{
			$menugroup = new VerticalGroup((int)Tools::getValue('id_spverticalmenu_group'));
			if($menugroup->delete()){
				$menus = $this->getIdMenuByGroup((int)Tools::getValue('id_spverticalmenu_group'));
				if($menus){
					foreach($menus as $menu){
						$new_menu = new Megamenu((int)$menu['id_spverticalmenu']);
						$new_menu->delete();
					}
				}
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
			}else{
				$this->_html .= $this->displayError('Could not delete.');
			}
			$this->clearCache();
		}		
		elseif (Tools::isSubmit('saveAndStayGroup') || Tools::isSubmit('saveGroupMenu'))
		{
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0 || !Validate::isInt(Tools::getValue('limit'))){
				if(Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
					$errors[] = $this->l('The title is not set.');
				if(!Validate::isInt(Tools::getValue('limit')))
					$errors[] = $this->l('Invalid Limit List Menu');
			}	
			else{
			if (Tools::getValue('id_spverticalmenu_group'))
			{
				$menugroup = new VerticalGroup((int)Tools::getValue ('id_spverticalmenu_group'));
				if (!Validate::isLoadedObject($menugroup))
				{
					$this->html .= $this->displayError($this->l('Invalid group ID'));
					return false;
				}
			}
			else
				$menugroup = new VerticalGroup();
			$next_ps = $this->getNextPosition();
			$menugroup->position = (!empty($menugroup->position)) ? (int)$menugroup->position : $next_ps;
			$menugroup->status = (Tools::getValue('status')) ? (int)Tools::getValue('status') : 0;
			$menugroup->hook	= Tools::getValue('hook');
			$tmp_data = array();
			$tmp_data['limit1'] = (int)Tools::getValue ('limit1', 9);
			$tmp_data['limit2'] = (int)Tools::getValue ('limit2', 9);
			$tmp_data['limit3'] = (int)Tools::getValue ('limit3', 9);
			$tmp_data['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx');
			$tmp_data['display_title_module'] = Tools::getValue ('display_title_module');
			$menugroup->params = serialize($tmp_data);
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				$menugroup->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
				$menugroup->content[(int)$language['id_lang']] = Tools::getValue ('content_'.$language['id_lang']);
			}
			
			Tools::getValue ('id_spverticalmenu_group') && $this->moduleExists((int)Tools::getValue ('id_spverticalmenu_group'))  ? $menugroup->update() : $menugroup->add ();
			$this->clearCache();
			if (Tools::isSubmit ('saveAndStayGroup'))
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spverticalmenu_group='.$menugroup->id);
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);				
			}
		}			
		elseif(Tools::getValue('savePosition') && Tools::getValue('serialized')){
			$mgmenu   = new Verticalmenu();
			$serialized = Tools::getValue('serialized');
			$lists =  Tools::jsonDecode($serialized, true); 
			$lesp = 1;
			$id_parent = 1;
			$mgmenu->updatePositions($lists,$lesp,$id_parent);
			$this->clearCache();
			die('Updated');
        }
		/* Processes menu */
		elseif (Tools::isSubmit('submitMenu'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_spverticalmenu'))
			{
				$mgmenu = new Verticalmenu((int)Tools::getValue('id_spverticalmenu'));
				if (!Validate::isLoadedObject($mgmenu))
				{
					$this->_html .= $this->displayError($this->l('Invalid menu ID'));
					return false;
				}
			}
			else
				$mgmenu = new Verticalmenu();
				
			/* Sets id_parent */
			$mgmenu->id_parent = (int)Tools::getValue('id_parent');	
			/* Sets type */
			$mgmenu->type = Tools::getValue('type');				
			/* Sets position */
			if (!Tools::getValue('id_spverticalmenu'))
			{
				$mgmenu->position = (int)$mgmenu->getmaxPositonMenu();	
			}
			/* Sets active */
			$mgmenu->active = (int)Tools::getValue('active');
			/* Sets show_title */
			$mgmenu->show_title = (int)Tools::getValue('show_title');	
			/* Sets show_sub_title */
			$mgmenu->show_sub_title = (int)Tools::getValue('show_sub_title');
			/* Sets menu_class */
			$mgmenu->menu_class = Tools::getValue('menu_class');
			/* Sets icon */
			$mgmenu->icon = Tools::getValue('icon');			
			/* Sets width */
			$mgmenu->width = Tools::getValue('width');
			/* Sets sub_menu */
			$mgmenu->sub_menu = Tools::getValue('sub_menu');	
			/* Sets sub_width */
			$mgmenu->sub_width = Tools::getValue('sub_width');				
			/* Sets showimg_subcategories */
			$mgmenu->showimg_subcategories = Tools::getValue('showimg_subcategories');				
			/* Sets group */
			$mgmenu->group  = (int)Tools::getValue('group');					
			/* Sets cat_subcategories */
			$mgmenu->cat_subcategories  = (int)Tools::getValue('cat_subcategories');	
			$mgmenu->id_spverticalmenu_group  = (int)Tools::getValue('id_spverticalmenu_group');			
            if( $mgmenu->type && $mgmenu->type !="html" && Tools::getValue("type_".$mgmenu->type) ){
                $mgmenu->value = serialize(Tools::getValue("type_".$mgmenu->type));
            }
			//echo "<pre>".print_r(Tools::getValue("type_".$mgmenu->type),1);die();
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);

			foreach ($languages as $language)
			{
				$mgmenu->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
				$mgmenu->label[$language['id_lang']] = Tools::getValue('label_'.$language['id_lang']);
				$mgmenu->short_description[$language['id_lang']] = Tools::getValue('short_description_'.$language['id_lang']);
				$mgmenu->sub_title[$language['id_lang']] = Tools::getValue('sub_title_'.$language['id_lang']);
				$mgmenu->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
				$mgmenu->html[$language['id_lang']] = Tools::getValue('html_'.$language['id_lang']);
			}
			
			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_spverticalmenu'))
				{
					if (!$mgmenu->add())
						$errors[] = $this->displayError($this->l('The menu could not be added.'));
				}
				/* Update */
				elseif ($mgmenu->update())
					//$errors[] = $this->displayError($this->l('The menu could not be updated.'));
				$this->clearCache();
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_spverticalmenu'))
		{
			Verticalmenu::deleteMenu((int)Tools::getValue('delete_id_spverticalmenu'));
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group'));
		}
		elseif (Tools::isSubmit('duplicate_id_spverticalmenu'))
		{
			$id_parent = (int)Tools::getValue('duplicate_id_spverticalmenu');
			$parent_menu = new Verticalmenu((int)Tools::getValue('duplicate_id_spverticalmenu'));
			$parent_menu->id = null;
			$parent_menu->id_spverticalmenu = null;
			$parent_menu->active = 0;
			$parent_menu->position = $parent_menu->getmaxPositonMenu();
			if ($parent_menu->add())
				$this->duplicateParentMenu($id_parent,$parent_menu->id);
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=19&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group'));
		}		

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitMenu') && Tools::getValue('id_spverticalmenu'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_spverticalmenu='.Tools::getValue('id_spverticalmenu').'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group'));
		elseif (Tools::isSubmit('submitMenu'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group'));
	}

	protected function _prepareHook($hook)
	{
		//if (!$this->isCached('spverticalmenu.tpl')){
			global $link;
			if(!$hook)
				return;			
			$id_shop_group = Shop::getContextShopGroupID();
			$id_shop = Shop::getContextShopID();	
			$current_link = $link->getPageLink('', false, $this->context->language->id);
			$object = new Verticalmenu();
			$groups 	= $this->getIdGroupByHook($hook);
			$list = array();
			if($groups){
				foreach($groups as $group){
					$id_spverticalmenu_group = ($group['id_spverticalmenu_group']) ?  (int)($group['id_spverticalmenu_group']) : 0;
					$groups = new VerticalGroup($id_spverticalmenu_group);
					$params = (isset($groups->params) && $groups->params) ? unserialize($groups->params) : array();
					$item['params'] = $params;
					$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
					$title = (isset($groups->title[$id_lang_default]) && $groups->title[$id_lang_default]) ? ($groups->title[$id_lang_default]) : '';
					$item['title'] = $title;
					if(isset($id_spverticalmenu_group) && $id_spverticalmenu_group)
						$vermegamenu = $object->getVermegamenu(1, 1,$id_spverticalmenu_group);
					else
						$vermegamenu = '';		
					$item['vermegamenu'] = $vermegamenu;
					$list[$id_spverticalmenu_group] = $item;	
				}		
			}
			$this->smarty->assign( 'current_link', $current_link );
			$this->smarty->assign( 'list', $list );
			$this->smarty->assign( 'spverticalmenu_params', $params );
			return $this->display(__FILE__,'spverticalmenu.tpl');
		//}

		return true;
	}
	
	
	private function getIdGroupByHook($hook){
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT mg.`id_spverticalmenu_group`
				FROM `'._DB_PREFIX_.'spverticalmenu_group` mg
				WHERE `hook` = \''.pSQL($hook).'\' AND `status`=1');
		return $result;
	}	

	public function SortGroupHTML()
	{
		if (Tools::getValue ('controller') != 'AdminModules' && Tools::getValue ('configure') != $this->name)
			return;
		$this->context->controller->addJqueryUI ('ui.sortable');
		$html = '<script type="text/javascript">
			$(function() {
				var $gird_items = $("#gird_items");
				$gird_items.sortable({
					opacity: 0.6,
					cursor: "move",
					handle: ".dragGroup",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateGroupPosition";
							$.ajax({
								type: "POST",
								dataType: "json",
								data:order,
								url:"'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/ajax_spsortgroup.php?secure_key='.$this->secure_key.'",
								success: function (msg){
									if (msg.error)
									{
										showErrorMessage(msg.error);
										return;
									}
									$(".positions", $gird_items).each(function(i){
										$(this).text(i);
									});
									showSuccessMessage(msg.success);
								}
							});
						
						}
					});
					$(".dragGroup",$gird_items).hover(function() {
						$(this).css("cursor","move");
					},
					function() {
						$(this).css("cursor","auto");
				    });
			});
		</script>
		';
		$html .= '<style type="text/css">#gird_items .ui-sortable-helper{display:table!important;}</style>';
		return $html;
	}	
	
    public function hookHeader()
    {
		$this->context->controller->addCss( __PS_BASE_URI__.'modules/spverticalmenu/css/spverticalmenu.css' ); 
    }
	
	public function hookdisplayVertical($params)
	{
		if (!$this->_prepareHook('displayVertical'))
			return false;

		return $this->display(__FILE__, 'spverticalmenu.tpl');
	}

	public function hookdisplayVertical2($params)
	{
		if (!$this->_prepareHook('displayVertical2'))
			return false;

		return $this->display(__FILE__, 'spverticalmenu2.tpl');
	}

	public function hookdisplayVertical3($params)
	{
		if (!$this->_prepareHook('displayVertical3'))
			return false;

		return $this->display(__FILE__, 'spverticalmenu3.tpl');
	}
	
	public function clearCache()
	{
		$this->_clearCache('spverticalmenu.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
			INSERT IGNORE INTO '._DB_PREFIX_.'spverticalmenu (id_spverticalmenu, id_shop)
			SELECT id_spverticalmenu, '.(int)$params['new_id_shop'].'
			FROM '._DB_PREFIX_.'spverticalmenu
			WHERE id_shop = '.(int)$params['old_id_shop']
		);
		$this->clearCache();
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;
		$action = AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules');
		$html = '<script type="text/javascript">var action="'.$action.'";</script>';
		return $html;
	}

	public function initForm()
	{
		$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
		$hooks = $this->getHookList ();
		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend'  => array(
				'title' => $this->l('General Options'),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'     => 'text',
					'label'    => $this->l('Title'),
					'lang'     => true,
					'name'     => 'title',
					'required'	=> true,
					'class'    => 'fixed-width-xl',
					'hint'     => $this->l('Title Of Module')
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Module Class Suffix'),
					'name'  => 'moduleclass_sfx',
					'hint'  => $this->l('A suffix to be applied to the CSS class of the module.
					This allows for individual module styling.'),
					'class' => 'fixed-width-xl'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit 1 List Menu'),
					'name' => 'limit1',
					'default' => '10',
					'col' => '6',
					'class' => 'fixed-width-xl',
					'desc' => 'For devices have screen width from 1400px to greater.'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit 2 List Menu'),
					'name' => 'limit2',
					'default' => '10',
					'col' => '6',
					'class' => 'fixed-width-xl',
					'desc' => 'For devices have screen width from 1200px to greater.'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit 3 List Menu'),
					'name' => 'limit3',
					'default' => '10',
					'col' => '6',
					'class' => 'fixed-width-xl',
					'desc' => 'For devices have screen width from 768px up to 1199px.'
				
				),					
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Title'),
					'name'   => 'display_title_module',
					'hint'   => $this->l('Display Title Of Module'),
					'values' => array(
						array(
							'id'    => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Status'),
					'name'   => 'status',
					'hint'   => $this->l('Status Of Module'),
					'values' => array(
						array(
							'id'    => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'    => 'select',
					'label'   => $this->l('Hook into'),
					'name'    => 'hook',
					'hint'    => $this->l('Select Hook for Module'),
					'options' => array(
						'query' => $hooks,
						'id'    => 'key',
						'name'  => 'name'
					)
				)
			),
			'submit'  => array(
				'title' => $this->l('Save')
			),
			'buttons' => array(
				array(
					'title' => $this->l('Save and stay'),
					'name'  => 'saveAndStayGroup',
					'type'  => 'submit',
					'class' => 'btn btn-default pull-right',
					'icon'  => 'process-icon-save'
				)
			)
		);
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'spverticalmenu_group';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite ('AdminModules');
		$helper->show_cancel_button = true;
		$helper->back_url = AdminController::$currentIndex.'&configure='.$this->name.'&token='
			.Tools::getAdminTokenLite ('AdminModules');
		foreach (Language::getLanguages (false) as $lang)
			$helper->languages[] = array(
				'id_lang'    => $lang['id_lang'],
				'iso_code'   => $lang['iso_code'],
				'name'       => $lang['name'],
				'is_default' => ( $default_lang == $lang['id_lang']?1:0 )
			);
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'saveGroupMenu';
		$helper->toolbar_btn = array(
			'save' => array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex.'&configure='.$this->name
					.'&save'.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules')
			),
			'back' => array(
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules'),
				'desc' => $this->l('Back to list') )
		);
		$id_spverticalmenu_group = (int)Tools::getValue ('id_spverticalmenu_group');

		if (Tools::isSubmit ('id_spverticalmenu_group') && $id_spverticalmenu_group)
		{
			$spmenugroup = new VerticalGroup((int)$id_spverticalmenu_group);
			$params = unserialize($spmenugroup->params);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spverticalmenu_group' );
		$helper->fields_value['id_spverticalmenu_group'] = Tools::getValue ('id_spverticalmenu_group', $spmenugroup->id);
		}
		else
		{
			$spmenugroup = new VerticalGroup();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title'][(int)$lang['id_lang']] = Tools::getValue ('title_'
				.(int)$lang['id_lang'],
				$spmenugroup->title[(int)$lang['id_lang']]);
		}
		$helper->fields_value['hook'] = Tools::getValue ('hook', $spmenugroup->hook);
		$helper->fields_value['status'] = (int)Tools::getValue('status', $spmenugroup->status);
		$display_title_module = isset( $params['display_title_module'] ) ? $params['display_title_module'] : 1;
		$helper->fields_value['display_title_module'] = Tools::getValue ('display_title_module', $display_title_module);
		$helper->fields_value['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx',
			isset($params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '' );
		$helper->fields_value['limit1'] = Tools::getValue ('limit1',
			isset($params['limit1']) ? $params['limit1'] : 9 );
		$helper->fields_value['limit2'] = Tools::getValue ('limit2',
			isset($params['limit2']) ? $params['limit2'] : 9 );
		$helper->fields_value['limit3'] = Tools::getValue ('limit3',
			isset($params['limit3']) ? $params['limit3'] : 9 );			
		$this->_html .= $helper->generateForm ($this->fields_form);
	}	
	
	public function getMenus($active = null)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_spverticalmenu` as id_spverticalmenu, hs.`position`, hs.`active`,hs.`type`, hssl.`title`
			FROM '._DB_PREFIX_.'spverticalmenu hs
			LEFT JOIN '._DB_PREFIX_.'spverticalmenu_shop hss ON (hs.id_spverticalmenu = hss.id_spverticalmenu)
			LEFT JOIN '._DB_PREFIX_.'spverticalmenu_lang hssl ON (hss.id_spverticalmenu = hssl.id_spverticalmenu)
			WHERE id_shop = '.(int)$id_shop.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hs.`active` = 1' : ' ').'
			ORDER BY hs.position'
		);
	}


	public function menuExists($id_spverticalmenu)
	{
		$req = 'SELECT hs.`id_spverticalmenu` as id_spverticalmenu
				FROM `'._DB_PREFIX_.'spverticalmenu` hs
				WHERE hs.`id_spverticalmenu` = '.(int)$id_spverticalmenu;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function renderList()
	{
		$this->context->controller->addJS( __PS_BASE_URI__.'modules/spverticalmenu/js/jquery.nestable.js' ); 
		$this->context->controller->addCss( __PS_BASE_URI__.'modules/spverticalmenu/css/form.css' ); 
		$object   		= new Verticalmenu();
		$output = '
			<div class="clearfix">
			<div class="col-md-12 col-lg-12 form_content">
				<h3>
					<i class="icon-list-ul"></i>
						menus list
					<span class="form-heading-action">
					   <menu id="spverticalmenu-menu">
							<button type="button" class="btn btn-info" data-action="expand-all">Expand All</button>
							<button type="button" class="btn btn-info" data-action="collapse-all">Collapse All</button>
						</menu>
						<p><input type="button" value="'.$this->l('Update Position').'" id="savePosition" data-loading-text="'.$this->l('Processing ...').'" class="btn btn-info" name="savePosition"></p>
						<a id="desc-product-new" class="list-toolbar-btn" href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spverticalmenu&addMenu=1&editMenugroup&id_spverticalmenu_group='.(int)Tools::getValue('id_spverticalmenu_group').'">
							<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
								<i class="process-icon-new "></i>
							</span>
						</a>
					</span>
				</h3>';
		$output .= $object->getTree(1,1);
		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
	
	private function displayForm()
	{
		$currentIndex = AdminController::$currentIndex;
		$modules = array();
		$this->_html .= $this->headerHTML ();
		$this->_html .= $this->SortGroupHTML();
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			$this->_html .= $this->getWarningMultishopHtml();
		else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
		{
			$modules = $this->getGridItems ();
			if (!empty($modules))
			{
				foreach ($modules as $key => $mod)
				{
					$associated_shop_ids = VerticalGroup::getAssociatedIdsShop((int)$mod['id_spverticalmenu_group']);
					if ($associated_shop_ids && count($associated_shop_ids) > 1)
						$modules[$key]['is_shared'] = true;
					else
						$modules[$key]['is_shared'] = false;
				}
			}
		}
		$this->_html .= '
	 	<div class="panel">
			<div class="panel-heading">
			'.$this->l('Module Manager').'
			<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="'.$currentIndex.'&configure='.$this->name
			.'&token='.Tools::getAdminTokenLite ('AdminModules').'&addMenuGroup">
			<span data-toggle="tooltip" class="label-tooltip" data-original-title="'
			.$this->l('Add new module').'" data-html="true"><i class="process-icon-new "></i></span></a>
			</span>
			</div>
			<table width="100%" class="table" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop">
				<th>'.$this->l('ID').'</th>
				<th>'.$this->l('Ordering').'</th>
				<th class=" left">'.$this->l('Title').'</th>
				<th class=" left">'.$this->l('Hook into').'</th>
				<th class=" left">'.$this->l('Status').'</th>
				<th class=" right"><span class="title_box text-right">'.$this->l('Actions').'</span></th>
			</tr>
			</thead>
			<tbody id="gird_items">';
		if (!empty($modules))
		{
			static $irow;
			foreach ($modules as $spmenugroup)
			{
				$this->_html .= '
				<tr id="item_'.$spmenugroup['id_spverticalmenu_group'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spverticalmenu_group='
					.$spmenugroup['id_spverticalmenu_group'].'\'">'
					.$spmenugroup['id_spverticalmenu_group'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$spmenugroup['position']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editMenugroup&id_spverticalmenu_group='.$spmenugroup['id_spverticalmenu_group'].'\'">'.$spmenugroup['title']
					.' '.($spmenugroup['is_shared'] ? '<span class="label color_field"
		style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spverticalmenu_group='
					.$spmenugroup['id_spverticalmenu_group'].'\'">'
					.$spmenugroup['hook'].'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusMenuGroup&id_spverticalmenu_group='.$spmenugroup['id_spverticalmenu_group'].'&status='
					.$spmenugroup['status'].'&hook='.$spmenugroup['hook'].'">'.( ($spmenugroup['status'] && $spmenugroup['status'] == 1)?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='
		.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spverticalmenu_group='.$spmenugroup['id_spverticalmenu_group'].'">
									<i class="icon-pencil"></i> Edit
								</a> 
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
									<span class="caret"></span>&nbsp;
								</button>
								<ul class="dropdown-menu">
									<li>
							<a onclick="return confirm(\''
					.$this->l('Are you sure want duplicate this item?')
					.'\');"  title="'.$this->l('Duplicate').'" href="'.$currentIndex.'&configure='
					.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateMenuGroup&id_spverticalmenu_group='
					.$spmenugroup['id_spverticalmenu_group'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteMenuGroup&id_spverticalmenu_group='
					.$spmenugroup['id_spverticalmenu_group'].'">
											<i class="icon-trash"></i> '.$this->l('Delete').'
										</a>
									</li>
								</ul>
							</div>
						</div>
					</td>
				</tr>';
			}
		}
		else
		{
			$this->_html .= '<td colspan="5" class="list-empty">
								<div class="list-empty-msg">
									<i class="icon-warning-sign list-empty-icon"></i>
									'.$this->l('No records found').'
								</div>
							</td>';
		}
		$this->_html .= '
			</tbody>
			</table>
		</div>';
	}	
	
	protected function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage megamenu items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}			
	
	public function renderAddForm()
	{
		$this->context->controller->addJS( __PS_BASE_URI__.'modules/spverticalmenu/js/form.js' ); 
		$id_lang    	= $this->context->language->id;
		$id_shop    	= $this->context->shop->id;
		$id_spverticalmenu 	= Tools::getValue('id_spverticalmenu') ? (int)Tools::getValue('id_spverticalmenu') : 0;
		$object   		= new Verticalmenu($id_spverticalmenu);
		$selected_categories = array();
		if($object->value){
			$object->value = unserialize($object->value);
			if($object->cat_subcategories && $object->type == 'subcategories')
				$selected_categories[0] = $object->cat_subcategories;			
		}
			
		$categories 	= Category::getCategories( $id_lang, true, false  ) ;
        $manufacturers 	= Manufacturer::getManufacturers(false, $id_lang, true);
		$all_manu = array(
				'id_manufacturer' =>  0 ,
				'name'			=> 	$this->l('All Manufacturer')
			);
		$manufacturers[] = $all_manu;
        $suppliers     	= Supplier::getSuppliers(false, $id_lang, true);
		$all_supp = array(
				'id_supplier' =>  0 ,
				'name'			=> 	$this->l('All Suppliers')
			);
		$suppliers[] = $all_supp;		
		$cms			= $object->getCMSOptions(0, 1, $this->context->language->id);
		$menu         	= $object->getChildren(null, $id_lang,$id_shop);
		$active = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );
		
		$sub_menu = array(
            array(
                'value' => 'yes',
                'label' => $this->l('Yes')
            ),
            array(
                'value' => 'no',
                'label' => $this->l('No')
            )
        );
		
		$columns = array(
            array(
                'value' => '1'
            ),
            array(
                'value' => '2',
            ),
            array(
                'value' => '3',
            ),
            array(
                'value' => '4',
            ),
            array(
                'value' => '6',
            ),			
        );
		
		$list_product = array(
			array(
				'id' => 'new',
				'label' => $this->l('New')
			),
			array(
				'id' => 'bestseller',
				'label' => $this->l('Bestseller')
			),
			array(
				'id' => 'special',
				'label' => $this->l('Special')
			),
			array(
				'id' => 'featured',
				'label' => $this->l('Featured')
			)
		);	
		
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Menu information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
                array(
                    'type'  => 'text',
                    'label' => $this->l('Title:'),
                    'name'  => 'title',
                    'value' => true,
                    'lang'  => true,
					'required'=> true,
                    'default'=> '',
					'col' => '6',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Title'),
                    'name' => 'show_title',
                    'values' => $active,
                    'default' => 1,
    
                 ),		
				array(
                    'type' => 'textarea',
                    'label' => $this->l('Label:'),
                    'name'  => 'label',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'autoload_rte' => true,
					'col' => '6',
                ), 
                array(
                    'type' => 'text',
                    'label' => $this->l('Icon Font'),
                    'name' => 'icon',
                    'display_image' => true,
                    'default' => '',
					'col' => '6',
					'desc' => 'Only use font awesome'
                ),				
				array(
                    'type' => 'textarea',
                    'label' => $this->l('Short Description:'),
                    'name'  => 'short_description',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'autoload_rte' => true,
					'col' => '6',
                ), 				
                array(
                    'type' => 'select',
                    'label' => $this->l('Parent ID'),
                    'name' => 'id_parent',
                    'options' => array(  'query' =>   $menu,
                    'id' => 'id_spverticalmenu',
                    'name' => 'title' ),
                    'default' => 1,
         
                 ), 
				array(
                    'type'  => 'text',
                    'label' => $this->l('Submenu Title:'),
                    'name'  => 'sub_title',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'col' => '6',
                ),				 
				array(
                    'type' => 'switch',
                    'label' => $this->l('Show Sub Title'),
                    'name' => 'show_sub_title',
                    'values' => $active,
                    'default' => 1,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Menu Type'),
                    'name' => 'type',
                    'id'    => 'select_menu',
                    'options' => array(  'query' => array(
                        array('id' => 'url', 'name' => $this->l('Url')),
						array('id' => 'product', 'name' => $this->l('Product')),
						array('id' => 'productlist', 'name' => $this->l('Product List')),
                        array('id' => 'manufacture', 'name' => $this->l('Manufacture')),
                        array('id' => 'supplier', 'name' => $this->l('Supplier')),
                        array('id' => 'cms', 'name' => $this->l('Cms')),
                        array('id' => 'html', 'name' => $this->l('Html')),
                        array('id' => 'category', 'name' => $this->l('Category')),
						array('id' => 'subcategories', 'name' => $this->l('Sub Categories'))
                    ),
                     'id' => 'id',
                    'name' => 'name' ),
                    'default' => "url",
         
                 ),
            
                array(
                    'type' => 'text',
                    'label' => $this->l('Product ID'),
                    'name' => 'type_product[product]',
                    'id' => 'type_product',
                    'class'=> 'type_group',
                    'default' => "",
					'desc'    => $this->l('Ex: 3')
                ),

				array(
					'type' 	  => 'select',
					'label'   => $this->l('Products List'),
					'name' 	  => 'type_productlist[type]',
					'options' => array(  'query' => $list_product ,
					'id' 	  => 'id',
					'name' 	  => 'label' ),
					'default' => "new",
					'class'=> 'type_group type_product_type',
					'desc'    => $this->l('Select Product Type')
	            ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit Product'),
                    'name' => 'type_productlist[limit]',
                    'id' => 'type_limit_product',
                    'class'=> 'type_group',
                    'default' => 4,
					'col' => '6'
                ),	
                array(
                    'type' => 'text',
                    'label' => $this->l('Col Product'),
                    'name' => 'type_productlist[col]',
                    'id' => 'type_col_product',
                    'class'=> 'type_group type_product_type',
                    'default' => 4,
					'col' => '6'
                ),					
                array(
                    'type' => 'select',
                    'label' => $this->l('CMS Type'),
                    'name' => 'type_cms[cms]',
                    'id'   => 'type_cms',
                    'options' => array(  'query' => $cms,
                    'id' => 'value',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('URL'),
                    'name' => 'url',
                    'id' => 'type_url',
					'required'=> true,
					'lang'  => true,
                    'class'=> 'type_group_lang',
                    'default' => "#",
					'col' => '6',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Category'),
                    'name' => 'type_category[category]',
                    'id'   => 'type_category',
                    'options' => array(  'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),
				array(
					'type'  => 'categories',
					'label' => $this->l('Sub categories'),
					'name'  => "cat_subcategories",
					'tree'  => array(
						'id'                  => 'type_subcategories',
						'selected_categories' => $selected_categories,
                        'root_category'       => $this->context->shop->getCategory()
					)
				),
				array(
                    'type' => 'text',
                    'label' => $this->l('Limit Subcategories Lever 1'),
                    'name' => "type_subcategories[limit1]",
                    'class'=> 'type_group type_limit_subcategories',
                    'default' => 4,
                ),	
				array(
                    'type' => 'text',
                    'label' => $this->l('Limit Subcategories Lever 2'),
                    'name' => "type_subcategories[limit2]",
                    'class'=> 'type_group type_limit_subcategories',
                    'default' => 4,
                ),	
				array(
                    'type' => 'text',
                    'label' => $this->l('Limit Subcategories Lever 3'),
                    'name' => "type_subcategories[limit3]",
                    'class'=> 'type_group type_limit_subcategories',
                    'default' => 4,
                ),									
				array(
                    'type' => 'select',
                    'label' => $this->l('Show Image Sub Categories'),
                    'name' => "type_subcategories[showimg]",
					'class'	=> 'showimg_subcategories',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),	
				array(
                    'type' => 'select',
                    'label' => $this->l('Show Image Children Categories'),
                    'name' => "type_subcategories[showimgchild]",
					'class'	=> 'showimgchild_subcategories',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),					 				
                array(
                    'type' => 'select',
                    'label' => $this->l('Manufacture Type'),
                    'name' => 'type_manufacture[manufacture]',
                    'id' => 'type_manufacture',
                    'options' => array(  'query' => $manufacturers,
                     'id' => 'id_manufacturer',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group type_manufacture', 
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Manufacture Col'),
                    'name' => 'type_manufacture[col]',
                    'id' => 'type_manufacture',
                    'options' => array(  'query' => $columns,
                     'id' => 'value',
                    'name' => 'value' ),
                    'default' => 1,
                    'class'=> 'type_group type_manufacture', 
                ),				
                 array(
                    'type' => 'select',
                    'label' => $this->l('Supplier Type'),
                    'name' => 'type_supplier[supplier]',
                    'id' => 'type_supplier',
                    'options' => array(  'query' => $suppliers,
                    'id' => 'id_supplier',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Html'),
                    'name' => 'html',
                    'lang' => true,
                    'default' => '',
                    'autoload_rte' => true,
                    'class'=> 'html_lang', 
					'col' => '6',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Class'),
                    'name' => 'menu_class',
                    'display_image' => true,
                    'default' => '',
					'col' => '6',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'id' => 'width',
                    'class'=> 'width',
                    'default' => "",
					'desc' => "Ex : 960px , 100%",
					'col' => '6',
                ),
				array(
                    'type' => 'select',
                    'label' => $this->l('Have Sub Menu'),
                    'name' => 'sub_menu',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Submenu Width'),
                    'name' => 'sub_width',
                    'id' => 'sub_width',
                    'class'=> 'sub_width',
                    'default' => "",
					'desc' => "Ex : 960px , 100%",
					'col' => '6',
                ),
				array(
                    'type' => 'switch',
                    'label' => $this->l('Group'),
                    'name' => 'group',
                    'values' => $active,
                    'default' => 0,
                 ),
				array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'values' => $active,
                    'default' => 1,
                 ),
				
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_spverticalmenu') && $this->menuExists((int)Tools::getValue('id_spverticalmenu')))
		{
			$menu = new Verticalmenu((int)Tools::getValue('id_spverticalmenu'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_spverticalmenu');
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitMenu';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_spverticalmenu_group='.Tools::getValue('id_spverticalmenu_group');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/'
		);

		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);

		if (count($languages) > 1)
			return $this->getMultiLanguageInfoMsg().$helper->generateForm(array($fields_form));
		else
			return $helper->generateForm(array($fields_form));
	}

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_spverticalmenu') && $this->menuExists((int)Tools::getValue('id_spverticalmenu')))
		{
			$mgmenu = new Verticalmenu((int)Tools::getValue('id_spverticalmenu'));
			$fields['id_spverticalmenu'] = (int)Tools::getValue('id_spverticalmenu', $mgmenu->id);
		}
		else
			$mgmenu = new Verticalmenu();

		$fields['active'] = Tools::getValue('active', $mgmenu->active);
		$fields['id_parent'] = Tools::getValue('id_parent', $mgmenu->id_parent);
		$fields['type'] = Tools::getValue('type', $mgmenu->type);
		$fields['icon'] = Tools::getValue('icon', $mgmenu->icon);
		$fields['position'] = Tools::getValue('position', $mgmenu->position);
		$fields['show_title'] = Tools::getValue('show_title', $mgmenu->show_title);
		$fields['show_sub_title'] = Tools::getValue('show_sub_title', $mgmenu->show_sub_title);
		$fields['menu_class'] = Tools::getValue('menu_class', $mgmenu->menu_class);
		$fields['width'] = Tools::getValue('width', $mgmenu->width);
		$fields['sub_menu'] = Tools::getValue('sub_menu', $mgmenu->sub_menu);
		$fields['sub_width'] = Tools::getValue('sub_width', $mgmenu->sub_width);
		$fields['group'] = Tools::getValue('group', $mgmenu->group);
		$fields['sub_width'] = Tools::getValue('sub_width', $mgmenu->sub_width);
		$fields['cat_subcategories'] = Tools::getValue('cat_subcategories', $mgmenu->cat_subcategories);
		
		$array_type = array('product' =>array('product'),
							'productlist' =>array('type','limit','col'),
							'cms' =>array('cms'),
							'category' =>array('category'),
							'manufacture' =>array('manufacture','col'),
							'supplier' =>array('supplier'),
							'subcategories' => array('limit1','limit2','limit3','showimg','showimgchild'),
							);
		
		foreach($array_type as $type=>$configs){
			if(isset($mgmenu->type) && $mgmenu->type && $mgmenu->type == $type){
				$values	= unserialize(Tools::getValue('value',$mgmenu->value));
				if($values){
					foreach($values as $key=>$value)
						$fields['type_'.$mgmenu->type.'['.$key.']'] = $value;
				}
			}	
			else{
				$fields["type_".$type] = '';
				if($configs){
					foreach($configs as $config)
						$fields['type_'.$type.'['.$config.']'] = '';
				}
			}	
		}
		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
		{
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $mgmenu->title[$lang['id_lang']]);
			$fields['label'][$lang['id_lang']] = Tools::getValue('label_'.(int)$lang['id_lang'], $mgmenu->label[$lang['id_lang']]);
			$fields['short_description'][$lang['id_lang']] = Tools::getValue('short_description_'.(int)$lang['id_lang'], $mgmenu->short_description[$lang['id_lang']]);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $mgmenu->url[$lang['id_lang']]);
			$fields['sub_title'][$lang['id_lang']] = Tools::getValue('sub_title_'.(int)$lang['id_lang'], $mgmenu->sub_title[$lang['id_lang']]);
			$fields['html'][$lang['id_lang']] = Tools::getValue('html_'.(int)$lang['id_lang'], $mgmenu->html[$lang['id_lang']]);
		}

		return $fields;
	}

	protected function getMultiLanguageInfoMsg()
	{
		return '<p class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'</p>';
	}

	public function renderProductList($products,$col_product=4){
		$tpl = 'views/templates/hook/product.tpl';
		$this->smarty->assign( 'col_product', $col_product );
		$this->smarty->assign( 'products', $products );
		return $this->display(__FILE__, $tpl);
	}
	
	public function duplicateParentMenu($id_parent,$id_spverticalmenu){
		$id_lang       = Context::getContext()->language->id;
		$id_shop       = Context::getContext()->shop->id;
		$spverticalmenu = new Verticalmenu();
		$menus         	= $spverticalmenu->getChildren($id_parent, $id_lang,$id_shop);
		if($menus){
			foreach($menus as $menu){
				$id_children  = $menu['id_spverticalmenu'];
				$parent_menu = new Verticalmenu((int)$id_children);
				$parent_menu->id = null;
				$parent_menu->id_spverticalmenu = null;
				$parent_menu->active = 1;
				$parent_menu->id_parent = $id_spverticalmenu;
				$parent_menu->position = $parent_menu->getmaxPositonMenu();
				$parent_menu->add();
					$this->duplicateParentMenu($id_children,$parent_menu->id);
			}
		}
	}
	
	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_spverticalmenu_group`,  b.`hook`, b.`position`, b.`status`, bl.`title`, bl.`content`
			FROM `'._DB_PREFIX_.'spverticalmenu_group` b
			LEFT JOIN `'._DB_PREFIX_.'spverticalmenu_group_shop` bs ON (b.`id_spverticalmenu_group` = bs.`id_spverticalmenu_group` )
			LEFT JOIN `'._DB_PREFIX_.'spverticalmenu_group_lang` bl ON (b.`id_spverticalmenu_group` = bl.`id_spverticalmenu_group`)
			WHERE bs.`id_shop` = '.(int)$id_shop.' 
			AND bl.`id_lang` = '.(int)$id_lang.'
			ORDER BY b.`position`';
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	}
	
	public function getHookList()
	{
		$hooks = array();
		foreach ($this->default_hook as $key=>$hook)
		{
			$hooks[$key]['key'] = $hook;
			$hooks[$key]['name'] = $hook;
		}
		return $hooks;
	}	
	
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'spverticalmenu_group` cs, `'._DB_PREFIX_.'spverticalmenu_group_shop` css
			WHERE css.`id_spverticalmenu_group` = cs.`id_spverticalmenu_group` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}		
		
	public function moduleExists($id_spverticalmenu_group)
	{
		$req = 'SELECT cs.`id_spverticalmenu_group` 
				FROM `'._DB_PREFIX_.'spverticalmenu_group` cs
				WHERE cs.`id_spverticalmenu_group` = '.(int)$id_spverticalmenu_group;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}	
	
	private function getIdMenuByGroup($id_spverticalmenu_group,$id_parent=false){
		$sql = '	SELECT ss.`id_spverticalmenu`
					FROM `'._DB_PREFIX_.'spverticalmenu` ss
					WHERE ss.`id_spverticalmenu_group` = '.(int)$id_spverticalmenu_group ;
		if($id_parent)	
		$sql .= ' AND id_parent = 1';
				
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		return $result;
	}
	
}
